<?php 

class IReporteCuestionario{
		var $cod_prueba = null;
		
		function IReporteCuestionario($cod_prueba){
			$this->cod_prueba = $cod_prueba;
		}
		
		function componentes(){
			if($this->cod_prueba == null)
				return FALSE;
			$sql = "SELECT nombre_componente, nombre_competencia, nombre_cualitativo FROM ".Config::get('ICuestionario','V-Pregunta').
						 " WHERE cod_prueba = '".$this->cod_prueba ."' AND valida = 't'";
			$result = DB::table_query($sql, 'nombre_componente');
			if($result == null)
				return null;
			$reporte = array();
			foreach($result as $componente => $preguntas){
				if(!isset($reporte[$componente]))
					$reporte[$componente] = array('competencias'=>array(), 'cualitativos'=>array());
				foreach($preguntas as $pregunta){
					if(!isset($reporte[$componente]['competencias'][$pregunta['nombre_competencia']]))
						$reporte[$componente]['competencias'][$pregunta['nombre_competencia']] = 0;
					$reporte[$componente]['competencias'][$pregunta['nombre_competencia']]++;
					if(!isset($reporte[$componente]['cualitativos'][$pregunta['nombre_cualitativo']]))
						$reporte[$componente]['cualitativos'][$pregunta['nombre_cualitativo']] = 0;
					$reporte[$componente]['cualitativos'][$pregunta['nombre_cualitativo']]++;
				}
			}
			return $reporte;
		}
		
		function cuestionarios(){
			$cod_programa = ITipo::programa($this->cod_prueba);
			$format = " SELECT cod_grupo, i_cuestionarios_calificados({$this->cod_prueba}, cod_grupo, '%s') AS %s FROM ".Config::get('TEstudiante', 'TGrupo')." WHERE cod_programa = '$cod_programa'";
			
			
			echo $sql = sprintf($format, 'I', 'incompletos');
			/*$db = DB::instance();
			$db->consulta($sql);
			$rs = array();
			 while ($result = pg_fetch_assoc($this->result_query)){
        $rs[$result['cod_grupo']]['I'] = $result['incompletos'];
			}
			debug($rs);*/
		}
}
?>
