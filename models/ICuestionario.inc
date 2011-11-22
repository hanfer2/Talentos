<?php

	class ICuestionario extends TBase{
	
		function IComponente(){
			require_once 'IComponente.inc';
			return new IComponente();
		}



/*funcion que me retorna el codigo interno de un estudiante que presento la prueba, 
 * que se encuentra en 	i_cuestionarios_diligenciados*/

function codigoInterno_estudiantePrueba($prueba){
  
$sql ="select cod_interno from i_cuestionarios_diligenciados where cod_prueba='$prueba'";

return DB::query($sql);

}
		/**
		 * Permite la actualizacion de un cuestionario.
		 * Si el cuestionario ya tiene registros calificados, actualizara cada pregunta existente;
		 * de lo contrario, eliminara las preguntas, y almacenara las nuevas preguntas indicadas.
		 */
		function actualizar($cod_prueba, $cod_componente, $preguntas){
			if($this->estaCalificada($cod_prueba))
				$this->actualizarPreguntas($preguntas);
			elseif($this->delete($cod_prueba, $cod_componente)){
				return $this->registrarPreguntas($cod_prueba, $preguntas);
			}
			return false;
		}
		
		
		function actualizarPregunta($codigo, $pregunta){
			unset($pregunta['codigo']);
			$sql = sql_update_from_array(Config::Get(__CLASS__, 'Pregunta'), $pregunta , "codigo = '$codigo'");
			$db = DB::instance($this);
			$db->query($sql);
		}
		
		function actualizarPreguntas($preguntas){
			foreach($preguntas as $pregunta){
				if(is_array($pregunta['respuesta']))
					$pregunta['respuesta'] = implode(",",$pregunta['respuesta']);
				if(!isset($pregunta['valida']) || $pregunta['valida'] != 't')
					$pregunta['valida'] = 'f';
				$this->actualizarPregunta($pregunta['codigo'], $pregunta);
			}
		}
		
		function delete($cod_prueba, $cod_componente=null){
			if(is_blank($cod_prueba))
				return FALSE;
				
			$sql = "DELETE FROM ".Config::Get(__CLASS__, 'Pregunta')." WHERE cod_prueba = '$cod_prueba'";
			if($cod_componente != null)
				$sql .= " AND cod_componente = '$cod_componente' ";
			DB::query($sql);
			return true;
		}
		
		function registrarPregunta($pregunta){
			$sql = sql_insert_from_array(Config::Get(__CLASS__, 'Pregunta'), $pregunta);
			DB::query($sql);
		}
		
		function registrarPreguntas($cod_prueba, $preguntas){
			for($i=1; $i <count($preguntas)+1; $i++){
				$preguntas[$i]['cod_prueba'] = $cod_prueba;
				$preguntas[$i]['numeral'] = intval($preguntas[$i]['numeral']);
				if(is_array($preguntas[$i]['respuesta']))
					$preguntas[$i]['respuesta'] = implode(",",$preguntas[$i]['respuesta']);
				ICuestionario::registrarPregunta($preguntas[$i]);
			}
			return true;
		}
		
		function componentes(){
			$componentes = parent::all('IComponente');
			return $componentes;
		}
		
		
		function digitador($cod_prueba, $cedula){
			$db = DB::instance(this);
			$cod_interno = TPersona::cod_interno($cedula);
			if($cod_interno == null)
				return false;
			$sql = "SELECT cod_digitador FROM ".Config::Get(__CLASS__, 'Diligenciados'). " WHERE cod_prueba = '$cod_prueba' AND cod_interno ='$cod_interno' ";
			return $db->fetchOne($sql);
		}
		
		/**
		 * Listado de Preguntas de Un Simulacro. 
		 * 
		 * NOTA: Indiquese el codigo del componente 
		 * si quiere acotarse el listado a solo las preguntas 
		 * que corresponden a esa area/componente
		 * 
		 * @param string $cod_prueba codigo de la prueba/simulacro
		 * @param string $cod_componente codigo del componente
		 * 
		 * @return array Listado de todas las preguntas asignadas a la prueba,
		 * ordenado por codigo del componente y numeral.
		 */
		function preguntas($cod_prueba, $cod_componente=null){
			if($cod_prueba == null)
				return false;
			
			$sql = "SELECT * FROM ".Config::Get(__CLASS__, 'Pregunta').
						 " WHERE cod_prueba = '$cod_prueba' ";
		  
		  if($cod_componente != null)
				$sql .= " AND cod_componente = '$cod_componente'";
				
			$sql .= " ORDER BY cod_componente, numeral";
			
			return DB::table_query($sql);
		}
		
		function preguntasParaNotas($cod_prueba){
			if($cod_prueba == null)
				return false;
			$sql = "SELECT preguntas.codigo, numeral, cod_componente, componente.nombre AS nombre_componente
							FROM ".Config::Get(__CLASS__, 'Pregunta'). " preguntas INNER JOIN ".Config::Get('IComponente')." componente ON (componente.codigo = cod_componente)".
						 " WHERE cod_prueba = '$cod_prueba' ORDER BY cod_componente, numeral";
			return DB::table_query($sql, "nombre_componente");
		}
		
		function preguntasEnFormatoCalificaciones($cod_prueba){
			if($cod_prueba == null)
				return false;
			$sql = "SELECT preguntas.*, componente.nombre AS nombre_componente
							FROM ".Config::Get(__CLASS__, 'Pregunta'). " preguntas INNER JOIN ".Config::Get('IComponente')." componente ON (componente.codigo = cod_componente)".
						 " WHERE cod_prueba = '$cod_prueba' AND valida = 't' ORDER BY cod_componente, numeral";
			$result = DB::table_query($sql, "cod_componente");
			$preguntas = array();
			foreach($result as $nombre_campo => $preguntas_componentes){
				$preguntas[$nombre_campo] = array();
				foreach($preguntas_componentes as $pregunta){
					$preguntas[$nombre_campo][$pregunta['codigo']] = $pregunta;
				}
			}
			return $preguntas;
		}
		
		function estaCalificada($cod_prueba, $cedula=null){
			$sql = "SELECT 1 FROM ".Config::Get(__CLASS__,'Diligenciados')." WHERE cod_prueba = '$cod_prueba' ";
			if($cedula !=null){
				$cod_interno = TPersona::cod_interno($cedula);
				if($cod_interno == null){
					return false;
				}
				$sql .=" AND cod_interno = $cod_interno ";
			}
			
			$sql .=" LIMIT 1 ";
			$result = DB::query($sql);
			return !empty($result);
		}
		
		function cantidad_respuestas($cod_prueba, $cedula){
			$cod_interno = TPersona::cod_interno($cedula);
			if($cod_interno == null)
				return false;
			$db = DB::instance(this);
			$sql = "SELECT COUNT(*) FROM ".Config::Get(__CLASS__,'Respuesta').
						 " WHERE cod_interno = '$cod_interno' AND cod_pregunta IN ".
								"(select codigo FROM ".Config::Get(__CLASS__,'Pregunta')." WHERE cod_prueba = '$cod_prueba')";
			return $db->fetchOne($sql);
		}
		
		function respuestas($cod_prueba, $cedula){
			$cod_interno = TPersona::cod_interno($cedula);
			if($cod_interno == null)
				return false;
			//consultamos la cantidad de respuestas del usuario en la prueba
			$db = DB::instance();
		
			$sql = "SELECT numeral ,a, b, c, d, e, componentes.nombre as nombre_componente, respuesta
							FROM ( SELECT * FROM ".Config::Get(__CLASS__,'Respuesta'). " WHERE cod_interno = '$cod_interno' ) respuestas ".
						  " RIGHT JOIN ".Config::Get(__CLASS__,'Pregunta') . " preguntas ON (cod_pregunta = preguntas.codigo) ".
						  " INNER JOIN ".Config::Get('IComponente') . " componentes ON (cod_componente = componentes.codigo) ".
						  " WHERE cod_prueba = '$cod_prueba' AND valida IS TRUE ORDER BY cod_componente, numeral";
              
        
     // echo $sql;
              
			return $db->table_query($sql, "nombre_componente");
		}
		
		
		
		function hayRespuestaEn($cedula, $cod_prueba, $numeral ){
				$cod_interno = TPersona::cod_interno($cedula);
				if($cod_interno == null)
					return FALSE;
				$sql = "SELECT 1 FROM ".Config::Get(__CLASS__,'Respuesta')." WHERE cod_interno = '$cod_interno' ".
							 " AND cod_pregunta = (select codigo from ".Config::Get(__CLASS__,'Pregunta') . 
										" where cod_prueba = '$cod_prueba' and numeral = '$numeral')";
				$db = DB::instance(this);
				return $db->fetchOne($sql) != null;
		}
		
		function actualizarRespuestaEscogida($cedula, $cod_prueba, $numeral, $respuestas){
			$cod_interno = TPersona::cod_interno($cedula);
			if($cod_interno == null)
				return FALSE;
				
			$arr = explode(",",lower($respuestas));
			$sql = "UPDATE i_respuestas SET ";

			foreach(range('a','e') as $letra)
				if(in_array($letra, $arr))
					$sql .= " $letra = TRUE,";
				else
					$sql .= " $letra = FALSE,";

			$sql = substr($sql, 0, -1)	;
			$sql .=" where cod_pregunta = (select codigo from i_preguntas where cod_prueba=$cod_prueba and numeral = '$numeral') and cod_interno = $cod_interno";
			
				
			DB::query($sql);
		}
		
		function pregunta( $cod_prueba, $numeral){
			$sql = "select codigo FROM ".Config::Get(__CLASS__,'Pregunta')." WHERE cod_prueba = '$cod_prueba' AND numeral = '$numeral'";
			$db = DB::instance(this);
			return $db->fetchOne($sql);
		}
		
		function insertarRespuestaEscogida($cedula, $cod_pregunta, $respuestas){
			$data = array();
			$data['cod_interno'] = TPersona::cod_interno($cedula);
			$data['cod_pregunta'] = $cod_pregunta;
			
			if(!is_array($respuestas))
				$respuestas = explode(",",lower($respuestas));
				
			foreach(range('a','e') as $letra)
				$data[$letra] = (in_array($letra, $respuestas))?'TRUE':'FALSE' ;
			
			$db = DB::instance($this);	
			$sql = sql_insert_from_array(Config::Get(__CLASS__, 'Respuesta'), $data);
			$db->query($sql);
		}
		
		function _esRespuestaCorrecta($respuesta_escogida, $respuesta_correcta){
			$respuesta_correcta = arrayize($respuesta_correcta);
			switch(count($respuesta_escogida)){
				case 0:
					return 0;
				case 1:
					return in_array(key($respuesta_escogida), $respuesta_correcta)? 1: -1;
				default:
					return -2;
			}
		}
		
		function _guardarRespuestas($cod_interno,$respuestas){
			$db = DB::instance();
			$table = Config::Get('TIcfes','Respuesta');
			foreach($respuestas as $cod_pregunta=>$respuesta){
				$respuesta['cod_interno'] = $cod_interno;
				$respuesta['cod_pregunta'] = $cod_pregunta;
				$sql = lower(sql_insert_from_array($table,$respuesta));
				$db->query($sql);
			}
		}
		
	 /**
		*	- Guarda en la BD las respuestas escogidas por un estudiante.
		* - Registra el cuestionario como diligenciado y el digitador que lo diligencio.
		* 
		* @param int $cod_interno codigo interno del estudiante que respondio el cuestionario
		* @param int $cod_simulacrio codigo del simulacro que se diligencio.
		* @param array $respuestas respuestas escogidas por el estudiante.
		* @param int $cod_digitador codigo interno del digitador que diligencio el cuestionario.
    * 
		**/
		function diligenciar($cod_interno, $cod_prueba, $respuestas, $cod_digitador){
			$this->_guardarRespuestas($cod_interno, $respuestas);
			$data = array('cod_interno'=>$cod_interno, 'cod_prueba'=>$cod_prueba, 'cod_digitador'=>$cod_digitador);
			$sql = sql_insert_from_array(Config::get(__CLASS__, 'Diligenciados'), $data);
			DB::query($sql);
		}
	
		function _guardarPuntaje($cod_interno, $cod_prueba, $puntajes){
			$adapter = array(1=>'biologia', 2=>'fisica',3=>'quimica',4=>'matematica',
											 5=>'geografia',6=>'lenguaje',7=>'historia',8=>'filosofia',9=>'interdisciplinar');
			$icfes = array('cod_interno'=>$cod_interno, 'tipo'=>$cod_prueba, 'num_registro_icfes'=>date('Y').zeropad($cod_prueba, 2)."-".$cod_interno);
			
			foreach($puntajes as $cod_componente=>$puntaje){
				$icfes[$adapter[$cod_componente]] = $puntaje;
			}	
			$sql = sql_insert_from_array(Config::Get('TIcfes'),$icfes);		
			DB::query($sql);
		}
		/*probar con estas funciones para mirar si funciona con ellas */
		function registrarRespuestasPorEstudiante($cod_interno, $cod_prueba, $preguntas, $respuestas){
			$resultados = ICuestionario::_calificarRespuestas($preguntas, $respuestas);
			ICuestionario::_guardarPuntaje($cod_interno, $cod_prueba, $resultados['componentes']);
		}
		
		function _calificarRespuestas($preguntas, $respuestas){
			$resultados = array('componentes'=>array(),'competencias'=>array(),'cualitativos'=>array());
			
			foreach($preguntas as $cod_componente =>$preguntas_componente):
				$reporteRespuestas = array('CORRECTAS'=>0, 'INCORRECTAS'=>0,'NULAS'=>0, 'VACIAS'=>0);
				$resultados['competencias'][$cod_componente] = array();
				$resultados['cualitativos'][$cod_componente] = array();
				
				foreach($preguntas_componente as $cod_pregunta=>$pregunta):
						if(!isset($resultados['competencias'][$cod_componente][$pregunta['cod_competencia']]))
							$resultados['competencias'][$cod_componente][$pregunta['cod_competencia']] = array('CORRECTAS'=>0, 'TOTAL'=>0);
						if(!isset($resultados['cualitativos'][$cod_componente][$pregunta['cod_cualitativo']]))
							$resultados['cualitativos'][$cod_componente][$pregunta['cod_cualitativo']] = array('CORRECTAS'=>0, 'TOTAL'=>0);
							
						$resultados['competencias'][$cod_componente][$pregunta['cod_competencia']]['TOTAL']++;
						$resultados['cualitativos'][$cod_componente][$pregunta['cod_cualitativo']]['TOTAL']++;
						
						switch(ICuestionario::_esRespuestaCorrecta($respuestas[$cod_pregunta], $pregunta['respuesta'])){
							case 0: //NO RESPONDIO -> PREGUNTA VACIA
								$reporteRespuestas['VACIAS']++;
								break;
							case -1: //RESPUESTA INCORRECTA
								$reporteRespuestas['INCORRECTAS']++;
								break;
							case -2: //RESPUESTA NULA
								$reporteRespuestas['NULAS']++;
								break;
							default:
								$reporteRespuestas['CORRECTAS']++;
								$resultados['competencias'][$cod_componente][$pregunta['cod_competencia']]['CORRECTAS']++;
								$resultados['cualitativos'][$cod_componente][$pregunta['cod_cualitativo']]['CORRECTAS']++;
						}
				endforeach;
				$resultados['componentes'][$cod_componente] = $reporteRespuestas['CORRECTAS'] * 100 / count($preguntas_componente);
				
				$r = $resultados['competencias'][$cod_componente];
				foreach($r as $cod_competencia=>$resumen){
					$resultados['competencias'][$cod_componente][$cod_competencia] = $resumen['CORRECTAS'] * 100 / $resumen['TOTAL'];
				}
				
				$r = $resultados['cualitativos'][$cod_componente];
				foreach($r as $cod_cualitativo=>$resumen){
					$resultados['cualitativos'][$cod_componente][$cod_cualitativo] = $resumen['CORRECTAS'] * 100 / $resumen['TOTAL'];
				}
			endforeach;
			print_r($resultados);
			return $resultados;
		}
		
		function exists($cod_prueba){
			$sql = "select 1 FROM ".Config::get(__CLASS__, 'Pregunta')." WHERE cod_prueba = '".q($cod_prueba)."' LIMIT 1";
			return DB::query($sql) == '1';
		}
	}
?>
