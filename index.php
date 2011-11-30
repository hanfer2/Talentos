<?php
/**
 * Inicio
 *
 * Inicio del Sistema de Informacion Web del Plan Talentos
 *
 * @author Carlos Andres Mercado <carlos00714@gmail.com>
 * @version 2.0
 * @copyright DINTEV
 */
  session_start();

  require_once  './lib/app/AppConst.class.php';
  require_once  './config/config.php';
  
  require_once  './lib/app/AppLoader.class.php';
  require_once  './config/autoload.php';
  require_once  './config/database.php';
  
  $appDispatcher = new AppDispatcher();
  $appDispatcher->dispatch();
  return false;
?>
