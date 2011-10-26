<?php

 if(!is_root_login())
   acceso_restringido();

 /**
	* 
  */
 class ConfiguracionesController extends Controller {
 /**
	* Constructor de la Clase UniversidadesController
	*/
   function __construct() {
     parent::__construct();
     $this->vista->setTitle("Configuraciones");
   }

   /**
    * Listado de las universidades
		*/
   function index() {
     
   }
   
   function roles(){
   }
   
   function visitantes(){
     
   }


 }
?>
