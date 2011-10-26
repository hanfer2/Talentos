<?php

/**
*define que controladores y que vista mostrar,que opciones habilitar en la vista segun el usuario que acceda al sistema
*/
	
	class AppDispatcher{
    
    var $controllerParam = "controlador";
    var $actionParam = "accion";
    var $defaultController = "sesion";
    var $defaultAction = "index";
    var $privateActionPrefix = "_";
		
		function AppDispatcher(){
			$this->init();
      $this->_getParams();
		}
		
    function init(){
      header_iso();
      setlocale(LC_ALL, "es_CO","es_ES");
      setlocale(LC_NUMERIC, "en_US");
    }
    
    function _getParams(){
      $this->controller = $_GET[$this->controllerParam];
      if($this->controller == null)
        $this->controller = $this->defaultController;
        
      $this->controller = lower(uncamelize($this->controller));
      
      if(!empty($_GET[$this->actionParam]))
        $this->action = $_GET[$this->actionParam];
      else
        $this->action = $this->defaultAction;
        
      $this->_getRequest();
      $this->_getUser();
      $this->_define_vars();
    }
    

    function _getRequest(){
      $request = new WebRequest();
      AppContext::set('Request',$request);  
    }
    
    function _getUser(){
      $user = new AppUser();
      AppContext::set('User',$user);  
    }
    
    function _define_vars(){
      $this->controllerName = camelizeUS($this->controller)."Controller";

      $this->controllerPath = AppLoader::get_controller_path($this->controller);
      
      $this->is_private_action = startsWith($this->action,$this->privateActionPrefix);
    }
    
    function define_unlogged_zone(){
      if(!is_user_login() && !is_path_for_unlogged($this->controller, $this->action) ){
         AppLoader::load('Controller');
         AppLoader::load_controller('sesion');
         $sesion = new SesionController();
         $sesion->_displayLoginPage($_SERVER['REQUEST_URI']);
         return false;
      }
      return true;
    }
    
    function show404($msg){
      header("HTTP/1.0 404 Not Found");
      Vista::show('404',array('message'=>$msg, 'pageTitle'=>"Recurso No Hallado"), array('layout'=>'clean'));
      return false;
    } 
    
    function showUnderConstruction(){
      Vista::show_under_construction();
    }
    
    function showAccessDenied(){
      Vista::acceso_restringido();
      return false;
    }
    
    function is_reserved_action(){
      if($this->is_private_action)
        return true;
      $reserved_actions = array('setup','forward','redirect','getuser','getrequest'); 
      if(in_array(strtolower($this->action), $reserved_actions))
        return true;
      return false;
    }
    
    
    function verify_request(){
      if(! $this->define_unlogged_zone() )
        return false;
      if($this->is_reserved_action()){
          AppDispatcher::showAccessDenied();
          return false;
      }
      
      if(is_file($this->controllerPath)){
        AppLoader::load('Controller');
        require_once $this->controllerPath;
        
      }else{
        AppDispatcher::show404("Controlador {$this->controller} ({$this->controllerPath}) no hallado");
        return false;
      }
      
      if(is_callable(array($this->controllerName, $this->action))== false){
        AppDispatcher::show404("La accion {$this->controller}::{$this->action} no esta definida");
        return false;
      }
      return true;
    }
    
     
   
    function dispatch(){
      if($this->verify_request()){
        AppLoader::load_config('config');
        
        $o = new $this->controllerName();
        $o->__name = $this->controller;
        $o->_loadModuleConfig();
        
        if($o->vista == null){
          trigger_error("El objeto Vista del Controlador {$this->controllerName} NO fue hallado. (Posiblemente al definir el <code>__construct</code>, olvidó invocar al <code>parent::__construct</code>)", E_USER_ERROR);
        }
        
        if(is_blank($o->vista->folder_view)){
            $o->vista->setController(lower($this->controller));
        }
        
        AppContext::set('Controller',$o);
        
        $o->_dispatch($this->action);

      }
    }

	}

?>
