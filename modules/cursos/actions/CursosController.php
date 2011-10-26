<?php

	if(is_student_login ())
	 return acceso_restringido ();

	/**
	 * Clase CursosController extendida de Controller
	 */
	class CursosController extends Controller {

     /**
	 * Constructor de la Clase CursosController
	 */
	 function __construct() {
		parent::__construct();
    $this->vista->setTitle('Cursos');
		$this->TSubgrupo = new TSubgrupo();
		$this->TPrograma = new TPrograma();
	 }

  /**
	 * Lista el programa, tipo de grupo, grupo y cantidad de estudiantes de un curso segun lo especificado
	 */
	 function index($params) {
		if($this->AppUser->isStudent())
			return $this->vista->acceso_restringido ();
		
		$this->vista->addJS("jquery.dataTable");
		
		
		$cod_programa = null;
		if (!is_blank($params['cod_programa'])){
			$cod_programa = $params['cod_programa'];
		}else{
			return $this->vista->display();
		}

		if (!is_blank($params['cod_grupo']))
		 $cod_grupo = $params['cod_grupo'];
		 
		$cod_estado = null;
		if($this->TPrograma->esta_activo($cod_programa))
			$cod_estado = COD_ESTADO_ACTIVO;
		else
			$cod_estado = COD_ESTADO_EGRESADO;
      
		$cursos = $this->TSubgrupo->listado($cod_programa, $cod_estado, $cod_grupo);
		$this->vista->set('cursos', $cursos);
		$this->vista->display();
	 }

  /**
	 * Lista los estudiantes de inscritos en un curso, se permite el acceso unicamente a los profesores que dictan clases
	 * en ese curso
	 */
	 function view() {
		if (!is_blank($this->params['cod_curso'])){
      $cod_curso = $this->params['cod_curso'];
      $cod_programa = $this->TSubgrupo->programa($cod_curso);
      $this->vista->set('cod_programa', $cod_programa);
    }
     
		$this->vista->addJS("jquery.dataTable");
		
		$estudiantes = null;
		if($this->TPrograma->esta_activo($cod_programa))
    {
			$estudiantes = $this->TSubgrupo->inscritosActivos($cod_curso);
		}
    else
    {
			$estudiantes = $this->TSubgrupo->inscritosEgresados($cod_curso);
    }
    
		$this->vista->set('nombre_curso', $this->TSubgrupo->nombre($cod_curso));
		$this->vista->set('estudiantes', $estudiantes);
		$this->vista->display();
	 }

	}

?>
