<?php
  require_once 'TEstudiante.inc';

	/**
	 * Clase que representa aquellos estudiantes que son denominados Flotantes.
	 * 
	 * Se considera un estudiante 'flotante', aquel que ve clases 
	 * en un curso diferente al asignado por motivos justificados
	 * 
	 */
	class EstudiantesFlotantes extends TEstudiante{
		
		/**
		 * Listado de estudiantes flotantes actuales.
		 * @param string cod_programa codigo del programa de los estudiantes flotantes.
		 * @return array listado de cedulas de los estudiantes flotantes del programa indicado.
		 */
		function actuales($cod_programa){
			$sql = "SELECT cedula FROM ".Config::Get('TEstudiante', 'flotantes') ." INNER JOIN ".Config::get('TEstudiante','TPrograma')." USING (cod_interno) WHERE flota IS TRUE AND cod_programa = '".q($cod_programa)."'";
			return DB::aquery($sql);
		}
	}

?>
