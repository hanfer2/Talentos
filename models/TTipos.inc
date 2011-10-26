<?php
  require_once 'TBaseModel.inc';
  

  require_once 'TEstado.inc';

  class TTipoPersona extends TBase{
    function all($options = array()){
			$options[]= 'order';
      return parent::all(__CLASS__, $options);
    }
    function get($codigo, $fields, $options=array()){
      return parent::get(__CLASS__,$codigo, $fields, $options);
    }

    function nombre($codigo) {
     return TTipoPersona::get($codigo, 'nombre');
    }
    
    function toSQL($options=array()){
      return parent::toSQL(__CLASS__, $options);
    }
    
    function toArray(){
			return parent::toArray(__CLASS__);
		}

		function usuarios(){
			$options['conditions'] = " codigo NOT IN (".COD_TIPO_ADMIN.",".COD_TIPO_ROOT.")";
			return TTipoPersona::all($options);
		}
  }
  
  class TTipoCedula extends TBase{

    function get($codigo, $fields, $options=array()){
      return parent::get(__CLASS__,$codigo, $fields, $options);
    }

    function nombre($codigo) {
     return TTipoCedula::get($codigo, 'nombre');
    }

    function sigla($codigo) {
      return TTipoCedula::get($codigo, 'sigla');
    }
		
		function toSQL($options=array()){
	    $options[] = 'order';
      return parent::toSQL(__CLASS__, $options);
    }
    
    function toArray(){
			return parent::toArray(__CLASS__);
		}
  }
  
  class TEstadoCivil extends TBase{
    function get($codigo, $fields, $options=array()){
      return parent::get(__CLASS__,$codigo, $fields, $options);
    }

    function nombre($codigo) {
     return TEstadoCivil::get($codigo,  __FUNCTION__);
    }
		
		function toSQL($options=array()){
	    $options[] = 'order';
      return parent::toSQL(__CLASS__, $options);
    }
    
    function toArray(){
			return parent::toArray(__CLASS__);
		}
  }

?>
