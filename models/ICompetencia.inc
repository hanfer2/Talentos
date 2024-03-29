<?php
	require_once 'TGrupo.inc';


	class ICompetencia extends TBase{

		function all($options=array()){
			return parent::all(__CLASS__, $options);
		}

		function nombre($codigo){
			return parent::get(__CLASS__, $codigo,'nombre');
		}

		function to_a(){
			$competencias = ICompetencia::all();
			$array = array();
			foreach($competencias as $competencia){
				$array[$competencia['codigo']] = $competencia['nombre'];
			}
			return $array;
		}

		function por_estudiante($cedula, $cod_prueba, $options=array()){
			$puntajes = array();
			$componentes = null;
			if(!isset($options['componentes']))
				$componentes = IComponente::all($cod_prueba, array('select'=>'nombre'));
			else
				$componentes = $options['componentes'];
			if(empty($componentes))
				return null;
			foreach($componentes as $componente){
				$puntajes[$componente] = array();
				$competencias = ITipo::competencias($cod_prueba, $componente);
				if(is_null($competencias))
					continue;
				$sql = "SELECT cod_competencia, nombre_competencia, puntaje
								FROM ".Config::get(__CLASS__, 'V-Puntaje')."
								WHERE cedula = '$cedula' AND cod_prueba = '$cod_prueba'
                  AND nombre_componente = '$componente'";
				
				$puntaje = DB::grouped_query($sql, "cod_competencia");
				$puntajes[$componente] = $puntaje;
			}
			return $puntajes;
		}
		
		function por_componentes($cod_prueba, $grouped_by='nombre_componente'){
			$sql = "SELECT cod_componente, cod_competencia, 
                    nombre_competencia, nombre_componente , count(*) AS cantidad_preguntas
              FROM ".	Config::Get('ICuestionario','V-Pregunta').
            " WHERE cod_prueba='$cod_prueba' AND valida IS TRUE
             GROUP BY cod_componente, cod_competencia, nombre_competencia, nombre_componente ";
			return DB::table_query($sql, $grouped_by);
		}

		function por_curso($cod_curso, $cod_prueba){
			$puntajes = array();
			$sql = "SELECT cedula, fullname, nombre_componente, nombre_competencia, puntaje
							FROM ".Config::get(__CLASS__, 'V-Puntaje').
						" WHERE cod_prueba = '$cod_prueba' AND cod_curso = '$cod_curso' ".
            " ORDER BY fullname, nombre_componente, nombre_competencia" ;
			$registros = DB::table_query($sql);
     // if($registros != null){
			foreach($registros as $registro){
				$cedula = $registro['cedula'];
				if(!isset($puntajes[$cedula])){
					$puntajes[$cedula] = array();
					$puntajes[$cedula]['fullname'] = $registro['fullname'];
					$puntajes[$cedula]['puntajes'] = array();
				}
				$puntajes[$cedula]['puntajes'][$registro['nombre_componente']][$registro['nombre_competencia']] = $registro['puntaje'];
			}
   // }
			return $puntajes;
		}
//la tabla i_preguntas_competencias nunca se esta llenando con la prueba actual, simulacro---buscar donde se hace o  debe hacereso
		function por_programa($cod_prueba){
			$cod_prueba = q($cod_prueba);
     // echo "la prueba es : ".$cod_prueba."<br/>";
			$_puntajes = array();
			$sql = "SELECT grupo, t_puntajes.*, nombre_competencia, cantidad_preguntas
							FROM 
								(SELECT cod_curso, nombre_curso, nombre_componente, cod_competencia, SUM(puntaje)::int as puntaje, COUNT(*) AS cantidad ".
							 "FROM ".Config::Get(__CLASS__, 'V-Puntaje').
							 " WHERE cod_prueba = '$cod_prueba' ".
							 " GROUP BY cod_curso, nombre_curso, nombre_componente, cod_competencia) t_puntajes
						  INNER JOIN ".Config::Get('TGrupo','viewname')." ON (cod_grupo = cod_curso)
						  INNER JOIN (
								SELECT nombre_componente, cod_competencia, nombre_competencia, COUNT(*) AS cantidad_preguntas
								FROM ".Config::get('ICuestionario','V-Pregunta')."
								WHERE cod_prueba = '$cod_prueba' AND valida IS TRUE
								GROUP BY nombre_componente, cod_competencia, nombre_competencia
						  ) t_competencias USING (nombre_componente, cod_competencia)
						 ORDER BY grupo, cod_curso, nombre_componente";	
           //  echo $sql;
			$registros = DB::table_query($sql);
  if(is_null($registros)){
  echo "<br/>"."ERROR NO HAY PUNTAJE POR COMPETENCIAS PARA LA PRUEBA ACTUAL"."<br/>";}
  else
  {
			foreach($registros as $registro){
        
				if(!isset($_puntajes[$registro['grupo']][$registro['cod_curso']])){
					$_puntajes[$registro['grupo']][$registro['cod_curso']]['nombre'] = $registro['nombre_curso'];
					$_puntajes[$registro['grupo']][$registro['cod_curso']]['puntajes'] = array();
          
				}
				$a = array('puntaje'=>$registro['puntaje'],'cantidad'=>$registro['cantidad'],'preguntas'=>$registro['cantidad_preguntas']);
				$_puntajes[$registro['grupo']][$registro['cod_curso']]['puntajes'][$registro['nombre_componente']][$registro['nombre_competencia']] = $a;
			}
}
			return $_puntajes;
		}
		
		function consolidado($cod_prueba){
			$cod_prueba = q($cod_prueba);
			$puntajes = array();
			$sql = "SELECT t_puntajes.*, nombre_competencia, cantidad_preguntas
							FROM 
								(SELECT grupo, nombre_componente, cod_competencia, SUM(puntaje)::int as puntaje, COUNT(*) AS cantidad ".
							" FROM ".Config::Get(__CLASS__, 'V-Puntaje').
							"  INNER JOIN ".Config::Get('TGrupo','viewname')." ON (cod_grupo = cod_curso)".
							" WHERE cod_prueba = '$cod_prueba' ".
							" GROUP BY grupo, nombre_componente, cod_competencia) t_puntajes
						  INNER JOIN (
								SELECT nombre_componente, cod_competencia, nombre_competencia, COUNT(*) AS cantidad_preguntas
								FROM ".Config::get('ICuestionario','V-Pregunta')."
								WHERE cod_prueba = '$cod_prueba' AND valida IS TRUE
								GROUP BY nombre_componente, cod_competencia, nombre_competencia
						  ) t_competencias USING (nombre_componente, cod_competencia)
						 ORDER BY grupo, nombre_componente";	
			$registros = DB::table_query($sql);
	//	if($registros != null)	{
			foreach($registros as $registro){
				if(!isset($puntajes[$registro['grupo']])){
					$puntajes[$registro['grupo']] = array();
				}
				$a = array('puntaje'=>$registro['puntaje'],'cantidad'=>$registro['cantidad'],'preguntas'=>$registro['cantidad_preguntas']);
				$puntajes[$registro['grupo']][$registro['nombre_componente']][$registro['nombre_competencia']] = $a;
			}
   // }
			return $puntajes;
		}
		
	}

?>
