<?php 
	/**
	 * NOMECLATURA DE LOS USUARIOS:
	 * Si es numero, representa la cedula
	 * Si es string, representa el rol.
	 * 
	 */
	class Auth{
		
		public Auth(){
			
		}
		function has_permission($user, $nomeclatura){
			$sql = "SELECT permiso FROM ".Config::Get('Sys', __CLASS__)." WHERE user='$user' AND nomeclatura ='$nomenclatura'";
			return DB::boolQuery($sql);
		}
		
		function is_allowed_to($user, $nomenclatura){
			return Auth::has_permission($user, $nomenclatura);
		}
		
		function is_restricted_to($user, $nomenclatura){
			return ! Auth::has_permission($user, $nomenclatura);
		}
		
	}
?>
