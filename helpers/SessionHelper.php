<?php
  function is_user_login($user=null) {
		$role = role_user_logged();
    if(is_null($user))
      return !is_blank($role);
    return $user == $role;
  }

  function is_bg_user(){
      return user_logged_info('bg_user') != null;
  }
  
  function is_monitor_login() {
		return is_user_login(COD_TIPO_MONITOR);
  }

	function is_super_admin_login(){
		return is_login(COD_TIPO_ROOT, COD_TIPO_ADMIN);
	}
	
  function is_admin_login() {
		return  is_login(COD_TIPO_ROOT, COD_TIPO_ADMIN, COD_TIPO_MONITOR);
  }

  function is_student_login() {
    return is_user_login(COD_TIPO_ESTUDIANTE);
  }

  function is_professor_login() {
    return is_user_login(COD_TIPO_DOCENTE);
  }

	function is_coordinator_login(){
		return is_user_login(COD_TIPO_COORDINADOR);
	}

	function is_root_login() {
    return is_user_login(COD_TIPO_ROOT);
  }

  function is_login() {
    $args = null;
    if(is_array(func_get_arg(0)))
      $args = func_get_arg(0);
    else
      $args = func_get_args();
    foreach($args as $user )
      if(is_user_login($user))
        return true;
    return false;
  }
	
	function user_logged_info($field){
		
		return $_SESSION[SESSION_PARENT_VAR][$field];
	}

	function role_user_logged(){
		return user_logged_info('cod_tipo_persona');
	}

	function acceso_restringido(){
	 redirect_to('sesion', 'acceso_restringido');
	}
	
	function is_logged_cedula(){
		$logged_cedula = user_logged_info('cedula');
		
		$args = null;
		if(is_array(func_get_arg(0)))
			$args = func_get_arg(0);
		else
			$args = func_get_args();
		return in_array($logged_cedula, $args);
	}
	 
	function canViewStudent($cedula){
   AppLoader::load_model('TDocente');
		$role = role_user_logged();
		switch($role){
			case COD_TIPO_ROOT:
			case COD_TIPO_ADMIN:
			case COD_TIPO_COORDINADOR:
			case COD_TIPO_MONITOR:
			case COD_TIPO_DOCENTE:
				return true;
			case COD_TIPO_ESTUDIANTE:
				return $_SESSION['user']['cedula'] == $cedula;
			default: 
				return false;
		}
	}
	
	function is_path_for_unlogged($controller, $action){
		if($controller != 'sesion'){
			
			return false;
		}
		if($action != 'login')
			return false;
		return true;
	}
?>
