<?php

	if(is_student_login ())
	 return acceso_restringido ();

	/**
	 * Clase CursosController extendida de Controller
	 */
	class CursosEspecialesController extends Controller {

     /**
	 * Constructor de la Clase CursosController
	 */
	 function __construct() {
		parent::__construct();
    $this->includeModel('CursoEspecial');
    $this->vista->setTitle('Cursos Especiales');
    
		$this->CursoEspecial = new CursoEspecial();
		$this->TPrograma = new TPrograma();
	 }
   
   function index($params){
     $this->vista->addJS("jquery.dataTable");
     if(isset($params['cod_programa'])){
       $this->TPrograma->load("TComponente");
       $componentes = $this->TPrograma->TComponente->talleres();
       $this->vista->set("componentes", $componentes);
       
       $cursos = $this->CursoEspecial->all($params['cod_programa']);
       $this->vista->set('cursos', $cursos);
     }
     
     $this->vista->display();
   }
   
   function preCreate($params, $request){
     if(!$request->isPOST()){
      $this->redirect('index');
      return false;
     }
   }
   
   function create($params){
     $this->CursoEspecial->create($params);
     $this->redirect("index");
   }
   
   function cursos_segun_programa($params){
     echo JSON::encode($this->CursoEspecial->toArray($params['cod_programa']));
   }

}
?>
