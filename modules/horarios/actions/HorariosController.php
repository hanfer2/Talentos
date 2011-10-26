<?php
    /**
     * Clase HorariosController extendida de Controller
     */
	class HorariosController extends Controller {

		/**
	     * Constructor de la Clase HorariosController
	     */
		function __construct() {
			parent::__construct();
			$this->includeModel('TEstudiante', 'TPrograma');
      $this->TSubgrupo = new TSubgrupo();
			$this->vista->setTitle('Horarios');
		}

        /**
		 * Muestra el calendario
		 */
		function index() {
			$this->vista->addJS("jquery.fullcalendar","datejs");
			$this->vista->addCSS("jquery.fullcalendar");
			$this->vista->display();
		}

    /**
		 * Muestra el calendario para el curso especificado, con componente, docente y sede
		 */
		function edit($params, $request){
        $this->includeModel('CursoEspecial');
        $this->CursoEspecial = new CursoEspecial();

			 $this->vista->addJS("jquery.fullcalendar","datejs","jquery.ui.datepicker");
			 $this->vista->addCSS("jquery.fullcalendar");
			 
			 if(!$request->hasParam('horarios')){
				if($request->hasParam('cod_curso')){

				$cod_curso = $request->getParam('cod_curso') ;
				$cod_programa = $request->getParam('cod_programa',TSubgrupo::programa($cod_curso));
        
        $is_curso_especial = $this->TSubgrupo->esEspecial($cod_curso);
        

        $this->vista->set('is_curso_especial', $is_curso_especial);
				

				$this->includeModel('TComponente', 'TDocente', 'TSede');

				$horario = TSubgrupo::esquemaHorario($cod_curso);
        
        $semestre = $request->getParam('semestre');
        
        if($is_curso_especial){
          $componentes = $this->CursoEspecial->getComponente($cod_curso);
          $semestre = 3;
          $this->vista->set('semestre',$semestre);
        }else{
          $componentes = TPrograma::componentes($cod_programa, $semestre);
				}
        
				$fechas = TPrograma::fechas($cod_programa, $semestre);
				$sedes  = TSede::all();
				$docentes = TDocente::all(array('select'=>'cod_interno, fullname'));

				$sedes[''] = '-';
				$docentes[''] = "-";
				
				$periodicidades = array('1'=>'SEMANAL','2'=>'QUINCENAL','0'=>'UNICA');
				
				//Cargamos las variables en el formulario
				$this->vista->set('componentes', $componentes);
				$this->vista->set('sedes', $sedes);
				//$this->vista->set('dias_semana', $dias_semanas);
				$this->vista->set('docentes', $docentes);
				$this->vista->set('horarios', $horario);
				$this->vista->set('periodicidades', $periodicidades);
				$this->vista->set('fechas', $fechas);
			 }
			 $this->vista->display();
     }
		 }



		/**
		 * Este método lee un arreglo de configuracion del horario para cada componente de cada curso.
		 * Este arreglo $data se compone de los grupos del PNAT.
		 * Cada grupo almacena dos subarreglos de configuracion, los cuales son:
		 * 	- general: La configuracion que es comun a todos los cursos de un grupo en cada componente.
		 * 							Ej: dia, hora_inicio, hora_fin, fecha_inicio, fecha_fin
		 * 	- cursos: Lista cada curso del grupo con su respectiva configuracion,
		 * 						que es particular para cada curso en cada componente.
		 */

		function view() {
			$this->vista->addJS("datejs");
			$this->vista->addJS("jquery.fullcalendar");
			$this->vista->addCSS("jquery.fullcalendar");

			if (!is_blank($this->params['cedula'])) {
				$this->vista->set('cod_curso', TEstudiante::curso($this->params['cedula'], null, 'cod_grupo'));
				if (is_xhr ()) {
					$cedula = $this->params['cedula'];
					$cod_tipo_per = TPersona::get($cedula, 'cod_tipo_per');
					$horario = null;

					switch ($cod_tipo_per) {
						case COD_TIPO_ESTUDIANTE:
							$horario = TEstudiante::clases($cedula);
							break;
						case COD_TIPO_DOCENTE:
							$this->includeModel('TDocente');
							$horario = TDocente::horario($cedula);
							break;
					}
					echo JSON::encode($horario);
				}
				else
					$this->vista->display();
			}elseif (!is_blank($this->params['cod_curso'])) {
				if (isset($this->params['load'])) {
					$this->horarios();
				} else {
					$this->vista->display();
				}
			}
		}

		/**
		 * Muestra horarios con asistencias segun el curso especificado
		 */
		function horarios(){
			if(isset($this->params['cod_curso'])){
				$this->includeModel("TGrupo");
				$horarios = TSubgrupo::horario($this->params['cod_curso'], $this->params['semestre']);
				$cursosConAsistencias = TSubgrupo::clasesConAsistencias($this->params['cod_curso']);
				for($i = 0; $i < count($horarios) ; $i++){
					$horarios[$i]['asistencia'] = in_array($horarios[$i]['cod_clase'], (array)$cursosConAsistencias);
				}
				echo JSON::encode($horarios);
			}
		}

		function add($params){
			$this->includeModel('THorario','TClase');
			THorario::save($params['horario']);
			TClase::add($params['horario']['codigo'], $params['clases']);
		}
		
		function delete($params){

			$this->includeModel('TClase');
			
			if(isset($params['cod_clase'])){
				TClase::remove($params['cod_clase']);
			}elseif(isset($params['cod_horario'])){
				TClase::removeByHorario($params['cod_horario']);
			}
		}
		
		function update($params){
				
			$this->includeModel('THorario','TClase');
			if(isset($params['clases'])){
				TClase::update($params['clases']);
			}
			THorario::save($params['horario']);
		}
   
    
	}
  
  

?>
