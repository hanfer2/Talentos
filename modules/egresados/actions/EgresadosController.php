	<?php

  if (!(is_admin_login() or is_coordinator_login() or is_user_login(COD_TIPO_VISITANTE_1))){
		 acceso_restringido ();
	}
	

  /**
   * Clase EgresadosController extendida de Controller
   */
  class EgresadosController extends Controller {

    /**
	 * @var $cod_programa codigo del programa al que pertenecen los egresados
	 */
    var $cod_programa = null;

   /**
		* Constructor de la Clase EgresadosController
		*/
    function __construct() {
      parent::__construct();
      $this->vista->setTitle("Egresados");
      $this->vista->addJS("jquery.ui.tabs");
      $this->includeModel('TEgresado');
    }

	/**
	 * Lista los egresados de un programa especifico, 
	 * si especifica un tipo (con ingreso a educacion superior o no, laborando)
	 * solo muestra lo de ese tipo
	 */
    function index() {
      // SI NO ESTA DEFINIDO EL CODIGO DEL PROGRAMA, MOSTRAR EL FORMULARIO DE BUSQUEDA.
      if (is_null($this->params['cod_programa'])){
				$this->vista->current_action = 'find';
        return $this->find();
      }$this->cod_programa = $this->params['cod_programa'];
      if (!is_xhr())
        $this->vista->addJS('jquery.dataTable');

      if (isset($this->params['tipo'])) {
        switch ($this->params['tipo']) {
          case 'IES':
            return $this->showIES();
          case 'noIES':
            return $this->showNoIES();
          case 'laborando':
            return $this->showLaborando();
          default:
            return $this->show();
        }
      }
    }

	/**
	 * Muestra informacion de un egresado especifico segun su cedula, sino se especifica la cedula se muestra la informacion
	 * de todos los egresados
	 *
	 * @return
	 */
    function view() {
      if (is_blank($this->params['cedula']))
        return redirect_to('egresados');
      $cedula = $this->params['cedula'];
      $egresado = TEgresado::situacion($cedula);
      $this->vista->set(array('egresado' => $egresado, 'cedula' => $cedula));
      $this->vista->display('view');
    }

	/**
	 * Lista los egresados de un programa en especifico
	 *
     * @return
	 */
    function show() {
      if (is_blank($this->cod_programa))
        return $this->find();
      $this->vista->set('egresados', TPrograma::egresados($this->cod_programa));
      $this->vista->set('cod_programa', $this->cod_programa);
      return $this->vista->display('index');
    }

	/**
	 * Lista los egresados de un programa en especifico con Ingreso a la Educacion Superior
	 */
    function showIES() {
      if (is_blank($this->cod_programa))
        return $this->find();
      $this->vista->set('egresados', TPrograma::egresadosIES($this->cod_programa));
      $this->vista->set('cod_programa', $this->cod_programa);
      $this->vista->display('_ies');
    }

	/**
	 * Lista los egresados de un programa en especifico con No Ingreso a la Educacion Superior
	 */
    function showNoIES() {
      if (is_blank($this->cod_programa))
        return $this->find();
      $this->vista->set('egresados', TPrograma::egresadosNoIES($this->cod_programa));
      $this->vista->set('noIES', true);
      $this->vista->set('cod_programa', $this->cod_programa);
      $this->vista->display('index');
    }

	/**
	 * Lista los egresados de un programa en especifico que se encuentren laborando
	 */
    function showLaborando() {
      $this->vista->set('egresados', TEgresado::laborando($this->cod_programa));
      $this->vista->set('cod_programa', $this->cod_programa);
      $this->vista->display('_laborando');
    }

	/**
	 * Muestra los tipos en los que se puede incluir a los egresados
	 */
    function find() {
      $this->vista->addJS('jquery.dataTable');
			$tipos = array('ALL'=>'TODOS', 'IES'=>'Ingreso Educ. Sup.', 'laborando'=>'Egresados Laborando','noIES'=>'Aspirantes a I.E.S.');
			$this->vista->set('tipos', $tipos);
      $this->vista->display();
    }

	/**
	 * Adiciona
	 */
    function add($params) {
//    	$this->under_construction();
			if(!is_admin_login ())
 		  	$this->vista->acceso_restringido ();
 		  $this->vista->setTitle('Registrar Egresado');
      $this->vista->addJS('jquery.ui.autocomplete','jquery.dataTable','jquery.ui.datepicker');
      if(isset($params['cedula'])){
				$status = $this->_check($params['cedula']);
				$this->vista->set($status);
				$this->vista->set('semestres', range_assoc(0,10));
			}
			$this->vista->display();
    }
    
		/**
 		 * Verifica si un estudiante existe dentro del Plan Talentos o ya ingreso a la educacion superior
		 */
   function _check($cedula) {
		 $vars = array();
		 $vars['exists'] = TEstudiante::exists($cedula)	;
		 $vars['estaInactivo'] = TEstudiante::estado($cedula) == COD_ESTADO_INACTIVO;
		 return $vars;
   }
   
   /**
	 * Registra a un estudiante en especifico como trabajador
	 */
    function registrar_trabajador($params) {
      if (empty($params['egresado'])) {
				$status = $this->_check($params['cedula']);
				$this->vista->set($status);
				if($status['exists'])
					$this->vista->set('estaReportado', TEgresado::estaTrabajando($params['cedula']));
        $this->vista->display('check_laborando');
      }
      else {
        TEgresado::registrarComoTrabajador($_POST['cedula'], $this->params['egresado']);
        redirect_to("egresados", 'view', array('cedula' => $this->params['cedula']));
      }
    }

	/**
	 * Registra a un egresado como  que ingresaro a la educacion superior.
	 */
    function create() {
      if (isset($this->params['IES']) && isset($this->params['cedula'])) {
        TEgresado::ingresarEducacionSuperior($this->params['cedula'], $this->params['IES']);
        $this->_redirect_to("view", array('cedula'=>$this->params['cedula']));
      }
    }

	/**
	 * ???
	 */
    function form_add() {
      $this->vista->display('add.form');
    }

	/**
	 * Elimina un egresado especifico de la tabla de IES (ingreso a la educacione superior) o dela tabla laborando
	 * segun sea el caso
	 */
    function del() {
      if (!is_blank($this->params['cedula'])) {
        switch ($this->params['source']) {
          case 'IES':
            TEgresado::eliminarIES($this->params['cedula']);
            break;
          case 'laborando':
            TEgresado::eliminarTrabajando($this->params['cedula']);
            break;
        }
      }
    }

	

	/**
	 * Muestra un informe con los egresados de un programa en especifico
	 */
    function informe() {
      $this->vista->setTitle("Informe de Egresados");
      if (!is_blank($this->params['cod_programa'])) {
        $informes = TEgresado::informe($this->params['cod_programa']);
        if($informes == null){
          $this->vista->set('informe', FALSE);
        }else{
          $this->vista->set("universidades", $informes['universidades']);
          $this->vista->set("carreras", $informes['carreras']);
          $this->vista->set("totalIES", $informes['IES']);
       }
      }
      $this->vista->display();
    }
    
   

  }

?>
