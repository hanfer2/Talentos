<?php
  class AppConst {
    /**
     * @var $__settings arreglo que almacena las constantes del sistema.
     */
    var $__settings = array();
    
    function &getInstance() {
			static $const = null;
			if ($const === null)
				$const = new AppConst();
			return $const;
		}
    
    function tr($value){
     $value = preg_replace("/%\w+%/Ue","AppConst::get('\\0')", $value);
     return $value;
    }
    
    function __assign($key, $value){
      $this->__settings[$key] = $value;
    }
    
    function set($key, $value){
      $const = &AppConst::getInstance();
      $value = AppConst::tr($value);
      $const->__assign(strtolower($key), $value);
    }
    
    function __retrieve($key){
      return $this->__settings[$key];
    }
    
    function get($key){
      $key = str_replace('%', '', $key);
      $const = &AppConst::getInstance();
      $value = $const->__retrieve(strtolower($key));
      return $value;
    }
  }
?>
