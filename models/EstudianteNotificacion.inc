<?php

  require_once 'Notificacion.inc';
  require_once 'TEstudiante.inc';
	class EstudianteNotificacion extends TBase{
    
    function __construct(){
      parent::__construct();
      $this->Notificacion = new Notificacion();
      $this->tablename = $this->Config->get(__CLASS__);
    }
    
		function por_cedula($cedula){
			$cod_interno = TPersona::cod_interno($cedula);
			if($cod_interno == null)
				return null;
			$sql = "SELECT * FROM ".Config::Get(__CLASS__,'viewname'). " WHERE cod_interno = '$cod_interno' ORDER BY fecha_inicio DESC, fecha_fin DESC, cod_mensaje DESC";
			return $this->db->table_query($sql);
		}
    
    function por_curso($cod_curso){
      $sql = "SELECT * FROM " . $this->Config->Get('Notificacion') ." t JOIN " . $this->Config->get(__CLASS__, 'Curso') . " ON cod_mensaje = t.codigo WHERE cod_curso = '$cod_curso'";
      return $this->db->table_query($sql);
    }
    
    function por_grupo($grupo){
      $sql = "SELECT * FROM " . $this->Config->Get('Notificacion') ." t JOIN " . $this->Config->get(__CLASS__, 'Grupo') . " ON cod_mensaje = t.codigo WHERE cod_grupo = '$grupo'";
     // echo $sql;
      return $this->db->table_query($sql);
    }
    
    function globales()
    {
      $sql = "SELECT codigo as cod_mensaje, mensaje, fecha_inicio, fecha_fin FROM " . $this->Config->Get('Notificacion') ." WHERE global IS TRUE ORDER BY codigo DESC";
      return $this->db->table_query($sql);
    }
		
		function add($cedula, $notificacion){
      $cod_interno = TPersona::cod_interno($cedula);
      if($cod_interno == null)
        return FALSE;
      $codigo = $this->Notificacion->add($notificacion);
      if($codigo == FALSE)
        return FALSE;

      $data = array('cod_interno'=>$cod_interno, 'cod_mensaje'=>$codigo, 'registrado_por'=>user_logged_info('cod_interno'));
      $sql = sql_insert_from_array($this->tablename, $data);
      $this->db->query($sql);
        
			return $this->db->errno == DB_NO_ERROR;
		}
    
    function agregar_global($notificacion){
      $notificacion['global'] = TRUE;
      $this->Notificacion->add($notificacion);
    }
    
    function agregar_por_grupo($grupo, $notificacion){
      $codigo = $this->Notificacion->add($notificacion);
      if($codigo == FALSE)
        return FALSE;

      $data = array('cod_grupo'=>$grupo, 'cod_mensaje'=>$codigo, 'registrado_por'=>user_logged_info('cod_interno'));
      $sql = sql_insert_from_array($this->Config->get(__CLASS__, 'Grupo'), $data);
      $this->db->query($sql);
        
			return $this->db->errno == DB_NO_ERROR;
		}
		
    function agregar_por_curso($cod_curso, $notificacion){
      $codigo = $this->Notificacion->add($notificacion);
      if($codigo == FALSE)
        return FALSE;

      $data = array('cod_curso'=>$cod_curso, 'cod_mensaje'=>$codigo, 'registrado_por'=>user_logged_info('cod_interno'));
      $sql = sql_insert_from_array($this->Config->get(__CLASS__, 'Curso'), $data);
      $this->db->query($sql);
        
			return $this->db->errno == DB_NO_ERROR;
		}
    
    function delete_global($cod_mensaje)
    {
      $ok = $this->Notificacion->delete($cod_mensaje);
      if($ok)
        return array('status'=>TRUE);
    }
    
    function buscarInterno($param){
      
      $sql = "Select cod_interno from a_persona where cedula = '$param'";
      
     
      
      return $this->db->query($sql);
  }
  
  function deleteNotificacion(){
    
      $sql = "delete cod_interno from a_persona where cedula = '$param'";
      
      $this->db->query($sql);
      
 }
    
		function delete($param, $valor_param, $cod_mensaje){
      if($param == 'cedula'){
        $valor_param = TPersona::cod_interno($valor_param);
       // $param = 'cod_interno';
      }
			if($valor_param == null){
				return array('status'=>FALSE, 'msg'=>'Registro No Hallado');
			}
      
      $class = "";
      switch($param){
        case 'cedula': $class = "tablename"; break;
        case 'cod_curso': $class = "Curso"; break;
        case 'cod_grupo': $class = "Grupo"; break;
        default: return false;
      }
       if ($param == 'cedula') {
        $param='cod_interno';
        }
			$cod_mensaje = q($cod_mensaje);
			$sql = "DELETE FROM ".Config::Get(__CLASS__, $class)." WHERE  $param  = '$valor_param' and cod_mensaje ='$cod_mensaje'";
			$this->db->query($sql);
      $this->Notificacion->clean($cod_mensaje);
			if($this->db->errno == DB_NO_ERROR){
				return array('status'=>TRUE);
			}else{
				return array('status'=>FALSE, 'msg'=>$this->db->error);
			}
		}
		
		function por_inasistencia($cedula){
			$cod_interno = TPersona::cod_interno($cedula);
			$sql = " SELECT COALESCE(SUM(inasistencias), 0) AS inasistencias ".
						 " FROM ".Config::get('TAsistencia','R-Inasistencias').
						 " WHERE cod_interno = '$cod_interno' AND cod_motivo IN (".
						 "   SELECT codigo FROM pe_motivos_inasistencias WHERE valida IS FALSE) ";

			return $this->db->query($sql);
		}
    
    function _activas_por_curso($cod_grupo, $cod_curso){
      if($cod_grupo == null or $cod_curso == null)
        return array();
      $sql = " SELECT mensaje FROM ".$this->Config->Get('Notificacion').
             " WHERE fecha_inicio <= CURRENT_DATE AND (fecha_fin IS NULL OR fecha_fin >= CURRENT_DATE) ".
                " AND codigo IN (SELECT cod_mensaje FROM ".$this->Config->Get(__CLASS__, 'Grupo')." WHERE cod_grupo = '$cod_grupo') ".
                " OR codigo IN (SELECT cod_mensaje FROM ".$this->Config->Get(__CLASS__, 'Curso')." WHERE cod_curso = '$cod_curso') ";

      $rs = $this->db->aquery($sql);
      if($rs == null)
        $rs = array();
      return $rs;
    }
    
    function _activas_globales(){
      $sql = "SELECT mensaje FROM ".$this->Config->Get('Notificacion')." WHERE global IS TRUE AND fecha_inicio <= CURRENT_DATE AND (fecha_fin IS NULL OR fecha_fin >= CURRENT_DATE)";
      $rs = $this->db->aquery($sql);
      if($rs == null)
        $rs = array();
      return $rs;
    }
		
		/**
		 * Retorna las notificaciones vigentes asignadas a un usuario.
		 * Es decir aquellas cuyo rango de fechas incluyen al dia actual.
		 */
		function activas($cedula){
			$cod_interno = TPersona::cod_interno($cedula);
			if($cod_interno == null)
				return FALSE;
			// Notificaciones cuya fecha inicio sea mayor a hoy y fecha fin sea NULA o menor a hoy.
			$sql = "SELECT mensaje FROM ".$this->Config->Get(__CLASS__, 'viewname')." ".
						 "WHERE cod_interno = '$cod_interno' AND".
									" fecha_inicio <= CURRENT_DATE AND ".	
									" (fecha_fin IS NULL OR fecha_fin >= CURRENT_DATE) ".
						 "ORDER BY fecha_inicio DESC, fecha_fin DESC, cod_mensaje DESC";
      
			$notificaciones = $this->db->aquery($sql);
      $grupo = TEstudiante::curso_y_grupo(array('cod_interno'=>$cod_interno));
      $notif_globales = $this->_activas_globales();
      $notif_curs = $this->_activas_por_curso($grupo['grupo'], $grupo['cod_grupo']);
      $notificaciones = array_merge((array)$notificaciones, (array)$notif_curs, (array) $notif_globales);
			if($notificaciones == null)
				return array();
			return $notificaciones;
		}
	}
?>
