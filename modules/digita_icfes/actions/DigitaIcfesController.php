<?php

 if(!is_root_login())
   acceso_restringido();

 /**
	* 
  */
 class DigitaIcfesController extends Controller {


 /**
	* Constructor de la Clase UniversidadesController
	*/
   function __construct() {
     parent::__construct();
     $this->includeModel('TIcfes');
     $this->TIcfes = new TIcfes();
   }


  function reporte(){
    $cod_prueba = $this->AppConfig->get('I.COD_CUESTIONARIO_ACTUAL');
    $this->vista->set('cod_prueba', $cod_prueba);
    if($cod_prueba != null){
      $this->vista->addJS('jquery.dataTable');
      $digitadores = $this->TIcfes->getReporteDigitadores($cod_prueba);
      $this->vista->set('digitadores', $digitadores);
    }
    $this->vista->display();
  }
  
  function view($params){
    if(isset($params['cedula'])){
      $cod_prueba = $this->AppConfig->get('I.COD_CUESTIONARIO_ACTUAL');
      $this->vista->set('cod_prueba', $cod_prueba);
      if($cod_prueba != null){
        $this->vista->addJS('jquery.dataTable');
        $estudiantes = $this->TIcfes->getFormulariosDigitadosPor($params['cedula']);
        $this->vista->set('estudiantes', $estudiantes);
      }
      $this->vista->display();
    }else{
      $this->_redirect_to('reporte');
    }
  }
 }
?>
