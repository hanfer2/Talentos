<?php

  class CiudadesController extends Controller {



   /**
	* Constructor de la Clase UniversidadesController
	*/
   function __construct() {
     parent::__construct();
     $this->includeModel('TCiudad');
     $this->TCiudad = new TCiudad();
     $this->vista->setTitle("Ciudades");
   }

   /**
    * Listado de ciudades
		*/
   function index() {
     if(isset($this->params['q'])){
       $this->_find_by_pattern($this->params['q'], $this->params['limit']);
       return true;
		 }
   }

   /**
    * Muestra,en formato JSON, un listado con las ciudades 
    * cuyo nombre cumplan con el patron indicado.
    * 
    * @param string $pattern patron que debe cumplir las ciudades a listar.
    * @param int	$limit	numero maximo de ciudades a mostrar.
    * 
    * @access private
		*/
   function _find_by_pattern($pattern, $limit) {
     $ciudades = $this->TCiudad->find_by_pattern($pattern, $limit);
     echo JSON::encode($ciudades);
   }

 }
?>
