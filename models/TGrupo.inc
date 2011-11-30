<?php
  /**
   * Se incluye la Clase TBaseModel
   */
  require_once 'TBaseModel.inc';

  /**
   * Clase TGrupo extendida de TBase
   */
  class TGrupo extends TBase {

    /**
     * Crea la consulta para seleccionar los distintos grupos de un programa especifico
     *
     * @param int $cod_programa
     * @return string
     */
    function toSQL($cod_programa=null) {
      if(is_blank($cod_programa))
        $cod_programa = TPrograma::max();
      return sprintfn("(SELECT '-', 'TODOS') UNION (SELECT DISTINCT grupo, grupo FROM %(viewname)s WHERE cod_programa = '$cod_programa' ORDER BY grupo )", Config::getModel(__CLASS__));
    }

    /**
     * Devuelve el campo especificado de los grupos segun tipo, programa al que pertenece y de letra especifica  ordenados por el nombre del grupo
     *
     * @param int $cod_programa
     * @param string $letra
     * @param string $campo
     * @param string $tipo
     * @return array
     */
    function subgrupos($cod_programa, $letra = null, $campo='nombre_grupo', $tipo = null) {
      $sql = "SELECT $campo FROM ". Config::get(__CLASS__,'viewname');
      $sql .= " WHERE tipo " . (is_null($tipo) ? "IS NULL" : "= $tipo") . " AND cod_programa = '$cod_programa'";
      if(!is_blank($letra))
        $sql .= " AND  grupo = '$letra'";
      $sql .= " ORDER BY nombre_grupo";
      return DB::query($sql);
    }

    /**
     * Devuelve el resultado de una consulta con algunos los campos
     *
     * @param int $codigo
     * @param array $fields
     * @param array $options
     * @return array
     */
    function get($codigo, $fields='*', $options=array()) {
      return TGrupo::get(__CLASS__, array('codigo'=>$codigo), $fields, $options);
    }

    /**
     * Devuelve los distintos grupos segun un programa especifico ordenados por grupo
     *
     * @param int $cod_programa
     * @return array
     */
    
function all() {
      $sql = "SELECT DISTINCT grupo FROM ".Config::get(__CLASS__, 'viewname').
          " WHERE cod_programa = '$cod_programa' ORDER BY grupo";
      return DB::query($sql);
    }
    
 function all2($codigoPrograma) {
      $sql = "SELECT DISTINCT grupo FROM ".Config::get(__CLASS__, 'viewname').
          " WHERE cod_programa = '$codigoPrograma' ORDER BY grupo";
      return DB::query($sql);
    }   
    /**
     * ???
     *
     * @param int $cod_grupo
     * @return string
     */
    function nombre($cod_grupo) {
      if($cod_grupo == '-')
        return 'TODOS';
      return $cod_grupo;
    }
    
    /**
     * Devuelve un arreglo con los codigos de los subgrupos
     *
     * @param int $cod_programa
     * @return array
     */
    function clasificadosConCursos($cod_programa){
    	$cursos = TGrupo::subgrupos($cod_programa, null, 'grupo, cod_grupo, subgrupo');
    	$grupos = array();
    	foreach($cursos as $curso)
    		$grupos[$curso['grupo']][$curso['subgrupo']] = $curso['cod_grupo'];
    	return $grupos;
    }
  

function letras($param){
  $sql="select distinct(grupo) from a_grupos where cod_programa = '$param' order by grupo";
   return DB::query($sql);
  }
}
  /**
   * Se incluye la Clase TCurso
   */
  require_once 'TCurso.inc';

?>
