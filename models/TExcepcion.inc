<?php
  require_once 'TBaseModel.inc';
  
	class TDiscapacidad extends TBase{
		
		function toSQL($options=array()){
			return parent::toSQL(__CLASS__, $options);
		}
		
		function nombre($codigo){
			if($codigo == null)
				$codigo = 0;
			return parent::get(__CLASS__, $codigo, __FUNCTION__);
		}
	}
	
	class TEtnia extends TBase{
	
		function toSQL($options=array()){
			return parent::toSQL(__CLASS__, $options);
		}
		
		function nombre($codigo){
			if($codigo == null)
				$codigo = 0;
			return parent::get(__CLASS__, $codigo, __FUNCTION__);
		}
	}

?>
