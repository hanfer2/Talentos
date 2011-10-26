<?php
/**
  * Se incluye el archivo TBaseModel.inc
  */
require_once 'TBaseModel.inc';

  /**
   * Clase TSede extendida de Tbase
   */
  class TSede extends TBase {

        /**
         * Devuelve el resultado de una consulta con todos los campos
         *
         * @param array $configs
         * @return array
         */
  	function all($configs = array()){
	  	if(!isset($configs['select']))
	  		$configs['select'] = "codigo, nombre";
  		return parent::all(__CLASS__,$configs);
  	}

        /**
         * Devuelve el resultado de una consulta con algunos los campos
         *
         * @param int $codigo
         * @param array $fields
         * @param array $options
         * @return mixed
         */
  	function get($codigo, $fields, $options=array()){
  		return parent::get(__CLASS__, $codigo, $fields, $options);
  	}

        /**
         * Devuelve el nombre de la sede segun el codigo
         *
         * @param int $codigo
         * @return array
         */
  	function nombre($codigo){
  		return TSede::get($codigo, __FUNCTION__);
  	}

        /**
         * Devuelve una consulta segun las opciones especificadas
         *
         * @param array $options
         * @return string
         */
  	function toSQL($options=array()){
  		return parent::toSQL(__CLASS__, $options);
  	}
  }
?>
