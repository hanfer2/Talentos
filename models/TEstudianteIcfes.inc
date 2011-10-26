<?php
 require_once("TEstudiante.inc");
 
class	TEstudianteIcfes	extends	TBase {

	function __construct(){
		parent::__construct();
		$this->tablename = Config::Get(__CLASS__);
	}
	
	/**
	 * Retorna el listado de los icfes/simulacros presentados 
	 * por el participante $cedula.
	 * @param string $cedula cedula del participante
	 * @param array $options listado de opciones
	 * 	- exclude: (string) Listado de codigos (separados por comas) de las pruebas que se excluiran del listado.
	 */
	function all($cedula, $options=null){
		$cod_interno = TEstudiante::cod_interno($cedula);
		if($cod_interno == null)
			return FALSE;
			
		//consulta general
		$sql = "SELECT icfes.* FROM {$this->tablename} icfes ".
					 " INNER JOIN ".Config::Get('ITipo')." pruebas ON pruebas.codigo = icfes.tipo  ".
					 " WHERE cod_interno = '$cod_interno' ";
		if($options['VISIBLE'])
			$sql .= " AND visible IS TRUE";
		$sql .=" ORDER BY fecha";
		$rs = $this->db->table_query($sql);
		
		return $rs;
	}
  
  /**
   * Registra en la base de datos un nuevo icfes para un participante 
   * @params array $data arreglo de datos del nuevo registro.
   */
  function create($data){
    $data = TEstudianteIcfes::clean_data($data);
    $sql = sql_insert_from_array($this->tablename, $data);
    $this->db->query($sql);
    
    $updated_by = user_logged_info('cod_interno');
    $update = array('cod_interno'=>$data['cod_interno'], 'cod_prueba'=>$data['tipo'], 'cod_digitador'=>$updated_by);
    $sql = sql_insert_from_array('i_cuestionarios_diligenciados', $update);
    $this->db->query($sql);
  }
  
  function update($data, $cod_prueba, $cod_interno){
    unset($data['tipo']);
    unset($data['cod_interno']);
    $data = TEstudianteIcfes::clean_data($data);
    $cod_prueba = q($cod_prueba);
    $cod_interno = q($cod_interno);
    $sql = sql_update_from_array($this->tablename, $data, " cod_interno = $cod_interno AND tipo = $cod_prueba ");
    $this->db->query($sql);
    $updated_by = user_logged_info('cod_interno');
    $sql = " UPDATE i_cuestionarios_diligenciados set n_actualizaciones = n_actualizaciones + 1, updated_by = '$updated_by' WHERE cod_interno = '$cod_interno' AND cod_prueba = '$cod_prueba' AND cod_digitador <> '$updated_by'";
    $this->db->query($sql);
  }
  
  function exists($cod_prueba, $cod_interno){
    $sql = "SELECT 1 FROM ".$this->tablename. " WHERE cod_interno = $cod_interno AND tipo = $cod_prueba ";
    return $this->db->boolQuery($sql);
  }
  
  function persist($data){
    if($this->exists($data['tipo'], $data['cod_interno']))
      $this->update($data, $data['tipo'], $data['cod_interno']);
    else
      $this->create($data);
  }
  
  function clean_data($old_data){
    $data = array();
    foreach($old_data as $k=>$v){
      if($k != 'num_registro_icfes')
        $data[$k] = floatval(str_replace(',', '.', $v));
      else
        $data[$k] =$v;
    }
    return $data;
  }
  
  function retrieve($cod_prueba, $cod_interno){
    $sql = "SELECT * FROM ". $this->tablename . " i JOIN i_cuestionarios_diligenciados c ON i.cod_interno = c.cod_interno AND i.tipo = c.cod_prueba WHERE i.tipo = '$cod_prueba' AND i.cod_interno = '$cod_interno' ";
    return $this->db->aquery($sql);
  }
}
?>
