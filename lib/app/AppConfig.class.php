<?php
	
	class AppConfig{
		
		var $settings;
		function AppConfig(){
			$this->db = DB::instance();
			$this->tablename = 'sys_configuraciones';
      $this->filename = 'settings';
      
      $this->__load();
		}
		
    function __load(){
      $this->settings = parse_ini_file(sprintf("%s%s.ini",AppConst::get("siat_configs_dir"), $this->filename));
    }
    
		function instance(){
			static $AppConfig = null;
			if ($AppConfig === null)
				$AppConfig = new AppConfig();
			return $AppConfig;
		}
		
		
		function get($nombre){
      $v = $this->settings[lower($nombre)];
      if($v !== null)
        return $v;
			$nombre = q($nombre);
			$sql = "SELECT valor FROM ".$this->tablename. " WHERE '$nombre' = upper(nombre)";
			return $this->db->fetchOne($sql);
		}
		
		function set($nombre, $valor){
			$valor = q($valor);
			$nombre = q($nombre);
			$sql = "UPDATE ".$this->tablename;
			if($valor === FALSE)
				$sql .=" SET valor = FALSE ";
			else if($valor === TRUE)
				$sql .=" SET valor = TRUE ";
			else if($valor == null)
				$sql .=" SET valor = NULL ";
			else
			 $sql .=" SET valor = '$valor' ";
			$sql =" WHERE upper(nombre) = '$nombre'";
			return $this->db->fetchOne($sql);
		}
	}

?>
