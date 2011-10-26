<?php
  /**
   * Clase Vista derivada de Smarty
   */
   AppLoader::load('Vista');
  /**
   * Librerias necesarias para Smarty
   */
  AppLoader::load('vendor/Smarty/Smarty');

	if(class_exists('Controller'))
		return;

	/**
	 * Clase Controller
	 */
	class Controller {

	 /**
	 * @var Vista
	 */
	 var $vista = null; 
   /**
    * @var current_controller
    */
   var $__name = null;
	 /**
	 *
	 * @var array arreglo de los parametros enviado por el REQUEST
	 */
	 var $params = array();


	 function Controller() {
		$args = func_get_args();
		call_user_func_array(array(&$this, '__construct'), $args);
	 }

     /**
      * Constructor de la Clase Controller
      */
	 function __construct() {
		$this->vista = new Vista();
    $this->includeModel("TPrograma");

		$this->AppConfig = &AppConfig::instance();

		$this->__addObsoleteVars();    
    $this->__addContextVars();
    
    $this->setup();
	 }
   
   function setup(){}
   
   function __getName(){
     if($this->__name == null){
       $this->__name = __CLASS__;
     }
     return $this->__name;
   }

   function __addObsoleteVars(){
    $this->params = $_REQUEST;
		$this->post = $_POST;
		$this->current_user = $_SESSION[SESSION_PARENT_VAR];
   }
   
   function __addContextVars(){
     $this->AppUser = AppContext::getUser();
     $this->Request = AppContext::getRequest();
   }
   

     /**
	 * Incluye los modelos necesarios
	 */
	 function includeModel() {
		$models = func_get_args();
		if (!empty($models)) {
		 foreach ($models as $model)
      if(AppLoader::load_model($model))
        if(class_exists($model))
          $this->$model = new $model();
		}
	 }

	 /**
	  * Funcion abstracta que indica que todo controlador tiene una accion index
	  */
	 function index() {}

	 /**
	  * Redirige una accion
	  */
	 function _redirect_to($action, $params=array()){
		$this->vista->current_action = $action;
		$this->$action(any(params(), $params));
	 }
   
   function forward($action, $params=array()){
     $this->_dispatch($action);
   }
   
   function redirect($action, $params=array()){
     redirect_to(AppContext::getControllerName(), $action, $params);
   }

	 /**
	 * Muestra el mensaje -under construction- para paginas no concluidas
	 */
	 function under_construction(){
	 	if(!$this->AppUser->isRoot()){
	 		Vista::under_construction();
		 	exit();
		}else{
			$this->vista->notify("Under Construction");
		}
	 }
   
   function _executeAction($action){
     $this->$action($this->Request->getAllParams(), $this->getRequest());
   }
   
   function _dispatch($action){
     if(!$this->_hasCredentialFor($action))
      return Vista::acceso_restringido();
     $continue = $this->_executePreFilterFor($action);
     if($continue){
        if($this->ModuleConfig->isActionUnderConstruction($action))
          $this->under_construction();
        $this->vista->current_action = $action;
        $this->_executeAction($action);
     }
   }
   
   function _executePreFilterFor($action){
      $preFilter = 'pre'.ucfirst($action);
      $rs = true;
      if(is_callable(array($this, $preFilter))){
        $rs = $this->_executeAction($preFilter);
        if($rs === NULL)
          return true;
        return $rs;
      }else{
        return true;
      }
    
   }
   
   function _loadModuleConfig(){
     $this->ModuleConfig = new ModuleConfig($this->__name);
   }
   
   function _hasCredentialFor($action){
     if($this->AppUser->isRoot())
        return true;
      $hasCredential = $this->ModuleConfig->hasCredential($action);
      return $hasCredential;
   }
   
   
   function getUser(){
     return $this->AppUser;
   }
   
   function getRequest(){
     return $this->Request;
   }
   
	}

?>
