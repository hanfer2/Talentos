<?php
 
  class AsignaCurso{

    function AsignaCurso($cod_programa){
			if(is_blank($cod_programa))
				trigger_error("ArgumentError: EL CODIGO DEL PROGRAMA NO PUEDE SER NULO", E_USER_ERROR);
        
      $this->db = &DB::instance();
      $this->cod_programa = $cod_programa;
      $this->leerDatos();
    }

    function leerDatos(){
      $sql = "SELECT cod_interno FROM a_persona WHERE cod_estado = '".COD_ESTADO_ADMITIDO."'";
      $this->__data = $this->db->aquery($sql);
    }
    
    function asignar_cursos(){
      if($this->__data == null){
        trigger_error('No se han cargado estudiantes para asignar cursos', E_USER_ERROR);
        return false;
      }
      
      foreach($this->__data as $cod_interno){
        $cod_curso = $this->db->fetchOne("SELECT codigo FROM a_grupos WHERE cod_programa = '{$this->cod_programa}' AND cupos > 0 ORDER BY codigo ASC LIMIT 1");
        if($cod_curso == null){
          trigger_error("No se hallaron cursos con cupos para este", E_USER_ERROR);
          return false;
        }
        $this->db->query(" INSERT INTO a_estudiantes_grupos(\"cod_interno\", \"cod_grupo\") VALUES('$cod_interno', '$cod_curso')");
        $this->db->query(" UPDATE a_grupos SET cupos = cupos - 1 WHERE codigo = '$cod_curso'");
		$this->db->query(" UPDATE a_persona SET cod_estado = ".COD_ESTADO_ACTIVO." WHERE cod_interno = '$cod_interno'");
		echo "-INSERTADO<br/>";
      }
    }

 }
?>
