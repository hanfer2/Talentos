<?php

      /**
       * Se incluye el archivo TPrograma.inc
       */
	require_once 'TPrograma.inc';


	class THorario extends TBase {

    
		function existe($cod_horario){
			$cod_horario = q($cod_horario);
			$sql = "SELECT 1 FROM ".Config::get('TCurso','Horario')." WHERE codigo = '$cod_horario'";
			$r = DB::query($sql);
			return !empty($r);
		}
		
		/**
		 * Devuelve el horario de un curso
		 *
		 * @param int $cod_curso
		 * @return array
		 */
		function get($cod_curso, $semestre=null) {
			$semestre = q($semestre);
			$sql = "SELECT clase.codigo AS cod_clase, cod_horario, dia, sede, edificio, salon, 
										hora_inicio, hora_fin, fecha_inicio, fecha_fin, 
										horario.observaciones AS observaciones_horario, anuncios,
										cod_componente, convert(nombre_componente,'LATIN1','UTF-8') AS nombre_componente,
										nombre_docente, fecha
							FROM " . Config::get('TCurso', 'Vista-Horario') . " horario".
						 " INNER JOIN ". Config::get('TClase'). " clase USING (cod_horario) ".
						 "WHERE cod_horario IS NOT NULL AND cod_curso = '$cod_curso'";
			if($semestre!= null)
				$sql .=" AND semestre = '$semestre'";
			$horario = DB::table_query($sql);
			return $horario;
		}

   

		/**
		 * Actualiza los horarios de un componentes dentro de un curso
		 *
		 * @param array $horarios
		 */
		function save($horario){
			$cod_horario = q($horario['codigo']);
			$tabla_componente_curso = Config::get('TComponente','TGrupo');
			
			$tabla_horario = Config::get('TCurso','Horario');
			
			$sql = "";
			if(THorario::existe($cod_horario)){
				$sql = sql_update_from_array($tabla_horario, $horario, "codigo = '$cod_horario'");
			}else{
				$sql = sql_insert_from_array($tabla_horario, $horario);
			}
			DB::query($sql);
		}
		
		
		function tieneClases($cod_horario){
			$cod_horario = q($cod_horario);
			$sql = "SELECT 1 FROM ".Config::GET('TClase'). " WHERE cod_horario = '$cod_horario' LIMIT 1";
			$r = DB::query($sql);
			return $r != null;
		}
		
		function remove($cod_horario){
			if(!THorario::tieneClases($cod_horario)){
				$cod_horario = q($cod_horario);
				$sql = "DELETE FROM ".Config::GET('TCurso','Horario') . " WHERE codigo = '$cod_horario'";
				DB::query($sql);
				return true;
			}
			return false;
		}
	}

?>
