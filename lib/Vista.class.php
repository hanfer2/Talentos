<?php
  AppLoader::load('vendor/Smarty/Smarty');

  class Vista extends Smarty {
    var $layout;
    var $extraHeaders = '';
    var $__extensionFile = 'tpl';
    var $current_controller = "";
    var $current_action = '';
    var $templateFolder = null;
    var $__baseTemplateDir = "";
    var $__flash = "";
    

    function Vista() {
      parent::Smarty();
      $this->_setup();
      $this->layout = "default";
      
       $this->includeParams();
    }
    
	 function _setup() {
		$this->template_dir = AppConst::get('siat_root_dir');
    
		$this->compile_dir = SMARTY_DIR . DS . 'views' . DS . 'templates_c';
		$this->cache_dir = SMARTY_DIR . DS .'views' . DS . 'cache';
		$this->config_dir = SMARTY_DIR . DS. 'views' . DS . 'configs';
    
		$this->__baseTemplateDir = $this->template_dir;
	 }

    function setTitle($title) {
      $this->set('pageTitle', $title);
    }

    
    function addJS() {
      $paths = func_get_args();
      foreach ($paths as $path)  {   
        $this->extraHeaders .= includeJS($path). "\n";
      }
    }

    function addCSS() {
      $paths = func_get_args();
      foreach ($paths as $path)
        $this->extraHeaders .= includeCSS($path). "\n";
    }
    
    function addModuleJS($js_file, $module = null) {
      if($module == null)
        $module = $this->current_controller;
      $this->extraHeaders .= includeJS($js_file, $module). "\n";
    }
    
    function addModuleCSS($css_file, $module= null){
      if($module == null)
        $module = $this->current_controller;
      $this->extraHeaders .= includeCSS($css_file, $module). "\n";
    }

    function acceso_restringido() {
			header('HTTP/1.1 403 Forbidden');
      Vista::show('acceso_restringido', null, array('layout'=>'clean'));
      exit();
    }
    
    function show_under_construction() {
      Vista::show('under_construction', null, array('layout'=>'clean'));
      exit();
    }
    
    function show_not_available() {
      Vista::show('under_construction', null, array('layout'=>'clean'));
      exit();
    }
    

    function set($var, $value=null) {
      $this->assign($var, t($value));
    }
    

    function __loadCustomJS(){
      $js_folder = $this->getCurrentTemplatePath().'js'. DS ;
      
      $js_filepath = $js_folder . $this->current_controller;
      $js_file = $this->current_controller;
      
      if(file_exists($js_filepath. '.js' )){
        $this->extraHeaders .= includeJS($js_file, $this->current_controller). "\n";
      }
      
      $js_file = $this->current_controller . '_'.$this->current_action ;
      $actionJS = $js_folder. $js_file ;
      
      if(file_exists($actionJS.".js")){
        $this->extraHeaders .= includeJS($js_file, $this->current_controller). "\n";
      }
    }
    
    function __loadCustomCSS(){
     
      $css_folder = $this->getCurrentTemplatePath().'css'. DS ;
      
      $css_filepath = $css_folder . $this->current_controller;
      $css_file = $this->current_controller;
      
      if(file_exists($css_filepath. '.css' )){
        $this->extraHeaders .= includeCSS($css_file, $this->current_controller). "\n";
      }
      
      $css_file = $this->current_controller . '_'.$this->current_action ;
      $actionCSS = $css_folder. $css_file ;
      
      if(file_exists($actionCSS.".css")){
        $this->extraHeaders .= includeCSS($css_file, $this->current_controller). "\n";
      }
    }
		
		function _isset($var){
			return isset($this->_tpl_vars[$var]);
		}
		
		function __addImplicitVars(){
			if($this->_isset('cedula') && class_exists('TPersona'))
				$this->set('nombre_persona', TPersona::nombre($this->_tpl_vars['cedula']));
			if($this->_isset('cod_prueba') && class_exists('ITipo'))
				$this->set('nombre_prueba', ITipo::nombre($this->_tpl_vars['cod_prueba']));
			if($this->_isset('cod_curso') && class_exists('TSubgrupo')){
				$this->set('nombre_curso', TSubgrupo::nombre($this->_tpl_vars['cod_curso']));
				if(!$this->_isset('cod_programa'))
					$this->set('cod_programa', TSubgrupo::programa($this->_tpl_vars['cod_curso']));
			}
			if($this->_isset('cod_programa') && class_exists('TPrograma'))
				$this->set('nombre_programa', TPrograma::nombre($this->_tpl_vars['cod_programa']));
			if($this->_isset('cod_componente') && class_exists('TComponente'))
				$this->set('nombre_componente', TComponente::nombre($this->_tpl_vars['cod_componente']));
				
			$this->set('is_admin_login', is_admin_login());
		}
    
    function setController($controller){
      $controller = lower($controller);
      if(is_blank($this->pageTitle))
        $this->pageTitle = $controller;
      $this->current_controller = $controller;
    }
		
		function notify($message, $tipo="NOTICE"){
				$this->__flash = $message;
		}
		
		function show($templateName, $vars=array(), $options=array()){
			$oVista = new Vista();
      
			$oVista->set($vars);
      
			if(isset($options['layout']))
				$oVista->layout = $options['layout'];
        

			$oVista->display('pages/'.$templateName);
		}
		
		function includeParams(){
			$params = params();
			foreach($params as $k=>$param){
				if(is_array($param)){
					$subkey = key($param);
					$this->set($k."_".$subkey, $param[$subkey]);
				}
				else
					$this->set($k, $param);
			}
			return $params;
			
		}
    
    function getModule(){
      return $this->current_controller;
    }
    
    function getTemplateFolder(){
        return any($this->templateFolder,$this->current_controller);
    }
    
    function getDefaultTemplatePath(){
      return AppConst::get('siat_public_templates_dir');
    }
    
    function getCurrentTemplatePath(){
      $template_folder = $this->getTemplateFolder();
      if(is_blank($template_folder))
        return $this->getDefaultTemplatePath();
        
      $MODULES_DIR = AppConst::get('siat_modules_dir');
      
      return $MODULES_DIR . $template_folder . DS.'templates/';
    }
    
    function getTemplatePathFor($module){
      return AppConst::get('siat_modules_dir') . $module . DS.'templates/';
    }
    
    function addContextVars(){
      $this->assign("siat_user", AppContext::getUser());
      $this->assign("siat_request", AppContext::getRequest());
    }
    
    function addOuterContextVars(){
      //add logger
      $logger = &Logger::getDefault();
      $this->assign('siat_logger', $logger);
      //add menu
      $this->assign('siat_menu', MenuFactory::getMenu());
      $this->register_function('include_menu', 'smarty_function_include_menu');
      //add AppConfig
      $config = &AppConfig::instance();
      $this->assign('siat_config', $config);
    }
    

    function display($__templateName=null) {
      
      if (is_blank($__templateName))
        $__templateName = $this->current_action;
        
      if (!endsWith($__templateName, ".$this->__extensionFile"))
        $__templateName .= ".".$this->__extensionFile;
        
        				
			$template_path = $this->getCurrentTemplatePath();
			$templateFile = $__templateName;
      
        
      if (!file_exists($template_path. $templateFile)) {
				$this->setTitle('Recurso No Hallado');
				$message = "Plantilla <strong>".substr($templateFile,0,-4)."</strong> no hallada en <strong>{$this->current_controller}</strong>";
      	Vista::show('404', array("message"=>$message));
      	return;
      }
      
     
      $this->addContextVars();
      
			$this->__addImplicitVars();

			$this->config_load("conf.ini");
			$this->compile_id = $this->getTemplateFolder();
			$this->assign("__flash", $this->__flash);
      
      // IF NOT LAYOUT
      if ($this->layout === FALSE || (is_xhr() && $this->layout !== FALSE )){
        if($this->current_controller == null)
          return $this->_display($this->getDefaultTemplatePath().$__templateName);
				return $this->_display("modules".DS.$this->current_controller . DS . 'templates'.DS.$__templateName);
      }else {
        $this->__loadCustomCSS();
        $this->__loadCustomJS();
        $this->assign("content_for_layout", $template_path. DS.$__templateName);
        $this->assign("__extraHeaders", $this->extraHeaders);
				$path = 'templates'.DS."_layouts" . DS . $this->layout . "." . $this->__extensionFile;
        
        $this->addOuterContextVars();
        
        return $this->_display($path);
      }
    }
    
    function _display($tpl){
      return parent::display($tpl);
    }

  }

?>
