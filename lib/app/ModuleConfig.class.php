<?php
	
	class ModuleConfig{
		
		var $_settings  = array();
    var $_controller = null;
    
		function ModuleConfig($controller){
      $this->_controller = $controller;
      $this->_load();
		}
    
    function getController(){
      return $this->_controller();
    }
    
    function _load()
    {
      $path = module_folder_dir($this->_controller). 'config' .DS;
      
      if( ! is_dir($path) ){
        return false;
      }
      
      $settingsFile = $path . 'settings.ini';  
      if( ! file_exists($settingsFile) ){
        return false;
      }
      
      $this->_settings = parse_ini_file($settingsFile, true);
    }
    
    function get($action, $setting){
      if($this->_settings == null)
        return false;
      $actionSettings = $this->_settings[$action];
      $defaultSettings = $this->_settings['default'];
      
      if($actionSettings == null){
        if($defaultSettings == null)
          return false;
        else
          $actionSettings = $defaultSettings;
      }
      
      return $actionSettings[$setting];
    }
    
    function isActionUnderConstruction($action){
      return toBool($this->get($action, 'under_construction'));
    }

    function hasCredential($action){
      $cedulas_autorizadas = $this->get($action, 'auth_cedulas');
      
      if(strtoupper($cedulas_autorizadas) == "NULL" || $cedulas_autorizadas == "[]")
        $cedulas_autorizadas = null;
        
      $roles_autorizados = $this->parse_roles($this->get($action, 'auth_roles'));
      
      if( $cedulas_autorizadas == null && $roles_autorizados == null)
        return true;
        
      foreach($roles_autorizados as $rol){
        if(startsWith($rol, '-')){
          if(is_user_login(substr($rol, 1)))
            break;
        }else{
          if(is_user_login($rol))
            return true;
        }
      }
      
      $cedulas_autorizadas = arrayize(explode(',',$cedulas_autorizadas));
      foreach($cedulas_autorizadas as $cedula){
        $cedula = trim($cedula);
        if(is_logged_cedula($cedula))
          return true;
      }
      return false;
    }
    
    function parse_roles($str_roles){
      if(strtoupper($str_roles) == "NULL" || $str_roles == "[]")
        return null;
      $arr_roles = arrayize(explode(',',$str_roles));
      
      if($str_roles == null)
        return null;
    
      $auth_roles = array();
      
      foreach($arr_roles as $rol){
        $rol = trim($rol);
        
        if(defined('COD_TIPO_'.$rol)){
          $rol = constant('COD_TIPO_'.$rol);
        }elseif(startsWith($rol, '-')){
          if(defined('COD_TIPO_'.substr($rol, 1)))
            $rol = "-".constant('COD_TIPO_'.substr($rol,1));
        }
        $auth_roles[] = $rol;
      }
      return $auth_roles;
    }
		
	}
?>
