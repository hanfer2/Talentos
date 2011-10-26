<?php

	class Notificacion extends TBase{
    
    function __construct(){
      parent::__construct();
      $this->tablename = $this->Config->get(__CLASS__);
    }
		
		function max(){
			$sql = "SELECT COALESCE(max(codigo), 0) AS max FROM ".Config::Get(__CLASS__);
			return $this->db->query($sql);
		}
    		
		function add($notificacion){
			$max = $this->max();
			if($max === FALSE)
				return FALSE;
			$data = subarray($notificacion, 'mensaje','fecha_inicio','fecha_fin');
      if($notificacion['global'] == TRUE)
        $data['global'] = 't';

			$data['codigo'] = $max + 1;
			$sql = sql_insert_from_array($this->tablename, $data);
			$this->db->query($sql);
			if($this->db->errno == DB_NO_ERROR)
        return $data['codigo'];
      else
        return FALSE;
		}
    
    function clean($codigo){
      $codigo = q($codigo);
      $sql = "DELETE FROM ". $this->tablename.
            " WHERE codigo = $codigo AND NOT EXISTS (SELECT * FROM ".$this->Config->Get('EstudianteNotificacion')." WHERE cod_mensaje = '$codigo')".
              "  AND NOT EXISTS (SELECT * FROM ".$this->Config->Get('EstudianteNotificacion','Grupo')." WHERE cod_mensaje = '$codigo')".
              "  AND NOT EXISTS (SELECT * FROM ".$this->Config->Get('EstudianteNotificacion', 'Curso')." WHERE cod_mensaje = '$codigo')";
      $this->db->query($sql);
    }
    
    function delete($codigo)
    {
        $sql = "DELETE FROM {$this->tablename} WHERE codigo = '$codigo'";
        $this->db->query($sql);
        return $this->db->errno == DB_NO_ERROR;
    }

	}
?>
