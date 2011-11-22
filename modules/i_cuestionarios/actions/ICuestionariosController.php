<?php

        /**
         * Clase ICuestionariosController extendida de Controller
         */
	class ICuestionariosController extends Controller {

         /**
	  * Constructor de la Clase ICuestionariosController
	  */
	 function __construct() {
			parent::__construct();
      //include_once 'TIcfes_Competencias.inc';
			$this->includeModel('TIcfes', 'TPrograma','ICompetencia', 'ICuestionario', 'ICualitativo');
			$this->vista->setTitle('Pruebas');
			$this->ICuestionario = new ICuestionario();
	 }

	 /**
	  * Muestra las pruebas y su tipo para el programa indicado
	  */
	 function index(){
		 if(isset($this->params['cod_programa'])){
			 $pruebas = ITipo::segunPrograma($this->params['cod_programa']);
			 $tipos_icfes = array(I_TIPO_SIMULACRO=>'Simulacro', I_TIPO_OFICIAL=>'Prueba Oficial');
			 $this->vista->set('pruebas', $pruebas);
			 $this->vista->set('tipos_icfes', $tipos_icfes);
		 }
		 $this->vista->display();
	 }

         /**
	  * Resumen de una prueba
	  *
	  * @param array $params
	  */
	 function view($params){
		 if(!is_blank($params['cod_prueba'])){
			$preguntas = ICuestionario::preguntas($params['cod_prueba'], $params['cod_componente']); 
			$this->vista->set('preguntas', $preguntas);
			if($preguntas != null){
				$this->vista->set('cod_programa', ITipo::programa($params['cod_prueba']));
				
				$IComponente = $this->ICuestionario->IComponente();
				$this->vista->set('componentes', $this->ICuestionario->componentes());
				if(isset($params['cod_componente'])){
					$this->vista->set('nombre_componente', $IComponente->nombre($params['cod_componente']));
				}
				$this->vista->set('cualitativos', ICualitativo::all());
				$this->vista->set('competencias', ICompetencia::all());
				$this->vista->set('respuestas', range('A','E'));

				$estaCalificada = $this->ICuestionario->estaCalificada($params['cod_prueba']);
				$this->vista->set('estaCalificada',$estaCalificada);
			}
		 }else{
			 $IComponente = $this->ICuestionario->IComponente();
			 $this->vista->set('componentes', $this->ICuestionario->componentes());
		 }
		 $this->vista->display();
		}

	 /**
	  * Muestra los simulacros sin cuestionario segun el programa indicado
	  */
	 function simulacros_sin_cuestionario(){
		 echo JSON::encode(ITipo::simulacrosSinCuestionario($this->params['cod_programa']));
	 }

         /**
	  * Muestra los simulacros con cuestionario segun el programa indicado
	  */
	 function simulacros_con_cuestionario(){
		 echo JSON::encode(ITipo::simulacrosConCuestionario($this->params['cod_programa']));
	 }

         /**
	  * Registra un cuestionario dentro de una prueba
	  *
	  * @param array $params
	  */
	 function add($params){
		 if(!is_root_login() and ! is_logged_cedula('1143924352'))
				$this->vista->acceso_restringido();
     if($this->params['cod_prueba']){
			 if(isset($this->params['preguntas'])){
				$preguntas = $this->params['preguntas'];
       // print_r ($preguntas[1]);
        //echo "<br/>"."la numeral ".$preguntas['1']['numeral'];
				$this->ICuestionario->registrarPreguntas($this->params['cod_prueba'], $preguntas);
				 $this->vista->set('message', "Registro Exitoso. El cuestionario se registro con éxito");
			 }else{
				 $this->vista->set('componentes', ICuestionario::componentes());
				 if(isset($params['cod_componente']))
					$this->vista->set('nombre_componente', TComponente::nombre($params['cod_componente']));
				 $this->vista->set('cualitativos', ICualitativo::all());
				 $this->vista->set('competencias', ICompetencia::all());
				 $this->vista->set('pregunta', array('codigo'=>$this->params['cod_prueba']."-".$preguntas['1']['numeral']));
				 $this->vista->set('respuestas', range('A','E'));
			}
	   }
		 $this->vista->display();
	 }

   /**
	  * Actualiza las preguntas de un cuestionario
    *
	  * @param array $params
	  */
	 function update($params){
     
		 if($_SERVER['REQUEST_METHOD'] =='POST' && isset($this->post['preguntas'])){
			 $params['cod_prueba'] = $this->post['cod_prueba'];
			 $params['cod_componente'] = $this->post['cod_componente'];
			 $this->ICuestionario->actualizar($params['cod_prueba'], $params['cod_componente'], $this->post['preguntas']);
			 
		 }
		 $this->_redirect_to('view', $params);
	 }
	 
	/**
	 * Informe de los resultados de una prueba
	 *
	 * @param array $params
	 */
	function informe($params){
		if(!is_blank($params['cod_prueba'])){
			require_once  'ICuestionario.inc';
			$reporte = new IReporteCuestionario($params['cod_prueba']);
			$rComponentes = $reporte->componentes();
			$this->vista->set('reportes', $reporte);
			$this->vista->set('rComponentes', $rComponentes);
		}
		$this->vista->display();
	}
 
	function calcular(){
   AppLoader::load_model('TIcfes.Competencias');
      $pruebActual='15';
   $respuesta=TIcfes_Competencias::calcular_todos($pruebaActual);
     $this->vista->set('pruebActual', $pruebActual);
     $this->vista->display();
  }

	function check($params){
		if($params['cod_prueba'] != null){
      
			require_once 'ICuestionario.inc';
			$reporte = new IReporteCuestionario($params['cod_prueba']);
			//generamos un reporte de los cuestionarios (CALIFICADOS/NO CALIFICADOS)
			$cuestionarios = $reporte->mostrarCuestionariosCalificados();
			$this->vista->display(array('layout'=>FALSE));
		}else{
			$this->vista->display();
		}
	}
	
}
?>
