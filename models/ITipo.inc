<?php

require_once 'IComponente.inc';

class ITipo extends TBase {
	
	function __construct(){
		parent::__construct();
		$this->tablename = Config::get(__CLASS__);
	}

  function get($codigo, $select='*', $options=array()) {
    return parent::get(__CLASS__, $codigo, $select, $options);
  }

	/**
	 * Lista todas las pruebas relacionadas con un programa.
	 * 
	 * @param string $cod_programa codigo del programa
	 * @return array las pruebas con su respectiva informacion.
	 */
  function all($cod_programa) {
		$sql = "SELECT * FROM {$this->tablename} WHERE cod_programa = '$cod_programa' ORDER BY fecha";
    return $this->db->grouped_query($sql, 'codigo');
  }

  function first($options=array()) {
    return parent::first(__CLASS__, $options);
  }

  /**
   * Retorna el nombre del ICFES con el codigo indicado.
   * @param int $codigo codigo del icfes
   * @return string nombre del icfes con el codigo indicado.
   *  FALSE si $codigo es nulo o blanco
   *  null si no es hallado el nombre del icfes
   */
  function nombre($codigo) {
    return ITipo::get($codigo, 'nombre');
  }

  function fecha($codigo) {
    return ITipo::get($codigo, 'fecha');
  }
  
  function tipo($codigo){
    return ITipo::get($codigo, 'tipo');
  }

  /**
   * Retorna el codigo del programa del icfes indicado.
   * @param int $codigo codigo del icfes a consultar
   * @return string codigo del programa al que pertenece
   */
  function programa($codigo) {
    return ITipo::get($codigo, 'cod_programa');
  }

  function codigos() {
    $sql = sprintfn("SELECT codigo FROM %(tablename)s ORDER BY %(order)s", Config::getModel(__CLASS__));
    return DB::query($sql);
  }

  function componentes() {
    $componentes = IComponente::componentes();
    return $componentes;
  }

  function competencias($cod_prueba, $componente=null) {
    $campo = 'codigo';
    $competencias = array();
    if (is_null($componente)):
      $competencias = DB::query("SELECT $campo FROM i_competencias WHERE EXISTS(SELECT * FROM i_preguntas where cod_prueba = '$cod_prueba' AND cod_competencia = i_competencias.codigo) AND valida = TRUE");
    else:
      $competencias = DB::query("SELECT $campo FROM i_competencias WHERE EXISTS(SELECT * FROM i_preguntas where cod_prueba = '$cod_prueba' AND cod_competencia = i_competencias.codigo AND valida = TRUE AND cod_componente =(SELECT codigo from i_componentes WHERE nombre ='$componente'))");
    endif;
    return $competencias;
  }
  
  function cualitativos($cod_prueba, $componente=null) {
    $campo = 'codigo';
    $cualitativos = array();
    if (is_null($componente)):
      $cualitativos = DB::query("SELECT $campo FROM i_cualitativos WHERE EXISTS(SELECT * FROM i_preguntas where cod_prueba = '$cod_prueba' AND cod_cualitativo = i_cualitativos.codigo) AND valida = TRUE");
    else:
      $cualitativos = DB::query("SELECT $campo FROM i_cualitativos WHERE EXISTS(SELECT * FROM i_preguntas where cod_prueba = '$cod_prueba' AND cod_cualitativo = i_cualitativos.codigo AND valida = TRUE AND cod_componente =(SELECT codigo from i_componentes WHERE nombre ='$componente'))");
    endif;
    return $cualitativos;
  }

  /**
   * Determina la ultima prueba oficial segun fecha de un programa indicado.
   * En caso de omitir el programa, sería la ultima prueba oficial en general.
   * @param string $cod_programa codigo del programa a consultar.
   * @return string codigo de la ultima prueba oficial del programa ingresado.
   */
  function ultimaPruebaOficial($cod_programa=null) {
    $conditions = array(
        'order' => 'fecha DESC', 'select' => 'codigo',
        'conditions' => array('tipo' => ICFES_PRUEBA_OFICIAL));
    if (!is_blank($cod_programa))
      $conditions['conditions']['cod_programa'] = $cod_programa;
    return IIcfes::first($conditions);
  }

  function segunPrograma($cod_programa) {
    $sql = "SELECT * FROM " . Config::get(__CLASS__) . "
							WHERE cod_programa = '$cod_programa' ORDER BY fecha";
    return DB::table_query($sql);
  }

  function toSQL($cod_programa=null) {
    if ($cod_programa == null)
      $cod_programa = TPrograma::max('codigo');
    $args = array('tablename' => Config::get(__CLASS__));
    return sprintfn("SELECT codigo, nombre FROM %(tablename)s WHERE cod_programa = '$cod_programa' ORDER BY fecha DESC", $args);
  }

  function icfesConCompetencias_toSQL($cod_programa=null) {
    if (is_blank($cod_programa))
      $cod_programa = TPrograma::max('codigo');
    $args = array(
        'tablename' => Config::get(__CLASS__),
        'icfes_table' => Config::get('TIcfes'),
        'i_preguntas' => Config::get('ICuestionario', 'Pregunta')
    );
    return sprintfn("
      SELECT codigo, nombre FROM %(tablename)s
      WHERE EXISTS(SELECT * FROM %(icfes_table)s WHERE	%(icfes_table)s.tipo = %(tablename)s.codigo) AND cod_programa = $cod_programa AND
        EXISTS (SELECT * FROM %(i_preguntas)s WHERE cod_prueba = %(tablename)s.codigo) ORDER BY fecha DESC", $args);
  }

  function simulacros($cod_programa=null, $options=array()) {
    if ($cod_programa == null)
      $cod_programa = TPrograma::max('codigo');

    $select = "codigo, nombre";
      
    $sql = "SELECT $select FROM " . Config::Get(__CLASS__) . " prueba
								WHERE cod_programa = '$cod_programa' AND tipo = '" . I_TIPO_SIMULACRO . "' ";
    if (isset($options['cuestionario'])) {
      $sql .= "AND " . ($options['cuestionario'] === FALSE ? "NOT" : "") .
          " EXISTS ( SELECT 1 FROM " . Config::get('ICuestionario', 'Pregunta') .
          " WHERE cod_prueba = prueba.codigo)";
    }
    $sql .= " ORDER BY fecha DESC";
    if($options['SQL'])
      return $sql;
    $result = DB::assoc_query($sql);
    
    return $result;
  }
  
  function cod_pruebas_simulacros($cod_programa){
    $sql = "SELECT codigo FROM i_tipos WHERE cod_programa = '".q($cod_programa)."' AND tipo = '".I_TIPO_SIMULACRO."'";
    return $this->db->aquery($sql);
  }

  function simulacrosSinCuestionario($cod_programa=null) {
    $sql =  ITipo::simulacros($cod_programa, array('cuestionario' => FALSE, 'SQL'=>TRUE));
    return DB::table_query($sql);
  }

  function simulacrosConCuestionario($cod_programa = null) {
    $sql =  ITipo::simulacros($cod_programa, array('cuestionario' => TRUE, 'SQL'=>TRUE));
    return DB::table_query($sql);
  }

  function max($select, $conditions="") {
    return parent::max(__CLASS__, $select, $conditions);
  }

  function create($data) {
    if (!isset($data['codigo'])) {
      $data['codigo'] = ITipo::max('codigo') + 1;
    }
    $data['nombre'] = upper($data['nombre']);
    $sql = sql_insert_from_array(Config::get(__CLASS__), $data);
    DB::query($sql);
  }
  
  function update($cod_prueba, $campos, $valores=null){
		if($cod_prueba == null)
			return false;
		if(is_array($valores))
			return $this->update($cod_prueba, array_combine($campos, $valores));
		$sql = sql_update_from_array($this->tablename, $campos, " codigo = $cod_prueba");
		return $this->db->query($sql);
	}
  
  /**
   * Modifica la visibilidad de una prueba.
   * @param string $cod_prueba codigo de la prueba
   * @param bool $visibilidad nuevo estado de visibilidad.
   */
  function setVisible($cod_prueba, $visibilidad){
		$this->update($cod_prueba, array('visible'=>$visibilidad));
	}
	
}

class IIdioma extends TBase {

  function get($codigo, $options=array()) {
    return parent::get(__CLASS___, $codigo, $options);
  }

  function nombre($codigo) {
    return IIdioma::get($codigo, 'nombre');
  }

}

class IInterdisciplinar extends TBase {
   
   function toArray(){
    $sql = "SELECT * FROM i_interdisciplinarias";
    return DB::query($sql);
  }

  function get($codigo, $options=array()) {
    return parent::get(__CLASS___, $codigo, $options);
  }

  function nombre($codigo) {
    return IInterdisciplinar::get($codigo, 'nombre');
  }

}



?>
