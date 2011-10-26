<?php

//require_once 'IAbstractCalificadoresEstudiantesController.php';
AppLoader::load_file(AppConst::get('siat_libs_dir').'controllers/IAbstractCalificadoresEstudiantesController');
/**
 * Clase ICualitativosEstudiantesController extendida de Controller
 */
class ICompetenciasEstudiantesController extends IAbstractCalificadoresEstudiantesController {

 /**
  * Constructor de la Clase ICompetenciasEstudiantesController
  */
  function __construct() {
    parent::__construct();
    $this->includeModel('ICompetencia');
    //AppLoader::load_model('ICompetencia');
    $this->Calificador = new ICompetencia();
    
    $this->vista->setTitle('Competencias Icfes');
  }

  /**
   * Reporte ICFES para una prueba especifica para todos o el estudiante especificado
   * 
   * @param array $params:
   *    - cod_prueba: codigo de la prueba a consultar.
   */
  function reporte($params) {
		//En el formulario de Reporte, el codigo del curso se incluye dentro del arreglo "competencias".
		if(!isset($params['cod_curso']) && isset($params['competencias']['cod_curso']))
			$params['cod_curso'] = $params['competencias']['cod_curso'];

		parent::reporte($params);
  }

}
?>
