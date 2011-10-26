<?php

AppLoader::load('menu/AdminMenu');

  class RootMenu extends AdminMenu{
    function RootMenu(){
      parent::AdminMenu();
    }
  }
?>
