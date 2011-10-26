<?php

  /**
   * Clase ProgramasComponentesController.
   * 
   * Esta clase esta encargada de las operaciones que vinculan
   * a los <em>Componentes</em> con los <em>Programas</em>.
   */
  class ProgramasComponentesController extends Controller{

    function __construct(){
      parent::__construct();
      $this->includeModel("TComponente");
      $this->vista->setTitle('Programas/Componente');
      $this->TPrograma = new TPrograma();
      $this->TComponente = new TComponente();
    }

		/**
		 * Muestra los componentes de un PNAT para un determinado semestre.
		 * 
		 * @params string cod_programa codigo del PNAT a mostrar
		 * @params string|int semestre numeral del semestre {1|2}
		 */
    function index($params, $request){
      $cod_programa = $request->getParam('cod_programa');
			$componentes = $this->TPrograma->componentes($cod_programa, $params['semestre']);
      if($this->AppUser->isRoot()){
        $this->vista->set('isProgramaClosed', $this->TPrograma->isClosed($cod_programa));
      }
			$this->vista->set('componentes', $componentes);
      $this->vista->display();
    }

		/**
		 * Permite la asignacion y desasignacion de componentes 
		 * a un PNAT en un determinado semestre.
		 */
    function edit($params){
			//Componentes que ya estan relacionados con el PNAT en el semestre indicado.
			$componentesAsignados = $this->TPrograma->componentes($params['cod_programa'], $params['semestre']);
			//Componentes que aun no se han relacionado con el PNAT en el semestre indicado.
			$componentesDisponibles = $this->TComponente->disponibles($params['cod_programa'], $params['semestre']);
			$componentesSinHorario = $this->TComponente->sin_horario($params['cod_programa'], $params['semestre']);
			
			$this->vista->set('componentesAsignados',$componentesAsignados);
			$this->vista->set('componentesDisponibles',$componentesDisponibles);
			$this->vista->set('componentesSinHorario',$componentesSinHorario);
			
			$this->vista->display();
    }
    
    function add($params){
      $semestre = $params['semestre'];
      if(upper($params['semestre']) == 'CURSOS_ESPECIALES')
        $semestre = 3;
			if(is_post_request() && is_super_admin_login()){
				if(count($params['componentes']['added']) > 0)
					foreach($params['componentes']['added'] as $cod_componente){
						TPrograma::asignarComponente($cod_componente, $params['cod_programa'], $semestre);
					}
				if(count($params['componentes']['removed']) > 0)
					foreach($params['componentes']['removed'] as $cod_componente){
						TPrograma::removerComponente($cod_componente, $params['cod_programa'], $semestre);
					}
			}
			
		}

	
  }
?>
