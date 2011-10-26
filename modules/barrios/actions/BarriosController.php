<?php

  class BarriosController extends Controller {



   /**
	* Constructor de la Clase UniversidadesController
	*/
   function __construct() {
     parent::__construct();
     $this->includeModel('TCiudad');
     $this->TBarrio = new TBarrio();
     $this->vista->setTitle("Barrios");
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
    * Muestra,en formato JSON, un listado con los barrios 
    * cuyo nombre cumplan con el patron indicado.
    * 
    * @param string $pattern patron que debe cumplir los barrios a listar.
    * @param int	$limit	numero maximo de barrios a mostrar.
    * 
    * @access private
		*/
   function _find_by_pattern($pattern, $limit) {
     $barrios = $this->TBarrio->find_by_pattern($pattern, $limit);
     echo JSON::encode($barrios);
   }

 }
?>
