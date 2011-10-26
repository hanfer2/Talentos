<?php
    /**
     * Clase ObservacionesController extendida de Controller
     */
	class ObservacionesController extends Controller {

		/**
	     * Constructor de la Clase ObservacionesController
	     */
		function __construct(){
			parent::__construct();
			$this->vista->setTitle("Observaciones");
			$this->includeModel("TPrograma", "TEstudiante", "TObservacion");
		}

		/**
		 * Listado con observaciones a los estudiantes segun un programa
		 */
		function index(){
			$this->vista->setTitle("Listado de Observaciones");
			$this->vista->addJS('jquery.dataTable');
			if(isset($this->params['cod_programa'])){
				$estudiantes = TObservacion::informePorPrograma($this->params['cod_programa']);
				$this->vista->set('estudiantes', $estudiantes);
			}
			$this->vista->display();
		}

		/**
		 * Lista de observaciones para un estudiante en particular
		 */
		function view(){
			if(!canViewStudent($this->params['cedula']))
				$this->vista->acceso_restringido();
			if(isset($this->params['cedula'])){
				$observaciones = TObservacion::informePorPersona($this->params['cedula']);
				$this->vista->set('observaciones', $observaciones);
				$this->vista->set('tipos', TObservacion::tipos());
			}
			$this->vista->display();
		}

		/**
		 * Elimina una observacion
		 */
		function delete(){
     //  echo"<script languaje='javascript'>alert('Un mensaje')</script>";
			if(is_super_admin_login() && isset($this->post['cod_observacion'])){
      
				TObservacion::delete($this->post['cod_observacion']);
			}	else{
				$this->vista->acceso_restringido();
			}
		}

		/**
		 * Registra una observacion para un estudiante
		 */
		function create(){
				if(is_admin_login() && isset($this->params['observacion']))
				{
					$observacion = $this->params['observacion'];
					$observacion['cod_interno'] = TPersona::cod_interno($observacion['cedula']);
					unset($observacion['cedula']);
					$observacion['updated_by'] = user_logged_info('cod_interno');
					TObservacion::save($observacion);
					redirect_to('observaciones','view', array('cedula'=>$this->params['observacion']['cedula']));
				}
		}
	}
?>
