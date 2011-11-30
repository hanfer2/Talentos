<?php
	/**
	 * 
	 * 
	 * 
	 * 
	 */
	class TObservacion extends TBase{
		
		function tipos(){
			return array('OBSERVACION'=>'Observación', 'MEMO'=>'Memo');
		}
		
		function informePorPersona($cedula){
			$cod_interno = TPersona::cod_interno($cedula);
			$sql = "SELECT codigo, tipo, fecha_registro, observacion
						  FROM ".Config::Get('TEstudiante',"V-Observacion"). 
						 " WHERE cod_interno = '$cod_interno'
						  ORDER BY tipo DESC, fecha_registro";
			return DB::table_query($sql, "tipo");
		}
		
		function informePorPrograma($cod_programa){
			$sql = "SELECT observaciones.*, telefono FROM ".Config::Get(__CLASS__, 'conteo'). " observaciones ".
						 " INNER JOIN ".Config::Get('TPersona') ." USING (cod_interno)".
						 " WHERE cod_programa = '$cod_programa'";
			return DB::table_query($sql);
		}
		
		function informe($options){
			if(isset($options['cedula']))
				return TObservaciones::informePorPersona($options['cedula']);
			if(isset($options['cod_programa']))
				return TObservaciones::informePorPrograma($options['cod_programa']);				
			if(isset($options['cod_interno']))
				return TObservaciones::informePorPersona(array('cod_interno'=>$options['cod_interno']));
		}
		
		function delete($cod_observacion){
      
      
			$sql = "DELETE FROM ".Config::Get(__CLASS__)." WHERE codigo = '$cod_observacion'";
			DB::query($sql);
		}
		
		function save($data){
			$sql = sql_insert_from_array(Config::Get(__CLASS__), $data);
			DB::query($sql);
		}
	}

?>
