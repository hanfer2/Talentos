<?php
	require_once 'TGrupo.inc';


	class ICualitativo extends TBase{

		function all($options=array()){
			return parent::all(__CLASS__, $options);
		}

		function nombre($codigo){
			return parent::get(__CLASS__, $codigo,'nombre');
		}

		function to_a(){
			$cualitativos = ICualitativo::all();
			$array = array();
			foreach($cualitativos as $cualitativo){
				$array[$cualitativo['codigo']] = $cualitativo['nombre'];
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
				$cualitativos = ITipo::cualitativos($cod_prueba, $componente);
				if(is_null($cualitativos))
					continue;
				$sql = "SELECT cod_cualitativo, nombre_cualitativo, puntaje
								FROM ".Config::get(__CLASS__, 'V-Puntaje')."
								WHERE cedula = '$cedula' AND cod_prueba = '$cod_prueba'
                  AND nombre_componente = '$componente'";
				
				$puntaje = DB::grouped_query($sql, "cod_cualitativo");
				$puntajes[$componente] = $puntaje;
			}
			return $puntajes;
		}
		
		function por_componentes($cod_prueba, $grouped_by='nombre_componente'){
			$sql = "SELECT cod_componente, cod_cualitativo, 
                    nombre_cualitativo, nombre_componente , count(*) AS cantidad_preguntas
              FROM ".	Config::Get('ICuestionario','V-Pregunta').
            " WHERE cod_prueba='$cod_prueba' AND valida IS TRUE
             GROUP BY cod_componente, cod_cualitativo, nombre_cualitativo, nombre_componente ";
			return DB::table_query($sql, $grouped_by);
		}

		function por_curso($cod_curso, $cod_prueba){
			$puntajes = array();
			$sql = "SELECT cedula, fullname, nombre_componente, nombre_cualitativo, puntaje
							FROM ".Config::get(__CLASS__, 'V-Puntaje').
						" WHERE cod_prueba = '$cod_prueba' AND cod_curso = '$cod_curso' ".
            " ORDER BY fullname, nombre_componente, nombre_cualitativo" ;
			$registros = DB::table_query($sql);
       if($registros != null){
			foreach($registros as $registro){
				$cedula = $registro['cedula'];
				if(!isset($puntajes[$cedula])){
					$puntajes[$cedula] = array();
					$puntajes[$cedula]['fullname'] = $registro['fullname'];
					$puntajes[$cedula]['puntajes'] = array();
				}
				$puntajes[$cedula]['puntajes'][$registro['nombre_componente']][$registro['nombre_cualitativo']] = $registro['puntaje'];
			}
    }
			return $puntajes;
		}

		function por_programa($cod_prueba){
			$cod_prueba = q($cod_prueba);
			$_puntajes = array();
			$sql = "SELECT grupo, t_puntajes.*, nombre_cualitativo, cantidad_preguntas
							FROM 
								(SELECT cod_curso, nombre_curso, nombre_componente, cod_cualitativo, SUM(puntaje)::int as puntaje, COUNT(*) AS cantidad ".
							 "FROM ".Config::Get(__CLASS__, 'V-Puntaje').
							 " WHERE cod_prueba = '$cod_prueba' ".
							 " GROUP BY cod_curso, nombre_curso, nombre_componente, cod_cualitativo) t_puntajes
						  INNER JOIN ".Config::Get('TGrupo','viewname')." ON (cod_grupo = cod_curso)
						  INNER JOIN (
								SELECT nombre_componente, cod_cualitativo, nombre_cualitativo, COUNT(*) AS cantidad_preguntas
								FROM ".Config::get('ICuestionario','V-Pregunta')."
								WHERE cod_prueba = '$cod_prueba' AND valida IS TRUE
								GROUP BY nombre_componente, cod_cualitativo, nombre_cualitativo
						  ) t_cualitativos USING (nombre_componente, cod_cualitativo)
						 ORDER BY grupo, cod_curso, nombre_componente";	
			$registros = DB::table_query($sql);
      if($registros != null){
			foreach($registros as $registro){
				if(!isset($_puntajes[$registro['grupo']][$registro['cod_curso']])){
					$_puntajes[$registro['grupo']][$registro['cod_curso']]['nombre'] = $registro['nombre_curso'];
					$_puntajes[$registro['grupo']][$registro['cod_curso']]['puntajes'] = array();
				}
      
				$a = array('puntaje'=>$registro['puntaje'],'cantidad'=>$registro['cantidad'],'preguntas'=>$registro['cantidad_preguntas']);
				$_puntajes[$registro['grupo']][$registro['cod_curso']]['puntajes'][$registro['nombre_componente']][$registro['nombre_cualitativo']] = $a;
			}
    }
			return $_puntajes;
		}
		
		function consolidado($cod_prueba){
			$cod_prueba = q($cod_prueba);
			$puntajes = array();
			$sql = "SELECT t_puntajes.*, nombre_cualitativo, cantidad_preguntas
							FROM 
								(SELECT grupo, nombre_componente, cod_cualitativo, SUM(puntaje)::int as puntaje, COUNT(*) AS cantidad ".
							" FROM ".Config::Get(__CLASS__, 'V-Puntaje').
							"  INNER JOIN ".Config::Get('TGrupo','viewname')." ON (cod_grupo = cod_curso)".
							" WHERE cod_prueba = '$cod_prueba' ".
							" GROUP BY grupo, nombre_componente, cod_cualitativo) t_puntajes
						  INNER JOIN (
								SELECT nombre_componente, cod_cualitativo, nombre_cualitativo, COUNT(*) AS cantidad_preguntas
								FROM ".Config::get('ICuestionario','V-Pregunta')."
								WHERE cod_prueba = '$cod_prueba' AND valida IS TRUE
								GROUP BY nombre_componente, cod_cualitativo, nombre_cualitativo
						  ) t_cualitativos USING (nombre_componente, cod_cualitativo)
						 ORDER BY grupo, nombre_componente";	
			$registros = DB::table_query($sql);
    if($registros != null){
			foreach($registros as $registro){
				if(!isset($puntajes[$registro['grupo']])){
					$puntajes[$registro['grupo']] = array();
				}
				$a = array('puntaje'=>$registro['puntaje'],'cantidad'=>$registro['cantidad'],'preguntas'=>$registro['cantidad_preguntas']);
				$puntajes[$registro['grupo']][$registro['nombre_componente']][$registro['nombre_cualitativo']] = $a;
			}
    }
			return $puntajes;
		}
		
	}

?>
