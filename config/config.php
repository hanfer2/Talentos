<?php
  error_reporting(E_ALL ^ E_NOTICE);
  
  
  $siat_const = AppConst::getInstance();

  define('DS','/');
  define('INDEX_FILE','index.php');

  /**
   * $siat_const->set la ruta de la carpeta ROOT
   */
  $siat_const->set('siat_root_dir','.' . DS);
  $siat_const->set('siat_libs_dir',   '%siat_root_dir%lib' . DS);
  $siat_const->set('siat_helpers_dir','%siat_root_dir%helpers' . DS);
  $siat_const->set('siat_configs_dir','%siat_root_dir%config' . DS);
  $siat_const->set('siat_models_dir','%siat_root_dir%models' . DS);
  $siat_const->set('siat_modules_dir','%siat_root_dir%modules' . DS);
  $siat_const->set('siat_templates_dir','%siat_root_dir%templates' . DS);
  
  $siat_const->set('siat_layouts_dir','%siat_templates_dir%_layouts' . DS);
  $siat_const->set('siat_public_templates_dir','%siat_templates_dir%_public' . DS);
  
?>
