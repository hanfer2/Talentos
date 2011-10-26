<?php

 if(!is_admin_login())
   acceso_restringido();

 /**
	* 
  */
 class UniversidadesController extends Controller {


   var $cod_programa = null;

   /**
	* Constructor de la Clase UniversidadesController
	*/
   function __construct() {
     parent::__construct();
     $this->includeModel('TEgresado');
     $this->Universidad = new TUniversidad();
     $this->vista->setTitle("Egresados");
   }

   /**
    * Listado de las universidades
		*/
   function index() {
     if(isset($this->params['q']))
       return $this->_find_by_pattern($this->params['q'], $this->params['cod_ciudad'], $this->params['limit']);
     $universidades = TUniversidad::all(array('from'=>Config::get('TUniversidad','viewname')));
     $this->vista->addJS('jquery.dataTable');
     $this->vista->setTitle("Listado de Universidades");
     $this->vista->set('universidades',$universidades);
     $this->vista->display();
   }

   /**
    * Lista las universidades que cumplan cuyo nombre cumplan con el patron indicado
    * 
		*/
   function _find_by_pattern($pattern, $cod_ciudad, $limit) {
     $universidades = TUniversidad::find_by_pattern($pattern, $cod_ciudad, $limit);
     echo JSON::encode($universidades);
   }

   /**
    * Crea una universidad
	*/
   function add() {
     if(empty($this->params['universidad'])){
			 $this->vista->set('ciudades', TCiudad::toArray());
       $this->vista->display();
     }else {
       TUniversidad::create($this->params['universidad']);
       echo "Universidad '{$this->params['universidad']['nombre']}' Creada!!!";
     }
   }

   /**
    *
	*/
   function find() {

   }

   /**
    * Muestra los egresados con la universidad y carrera donde ingresaron
		*/
   function egresados($params) {
     if(!is_blank($params['cod_universidad'])) {
       $cod_universidad = $params['cod_universidad'];
       $cod_carrera = $params['cod_carrera'];
       $egresados = TUniversidad::egresados($cod_universidad, $cod_carrera);
			 $this->vista->set('nombre_universidad', TUniversidad::nombre($cod_universidad));
       $this->vista->addJS('jquery.dataTable');
       $this->vista->set('egresados', $egresados);
       $this->vista->display();
     }
   }

   /**
    * Lista el codigo de las ciudades en que existen universidades
    * y que cumplan con el patron indicado por el $_GET['q']
    */
   function ciudades() {
		 $ciudades = TUniversidad::ciudades($this->params['q'], $this->params['limit']);
     echo JSON::encode($ciudades);
   }

   /**
    * Muestra las carreras y modalidad de las mismas en las universidades
    */
   function carreras() {
     if(isset($this->params['cod_universidad'])) {
			 $DEFAULT_DISPLAY_FORMAT = 'full';
			 $cod_universidad = $this->params['cod_universidad'];
			 $cod_ciudad =$this->params['cod_ciudad']; 
			 $pattern =$this->params['pattern']; 
			 
       if(!is_blank($cod_ciudad)){
				 $this->vista->set('nombre_ciudad', TCiudad::nombre($cod_ciudad));
			 }
			 //Realizar busqueda.
       $carreras = $this->Universidad->carreras($cod_universidad, $cod_ciudad, $pattern);
       
       //Si no es especificado el formato en que se listaran las carreras, se asignara $DEFAULT_DISPLAY_FORMAT.
       if($this->params['display_format']== null){
					$this->vista->set('display_format', $DEFAULT_DISPLAY_FORMAT);
					$this->vista->addJS('jquery.dataTable');	
			 }
			 
       $this->vista->set('carreras', $carreras);
       $this->vista->set('nombre_universidad', TUniversidad::nombre($cod_universidad));
			 $this->vista->set('modalidades', TCarrera::modalidades());
			 
       $this->vista->display();
     }
   }

   


 }
?>
