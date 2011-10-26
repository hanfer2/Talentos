<?php

//require_once 'IAbstractCalificadoresEstudiantesController.php';
AppLoader::load_file(AppConst::get('siat_libs_dir').'controllers/IAbstractCalificadoresEstudiantesController');
/**
 * Clase ICualitativosEstudiantesController extendida de Controller
 */
class ICualitativosEstudiantesController extends IAbstractCalificadoresEstudiantesController {

 /**
  * Constructor de la Clase ICualitativosEstudiantesController
  */
  function __construct() {
    parent::__construct();
    $this->includeModel('ICualitativo');
    $this->Calificador = new ICualitativo();
    $this->vista->setTitle('Componentes Icfes');
  }

  /**
   * Reporte ICFES para una prueba especifica para todos o el estudiante especificado
   * 
   * @param array $params:
   *    - cod_prueba: codigo de la prueba a consultar.
   */
  function reporte($params) {
		//En el formulario de Reporte, el codigo del curso se incluye dentro del arreglo "cualitativos".
		if(!isset($params['cod_curso']) && isset($params['cualitativos']['cod_curso']))
			$params['cod_curso'] = $params['cualitativos']['cod_curso'];

		parent::reporte($params);
  }

}

?>
