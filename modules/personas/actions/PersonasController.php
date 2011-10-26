<?php

  /**
   * Clase PersonasController extendida de Controller
   */
  class PersonasController extends Controller {

	/**
	 * Constructor de la Clase PersonasController
	 */
    function __construct() {
      parent::__construct();
      $this->includeModel('TEstudiante');
      $this->vista->setTitle('Usuarios');
    }

    /**
	 * Muestra informacion de un estudiante, con informacion mas detallada para los administradores del sistema
	 */
    function view() {
      if (!is_blank($this->params['cedula'])){
        
				$cedula = trim($this->params['cedula']);
        
        //echo $cedula;
        
				$persona = TPersona::first(array('conditions' => array('cedula' => $cedula)));
				if($persona != null){

				$persona['nombre_estado'] = TEstado::nombre($persona['cod_estado']);
				
					if($persona['cod_tipo_per'] == COD_TIPO_ESTUDIANTE){
						$cod_curso = TEstudiante::curso($cedula, null,'cod_grupo');
						$persona['nombre_ciudad_nacimiento'] = TCiudad::nombre($persona['cod_lugar_nacimiento']);
						$persona['nombre_estado_civil'] = TEstadoCivil::nombre($persona['cod_estado_civil']);
						
						$persona['nombre_discapacidad'] = TDiscapacidad::nombre($persona['cod_discapacidad']);
						$persona['nombre_etnia'] = TEtnia::nombre($persona['cod_etnia']);
						$persona['nombre_ciudad'] = TCiudad::nombre($persona['cod_ciudad']);
						$persona['nombre_barrio'] = TBarrio::nombre($persona['cod_barrio']);
						$persona['edad'] = TPersona::calcularEdad($persona['fecha_nacimiento']);
						$persona['enEmbarazo'] = TPersona::enEmbarazo($cedula);
						$persona['colegio'] = TEstudiante::colegio($cedula);
						
						
            $this->vista->set('cod_curso', $cod_curso);
					
            
						if($this->AppUser->isAdmin()){
							$persona['cod_ciudad_desplazado'] = TPersona::cod_ciudad_desplazado($cedula);
							$persona['nombre_ciudad_desplazado'] = TCiudad::nombre($persona['cod_ciudad_desplazado']);

							$this->vista->set('causas_bloqueo', TEstudiante::causas_bloqueo());
							$this->vista->set('ciudades', TCiudad::toSQL());
              
							if(!is_null($cod_curso)){
								$this->vista->set('cod_curso', $cod_curso);
								
								$this->vista->set('cursos', TEstudiante::cursosACambiar($cedula));
							}
             
              $auth_admins = array("MARY GARCIA"=>"MARY GARCIA", "JOSE LUIS RENDON"=>"JOSE LUIS RENDON");
              $this->vista->set("auth_admins", $auth_admins);
						}
					} // fin IF COD_TIPO_ESTUDIANTE
					if(is_user_login(COD_TIPO_DIGITA_ICFES) && $persona['cod_tipo_per'] == COD_TIPO_DIGITA_ICFES){
						$cod_prueba_actual = Config::Get('App','I.COD_CUESTIONARIO_ACTUAL');
						$this->vista->set("cod_prueba", $cod_prueba_actual);
					}
				}
				$this->vista->set('persona', $persona);
			}
      $this->vista->display();
    }


    /**
	 *
	 */
	function find(){
		$this->vista->addJS('jquery.dataTable');
		$this->vista->addCSS('dataTable');
		$this->vista->display();
	}

    /**
	 * Prepara la informacion
	 */
	function _prepareForm(){
		$this->vista->addJS('jquery.ui.datepicker');
		$nullOption = array(""=>"-") ;
		$this->vista->set('tipos_personas', (is_root_login())?TTipoPersona::all():TTipoPersona::usuarios());
		$this->vista->set('tipos_cedulas', TTipoCedula::toArray());
		$this->vista->set('estados_civiles',TEstadoCivil::toArray());
		$this->vista->set('discapacidades', TDiscapacidad::toArray());
		$this->vista->set('estratos', $nullOption  + range_assoc(1,3));
		$this->vista->set('etnias', TEtnia::toArray());
	}

  /**
	 * Permite registrar un nuevo usuario
	 */
	function add() {
		if(!is_admin_login())
			return $this->vista->acceso_restringido();
		$this->vista->addJS("jquery.ui.autocomplete");
		$this->vista->setTitle("Personas - Editar");
		
		if(is_array($this->params['persona'])){
			$created = TPersona::create($this->params['persona']);
			unset($_POST['persona']);
			$this->vista->set('message', $created ? "REGISTRO EXITOSO" : "EL NUEVO USUARIO NO PUDO CREARSE. LA CÉDULA YA EXISTE EN EL SISTEMA");
		}
		$this->_prepareForm();
		$this->vista->display();
	}

    /**
	 * Permite actualizar la informacion de un estudiante
	 */
	function edit(){
		if(!is_admin_login())
			return $this->vista->acceso_restringido();

		if(is_array($this->params['persona'])){
			TPersona::update($this->params['persona']);      
			return redirect_to('personas', 'view', array('cedula'=>$this->params['persona']['cedula']));
		}else{      
			$this->_prepareForm();
			$persona = TPersona::get($this->params['cedula']);      
			$persona['enEmbarazo'] = TPersona::enEmbarazo($this->params['cedula']);
      $persona['updated_by']= TPersona::cod_interno($this->params['updated_by']);      
			$this->vista->set('persona', $persona);
			$this->vista->display('add');
		}
	}

    /**
	 * Permite buscar un estudiante por apellido
	 */
	function buscarPorApellido(){
		if(!is_blank($this->params['q'])){
			
			$cod_programa = upper($this->params['cod_programa']);
      if(is_user_login(COD_TIPO_VISITANTE_1))
          $cod_programa = '001';
			elseif($cod_programa != NULL && $cod_programa != 'ALL'){
				if($cod_programa == 'CURRENT'){
					$this->includeModel('TPrograma');
					$cod_programa = TPrograma::actual();
				}
			}
      $this->params['cod_programa'] = $cod_programa;
			$personas = TPersona::buscarPorApellido($this->params['q'], $this->params);            
			$this->vista->set('personas', $personas);
			$this->vista->display();
		}
	}

    /**
	 * Permite cambiar la contraseña a un estudiante
	 */
	function edit_passwd($params){
		if($params['cedula']&&$params['passwd']['new']){
			$cedula = $this->params['cedula'];
			$passwd = TPersona::passwd($cedula);
			if(!is_admin_login() && (is_blank($passwd)|| $passwd != md5($params['passwd']['old']))){
				echo "Contrase&ntilde;a Incorrecta";
			}else{
				if(TPersona::update_passwd($cedula, $params['passwd']['new'], is_admin_login()))
					echo "Contrase&ntilde;a Actualizada";
				else
					echo "Error al actualizar Contrase&ntilde;a";
			}
		}
	}

	/**
	 * Permite editar la ciudad de desplazamiento de un estudiante
	 */
	function editDesplazamiento(){
		if($this->params['cod_interno'])
			TPersona::setCiudadDesplazado($this->params['cod_interno'], $this->params['desplazamiento']['cod_ciudad']);
	}
 }

?>
