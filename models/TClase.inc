<?php
	require_once 'TCurso.inc';
	require_once 'THorario.inc';
	require_once 'TAsistencia.inc';

	class TClase extends TBase {
		function get($cod_horario, $field){
			return parent::get(__CLASS__, $cod_horario, $field);
		}
		function fecha($cod_horario){
			return TClase::get($cod_horario, 'fecha');
		}

		function autor($cod_horario){
			return TClase::get($cod_horario, 'updated_by, updated_at');
		}

		function actualizar($clase){
      
			$updated_by = TPersona::cod_interno(user_logged_info('cedula'));
      //print_r($updated_by);
			$sql = sql_update_from_array(Config::get(__CLASS__), array('observaciones'=>$clase['observaciones'],'updated_at'=>  date("Y-m-d H:i:s"),'updated_by'=>$updated_by),  "codigo = '{$clase['codigo']}'");
			
      DB::query($sql);
      return $updated_by;
		}

		function verificarSiReportaAsistencia($cod_clase){
			if(is_blank($cod_clase))
			 trigger_error ("el codigo de la clase no puede estar vacio", E_USER_ERROR);
			return DB::query("SELECT 1 FROM ".Config::get('TAsistencia')." WHERE cod_clase = '$cod_clase' LIMIT 1");
		}


		function registrarAsistencia($clase, $asistencia){
			$ese = TClase::actualizar($clase);
			return TAsistencia::guardar($asistencia, $clase, $ese);
		}
		
		function cod_curso($cod_clase){
			$sql = "SELECT cod_curso FROM ".Config::get(__CLASS__)." clase INNER JOIN ".Config::get('TCurso','Vista-Horario'). " USING (cod_horario) WHERE clase.codigo = '$cod_clase'";
			return DB::query($sql);
		}
		
		function cod_componente($cod_clase){
			$sql = "SELECT cod_componente FROM cu_clases clase ".
             " JOIN v_horarios USING (cod_horario) ".
             " WHERE clase.codigo = '$cod_clase'";
			return DB::query($sql);
		}
		
		/**
		 * Cantidad de Clases Total registradas Por Curso
		 * @param string|int $cod_curso codigo del curso
		 * @return Cantidad de Clases Total registradas Por Curso
		 */
		function totalPorCurso($cod_curso, $options=array()){
			$sql = "select count(*) 
							FROM ".Config::get(__CLASS__)." INNER JOIN ".Config::get('TCurso','Vista-Horario')." USING (cod_horario) 
							where cod_curso = '$cod_curso'";
			return DB::query($sql);
		}
		
		/**
		 * Cantidad de Clases Total registradas Por Curso
		 * @param string|int $cod_curso codigo del curso
		 * @return Cantidad de Clases Total registradas Por Curso
		 */
		function totalPorComponente($cod_curso){
			if($cod_curso == null)
				return null;
			$clases = Config::get(__CLASS__);
			$cursos = Config::get('TComponente','TGrupo');
	
			$sql = "SELECT componentes.nombre as nombre_componente, inasistencias_hoy, inasistencias_total  
							FROM (select cod_componente, count(*) as inasistencias_hoy 
									FROM $clases INNER JOIN $cursos USING (cod_horario) 
									where cod_curso = '$cod_curso' AND fecha < now() group by cod_componente)hoy 
								INNER JOIN (
									select cod_componente, count(*) as inasistencias_total 
									FROM $clases INNER JOIN $cursos USING (cod_horario) 
									where cod_curso = '$cod_curso' group by cod_componente) total USING (cod_componente)
								INNER JOIN ".Config::get('TComponente')." componentes ON (cod_componente = componentes.codigo)";
			return DB::table_query($sql, 'nombre_componente');
		}
		
		function maxCodigo($cod_horario){
			$size = strlen($cod_horario) + 1;
			$sql = " SELECT COALESCE(SUBSTRING(MAX(codigo) FROM $size), '0')::int AS max_codigo ".
						 " FROM ".Config::Get(__CLASS__)." WHERE codigo LIKE '$cod_horario%'";
			$codigo = DB::query($sql);
			return $codigo;
		}
		
		function add($cod_horario, $clases){
			$cod_horario = q($cod_horario);
			$table = Config::Get(__CLASS__);
			foreach($clases as $clase){
				$clase['cod_horario'] = $cod_horario;
				$sql = sql_insert_from_array($table, $clase);
				DB::query($sql);
			}
		}
		
		function removeByHorario($cod_horario){
			$cod_horario = q($cod_horario);
			$table = Config::Get(__CLASS__);
			$sql = "DELETE FROM $table ".
						" WHERE cod_horario = '$cod_horario' AND NOT EXISTS( 
								SELECT * FROM ".Config::Get(__CLASS__, 'TAsistencia')." a WHERE a.cod_clase = $table.codigo)";
			DB::query($sql);
			THorario::remove($cod_horario);
		}
		
		function remove($cod_clase){
			if(is_array($cod_clase)){
				foreach($cod_clase as $clase){
					TClase::remove($clase);
				}
			}else{
				$cod_clase = q($cod_clase);
				$sql = "SELECT cod_horario FROM ".Config::Get(__CLASS__)." WHERE codigo = '$cod_clase'";
				$cod_horario = DB::query($sql);
				$tablename = Config::Get(__CLASS__);
				$sql = "DELETE FROM $tablename ".
							" WHERE codigo = '$cod_clase' AND NOT EXISTS( 
									SELECT * FROM ".Config::Get(__CLASS__, 'TAsistencia')." a WHERE a.cod_clase = $tablename.codigo)";
				DB::query($sql);
				THorario::remove($cod_horario);
			}
		}
			
		function update($clases){
			$table = Config::Get(__CLASS__);
			foreach($clases as $clase){
				$sql = sql_update_from_array($table, $clase, " codigo = '".$clase['codigo']."'");
				DB::query($sql);
			}
		}
		
	
	}

?>
