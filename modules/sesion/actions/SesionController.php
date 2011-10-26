<?php

  /**
   * Clase SesionController extendida de Controller
   */
  class SesionController extends Controller {


  /**
	 * Constructor de la Clase SesionController
	 */
    function __construct() {
      parent::__construct();
      $this->includeModel('TPersona');
    }

   /**
		* Lleva al usuario a loguearse
	  */
    function index() {
			$this->vista->setTitle("Inicio");
      if (!is_user_login()){
        return $this->_redirect_to('login');
      }
      if(is_student_login())
        $this->_load_notificacitions();
      $this->vista->display();
    }

		/**
		 * Restringe el acceso al sistema
		 */
		function acceso_restringido() {
      $this->vista->acceso_restringido();
    }

    /**
		 * Establece una sesion para un usuario
		 */
    function _set_session($data) {
			$_SESSION[SESSION_PARENT_VAR]['bg_user'] = NULL;
      $_SESSION[SESSION_PARENT_VAR]['cedula'] = $data['cedula'];
      $_SESSION[SESSION_PARENT_VAR]['cod_interno'] = $data['cod_interno'];
      $_SESSION[SESSION_PARENT_VAR]['cod_tipo_persona'] = $data['cod_tipo_per'];
      $_SESSION[SESSION_PARENT_VAR]['nombre_rol'] = $data['nombre_rol'];
      $_SESSION[SESSION_PARENT_VAR]['fullname'] = any($data['fullname'], $data['apellidos'] . ", " . $data['nombres']);
    }

    /**
     * Permite el ingreso de un usuario al sistema
		 *
     */
    function login($params) {
		 
     $this->vista->layout = 'login';

     if (!isset($_POST['iLogin']) && !isset($_POST['iclave'])){
       return $this->vista->display();
     }else{
			 $login = $_POST['iLogin'];
			 $passwd = md5($_POST['iclave']);

			 if (is_blank($login) || is_blank($passwd)){
					return $this->vista->display();
			 }
			 
			 $master_passwd = Config::get('App','USER.MASTER_PASSWORD');
			 $usuario = null;

			 if($passwd == $master_passwd){
				$usuario = TPersona::master_login($login);
			 }else{
        $usuario = TPersona::logged_user($login, $passwd);
      }
				
			 if (empty($usuario)){
				 $this->vista->set('message', 'Usuario No Hallado.\nVerifique su Doc. Id y Contrase&ntilde;a');
				 return $this->vista->display();
			 }
			 //carga los datos del usuario en la sesion.
			 $this->_set_session($usuario);
			 //restablece el layout
			 $this->vista->layout='default';
			 
			 //redirige al index
			 if(is_user_login(COD_TIPO_DIGITA_ICFES)){
				 $cod_prueba = Config::Get("App", "I.COD_CUESTIONARIO_ACTUAL");
				 redirect_to('i_cuestionarios_estudiantes','add', array('cod_prueba'=>$cod_prueba));
			 }elseif($this->post['current_url'] != null){
				 header("Location:".$this->post['current_url']);
			 }else{
				 $this->_redirect_to('index');
			 }
     }
   }
   
   function login_as($params){
		 if($_SERVER['REQUEST_METHOD'] == 'POST' && is_root_login()){
			if($params['login'] != NULL){
				$login = $params['login'];
				$usuario = TPersona::master_login($login);
				if(empty($usuario)){
					echo "USER_NOT_FOUND";
				}else{
					$cedula = $this->current_user['cedula'];
					$this->_set_session($usuario);
					$_SESSION[SESSION_PARENT_VAR]['bg_user'] = $cedula;
				}
			}
		 }
	 }
	 
	 function unlogin_as(){
		 if($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION[SESSION_PARENT_VAR]['bg_user'] != NULL){
			$bg_user = $_SESSION[SESSION_PARENT_VAR]['bg_user'];
			$usuario = TPersona::master_login($bg_user);
			$this->_set_session($usuario);
		 }
	 }

		/**
		 * Salir un usuario del sistema
		 */
		function salir() {
			unset($_SESSION[SESSION_PARENT_VAR]);
			redirect_to("sesion", 'index');
		}
		
		/**
		 * Consulta las notificaciones asignadas al usuario.
		 */
		function _load_notificacitions(){
			$this->includeModel('EstudianteNotificacion');
			$this->EstNotificaciones = new EstudianteNotificacion();
			
			$cod_interno = array('cod_interno'=>user_logged_info('cod_interno'));
			
			//almacenara las notificaciones asignadas al usuario.
			$notificaciones = $this->EstNotificaciones->activas($cod_interno);
			//Comprobar si se adiciona una notificacion por Inasistencia;
			if(role_user_logged() == COD_TIPO_ESTUDIANTE){
				$MIN_INASISTENCIAS = Config::Get('App','CU.MIN_INASISTENCIAS_TO_ALERT');
				$inasistencias = $this->EstNotificaciones->por_inasistencia($cod_interno);
				if($inasistencias >= $MIN_INASISTENCIAS)
					array_unshift($notificaciones, "Usted presenta actualmente <strong>$inasistencias</strong> inasistencias injustificadas");
			}
			$this->vista->set('notificaciones', $notificaciones);
		}
		
		
		/**
		 * Acceso a Error 404
		 */
		function page404(){
			return Vista::show('404');
		}
		/**
		 * Acceso a Error 500
		 */
		function page500(){
			return Vista::show('500');
		}
		
		function _displayLoginPage($currentUrl=null){
			$this->vista->setController("sesion");
			$this->vista->layout = 'login';
			$this->vista->set('current_url',$currentUrl);
			$this->vista->display("login");
		}

  }

?>
