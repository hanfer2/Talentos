<?php
  class MovimientoEstudiante extends TBase{
    
    function all($cod_programa){
      $Programa = TPrograma::getObject($cod_programa);
      $sql = "SELECT * FROM t_movim_estudiantes WHERE fecha BETWEEN '{$Programa->fecha_inicio_1}' AND '{$Programa->fecha_cierre_2}' ORDER BY fecha ASC";
      return $this->db->table_query($sql);
    }
    
    function buscarIngresosPorFecha($fecha){
      $sql = "SELECT v.cedula, v.fullname, v.nombre_grupo, fullname(b) AS creado_por FROM v_estudiantes_grupos v JOIN a_persona a USING(cod_interno) LEFT JOIN a_persona b ON b.cod_interno = a.created_by  WHERE a.fecha_ingreso = '$fecha'";
      return $this->db->table_query($sql);
    }
    
    function buscarBloqueadosPorFecha($fecha){
      $sql = "SELECT v.cedula, v.fullname, v.nombre_grupo, fullname(b) AS creado_por FROM v_estudiantes_grupos v JOIN a_bloqueados a USING(cod_interno) LEFT JOIN a_persona b ON b.cod_interno = a.updated_by  WHERE a.fecha = '$fecha'";
      return $this->db->table_query($sql);
    }
    
    function buscarPorFecha($fecha){
      $movimientos = array();
      $ingresos = $this->buscarIngresosPorFecha($fecha);
      $movimientos = array_merge((array) $ingresos);
      return $movimientos;
    }
  }
