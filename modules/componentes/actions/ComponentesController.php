<?php
  /**
   * Clase ComponentesController extendida de Controller
   */
  class ComponentesController extends Controller{
	/**
	 * Constructor de la Clase ComponentesController
	 */
    function __construct(){
      parent::__construct();
      $this->includeModel('TPrograma','TComponente');
			$this->vista->setTitle("Componentes");
    }

	/**
	 * Los componentes de un programa especifico
	 */
	function componentes_segun_programa(){
		echo url_encode(TComponente::toJSON(array('cod_programa'=>$this->params['cod_programa'])));
	}

	/**
	 * Listado de componentes y sus modalidades
	 */
    function index(){
			if(!is_admin_login() && !is_coordinator_login())
				$this->vista->acceso_restringido ();
      $componentes = TComponente::all();
			if($this->params['format']=='js'){
				echo JSON::encode ($componentes);
				return;
			}
			$this->vista->addJS('jquery.dataTable');
			$this->vista->set('componentes', $componentes);
			$this->vista->set('modalidades',  TComponente::modalidades());
			$this->vista->setTitle("Componentes - Listado");
			$this->vista->display();
    }

		/**
		 * Muestra las modalidades
		 */
		function add(){
			if(!is_super_admin_login())
				$this->vista->acceso_restringido ();
			$this->vista->set('modalidades',  TComponente::modalidades());
			$this->vista->display();
		}

	/**
	 * Crea un componente en la BD
	 */
    function create(){
			if(!is_super_admin_login())
				$this->vista->acceso_restringido ();
			if(!empty($this->params['componentes'])){
				TComponente::crear($this->params['componentes']);
				echo "Componente Creado";
			}
    }
  }
?>
