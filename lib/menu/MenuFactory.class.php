<?php

  class MenuFactory{
    function getMenu(){
      $current_user_role = role_user_logged();
      $menu = null;
      switch($current_user_role){
        case COD_TIPO_ESTUDIANTE:
          AppLoader::load('menu/EstudianteMenu');
          $menu = new EstudianteMenu();
          break;
        case COD_TIPO_DOCENTE:
          AppLoader::load('menu/DocenteMenu');
          $menu = new DocenteMenu();
          break;
        case COD_TIPO_VISITANTE_1:
          AppLoader::load('menu/VistanteMenu');
          $menu = new VisitanteMenu();
          break;
        case COD_TIPO_ADMIN:
        case COD_TIPO_MONITOR:
           AppLoader::load('menu/AdminMenu');
          $menu = new AdminMenu();
          break;
        case COD_TIPO_COORDINADOR:
          AppLoader::load('menu/CoordinadorMenu');
          $menu = new CoordinadorMenu();
          break;
        case COD_TIPO_DIGITA_ICFES:
          AppLoader::load('menu/DigitaIcfesMenu');
          $menu = new DigitaIcfesMenu();
          break;
        case COD_TIPO_ROOT:
          AppLoader::load('menu/RootMenu');
          $menu = new RootMenu();
          break;
      }
      return $menu;
    }
  }

?>
