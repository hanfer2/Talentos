<?php 

AppConst::set('cu.tipo_curso_tf','TF');

class CursoEspecial extends TBase{
  
  function __construct(){
    parent::__construct();
    $this->tablename = "a_grupos";
  }
  
  function all($cod_programa){
    $sql = " SELECT g.nombre_grupo, c.nombre AS nombre_componente"
         . " FROM v_grupo g JOIN cu_componentes_cursos ON cod_grupo = cod_curso "
         . " JOIN a_componentes c ON cod_componente = c.codigo "
         . " WHERE tipo = '".AppConst::get('cu.tipo_curso_tf')."' AND cod_programa = '".q($cod_programa)."'";
    return $this->db->table_query($sql);
  }
  
  function add($data){
    $sql = sql_insert_from_array($this->tablename, $data);
    $this->db->query($sql);
  }
  
  function get($cod_programa, $field){
    $sql = "SELECT $field FROM v_grupo WHERE tipo = '".AppConst::get('cu.tipo_curso_tf')."' AND cod_programa = '".q($cod_programa)."'";
    return $this->db->fetchOne($sql);
  }
  
  function nextCurso($cod_programa){
    return $this->get($cod_programa, 'COALESCE(MAX(subgrupo), 0) + 1');
  }
  
  function nextCodigo(){
    $sql = "SELECT MAX(cod_grupo) + 1 FROM v_grupo";
    return $this->db->fetchOne($sql);
  }
  
  function beforeCreate($curso){
    $curso['codigo']    = $this->nextCodigo();
    $curso['grupo']     = 'T';
    $curso['subgrupo']  = $this->nextCurso($curso['cod_programa']);
    $curso['tipo']      = AppConst::get('cu.tipo_curso_tf');  
    return $curso;
  }
  
  function relacionarComponente($cod_curso, $cod_componente){
    $data = array(
      'codigo' => $cod_componente . $cod_curso . 3,
      'cod_componente' => $cod_componente,
      'cod_curso' => $cod_curso,
      'semestre' => 3
    );
    $sql = sql_insert_from_array('cu_componentes_cursos', $data);
    $this->db->query($sql);
  }
  
  function create($params){
    $curso = $this->beforeCreate($params['curso']);
    $this->add($curso);
    $this->relacionarComponente($curso['codigo'], $params['curso_componente']['cod_componente']);
  }
  
  function toSQL($cod_programa=null){
    
    if (is_blank($cod_programa))
				$cod_programa = TPrograma::max();
    $sql= " SELECT cod_grupo, nombre_grupo FROM v_grupo "
        . " WHERE tipo = '".AppConst::get('cu.tipo_curso_tf'). "' AND cod_programa = '".q($cod_programa)."'";
        
    return $sql;   
  }
  
  function toArray($cod_programa = null){
    $sql = CursoEspecial::toSQL($cod_programa);
    return $this->db->table_query($sql);
  }
  
  function getComponente($cod_curso){
    $sql = "SELECT * FROM a_componentes WHERE codigo = (SELECT cod_componente FROM cu_componentes_cursos WHERE semestre = 3 AND cod_curso = '$cod_curso' LIMIT 1) LIMIT 1";
    return $this->db->table_query($sql);
  }
  
  function getCodComponente($cod_curso){
    $sql = "SELECT codigo FROM a_componentes WHERE codigo = (SELECT cod_componente FROM cu_componentes_cursos WHERE semestre = 3 AND cod_curso = '$cod_curso' LIMIT 1) LIMIT 1";
    return $this->db->fetchOne($sql);
  }
  
  
}
?>
