<?php
        /**
         * Clase IcfesController extendida de Controller
         */
	class IcfesController extends Controller {

         /**
	  * Constructor de la Clase IcfesController
	  */
	 function __construct() {
		parent::__construct();
		$this->includeModel('TIcfes', 'TEstudianteIcfes');
		$this->vista->setTitle('Icfes');
		$this->vista->addJS('jquery.dataTable');
    
    //EStudianteIcfes es = a Un TEstudianteIcfes que es .inc que realiza las consultas en la base de datos
		$this->EstudianteIcfes = new TEstudianteIcfes();
    $this->TIcfes = new TIcfes();
		$this->ITipo = new ITipo();
	 }

    /**
	  * Muestra segun el programa
	  */
	 function icfes_segun_programa() {
		 $pruebas = DB::table_query($this->ITipo->toSQL($this->params['cod_programa']));
		 echo JSON::encode($pruebas);
	 }

         /**
	  *
	  */
	 function find() {
		$this->vista->display();
	 }

   /**
	  * Reporte de ICFES de un  estudiante
	  */
	 function reporteIndividual($params) {
		
		$this->vista->addJS('jquery.ui.tabs');
	  $this->vista->addJS('highcharts'); //incluye libreria js para dibujar gráficas.
	  
	  
	 	if(isset($params['cedula'])){
			$cedula = $params['cedula'];
			$usuario = array('cod_interno'=>TPersona::cod_interno($cedula));

			
			//Verificar que el usuario puede ver este reporte.
			 if(!canViewStudent($cedula))
				 return $this->vista->acceso_restringido ();
				 
			 $cod_curso = TEstudiante::curso($usuario,null,'cod_grupo');
			 
			$pruebas = null;
			 
			 $options = array();
			 if (!is_blank($cedula) ) {
         
				 if(!is_super_admin_login() )
					 $options['VISIBLE'] = TRUE;
				 $pruebas = $this->EstudianteIcfes->all($usuario,	 1);
       // print_r($cedula);
        //print_r($usuario);
       // print_r($options);
       // print_r($pruebas);
				 $componentes = IComponente::componentes();
        // $vamos="No es blanca";
        // print_r($componentes);
         
			 }
			 
			 $cod_programa = TEstudiante::cod_programa($usuario);
			 
			 $info_pruebas = $this->ITipo->all($cod_programa);
       //print_r($info_pruebas);
			 $this->vista->set('cod_curso', $cod_curso);
			 $this->vista->set(array('componentes' => $componentes, 'pruebas' => $pruebas));
			 
       
       $simulacros = $this->ITipo->cod_pruebas_simulacros($cod_programa, array('select'=>'codigo'));
       
       $this->vista->set('simulacros', $simulacros);
       $this->vista->set('info_pruebas', $info_pruebas);
       $this->vista->set('cod_programa', $cod_programa);

		}
		 return $this->vista->display();
	 }

          /**
	  * Reporte detallado de ICFES por cursos en un programa especifico
	  */
	 function reporteDetallado($params, $request) {
    $this->vista->addModuleCSS('i_competencias_estudiantes','i_competencias_estudiantes');
    $this->vista->addJS('jquery.ui.tabs','highcharts');
    $this->vista->set('tipo', $this->ITipo->tipo($request->getParam('cod_prueba')));
 	 	if($this->params['cod_programa'])
 	 		$this->vista->set('cursos', TPrograma::cursos($this->params['cod_programa']));
		 $this->vista->display('reporteDetallado.form');
	 }
   
   
   function listado_icfes($params) {
     if($params['cod_prueba']){
      $this->vista->set('icfes', $this->TIcfes->listadoIcfes($params['cod_prueba']));   
     }
     $this->vista->display();
	 }
	 
	 
	 function ver_curso($params){
		 $cod_prueba = $params['cod_curso'];
		 $cod_programa = ITipo::programa($cod_prueba);
		 
		 $promedios = array();
	 }

   /**
	  * Muestra reporte ICFES segun lo indicado
	  *
	  * @return
	  */
	 function view() {
		// Mostrar los icfes de un estudiante.
		if (!empty($this->params['cedula'])) {
			return $this->_redirect_to('reporteIndividual');
		} else
		//Mostrar el icfes indicado de un grupo o curso o todos los de un programas
		if (!empty($this->params['cod_prueba'])) {
		 $this->under_construction();
		 $cod_prueba = $this->params['cod_prueba'];
		 $conditions = array('tipo' => $cod_prueba);
		 $cod_programa = any($this->params['cod_programa'], ITipo::programa($cod_prueba));

		 $promedios = array();
		 /**Si se va a mostrar el de un grupo.*/
		 if (!empty($this->params['cod_grupo']) && $this->params['cod_grupo'] != '-') {
			if (is_null($cod_programa))
			 return $this->vista->mostrar_error(__LINE__ . ": FALTA INFORMACION IMPORTANTE: CODIGO DEL PROGRAMA");
			$args = array(
				'table_grupos' => Config::get('TGrupo'),
				'cod_grupo' => $this->params['cod_grupo'],
				'cod_programa' => $cod_programa
			);
			//Condiciones: cod_grupo y cod_programa.
			$conditions['cod_grupo'] = sprintfn("IN (SELECT codigo FROM %(table_grupos)s WHERE grupo = '%(cod_grupo)s') AND cod_programa = '%(cod_programa)s'", $args);
			//Calculo los Promedios del Grupo
			$promedios = TIcfes::promediosPorGrupo($cod_prueba, $this->params['cod_grupo'], $cod_programa);
		 }else
		 /**Si se va a mostrar el de un curso **/
		 if ((!empty($this->params['componentes']['cod_curso']) && $this->params['componentes']['cod_curso'] != '0' ) ||
		 			(!empty($this->params['cod_curso']) && $this->params['cod_curso'] != '0')) {
			//Condiciones: cod_curso. (Con el curso, puedo saber el programa!)
			$cod_curso = any($this->params['componentes']['cod_curso'], $this->params['cod_curso']);
			$conditions['cod_grupo'] = $cod_curso;
			$cod_programa = any($cod_programa, TSubgrupo::programa($cod_curso));
			//Calculo los promedios del Curso
			$promedios = TIcfes::promediosPorCurso($cod_prueba, $cod_curso);
		 }
		 //Consulto los icfes de acuerdo a las condiciones citadas.
		 $estudiantes = TIcfes::all(array(
				 'conditions' => $conditions, 'join' => Config::get('TEstudiante', 'TGrupo') . ' USING (cod_interno) ',
				 'order' => ' cod_grupo ASC, fullname ASC'
			 ));
			 
		 $componentes = ITipo::componentes($cod_prueba);
		 $componentes = array_map('lower', $componentes);
		 
		 $this->vista->set('param_componentes', array('tipo'=>'detallado', 'porniveles'=>1));
		 $this->vista->set('componentes',$componentes);
		 $this->vista->set('pruebas', ITipo::segunPrograma($cod_programa));
		 $this->vista->set('cod_programa', $cod_programa);
		 $this->vista->set(array('cod_curso'=>$cod_curso,'estudiantes' => $estudiantes, 'promedios' => $promedios));
		 return $this->vista->display();
		}
		
		return $this->_redirect_to('reporteIndividual');
	 }

         /**
	  * Muestra comparativas con promedios de ICFES para el programa especificado
	  */
	 function comparativas() {
		$this->vista->addJS('highcharts','jquery.ui.tabs');
		$this->vista->setTitle('Icfes - Comparativas');
		
		if($this->params['cod_programa']){
			$tipos_icfes = ITipo::segunPrograma($this->params['cod_programa']);
			$componentes = ITipo::componentes();
			
			$ultimoIcfes = $tipos_icfes[count($tipos_icfes) - 1];
			
			$promedios = array();
			
      foreach($tipos_icfes as $icfes){
        $promedios['absolute'][$icfes['codigo']] = TIcfes::promediosGenerales($icfes['codigo']);
        $promedios['relative'][$icfes['codigo']] = TIcfes::promediosGenerales($icfes['codigo'], $ultimoIcfes['codigo']);
       }
        
			$this->vista->set('componentes', $componentes);
			$this->vista->set('tipos_icfes', $tipos_icfes);
			$this->vista->set('promedios', $promedios);
			$this->vista->set('ultimo_icfes', $ultimoIcfes);
			
		}
		$this->vista->display();
	 }

         /**
	  * Informe detallado de ICFES por niveles
	  */
	 function __reporteComponentePorNiveles($cod_prueba, $cod_programa){
     AppLoader::load_model('Extra/TIcfes.Niveles');
	 	//	require_once CARPETA_MODELOS_EXTRAS . ".inc";
	 		
	 		//Arreglo de opciones para la consulta de Icfes.
			$find_options = array();
			$find_options['join'] = Config::get('TEstudiante', 'TGrupo') . ' USING (cod_interno) ';
			$find_options['order'] = 'cod_grupo ASC, fullname ASC';
				
			$conditions = array('tipo' => $cod_prueba);
			//Informe Detallado por Niveles
			if ($this->params['componentes']['tipo'] == 'detallado' && !is_null($this->params['componentes']['cod_curso'])) {
			 $cod_curso = $this->params['componentes']['cod_curso'];
			 $conditions['cod_grupo'] = $cod_curso;
			 
			 $find_options['conditions'] = $conditions;
			 
			 $icfesCurso = TIcfes::all($find_options); #Listado de Icfes de los estudiantes del curso!
			 
			 $calculadorNiveles = new TIcfes_CalculaNiveles($icfesCurso, $cod_curso, $cod_prueba);
			 $icfesPorNiveles = $calculadorNiveles->procesar();
			 $this->vista->set(array(
					 'icfes_niveles' => $icfesPorNiveles,
					 '_componentes' => ITipo::componentes($cod_prueba),
					 '_niveles' => Niveles_Por_Puntaje::niveles(),
					 'clasificador' => $calculadorNiveles->clasificador,
					 'rangos'=>Niveles_Por_Puntaje::rangos(),
					 'cod_curso'=>$cod_curso
				 ));
			 $this->vista->display('reporteNivelesDetallado');
			}
			else {
			 $conditions['cod_programa'] = $cod_programa;
			 $find_options['conditions'] = $conditions;
			 $cursos = TIcfes::all($find_options);
			 $codigos_cursos = TGrupo::subgrupos($cod_programa, null, 'cod_grupo');
			 $calculaNiveles = new TIcfes_CalculaNiveles($cursos, $codigos_cursos, $cod_prueba);
			 $icfes_niveles = $calculaNiveles->procesar();
			 $resumen_niveles = $calculaNiveles->clasificador->resumir();
			 $this->vista->set(array(
					 'icfes_niveles' => $icfes_niveles,
					 'resumen_niveles' => $resumen_niveles,
					 '_componentes' => ITipo::componentes($cod_prueba),
					 '_niveles' => Niveles_Por_Puntaje::niveles(),
					 '_superniveles' => Niveles_Por_Puntaje::nivelesConSuperniveles(),
					 'rangos'=>Niveles_Por_Puntaje::rangos(),
					 'clasificador' => $calculaNiveles->clasificador,
					 'grupos' => TGrupo::all($cod_programa),
					 'rangos'=>Niveles_Por_Puntaje::rangos()
				 ));
			 $this->vista->display("reporteNivelesResumen");
			}
	 }

         /**
	  * Reporte detallado ICFES por componentes para el grupo indicado segun el caso
	  */
	 function reporteComponentes() {
		 
		$this->vista->addJS('jquery.ui.tabs', 'custom/icfes_reporteDetallado');
		if (!is_null($this->params['cod_prueba'])) {
		 
		 $this->TIcfes = new TIcfes();
		 
		 $cod_prueba = $this->params['cod_prueba'];
		 $cod_programa = any($this->cod_programa, $this->ITipo->programa($cod_prueba));
		 
		 if ($this->params['componentes']['porniveles'] != '1') {
			if ($this->params['componentes']['tipo'] == 'detallado' && !is_null($this->params['componentes']['cod_curso'])) {
			 //mostrar detallado para el grupo indicado
			 return $this->_redirect_to('view');
			}else {
			 $cursos = $this->TIcfes->resumenPromediosPorCursos($cod_prueba);
			 $grupos = $this->TIcfes->resumenPromediosPorGrupos($cod_prueba);
			 $promediosTotales = $this->TIcfes->promediosGenerales($cod_prueba);

			 $this->vista->set('componentes',array_map('lower',$this->ITipo->componentes($cod_prueba)));
			 $this->vista->set(array("cursos" => $cursos, 'grupos' => $grupos));
			 $this->vista->set('cod_programa', $cod_programa);
			 $this->vista->set('promediosTotales', $promediosTotales);
			 $this->vista->display("reporteResumenPorGrupos");
			}
		 } else //Reporte Componentes Niveles
			$this->__reporteComponentePorNiveles($cod_prueba, $cod_programa);
		}
	 }

	 
	 /**
	  * Respuestas del estudiante indicado en una prueba ICFES especifica
	  */
	 function respuestasIndividual(){
		$respuestas = TIcfes::respuestas($this->params['cedula'], $this->params['cod_prueba']);
		if(empty($respuestas))
			die(html_decorated_div("No Hay Respuestas Registradas para este estudiante en esta prueba","Respuestas No Halladas", array("style"=>'width:8cm'))."<br/>");
		$_respuestas = array();
		foreach($respuestas as $respuesta)
			$_respuestas[$respuesta['cod_pregunta']] = $respuesta;
		unset($respuestas);
		$_preguntas =$db->fetch_array("SELECT * from i_preguntas where cod_prueba = '$cod_prueba' ORDER BY cod_componente, numeral");
		$_resumen = array();
	 }
   
   function add($params){
     if(!isset($params['cod_prueba'])){
       $cod_prueba = $this->AppConfig->get('I.COD_CUESTIONARIO_ACTUAL');
       $this->vista->set('cod_prueba', $cod_prueba);
     }else{
       $cod_prueba = $params['cod_prueba'];
     }
     $interdisciplinar = IInterdisciplinar::toArray();
     $this->vista->set('interdisciplinar', $interdisciplinar);
     if(isset($params['cedula'])){
       $cod_interno = TEstudiante::cod_interno($params['cedula'], COD_ESTADO_ACTIVO);
       
       if($cod_interno != null){
         $TIcfes = new TEstudianteIcfes();
         $icfes = $TIcfes->retrieve($cod_prueba, $cod_interno);
         $this->vista->set('icfes', $icfes);
         if(is_root_login() && $icfes['cod_digitador'] != null){
           
           $nombre_digitador = TPersona::nombre(array('cod_interno'=>$icfes['cod_digitador']));
           $this->vista->set('nombre_digitador', $nombre_digitador);
         }
       }
       $this->vista->set('cod_interno', $cod_interno);
     }
     $this->vista->display();
   }
   
   function create($params){
     if(is_post_request()){
       $TIcfes = new TEstudianteIcfes();
       $TIcfes->persist($params['icfes']);
       redirect_to('icfes','add', array('cod_prueba'=>$params['icfes']['tipo'], 'cedula'=>$params['cedula']));
     }else{
       $this->_redirect_to('add');
     }
   }

	}

?>
