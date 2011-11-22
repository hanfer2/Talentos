<?php
	set_time_limit (600);	
  AppLoader::load_model('ICuestionario');
	
	class GeneraPuntaje{
		
		var $debug = FALSE;
		var $procesarCalificadores = true;
		
		var $cod_prueba = null;
		var $preguntas = null;
		var $componentes = null;
		var $estudiantes = array();
		var $totalEstudiantes = null;
		var $estadisticasPorPregunta = array();
		var $estadisticasCompetencias=array();
		var $estadisticasCualitativos=array();
		var $totalPreguntasPorComponentes = array();
		
		var $nombresComponentes = array();
		var $nombresCompetencias = array();
		var $nombresCualitativos = array();
		
		var $competenciasIndividuales = array();
		var $cualitativosIndividuales = array();
		
		function GeneraPuntaje($cod_prueba){
			
			$this->cod_prueba = $cod_prueba;
			$this->db = DB::instance();
			
			GeneraPuntaje::init();
			
			Logger::debug("= Borrando Datos Previos...", __LINE__);
			GeneraPuntaje::delete();
			
			$this->competencias = GeneraPuntaje::totalPreguntasPorCompetencia();
			$this->cualitativos = GeneraPuntaje::totalPreguntasPorCualitativo();
			
			$this->nombresComponentes =DB::grouped_query("SELECT codigo, nombre FROM i_componentes",'codigo');
			$this->nombresCompetencias =DB::grouped_query("SELECT codigo, nombre FROM i_competencias",'codigo');
			$this->nombresCualitativos =DB::grouped_query("SELECT codigo, nombre FROM i_cualitativos",'codigo');

			$this->totalPreguntasPorComponentes = GeneraPuntaje::getTotalPreguntasPorComponente();
			$estudiantes = GeneraPuntaje::estudiantes();
			$this->totalEstudiantes = count($estudiantes);
			
			$this->preguntas = DB::table_query("SELECT * FROM ".Config::Get('ICuestionario','Pregunta'). " WHERE cod_prueba ='{$this->cod_prueba}'");
			
			echo "<div>Total Estudiantes que presentaron la prueba:  <strong>{$this->totalEstudiantes}</strong></div>";
			foreach($estudiantes as $cod_interno){

				$this->competenciasIndividuales = array();
				$this->cualitativosIndividuales = array();
				$this->estudiantes[$cod_interno] = GeneraPuntaje::datosEstudiante($cod_interno);
				$respuestas = GeneraPuntaje::consultarRespuestasPorEstudiante($cod_interno);
				$resultados = GeneraPuntaje::calificarRespuestas($cod_interno, $respuestas);
				GeneraPuntaje::guardarPuntaje($cod_interno, $resultados);
				
				//if($this->procesarCalificadores){
					GeneraPuntaje::calcularCompetencias($cod_interno);
					GeneraPuntaje::calcularCualitativos($cod_interno);
				//}
				GeneraPuntaje::imprimirResultadosEstudiante($cod_interno, $resultados);
			}
			echo "<hr/>";
			
		//	if($this->procesarCalificadores){
				GeneraPuntaje::procesarCompetencias();
				GeneraPuntaje::procesarCualitativos();
		//	}
		}
		
		function delete(){
			$sql = "DELETE FROM a_estudiantes_icfes where tipo = '{$this->cod_prueba}'";
			DB::query($sql);
			Logger::debug("=== PUNTAJES DE PRUEBA {$this->cod_prueba}... BORRADOS");
			if($this->procesarCalificadores){
				$sql = "DELETE FROM i_puntajes_competencias where cod_prueba = '{$this->cod_prueba}'";
				DB::query($sql);
				Logger::debug("=== PUNTAJES DE COMPETENCIAS {$this->cod_prueba}... BORRADOS");
				$sql = "DELETE FROM i_puntajes_cualitativos where cod_prueba = '{$this->cod_prueba}'";
				DB::query($sql);
				Logger::debug("=== PUNTAJES DE COMPONENTES {$this->cod_prueba}... BORRADOS<br/>");
			}
		  Logger::debug("== REPORTE DE DATOS DE LA PRUEBA {$this->cod_prueba}.... BORRADO<hr/>");
		}
		
		
		function definirComponentes(){
			$sql = "SELECT DISTINCT cod_componente FROM ".Config::Get('ICuestionario','Pregunta')." WHERE cod_prueba='{$this->cod_prueba}'";
			$this->componentes = $this->db->aquery($sql);
		}
		
		function init(){
			GeneraPuntaje::definirComponentes();
			foreach($this->componentes as $componente){
				$this->estadisticasPorPregunta['GENERAL'][$componente] = array('CORRECTAS'=>0, 'INCORRECTAS'=>0,'NULAS'=>0, 'VACIAS'=>0, 'TOTAL'=>0);
			}
		}
		
		function consultarDatoEstudiante($cod_interno, $dato=null){
			if($dato == null)
				return $this->estudiantes[$cod_interno];
			return $this->estudiantes[$cod_interno][$dato];
		}
		
		function getTotalPreguntasPorComponente(){
			$sql = "SELECT cod_componente, count(*) AS cantidad FROM ".Config::Get('ICuestionario','Pregunta').
							" WHERE cod_prueba='{$this->cod_prueba}' GROUP BY cod_componente";
			return $this->db->grouped_query($sql, 'cod_componente');
		}
		
		function imprimirResultadosEstudiante($cod_interno, $resultados){
			$datos = GeneraPuntaje::consultarDatoEstudiante($cod_interno);
			echo "<div style='clear:both'><h4 style='color:#333; border-bottom: 1px solid #666'>[".$datos['nombre_grupo']."] ".$datos['cedula']."- ".$datos['fullname']."</h4>";
			echo "<div>";
			echo "<table class='table' style='border:1px solid #333'><thead style='background-color:#DDD'><tr><th>Componente</th><th>Nulas</th><th>Vacias</th><th>Incorrectas</th><th>Correctas</th><th>PUNTAJE</th></tr></thead><tbody>";
			
			foreach($resultados as $cod_componente=>$resultado){
				echo "<tr>";
				echo "<th style='background-color:#EEE'>".$this->nombresComponentes[$cod_componente]['nombre']."</th>";
				echo "<td>".$resultado['NULAS']."</td>";
				echo "<td>".$resultado['VACIAS']."</td>";
				echo "<td>".$resultado['INCORRECTAS']."</td>";
				echo "<td>".$resultado['CORRECTAS']."</td>";
				echo "<th style='background-color:#EEE'>".number_format($resultado['TOTAL'], 2)."</th>";
				echo "</tr>";
			}
			echo "</tbody></table>";
			echo "</div></div>";
		}
		
			
		function datosEstudiante($cod_interno){
			$sql = "SELECT cedula, fullname, nombre_grupo, cod_grupo AS cod_curso, grupo  
							FROM ".Config::Get('TEstudiante','TGrupo')." WHERE cod_interno = '$cod_interno'";
			return $this->db->query($sql);
			
		}
		
		function consultarRespuestasPorEstudiante($cod_interno){
			$sql = "SELECT cod_pregunta, numeral, cod_componente, cod_competencia,  cod_cualitativo, 
							respuesta, a, b, c, d, e
							FROM ".Config::Get('ICuestionario','V-Respuesta').
						 " WHERE cod_interno = '$cod_interno' AND 
										cod_pregunta IN ( SELECT codigo FROM ".Config::Get('ICuestionario','Pregunta')."
											WHERE cod_prueba = '{$this->cod_prueba}')";
			return $this->db->grouped_query($sql,'cod_pregunta');
		}
		
		function estudiantes(){
			$limit = $_GET['limit'];
			echo $sql = "SELECT DISTINCT cod_interno FROM ".Config::Get('ICuestionario','Respuesta')." ".
						 "WHERE cod_pregunta IN ( SELECT codigo FROM ".Config::Get('ICuestionario','Pregunta')."
							WHERE cod_prueba = '{$this->cod_prueba}') HAVING cod_interno IS NOT NULL ";
			if(!is_blank($limit))
				$sql .=" LIMIT $limit";
		
			return $this->db->aquery($sql);
		}
		
		function totalPreguntasPorCompetencia(){
			$sql = "SELECT cod_componente, cod_competencia, count(*) AS cantidad
							FROM ".Config::Get('ICuestionario','Pregunta')." where cod_prueba = '".$this->cod_prueba."'
							GROUP BY cod_componente, cod_competencia";
			return $this->db->table_query($sql, 'cod_componente');
		}
		
		function totalPreguntasPorCualitativo(){
			
			$sql = "SELECT cod_componente, cod_cualitativo, count(*) AS cantidad
							FROM ".Config::Get('ICuestionario','Pregunta')." where cod_prueba = '".$this->cod_prueba."'
							GROUP BY cod_componente, cod_cualitativo";
			return $this->db->table_query($sql, 'cod_componente');
		}
		
		function guardarPuntaje($cod_interno, $puntajes){
			$adapter = array(1=>'biologia', 2=>'fisica',3=>'quimica',4=>'matematica',
											 5=>'geografia',6=>'lenguaje',7=>'sociales',8=>'filosofia',9=>'interdisciplinar');
			$icfes = array('cod_interno'=>$cod_interno, 'tipo'=>$this->cod_prueba, 
										 'num_registro_icfes'=>zeropad($this->cod_prueba, 2)."-".GeneraPuntaje::consultarDatoEstudiante($cod_interno, 'cedula'));
			
			foreach($puntajes as $cod_componente=>$puntaje){
				$icfes[$adapter[$cod_componente]] = number_format($puntaje['TOTAL'],2);
			}	
			$sql = sql_insert_from_array(Config::Get('TIcfes'),$icfes);		
		//	if($this->debug){
			//	Logger::debug($sql);
		//	}else{
				$this->db->query($sql);
		//	}
		}
		
		function registrarRespuestasPorEstudiante($cod_interno, $respuestas){
			return $resultados;
		}
		
		
		
		function definirRespuestaEscogida($resultados){
			$respuestas_escogidas = array();
			$letras = range('a','e');
			foreach($letras as $letra)
				if($resultados[$letra]=='t')
					$respuestas_escogidas[]=$letra;
			return $respuestas_escogidas;
		}
		
		/**
		 * @param string $respuestas_correctas
		 */
		function esRespuestaCorrecta($respuesta_escogida, $respuestas_correctas){
			if(strlen($respuestas_correctas)== 0)
				return 'NO CALIFICADAS';
			$respuestas_correctas = explode(',',$respuestas_correctas);
			switch(count($respuesta_escogida)){
				case 0:
					return 'VACIAS';
				case 1:
					return in_array(upper($respuesta_escogida[0]), $respuestas_correctas)? 'CORRECTAS': 'INCORRECTAS';
				default:
					return 'NULAS';
			}
		}
		
		function clasificarRespuesta($cod_interno, $respuesta, $pregunta, $valoracion){
			$cod_componente = $pregunta['cod_componente'];
			if(is_blank($cod_componente)){
				debug($pregunta);
				exit();
			}
			$curso = GeneraPuntaje::consultarDatoEstudiante($cod_interno,'cod_curso');
			$grupo = GeneraPuntaje::consultarDatoEstudiante($cod_interno,'grupo');
			
			$this->estadisticasPorPregunta['GENERAL'][$cod_componente][$valoracion]++;
			/*
			if(!isset($this->estadisticasPorPregunta['CURSO'][$curso][$cod_componente][$valoracion]))
				$this->estadisticasPorPregunta['CURSO'][$curso][$cod_componente][$valoracion] = 0;
			$this->estadisticasPorPregunta['CURSO'][$curso][$cod_componente][$valoracion]++;
			
			if(!isset($this->estadisticasPorPregunta['GRUPO'][$grupo][$cod_componente][$valoracion]))
				$this->estadisticasPorPregunta['GRUPO'][$grupo][$cod_componente][$valoracion] = 0;
			$this->estadisticasPorPregunta['GRUPO'][$grupo][$cod_componente][$valoracion]++;*/
			
			$competencia = $pregunta['cod_competencia'];
			if(!isset($this->estadisticasCompetencias['GENERAL'][$cod_componente][$competencia][$valoracion]))
				$this->estadisticasCompetencias['GENERAL'][$cod_componente][$competencia][$valoracion] = 0;
			$this->estadisticasCompetencias['GENERAL'][$cod_componente][$competencia][$valoracion]++;
			
			if(!isset($this->competenciasIndividuales[$cod_componente][$competencia][$valoracion]))
				$this->competenciasIndividuales[$cod_componente][$competencia][$valoracion] = 0;
			$this->competenciasIndividuales[$cod_componente][$competencia][$valoracion]++;
			/*
			if(!isset($this->estadisticasCompetencias['CURSO'][$curso][$cod_componente][$competencia][$valoracion]))
				$this->estadisticasCompetencias['CURSO'][$curso][$cod_componente][$competencia][$valoracion] = 0;
			$this->estadisticasCompetencias['CURSO'][$curso][$cod_componente][$competencia][$valoracion]++;
			
			if(!isset($this->estadisticasCompetencias['GRUPO'][$grupo][$cod_componente][$competencia][$valoracion]))
				$this->estadisticasCompetencias['GRUPO'][$grupo][$cod_componente][$competencia][$valoracion] = 0;
			$this->estadisticasCompetencias['GRUPO'][$grupo][$cod_componente][$competencia][$valoracion]++;
			*/
			$cualitativo = $pregunta['cod_cualitativo'];
			if(!isset($this->estadisticasCualitativos['GENERAL'][$cod_componente][$cualitativo][$valoracion]))
				$this->estadisticasCualitativos['GENERAL'][$cod_componente][$cualitativo][$valoracion] = 0;
			$this->estadisticasCualitativos['GENERAL'][$cod_componente][$cualitativo][$valoracion]++;
			
			if(!isset($this->cualitativosIndividuales[$cod_componente][$cualitativo][$valoracion]))
				$this->cualitativosIndividuales[$cod_componente][$cualitativo][$valoracion] = 0;
			$this->cualitativosIndividuales[$cod_componente][$cualitativo][$valoracion]++;
			/*
			if(!isset($this->estadisticasCualitativos['CURSO'][$curso][$cod_componente][$cualitativo][$valoracion]))
				$this->estadisticasCualitativos['CURSO'][$curso][$cod_componente][$cualitativo][$valoracion] = 0;
			$this->estadisticasCualitativos['CURSO'][$curso][$cod_componente][$cualitativo][$valoracion]++;
			
			if(!isset($this->estadisticasCualitativos['GRUPO'][$grupo][$cod_componente][$cualitativo][$valoracion]))
				$this->estadisticasCualitativos['GRUPO'][$grupo][$cod_componente][$cualitativo][$valoracion] = 0;
			$this->estadisticasCualitativos['GRUPO'][$grupo][$cod_componente][$cualitativo][$valoracion]++;
			*/
		}
		
		function calificarRespuestas($cod_interno, $respuestas){
			$resultados = array();
			foreach($this->componentes as $componente)
				$resultados[$componente] = array('CORRECTAS'=>0, 'INCORRECTAS'=>0,'NULAS'=>0, 'VACIAS'=>0, 'TOTAL'=>0);
				
			foreach($this->preguntas as $pregunta){
				$respuesta = $respuestas[$pregunta['codigo']];
				$respuesta_escogida = GeneraPuntaje::definirRespuestaEscogida($respuesta);
				$valoracion = GeneraPuntaje::esRespuestaCorrecta($respuesta_escogida, $respuesta['respuesta']);
				GeneraPuntaje::clasificarRespuesta($cod_interno, $respuesta, $pregunta, $valoracion);
				
				$cod_componente = $pregunta['cod_componente'];
				$resultados[$cod_componente][$valoracion]++;
			}
			foreach($this->componentes as $componente)
				$resultados[$componente]['TOTAL'] = $resultados[$componente]['CORRECTAS'] * 100 / $this->totalPreguntasPorComponentes[$componente]['cantidad'];
				
			return $resultados;
		}
		
		
		function calcularCompetencias($cod_interno){
			foreach($this->competenciasIndividuales as $cod_componente=>$competencias)
				foreach($competencias as $cod_competencia=>$puntaje){
					$a = array();
					$a['cod_interno'] = $cod_interno;
					$a['cod_prueba'] = $this->cod_prueba;
					$a['cod_componente'] = $cod_componente;
					$a['cod_competencia'] = $cod_competencia;
					$a['puntaje'] = any($puntaje['CORRECTAS'],0);
					$a['codigo'] = zeropad($this->cod_prueba,2).zeropad($cod_componente,2).zeropad($cod_competencia,2).$cod_interno;
				//	echo "VAMOS AMIRAR QUE SI  ESTE INSERTANDO ESTA VAINA"."<br/>";
					$sql = sql_insert_from_array('i_puntajes_competencias',$a);
       // echo  "esto inserta"."<br/>".$sql;
          
					//if($this->debug)
					//	Logger::sql($sql);
					//else
						$this->db->query($sql);
				}
//			debug($this->competenciasIndividuales);
		}
		
		function calcularCualitativos($cod_interno){
			foreach($this->cualitativosIndividuales as $cod_componente=>$cualitativos)
				foreach($cualitativos as $cod_cualitativo=>$puntaje){
					$a = array();
					$a['cod_interno'] = $cod_interno;
					$a['cod_prueba'] = $this->cod_prueba;
					$a['cod_componente'] = $cod_componente;
					$a['cod_cualitativo'] = $cod_cualitativo;
					$a['puntaje'] = any($puntaje['CORRECTAS'],0);
					$a['codigo'] = zeropad($this->cod_prueba,2).zeropad($cod_componente,2).zeropad($cod_cualitativo,2).$cod_interno;
 				  $sql = sql_insert_from_array('i_puntajes_cualitativos',$a);
					//if($this->debug)
					//	Logger::sql($sql);
				//	else
						$this->db->query($sql);
				}
//			debug($this->competenciasIndividuales);
		}
		
		
		function procesarCompetencias(){
				echo "<h2>Reporte Competencias</h2>";
				echo "<table>
								<thead><tr><td>Componente</td><td>Competencia</td><td>Nulas</td><td>Vacias</td><td>Incorrectas</td><td>Correctas</td><td>TOTAL</td></tr></thead>";
			
				foreach($this->componentes as $componente){
					foreach($this->competencias[$componente] as $competencia){
						$cod_competencia = $competencia['cod_competencia'];
						$this->estadisticasCompetencias['GENERAL'][$componente][$cod_competencia]['TOTAL'] =  $this->estadisticasCompetencias['GENERAL'][$componente][$cod_competencia]['CORRECTAS'] * 100 / ($this->totalEstudiantes * $competencia['cantidad']);
						echo "<tr>
									<th>".$this->nombresComponentes[$componente]['nombre']."</th>
									<th>".$this->nombresCompetencias[$cod_competencia]['nombre']."</th>
									<td>".number_format($this->estadisticasCompetencias['GENERAL'][$componente][$cod_competencia]['NULAS'],0)."</td>
									<td>".number_format($this->estadisticasCompetencias['GENERAL'][$componente][$cod_competencia]['VACIAS'],0)."</td>
									<td>".number_format($this->estadisticasCompetencias['GENERAL'][$componente][$cod_competencia]['INCORRECTAS'],0)."</td>
									<td>".number_format($this->estadisticasCompetencias['GENERAL'][$componente][$cod_competencia]['CORRECTAS'],0)."</td>
									<td style='background-color:#EEE'>".number_format($this->estadisticasCompetencias['GENERAL'][$componente][$cod_competencia]['TOTAL'], 2)."</td>
									</tr>";
					}
				}
				echo "</tbody></table>";
		}
		
		function procesarCualitativos(){
				echo "<h2>Reporte Cualitativos</h2>";
				echo "<table>
								<thead><tr><td>Componente(Area)</td><td>Componente Cualitativo</td><td>Nulas</td><td>Vacias</td><td>Incorrectas</td><td>Correctas</td><td>TOTAL</td></tr></thead>";
			
				foreach($this->componentes as $componente){
					foreach($this->cualitativos[$componente] as $cualitativo){
						$cod_cualitativo = $cualitativo['cod_cualitativo'];
						$this->estadisticasCualitativos['GENERAL'][$componente][$cod_cualitativo]['TOTAL'] =  $this->estadisticasCualitativos['GENERAL'][$componente][$cod_cualitativo]['CORRECTAS'] * 100 / ($this->totalEstudiantes * $cualitativo['cantidad']);
						echo "<tr>
									<th>".$this->nombresComponentes[$componente]['nombre']	."</th>
									<th>".$this->nombresCualitativos[$cod_cualitativo]['nombre']."</th>
									<td>".number_format($this->estadisticasCualitativos['GENERAL'][$componente][$cod_cualitativo]['NULAS'],0)."</td>
									<td>".number_format($this->estadisticasCualitativos['GENERAL'][$componente][$cod_cualitativo]['VACIAS'],0)."</td>
									<td>".number_format($this->estadisticasCualitativos['GENERAL'][$componente][$cod_cualitativo]['INCORRECTAS'],0)."</td>
									<td>".number_format($this->estadisticasCualitativos['GENERAL'][$componente][$cod_cualitativo]['CORRECTAS'],0)."</td>
									<td style='background-color:#EEE'>".number_format($this->estadisticasCualitativos['GENERAL'][$componente][$cod_cualitativo]['TOTAL'], 2)."</td>
									</tr>";
					}
				}
				echo "</tbody></table>";
		}
		
	}
?>
