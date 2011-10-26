<?php

/**
 * Clase ICualitativosEstudiantesController extendida de Controller
 */
class IAbstractCalificadoresEstudiantesController extends Controller {

	var $Calificador = null;
 /**
  * Constructor de la Clase ICualitativosEstudiantesController
  */
  function __construct() {
    parent::__construct();
    $this->includeModel('ICuestionario', 'TIcfes');
    $this->vista->addJS('jquery.dataTable','custom/icfes');
  }

  /**
   * 
   * @param array $params
   *  - cod_prueba:  codigo de la prueba a consultar.
   *  - cedula: cedula del estudiante a consultar.
   */
  function view($params) {
    if (!is_blank($params['cod_prueba']) && !is_blank($params['cedula'])) {
      $reporte = $this->Calificador->por_estudiante($params['cedula'], $params['cod_prueba']);
      $this->vista->set('reporte', $reporte);
      $this->vista->set('__componentes', $this->Calificador->por_componentes($params['cod_prueba']));
    }
    $this->vista->display();
  }

  /**
   * Reporte de ICFES por componentes para un curso segun la prueba especificada
   *
   * @return array
   */
  function __reporte_por_curso($params) {
    $reporte = $this->Calificador->por_curso($params['cod_curso'], $params['cod_prueba']);
    return $reporte;
  }

  /**
   * Reporte ICFES para una prueba especifica para todos o el estudiante especificado
   * 
   * @param array $params:
   *    - cod_prueba: codigo de la prueba a consultar.
   */
  function reporte($params) {
    if ($this->params['cod_prueba']) {
			$cod_prueba = $this->params['cod_prueba'];
      $reporte = null;
      $tpl_name = "";
      // Reporte individual.
      if (isset($params['cedula'])) {
        return $this->_redirect_to('view');
      } else{
        // Reporte por cursos.
        if (isset($params['cod_curso'])) {
          $cod_curso = any($params['cod_curso']);
          $this->vista->set('cod_curso', $cod_curso);
          $reporte = $this->__reporte_por_curso($params);
          $tpl_name = "por_curso";
        }else{
					if(ICuestionario::exists($cod_prueba)){
						$reporte = $this->Calificador->por_programa($cod_prueba);
						$grupos = array_keys($reporte);
						$reporte['consolidado'] = $this->Calificador->consolidado($cod_prueba);
						$this->vista->set('grupos', $grupos);
					}
					$tpl_name = "general";
				}
      }
      $componentes = $this->Calificador->por_componentes($cod_prueba);
      
      $this->vista->set('reporte', $reporte);
      $this->vista->set('__componentes', $componentes);
      $this->vista->set('nombres_componentes', array_keys($componentes));
      $this->vista->display(__FUNCTION__ . "_" . $tpl_name);
    }
  }

}

?>
