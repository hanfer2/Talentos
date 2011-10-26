<?php 

 
class Auditoria extends TBase{
  
  function __construct(){
    parent::__construct();
    $this->tablename = "t_reporte_cambios";
  }
  
   
  function cambios_estudiante($cedula, $cod_programa, $cambio){
    
    
    $tabla_cambio = " ";    
    switch ($cambio) {
        case "ESTADO":
            $tabla_cambio = "a_estados";
            break;
        case "ROL":
            $tabla_cambio = "p_tipos_personas";
            break;        
    }
     
    $sql = " SELECT t.fecha, t.cambio, e.fullname, p.fullname as realizado_por, e.cedula ";
    
    if($cambio!="DOC. ID" && $cambio!=""){
    $sql = $sql . " ,c1.nombre as estado_previo, c2.nombre as estado_nuevo ";
    }else{
    $sql = $sql . " ,t.estado_previo, t.estado_nuevo ";
    }
    
    $sql = $sql . " FROM t_reporte_cambios t ".
                  " JOIN v_estudiantes_programas e ON e.cod_interno = t.codigo ".
                  " JOIN a_persona p ON p.cod_interno = t.realizado_por ";
    
    if($cambio!="DOC. ID" && $cambio!=""){
    $sql = $sql . " JOIN $tabla_cambio c1 ON c1.codigo = t.estado_previo ".
                  " JOIN $tabla_cambio c2 ON c2.codigo = t.estado_nuevo ";  
    }   
    
    if($cedula!=null){
    $sql = $sql . " AND e.cedula='$cedula' ";
    }
    else{
    $sql = $sql . " AND e.cod_programa='$cod_programa' ";  
    }
    if($cambio!="")
    $sql = $sql . "AND cambio='$cambio' ";
              
    return $this->db->table_query($sql);   
       
  }
  
   
  
}
?>
