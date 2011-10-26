<?php
	if(!is_root_login ())
		return acceso_restringido ();


	/**
     * Clase TestController extendida de Controller
     */
	class TestController extends Controller {

	    /**
		 *
		 */
		function cargarIcfes(){
			$this->includeModel('TIcfes');

			$cod_programa = '002';
			$tipoIcfes = 6;
			$filename = "../Tests/icfes.csv";
			$estudiantes = CSV::load($filename);
			$keys = array('cod_estud','num_registro_icfes','biologia','matematica',
										'filosofia','fisica','historia','quimica','lenguaje','geografia',
										'idioma','interdisciplinar','sociales');

			//TIcfes::__load($filename, $keys, $tipoIcfes, $cod_programa);// DESCOMENTAR PARA CARGAR ARCHIVO
		}

		/**
		 *
		 */
		function cargarColegios(){
			$this->includeModel('TColegio');
			$keys = array('cod_estud','cod_colegio','fecha_finalizacion');
			TColegio::__cargarColegiosEstudiantes('../Tests/colegios.csv', $keys);
		}

		/**
		 *
		 */
		function cargarEstudiantes(){
			$filename = "../Tests/llamado3.csv";
			$maxCodInterno = 3248;
			$keys = array('cod_estud','apellidos', 'nombres', 'cod_tipo_ced','cedula','cod_expedida',
										'direccion','telefono','cod_ciudad','tel_celular', 'email_2', 'cod_estado_civil','genero');
			$file = CSV::load($filename, ';');
			foreach($file as $row){
				$estudiante = array_combine($keys, $row);
				$estudiante['cod_interno'] = ++$maxCodInterno;
				$estudiante['cod_tipo_per'] = 2;
				$sql = sql_insert_from_array(Config::get('TPersona'), $estudiante);
				echo $sql ."<br>";
			}
		}
		
		
		function genera_puntajes(){
			require_once CARPETA_MODELOS_EXTRAS . "IRespuestas.php";
			echo html_link_to("Inicio", url_for('sesion',"index"))."<br/>";
			$o = new GeneraPuntaje(8);
		}
		
		function ln(){
			$this->includeModel('EstudianteNotificacion');
			$this->Notificaciones = new EstudianteNotificacion();
			
			$cod_interno = array('cod_interno'=>user_logged_info('cod_interno'));
			
			//almacenara las notificaciones asignadas al usuario.
			$notificaciones = $this->Notificaciones->activas($cod_interno);
			//Comprobar si se adiciona una notificacion por Inasistencia;
			if(role_user_logged() == COD_TIPO_ESTUDIANTE){
				$MIN_INASISTENCIAS = Config::Get('App','CU.MIN_INASISTENCIAS_TO_ALERT');
				$inasistencias = $this->Notificaciones->por_inasistencia($cod_interno);
				if($inasistencias >= $MIN_INASISTENCIAS)
					array_unshift($notificaciones, "Usted presenta actualmente <strong>$inasistencias</strong> inasistencias injustificadas");
			}
			$this->vista->set('notificaciones', $notificaciones);
      $this->vista->display('');
		}


		/**
		 *
		 */
		function info(){
			phpinfo();
		}
}
?>
