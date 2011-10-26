<?php
  /**
   * Clase CarrerasController extendida de Controller
   */
  class CarrerasController extends Controller{

	/**
	 * Constructor de la Clase CarrerasController
	 */
    function __construct(){
      parent::__construct();
      $this->includeModel('TEgresado');
    }

	/**
	 * Redirige a universidades
	 */
    function index($params){
			if(isset($params['q'])){
				return $this->_find_by_pattern($this->params['q'], $this->params['cod_ciudad'], $this->params['cod_universidad'], $this->params['limit']);
			}else{
				redirect_to("universidades");
			}
    }
    
   /**
    * Lista las carreras que cumplan cuyo nombre cumplan con el patron indicado
    * 
		*/
   function _find_by_pattern($pattern, $cod_ciudad, $cod_universidad,$limit) {
     $carreras = TCarrera::find_by_pattern($pattern, $cod_ciudad, $cod_universidad, $limit);
     echo JSON::encode($carreras);
   }

	/**
	 * Crea una carrera en la BD
	 */
    function add(){
      if(!is_blank($this->params['carrera'])){
        TCarrera::add($this->params['carrera']);
        echo "Creacion Exitosa";
      }
    }
  }
?>
