<?php
	/**
     * Clase AsistenciasController extendida de Controller
     */
	class AsistenciasController extends Controller{

		/**
		 * Constructor de la Clase AsistenciasController
		 */
		function __construct() {
			parent::__construct();
			$this->includeModel('TComponente','TClase', 'TEstudiante');
      
      $this->TSubgrupo = new TSubgrupo();
			$this->vista->setTitle('Asistencias');
		}

		/**
		 * Muestra las clases y su asistencia, segun curso y componenete especifico
		 */
		function clases($params, $request){
			if($request->hasParam('cod_curso')){
        $cod_curso = $request->getParam('cod_curso');
        $is_curso_especial = $this->TSubgrupo->esEspecial($cod_curso);
        if($is_curso_especial){
          $this->includeModel('CursoEspecial');
          $cod_componente = $this->CursoEspecial->getCodComponente($cod_curso);
          $this->vista->set('cod_componente', $cod_componente);
        }else{
          $cod_componente = $request->getParam('cod_componente');
        }
				$clases = TSubgrupo::clases($cod_curso, $cod_componente, array('maxDate'=>date('Y-m-d')));
				$this->vista->set('clases', $clases);
				$this->vista->set('clasesRegistradas', TSubgrupo::clasesConAsistencias($cod_curso, $cod_componente));
			}
			$this->vista->display();
		}

		/**
		 * Listado de inasistencias
		 *
		 * Muestra el listado de inasistencias de un estudiante
		 */
		function view(){
			$this->vista->setTitle('Asistencia - Listado de Inasistencias');
			$this->vista->addJS('jquery.dataTable');
			if(isset($this->params['cedula'])){
				if(!canViewStudent($this->params['cedula']))
					return $this->vista->acceso_restringido();
				$inasistencias = TAsistencia::inasistencias(array('cedula'=>$this->params['cedula']));
				//$totalInasistencias = TClase::totalPorComponente(TEstudiante::curso($this->params['cedula'],null,'cod_grupo'));
				$this->vista->set('curso',TEstudiante::curso($this->params['cedula']));
				$this->vista->set('motivos', TMotivoInasistencia::motivos());
				$this->vista->set('nClasesReportadas', TAsistencia::clases($this->params['cedula'], array('operation'=>'count')));#Numero de clases reportadas
				$this->vista->set('inasistencias', $inasistencias);
				$this->vista->set('status', TEstado::nombre(TEstudiante::estado($this->params['cedula'])));
			}
			$this->vista->display();
		}

			/**
			 * Listado de inasistencias
			 *
			 * Muestra el listado de inasistencias por programa o por curso
			 */
		function general($params){
			if(!is_admin_login() && !is_coordinator_login())
				$this->vista->acceso_restringido();
			$this->vista->addJS('jquery.dataTable');
			$conditions = null;
			if(!is_blank($params['cod_programa'])){
				$conditions = array('cod_programa'=>$params['cod_programa']);
			}
      if(!is_blank($params['cod_curso'])){
				$conditions = array('cod_curso'=>$params['cod_curso']);				
			}
			if(!is_null($conditions)){
				$this->vista->set('inasistencias', TAsistencia::inasistencias($conditions));
				$this->vista->set('clasesAsistidas', TAsistencia::nClasesAsistidas($conditions));
				$this->vista->set('motivos', TMotivoInasistencia::motivosAgrupadosPorValidez());
			}
			$this->vista->display();

		}
/*funcion lista los grupos con su inasistencia A,B,C,D..*/
 function index(){
      
			if(!(is_admin_login() || is_coordinator_login()))
				return $this->vista->acceso_restringido();
     $grupo = TAsistencia::all2('003'); 
      $this->vista->addJS('jquery.dataTable','jquery.ui.datepicker');
      $this->vista->set('grupo',$grupo);
      $this->vista->display();
    }
    
    
    /*funcion que listara los subgrupos A-01...D-11 segun el grupo que se escoja en el index*/
     function indexCursos($grupo){
       
       $g=$grupo;
     //print_r ($g);
      
			if(!(is_admin_login() || is_coordinator_login()))
				return $this->vista->acceso_restringido();
     $grupo = TAsistencia::allSubgruposDeUnGrupo($grupo['grupo']); 
      $this->vista->addJS('jquery.dataTable','jquery.ui.datepicker');
      $this->vista->set('grupo',$grupo);
       $this->vista->set('g',$g);
      $this->vista->display();
    }

  function componentes( $cod_programa ){
       
     // echo hola;
			if(!(is_admin_login() || is_coordinator_login()))
				return $this->vista->acceso_restringido();
     $componentes = TAsistencia::allComponentes($cod_programa);
     //$NOJusti=TAsistencia::allMotivoNoJustificadas('0');
     //$justificadas=TAsistencia::alljsutificadas();
     //$nojustificadas=TAsistencia::alljsutificadas();
     $cod_curso = null;
    // print_r ($NOJusti);
      $this->vista->addJS('jquery.dataTable','jquery.ui.datepicker');
      $this->vista->set('componentes',$componentes);
      $this->vista->set('cod_programa',$cod_programa);
            $this->vista->set('cod_curso',$cod_curso);
   /*   $this->vista->set('justificadas',$justificadas);
       $this->vista->set('nojustificadas',$nojustificadas);*/
      $this->vista->display();
    }

function claseporcomponente($nombreComponente){
  
  //print_r ($nombreComponente);
  $nombre=TAsistencia::nombre($nombreComponente['nombrecomponente']);
  $cursoxcomponente =TAsistencia::cursoPorComponenteAsistencia($nombreComponente['nombrecomponente']);
  $this->vista->set('nombre',$nombre);
  $this->vista->set('cursoxcomponente',$cursoxcomponente);
  $this->vista->display();
  
}


		/**
		 * Registro de asistencias
		 *
		 * Permite registrar la asistencia de un estudiante de un grupo en una clase especifica
		 */
		function registrar(){
			$this->vista->setTitle("Asistencia - Registrar");
			$this->vista->addJS('jquery.dataTable');
      			//echo "cod_clase= ".$this->params['cod_clase']."/n";
			//echo "cod_curso= ".$this->params['cod_curso']."/n";
			//echo "cod_componente= ".TClase::cod_componente($this->params['cod_clase'])."/n";
			
 
			if(isset($this->params['cod_clase'])){
				$cod_curso = $this->params['cod_curso'];

				if($cod_curso == null){
					$cod_curso = TClase::cod_curso($this->params['cod_clase']);
					$cod_componente = TClase::cod_componente($this->params['cod_clase']);
					$this->vista->set('cod_curso', $cod_curso);
					$this->vista->set('cod_componente', $cod_componente);
				}
        if($cod_componente == null){
          $cod_componente = TClase::cod_componente($this->params['cod_clase']);
          $this->vista->set('cod_componente', $cod_componente);
        }
				 $clase = TClase::get($this->params['cod_clase'], '*');
        $oSubgrupo = new TSubgrupo();
				$estudiantes = $oSubgrupo->inscritosActivos($cod_curso, array(" fecha_ingreso <='{$clase['fecha']}' "));
				$asistencias = TAsistencia::porEstudiante($this->params['cod_clase']);
 


				if($clase['updated_by'] != null){
        
					$clase['updated_by'] = TPersona::get(array('cod_interno'=>$clase['updated_by']), "fullname(".Config::get('TPersona').".*)");
           // print_r($clase['updated_by']);
				}

				$this->vista->set('asistencias', $asistencias);
				$this->vista->set('clase', $clase);
				$this->vista->set('estudiantes', $estudiantes);
				$this->vista->set('justificaciones', TMotivoInasistencia::all(array('select'=>'codigo, nombre')));
				$this->vista->set('estudiantesFlotantes', TEstudiante::flotantes());
				if(isset($this->params['u'])){
					$this->vista->set('alert_message',$this->params['u']?"Actualizaci&oacute;on Exitosa":"Actualizaci&oacute;n FALLIDA");
				}
			}
			$this->vista->display();
		}


        /**
         * Registra las asistencias de una clase
         */
		function save(){
      //print_r($clase['updated_by']);
			if(isset($this->params['asistencia'])){
				$asistencia = $this->params['asistencia'];
				 $ok = TClase::registrarAsistencia($this->params['clase'], $this->params['asistencia']);
				 redirect_to ('asistencias', 'registrar', array('cod_clase'=>$this->params['clase']['codigo'],'u'=>$ok));
			}
		}

        /**
         * Muestra el formato de asistencia
         */
		function formatos(){
			$this->vista->setTitle('Formatos de Asistencia');
			if(isset($this->params['cod_curso'])){
				$sql = "SELECT cedula, apellidos, nombres, nombre_grupo ".
							" FROM ".Config::get('TEstudiante','TGrupo') .
							" INNER JOIN ".Config::Get('TPersona') . " p USING (cod_interno, cedula)".
							" WHERE p.cod_estado = ".COD_ESTADO_ACTIVO . " AND ";
				if($this->params['cod_curso'] == '0')
					$sql .= "cod_programa = '{$this->params['cod_programa']}'";
				else
					$sql .= "cod_grupo = '{$this->params['cod_curso']}'";
				$cursos = DB::table_query($sql, 'nombre_grupo');
				$this->vista->set('cursos', $cursos);
			}
			$this->vista->display();
		}
	}
?>
