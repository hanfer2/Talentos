<?php
  
	class TMotivoInasistencia extends TBase{
		function all($options=array()){
			return parent::all(__CLASS__, $options);
		}
		
		function toSQL(){
			return parent::toSQL(__CLASS__, array());
		}
		function motivos(){
			$motivos = DB::table_query(TMotivoInasistencia::toSQL());
			$justificaciones = array();
			foreach($motivos as $motivo){
				$justificaciones[$motivo['codigo']] = $motivo;
			}
			return $justificaciones;
		}
		
		function motivosAgrupadosPorValidez(){
			$motivos = DB::table_query(TMotivoInasistencia::toSQL(),'valida');
			return $motivos;
		}
	}
	
?>
