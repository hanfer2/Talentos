<?php
  /**
   * Clase EstudiantesController extendida de Controller
   */
 class EstudiantesController extends Controller {

   /**
	* Constructor de la Clase EstudiantesController
	*/
   function __construct() {
     parent::__construct();
     parent::includeModel('TEstudiante');
     $this->vista->setTitle('Participantes');
     $this->TEstudiante = new TEstudiante();
   }

   /**
    * Muestra un informe detallado con los estudiantes segun el programa
		*/
   function informe($params) {
		 $this->vista->addJS('highcharts','jquery.dataTable');
     $this->vista->setTitle('Informe de Participantes');
     if($this->params['cod_programa']){
		   AppLoader::load_model('Reports/Estudiantes');
		   $oInforme = new InformeEstudiantes($params['cod_programa']);
		   $this->TEstudiante->Load('TEstado');
		   $oInforme->nombreEstadoEstudiantes = $this->TEstudiante->TEstado->nombre($oInforme->EstadoEstudiantes);
		   $this->vista->set('oInforme', $oInforme);
		 }
     $this->vista->display();
   }

   /**
	  * Muestra el listado de los estudiantes inactivos segun el programa
	  */
	 function inactivos(){
		 $this->vista->addJS('jquery.dataTable');
		 $this->vista->setTitle('Informe de Inactivos');
		 if($this->params['cod_programa']){
			 $inactivos = $this->TEstudiante->inactivos($this->params['cod_programa']);
			 $this->vista->set('inactivos', $inactivos);
		 }
		 $this->vista->display();
	 }
	 
	 

   /**
    * Listado de estudiantes segun un programa
		*/
   function index($params) {
     if(is_student_login())
      $this->vista->acceso_restringido();
     $this->vista->setTitle('Listado de Participantes');
     
     $this->vista->addJS('jquery.dataTable');
     
     //Si se indica el programa.
     if(!is_blank($params['cod_programa'])){
			 $cod_programa = $params['cod_programa'];
       $status = null;
       if(isset($params['st'])){
        $status = str_replace("|",",",$params['st']);
       }else{
        $TPrograma = new TPrograma();
        $status = $TPrograma->esta_activo($params['cod_programa']) ? COD_ESTADO_ACTIVO : COD_ESTADO_EGRESADO;
       }
			 $estudiantes = $this->TEstudiante->listado_completo($cod_programa, $status);
			 
			 $nombres_estados = array();
			 
			 $this->vista->set('estudiantes',$estudiantes);
			 
			 $this->TEstudiante->Load('TEstado');
			 foreach(explode(',', $status) as $cod_estado)
					$nombres_estados[$cod_estado] = $this->TEstudiante->TEstado->nombre($cod_estado). "S";
			 $this->vista->set('nombres_estados', $nombres_estados);
     }
			$this->vista->display();
   }

	 /**
	  * Pone como inactivo a un estudiante
	  */
	 function delete(){
			if($this->params['persona']){
			 TEstudiante::inactivar($this->params['persona']);
			}
		}

		/**
		 * Reactiva a un estudiante segun su cedula
		 */
		function reactivate(){
			if($this->params['cedula']){
			 TEstudiante::reactivar($this->params['cedula']);
			 redirect_to('personas','view',array('cedula'=>$this->params['cedula']));
			}
		}

		/**
		 * Cambia de curso a un estudiante
		 */
		function cambiarCurso(){
			if($this->params['persona']){
			 TEstudiante::cambiarCurso($this->params['persona']['cod_interno'], $this->params['persona']['cod_curso']);
			}
		}

		/**
		 * Le asigan un curso a un estudiante
		 */
		function asignarCurso(){
			if($this->post['persona']){
				TEstudiante::asignarCurso($this->params['persona']['cod_interno'], $this->post['cod_curso']);
			}
		}
    
    function movimientos($params, $request){
      $cod_programa = $request->getParam('cod_programa', TPrograma::max());
      if(!$request->hasParam('cod_programa')){
          $this->vista->set('cod_programa', $cod_programa);
      }
      
      $mov = $this->TEstudiante->movimientos($cod_programa);
      $this->vista->set('total',0);
      $this->vista->set('mov', $mov);
      
      $this->vista->display();
    }
	
		
	 
 }
?>
