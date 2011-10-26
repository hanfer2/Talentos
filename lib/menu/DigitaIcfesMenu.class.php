<?php

AppLoader::load('menu/Menu');
AppLoader::load_model('ITipo');

class DigitaIcfesMenu extends Menu{
    function DigitaIcfesMenu(){
      parent::Menu();
      $this->pruebaActiva = $this->getPruebaActiva();
    }
    
    function getPruebaActiva(){
      if($this->pruebaActiva == null){
        $appConfig = AppConfig::instance();
        $this->pruebaActiva = $appConfig->get('I.COD_CUESTIONARIO_ACTUAL');
      }
      return $this->pruebaActiva;
    }
    
    function getTipoPruebaActiva(){
      if($this->pruebaActiva == null)
        return false;
      $tipo = ITipo::tipo($this->pruebaActiva);
      return $tipo;
    }
  }
?>
