<?php
//require_once 'IRespuestas.inc';
AppLoader::load_model('Extra/IRespuestas');
/**
 * Clase ICuestionariosEstudiantesController extendida de Controller
 */
class ICuestionariosEstudiantesController extends Controller {

  /**
   * Constructor de la Clase ICuestionariosEstudiantesController
   */
  function __construct() {
    
    parent::__construct();
    $this->includeModel('TIcfes', 'ICompetencia', 'ICuestionario');
		$this->vista->setTitle('Pruebas');
		$this->ICuestionario = new ICuestionario();
  }

  /**
   * Registra un cuestionario dentro de una prueba
   *
   * @param array $params
   */
  function add($params) {
    if (!is_blank($params['cod_prueba'])) {
      if (!is_blank($params['cedula'])) {
        if (TPersona::cod_interno($params['cedula']) == null) {
          ;
        } else if (ICuestionario::estaCalificada($params['cod_prueba'], $params['cedula']))
          $this->vista->set('estudianteCalificado', true);
        else {
          $this->vista->set('estudianteCalificado', false);
          $preguntas = ICuestionario::preguntasParaNotas($params['cod_prueba']);
          if ($preguntas != null) {
            $this->vista->set('componentes', ICuestionario::componentes());
            $this->vista->set('letras', range('A', 'E'));
          }
          $this->vista->set('preguntas', $preguntas);
        }
      }
    }
    $this->vista->display();
  }

  /**
   * Resumen de una prueba
   *
   * @param array $params
   */
  function view($params) {
    if (isset($params['cedula']) && isset($params['cod_prueba'])) {
			
			$cod_prueba = $params['cod_prueba'];
			$cod_interno = array('cod_interno'=>TPersona::cod_interno($params['cedula']));
			$cantidad_respuestas = ICuestionario::cantidad_respuestas($cod_prueba, $cod_interno);
      $respuestas = ICuestionario::respuestas($cod_prueba, $cod_interno);
      
      $this->vista->set('letras', range('a', 'e'));
      
			if(!is_user_login(COD_TIPO_DIGITA_ICFES)){
        AppLoader::load_model('Extra/IRespuestas');
		    
		    $VALORATION_TYPES = array('CORRECTAS' => 0, 'INCORRECTAS' => 0, 'NULAS' => 0, 'VACIAS' => 0, 'NO CALIFICADAS'=>0);
		    $resumen = array();
		    $resumen['GENERAL'] = $VALORATION_TYPES;
		    foreach ($respuestas as $componente => $preguntas) {
		      $resumen[$componente] = $VALORATION_TYPES;
		      foreach ($preguntas as $contador_pregunta => $respuesta) {
		        $respuesta_escogida = GeneraPuntaje::definirRespuestaEscogida($respuesta);
		        $valoracion = GeneraPuntaje::esRespuestaCorrecta($respuesta_escogida, $respuesta['respuesta']);
		        $resumen['GENERAL'][$valoracion]++;
		        $resumen[$componente][$valoracion]++;
		        $respuestas[$componente][$contador_pregunta]['VALORACION'] = $valoracion;
		        $respuestas[$componente][$contador_pregunta]['respuesta'] = explode(",", $respuesta['respuesta']);
		      }
		    }
		    $this->vista->set('resumen', $resumen);
		    if(is_root_login()){
					$cod_digitador = ICuestionario::digitador($cod_prueba, $cod_interno);
					if($cod_digitador != null)
						$this->vista->set('nombre_digitador', TPersona::nombre(array('cod_interno'=>$cod_digitador)));
		    }
		    
		  }
		  $this->vista->set('respuestas', $respuestas);
		  $this->vista->set('cantidad_respuestas', $cantidad_respuestas);
		  $this->vista->set('is_digita_icfes_login', is_user_login(COD_TIPO_DIGITA_ICFES));
    }
    $this->vista->display();
  }

  /**
   * Guarda las respuestas de una persona en concreto
   *
   * @param array $params
   * 	- cedula: cedula del estudiante a quien se le diligencia el cuestionario.
   */
  function save($params) {
		if($_SERVER['REQUEST_METHOD'] != 'POST')
			$this->vista->acceso_restringido();
		$cedula = $params['cedula'];
    if (isset($this->post['respuestas'])) {
			
      $cod_interno = TPersona::cod_interno($cedula);
      //Guarda las respuestas escogidas por el estudiante.
      $this->ICuestionario->diligenciar($cod_interno, $params['cod_prueba'] ,$this->post['respuestas'], $this->current_user['cod_interno']);
    }
    $cod_prueba_actual = Config::Get('App','I.COD_CUESTIONARIO_ACTUAL');
    redirect_to('i_cuestionarios_estudiantes', 'view', array('cod_prueba' => $cod_prueba_actual, 'cedula' => $cedula));
  }

  function delete(){
		//if($_SERVER['REQUEST_METHOD'] != 'POST')
		//	$this->vista->acceso_restringido();   
			
			if($this->params['cedula'] != null){
				$cedula = $this->params['cedula'];
				$cod_prueba = $this->params['cod_prueba'];
				$sql = "delete from i_respuestas where cod_interno = (select cod_interno from a_persona where cedula='$cedula') and cod_pregunta in (select codigo from i_preguntas where cod_prueba = $cod_prueba)";
				DB::query($sql);
				$sql = "delete from i_cuestionarios_diligenciados where cod_interno = (select cod_interno from a_persona where cedula='$cedula') and cod_prueba = $cod_prueba";
				DB::query($sql);
			}
			if(!is_xhr())
				$this->vista->display();	
   }
   
	function edit(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$cod_interno = TPersona::cod_interno($this->params['cedula']);
			$numeral = $this->params['numeral'];
			$cod_prueba = $this->params['cod_prueba'];
			if($cod_prueba == null)
				echo "CODIGO DE PRUEBA NO DEFINIDO";
			else{
				$respuesta = $this->params['respuesta'];
				
				$hayRespuestaEn = ICuestionario::hayRespuestaEn(array('cod_interno'=>$cod_interno), $cod_prueba, $numeral);
				if($hayRespuestaEn)
					ICuestionario::actualizarRespuestaEscogida(array('cod_interno'=>$cod_interno), $cod_prueba, $numeral, $respuesta);
				else{
					$cod_pregunta = ICuestionario::pregunta($cod_prueba, $numeral);
					ICuestionario::insertarRespuestaEscogida(array('cod_interno'=>$cod_interno), $cod_pregunta, $respuesta);
				}
			}
		}
		if(!is_xhr())
			$this->vista->display();
	}
  
  
/*pruebas para las funciones de las respuestas para los simulacros, se llamara atravez del menu, mandaremos 
 * los codigo internos con la prueba que estan en la tabla i_cuestionarios_diligenciados, para ello primero debemos consultar ese listado*/
 

function prueba(){
  // AppLoader::load_model('Extra/IRespuestas');
//hallar estudiantes de la prueba actualq eu ya alla llenado el simulacro con respuestas
  $estudiantesD=ICuestionario::codigoInterno_estudiantePrueba('15');
  //print_r ($estudiantesD);
  echo "miremos si sale en esa vaina";
  GeneraPuntaje::GeneraPuntaje('15');
}
}

?>
