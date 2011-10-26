<?php
	class AppLoader{
		
    function _load($file){
      if(file_exists ($file)){
        require_once($file);
        return true;
      }
      echo "[ERROR]AppLoader> File Not Found: $file .<br/>";
      return false;
    }
    function get_lib_path($filename){
      return AppConst::get('siat_libs_dir').$filename.'.class.php';
    }
		function load($filename){
      $filepath = AppLoader::get_lib_path($filename);
      return AppLoader::_load($filepath);
    }
    
    function load_helper($filename){
      $filepath = AppConst::get('siat_helpers_dir').$filename.'Helper.php';
      return AppLoader::_load($filepath);
    }
    
    function load_config($filename){
      $filepath = AppConst::get('siat_configs_dir') .$filename. '.php';
      return AppLoader::_load($filepath);
    }
    
    function load_file($file){
      return AppLoader::_load($file . '.php');
    }
    
    function load_model($model){
      $filepath = AppConst::get('siat_models_dir') . $model . '.inc';
      return AppLoader::_load($filepath);
    }
    
    function get_controller_path($controller){
      return AppConst::get('siat_modules_dir').$controller . DS . 'actions' . DS . camelizeUS($controller).'Controller.php';
    }
    
    function load_controller($controller){
      $filepath = AppLoader::get_controller_path($controller);
      return AppLoader::_load($filepath);
    }
    
	}
?>
