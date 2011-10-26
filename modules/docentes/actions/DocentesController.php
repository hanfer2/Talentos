<?php

 /**
  * Clase DocentesController extendida de Controller
  */
 class DocentesController extends Controller {
   
   /**
    * Constructor de la Clase DocentesController
    */
   function __construct() {
     parent::__construct();
     $this->includeModel('TDocente','TPrograma');
     $this->TDocente = new TDocente();
     $this->vista->setTitle("Docentes");
   }

   /**
    * Muestra informacion de los docentes
    */
   function index($params){
     if(isset($params['cod_programa'])){
       $docentes = $this->TDocente->buscarPorPrograma($params['cod_programa']);
       $this->vista->set('docentes',$docentes);
     }
     $this->vista->addJS('jquery.dataTable');
     $this->vista->display();
   }

   /**
    * Lista los cursos que dicta el docente especificado
    */
   function cursos($params){
     $docentes = null;
     
     if(isset($params['cedula']))
      $docentes = $this->TDocente->cursos($params['cedula']);
     else
      $docentes = $this->TDocente->buscarPorProgramaYComponente($params['cod_programa'], $params['cod_componente']);
      
     $this->vista->set('docentes', $docentes);
     $this->vista->addJS('jquery.dataTable');
     $this->vista->display();
   }

   /**
    * ???
    */
   function informe(){
     if($this->params['tipo'] === null){
       $this->vista->display('informe.form');
     }
   }

 }
?>
