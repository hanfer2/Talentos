<?php
	class AppContext{
    
   
    function &getInstance() {
			static $config = null;
			if ($config === null)
				$config = new AppContext();
			return $config;
		}
    
    function set($param, $value){
      $param = "_".$param;
      $app = &AppContext::getInstance();
      $app->$param = $value;
    }
    
    function get($param){
      $param = "_".$param;
      $context = &AppContext::getInstance();
      return $context->$param;
    }
    
		function getSmarty()
    {
        return AppContext::get('Smarty');
    }
    
    function getController()
    {
      return AppContext::get('Controller');
    }
    
    function getRequest(){
      return AppContext::get('Request');
    }
    
    function getUser(){
     return AppContext::get('User'); 
    }
    
    /**
     * Retorna el codigo interno del usuario logueado en el sistema.
     */
    function getUserId(){
      $user = AppContext::getUser();
      if($user == null)
        return false;
      return $user->getId();
    }
    
    function getControllerName()
    {
      $controller =  AppContext::getController();
      if($controller != null)
        return $controller->__name;
      return false;
    }
	}
?>
