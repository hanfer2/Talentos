<?php 
  class SubeEstudiantesFactory {
    function create($tipo, $csv){
      $class = 'Sube'.ucfirst($tipo);
      AppLoader::load_model('Extra/SubeEstudiantes/'.$class);
      return new $class($csv);
    }
  }
