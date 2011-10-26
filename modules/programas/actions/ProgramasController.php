<?php

  /**
   * Clase ProgramasController extendida de Controller
   */
  class ProgramasController extends Controller{

    /**
	 * Constructor de la Clase ProgramasController
	 */
    function __construct(){
      parent::__construct();
      $this->includeModel("TPrograma");
      $this->vista->setTitle('Programas');
    // $smarty = new Smarty;
    }

	/**
	 * Muestra los PNATs
	 */
    function index(){
      
			if(!(is_admin_login() || is_coordinator_login()))
				return $this->vista->acceso_restringido();
      $programas = TPrograma::all();
     
      $sm=strtotime("now");

      
      $this->vista->addJS('jquery.dataTable','jquery.ui.datepicker');
      $this->vista->set('programas',$programas);
      $this->vista->display();
    }

	/**
	 * Registra un nuevo PNAT
	 */
    function add(){
			if(!is_super_admin_login())
				return $this->vista->acceso_restringido();
      if(!empty($this->params['programa'])){
        TPrograma::add($this->params['programa']);
      }
    }

	/**
	 * Muestra informacion sobre un PNAT
	 */
    function view($params, $request){
			$cod_programa = $request->getParam('cod_programa');
			
			$this->includeModel('TComponente');
	
      if($this->AppUser->isStudent()){
				$cedula = $this->AppUser->getCedula();
				$this->includeModel("TPersona");
				$cod_programa = $this->TPersona->cod_programa($cedula);
				$this->vista->set('cod_programa', $cod_programa);
      }else{
        $this->vista->set('programa', $this->TPrograma->get($cod_programa));
      }
		
			$CANT_SEMESTRES = 2; #CANTIDAD DE SEMESTRES
			$this->vista->set('cantidad_semestres', $CANT_SEMESTRES);
      $this->vista->set('is_closed', $this->TPrograma->isClosed($cod_programa));
			$this->vista->display();
    }

    /**
	 * Registrar programas y cursos
	 */
    function configurar() {
     //SOLO EL ADMINISTRADOR PUEDE MATRICULAR
     if(!$this->AppUser->isRoot())
       return $this->vista->acceso_restringido();

     $this->includeModel('TComponente');

     //TODO: actualizar el codigo del programa a matricular.
     $cod_programa = $this->params['cod_programa'];
     $this->vista->addJS('jquery.dataTable');

     $tiene_cursos = $this->TPrograma->tieneCursos($cod_programa);
     
     $this->vista->set('tiene_cursos', $tiene_cursos);
     if(!$tiene_cursos){
       if($this->TPersona == null)
        $this->TPersona = new TPersona();
       $tiene_participantes = $this->TPersona->hayAdmitidos();
       $this->vista->set('tiene_participantes', $tiene_participantes);
     }
     
     $this->vista->display();
   }
   
   function create_cursos($params, $request){
     if(!$this->AppUser->isRoot() && !$request->isPost())
       return $this->vista->acceso_restringido();
     $grupos = $params['programa']['cursos'];
     $cod_programa = $request->getParam('cod_programa');
     AppLoader::load_model('TCurso');
     
     $this->TCurso = new TSubgrupo();
     $codigo = TSubgrupo::max();
     
     foreach($grupos as $grupo=>$cursos)
      foreach($cursos as $nombre_curso=> $cupo){
        if($cupo == "")
          continue;
        $curso = array('codigo'=>++$codigo, 'grupo'=>$grupo, 'subgrupo'=>$nombre_curso, 'cod_programa'=>$cod_programa, 'cupos'=>$cupo);
        $this->TCurso->crear($curso);
      }
   }
   //cargar el archivo CSv con el listado de estudiantes
   
   function cargar_participantes($params, $request){
     if(!$this->AppUser->isRoot())
      return $this->vista->acceso_restringido();
      
     $file = $request->getFile('participante');
     
     if($file['type'] == 'text/csv'){
       AppLoader::load_model('Extra/SubeEstudiantesFactory');
       $csv = CSV::load($file['tmp_name'],';');
       $loader = SubeEstudiantesFactory::create($request->getParam('tipo','participantes'),$csv);
       $loader->subir();
     }else{
       echo 'El archivo debe ser un CSV';
     }
   }
   
   function asignar_cursos($params, $request){
     if(!$this->AppUser->isRoot())
      return $this->vista->acceso_restringido();
     AppLoader::load_model('Extra/AsignaCurso');
     $asignador = new AsignaCurso($request->getParam('cod_programa')) ;
     $asignador->asignar_cursos();
   }
   

   
   
   function close($params, $request){
     if(!$this->AppUser->isRoot())
      return $this->vista->acceso_restringido();
     if($request->hasParam('cod_programa')){
       $cod_programa = $request->getParam('cod_programa');
       $this->TPrograma->close($cod_programa);
       return $this->redirect('view', array('cod_programa'=>$cod_programa));
     }
     return $this->redirect('index');
      
   }
  }
?>
