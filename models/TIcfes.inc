<?php
 require_once("TEstudiante.inc");
 
 class	TIcfes	extends	TBase {

   function	get($codigo,	$select='*',	$options=array()) {
     return	parent::all(__CLASS__,	$codigo,	$select,	$options);
   }

   function	all($options=array()) {
   	 $sql = parent::toSQL(__CLASS__, $options);
     return	DB::table_query($sql);
   }

   function	first($options=array()) {
     return	parent::first(__CLASS__,	$options);
   }
	 
	 function respuestas($cedula, $cod_prueba){
		$cod_interno = TEstudiante::cod_interno($cedula);
		if($cod_interno === null)
			return FALSE;
		$sql ="SELECT * FROM ".Config::get(__CLASS__, 'Respuesta').
				  "WHERE cod_interno = '$cod_interno' AND	cod_pregunta IN(
						SELECT codigo	FROM ".Config::get('ITipo', 'Pregunta'). "WHERE cod_prueba ='$cod_prueba')
					 ORDER BY cod_pregunta ASC";
		return DB::query($sql);
	 }
////otra qe no estaba
///lista los componentes que haran parte de una pruba, simulacro

function componentes($param){
  
  $sql="select distinct(cod_componente) from v_preguntas where cod_prueba='$param'";
  
  return DB::query($sql);
  
  }
  ///muestra las competencias que se manejan por componente
  function competencias($cod_prueba, $cod_componente){
     $sql="SELECT cod_competencia from i_preguntas where cod_componente ='$cod_componente' AND cod_prueba='$cod_prueba'";
  
  return DB::query($sql);
    
  }
  
  
	//PRUEBA SI UN ESTUDIANTE TIENE ASOCIADA UNA DETERMINADA PRUEBA.
   function	exists($cod_interno,	$tipo,	$num_registro_icfes	=	null) {
     $db	=	DB_new();
     $reg	=	'';
     if	(!is_null($num_registro_icfes))
       $reg	=	sprintf("and num_registro_icfes = '%s'",	pg_escape_string($num_registro_icfes));
     $sql	=	sprintf("select count(*) from a_icfes where cod_interno = '%s' and tipo = '%s'",	pg_escape_string($cod_interno),	pg_escape_string($tipo))	.	$reg;
     return	$db->consultar_unico($sql)	>	0;
   }
function llamarConsultarUnico($sql){
   $db	=	DB_new();
  return	$db->consulta($sql);
}

   function	_componentes_in_aggregateFunction($function) {
     return	"
       $function(lenguaje) as LENGUAJE,
       $function(matematica) as MATEMATICA,
       $function(filosofia) as FILOSOFIA,
       $function(biologia) as BIOLOGIA,
       $function(quimica) as QUIMICA,
       $function(fisica) as FISICA,
       $function(idioma) as IDIOMA,
       $function(geografia) as GEOGRAFIA,
       $function(historia) as HISTORIA,
       $function(sociales) as SOCIALES,
       $function(interdisciplinar) as INTERDISCIPLINAR";
   }
   
   
   function listadoIcfes($cod_prueba){
     $cod_prueba =q($cod_prueba);
     $sql="SELECT  v_estudiantes_icfes.*, a_persona.email, a_persona.telefono 
          FROM v_estudiantes_icfes JOIN a_persona USING (cod_interno)
          WHERE tipo=$cod_prueba";
     return $this->db->table_query($sql);
     }

   function	promediosPorGrupo($cod_prueba,	$cod_grupo,	$cod_programa) {
     $args	=	array(
       'componentes'	=>	TIcfes::_componentes_in_aggregateFunction('AVG'),
       'tablename'	=>	Config::get(__CLASS__),
       'estudiantes_grupos_programas'	=>	Config::get('TEstudiante','TGrupo')
     );
     $sql	=	sprintfn("
        SELECT %(componentes)s FROM %(tablename)s
        WHERE  %(tablename)s.tipo = '$cod_prueba' AND cod_interno IN (
          SELECT cod_interno FROM %(estudiantes_grupos_programas)s
          WHERE grupo = '$cod_grupo' AND cod_programa ='$cod_programa')",	$args);
     return	DB::table_query($sql);
   }

   function	promediosPorCurso($cod_prueba,	$cod_curso) {
     $args	=	array(
       'componentes'	=>	TIcfes::_componentes_in_aggregateFunction('AVG'),
       'tablename'	=>	Config::get(__CLASS__),
       'estudiantes_grupos_programas'	=>	Config::get('TEstudiante','TGrupo')
     );
     $sql	=	sprintfn("
        SELECT %(componentes)s FROM %(tablename)s
        WHERE %(tablename)s.tipo = '$cod_prueba' AND cod_interno IN (
          SELECT cod_interno FROM %(estudiantes_grupos_programas)s
          WHERE cod_grupo = '$cod_curso')",	$args);
     return	DB::table_query($sql);
   }

   function	resumenPromediosPorCursos($cod_prueba) {
     $args	=	array(
       'select'	=>	TIcfes::_componentes_in_aggregateFunction('AVG'),
       'tablename'	=>	Config::get(__CLASS__),
       'estudiantes_grupos'	=>	Config::get('TEstudiante',	'TGrupo')
     );
     $sql	=	sprintfn("
        SELECT cod_grupo, subgrupo, grupo, %(select)s,
           COUNT(*) AS cantidad_estud,
           COUNT(lenguaje) AS clenguaje,
           COUNT(matematica) AS cmatematica,
           COUNT(biologia) AS cbiologia,
           COUNT(fisica) as cfisica,
           COUNT(quimica) as cquimica,
           COUNT(filosofia) as cfilosofia,
           COUNT(historia) as chistoria,
           COUNT(geografia) as cgeografia,
           COUNT(sociales) as csociales,
           COUNT(interdisciplinar) as cinterdisciplinar
        FROM %(tablename)s INNER JOIN %(estudiantes_grupos)s USING (cod_interno)
        WHERE %(tablename)s.tipo = $cod_prueba
        GROUP BY grupo, subgrupo, cod_grupo
        ORDER BY grupo, subgrupo
       ",	$args);
     return	DB::table_query($sql);
   }

   function	resumenPromediosPorGrupos($cod_prueba) {
     $args = array(
       'selects'=>TIcfes::_componentes_in_aggregateFunction('AVG'),
       'tablename'=>Config::get(__CLASS__),
       'v_grupo'=>Config::get('TGrupo',	'viewname')
     );
     $sql = sprintfn(
       "SELECT grupo, %(selects)s
									 FROM %(tablename)s
											INNER JOIN v_estudiantes_grupos USING (cod_interno)
											INNER JOIN %(v_grupo)s USING (cod_grupo, nombre_grupo, grupo)
	 								 WHERE %(tablename)s.tipo = $cod_prueba GROUP BY grupo
                   HAVING grupo IS NOT NULL ORDER BY grupo", $args);
     return DB::table_query($sql);
   }

   /**
    * genera los promedios generales de un determinado icfes.
    * @param int $cod_prueba codigo del la prueba icfes a consultar
    * @param int $icfesRelacionado codigo del icfes respecto al cual se va a realizar la contabilizacion
    * @return array promedios generales del icfes indicado.
    */
   function	promediosGenerales($cod_prueba,	$icfesRelacionado=null) {
     $db	=	&DB::instance();
     $sqlIcfesRelacionado	=	"";

     if	(!is_blank($icfesRelacionado))
       $sqlIcfesRelacionado	=	" AND EXISTS(
                                  SELECT * FROM a_estudiantes_icfes b
                                  WHERE b.tipo = $icfesRelacionado AND
                                        a.cod_interno = b.cod_interno) ";

     $consulta	=	sprintf("SELECT
							AVG(lenguaje) as LENGUAJE,
							AVG(matematica) as MATEMATICA,
							AVG(filosofia) as FILOSOFIA,
							AVG(biologia) as BIOLOGIA,
							AVG(quimica) as QUIMICA,
							AVG(fisica) as FISICA,
							AVG(idioma) as IDIOMA,
							AVG(interdisciplinar) as INTERDISCIPLINAR,
							COUNT(*) as cantidad
							FROM a_estudiantes_icfes a
							WHERE tipo = '%s' %s",	$cod_prueba,	$sqlIcfesRelacionado);

     $promedios	=	$db->fetch_array($consulta,	false);
     if	(empty($promedios))
       return	null;

     $consulta	=	sprintf("SELECT AVG(geografia) as GEOGRAFIA, AVG(historia) as HISTORIA, COUNT(*) AS COUNT_GEOG
                             FROM a_estudiantes_icfes a where tipo = '%s' AND geografia IS NOT NULL and geografia <>0 %s ",	$cod_prueba,	$sqlIcfesRelacionado);
     $promedios	=	(array_merge($promedios,	$db->fetch_array($consulta,	false)));
     $consulta	=	sprintf("SELECT AVG(sociales) as SOCIALES, COUNT(*) as COUNT_SOCIALES
                     FROM a_estudiantes_icfes a where tipo = '%s' AND sociales IS NOT NULL and sociales <>0  %s",	$cod_prueba,	$sqlIcfesRelacionado);
     $promedios	=	(array_merge($promedios,	$db->fetch_array($consulta,	false)));
     return	$promedios;
   }
   
   //LISTADO DE ESTUDIANTES DE UN PNAT QUE NO TIENEN ASOCIADO UN PRUEBA.
   function estudiantesSinIcfes($cod_programa, $cod_prueba){
   	$sql = "
   		SELECT * from v_estudiantes_programas 
			WHERE cod_programa = '$cod_programa' AND tipo = '$cod_prueba' AND cod_estado = 11  
				AND NOT EXISTS (SELECT * FROM a_estudiantes_icfes WHERE v_estudiantes_programas.cod_interno = a_estudiantes_icfes.cod_interno )";
		return DB::table_query($sql);
   }
   
   //FUNCION PARA GUARDAR REGISTROS ICFES EN LA BD.. DESDE UN ARCHIVO CSV.
   function __load($filename, $keys, $tipo){
	   	$estudiantes = CSV::load($filename, ";");
	   	//TODO emplear una funcion que agrupe mejor los resultados de la consulta.
   		$cod_internos = DB::table_query("SELECT cod_interno, cod_estud FROM  a_persona  where a_persona.cod_estado = 11 AND cod_tipo_per='1'","cod_estud");
			$table_icfes = Config::get(__CLASS__);
			$counter = 1;
			$estudiantesNoRegistrados = array();
			foreach($estudiantes as $estudiante){
				$icfes = array_combine($keys, $estudiante);
				$cod_interno = $cod_internos[$icfes['cod_estud']][0]['cod_interno'];
				if(is_null($cod_interno)){ //Si el estudiante no tiene Codigo Interno...
					$estudiantesNoRegistrados[$icfes['cod_estud']] = 1;
					continue;
				}
				unset($icfes['cod_estud']);
				$icfes['cod_interno'] = $cod_interno;
				$icfes['tipo'] = $tipo;
				echo $counter++ ."- ";
				$sql = sql_insert_from_array($table_icfes,$icfes);
				DB::query($sql);  //DESCOMENTAR PARA REALIZAR LA TRANSACCION
				echo "$sql;<br/>";
				echo "<br/>";
				
			}
			echo "<h2>Estudiantes No Registrados</h2>";
			debug(array_keys($estudiantesNoRegistrados));
   }
   
   //LISTADO DE CEDULAS DE ESTUDIANTES DE UN CURSO QUE PRESENTARON UNA DETERMINADA PRUEBA.
		function estudiantesConIcfes($cod_curso, $cod_prueba) {
     // echo "entra";
			$sql = "SELECT cedula FROM " . Config::get('TEstudiante', 'TGrupo') .
						 " WHERE cod_grupo = '$cod_curso' AND cod_interno IN (
								SELECT cod_interno FROM " . Config::get(__CLASS__) . " where tipo = '$cod_prueba')";
              //echo $sql;
			return DB::aquery($sql);
		}
    
    function getReporteDigitadores($cod_prueba){
      if($cod_prueba == null)
        return null;
      $sql = "SELECT * FROM v_reporte_idigitadores WHERE cod_prueba = ".q($cod_prueba);
      return $this->db->table_query($sql);
    }
    
    function getFormulariosDigitadosPor($cedula){
      $cod_interno = TPersona::cod_interno($cedula);
      if($cod_interno == null)
        return null;
      $sql = "SELECT cedula, fullname, nombre_grupo, n_actualizaciones AS correcciones FROM v_estudiantes_grupos JOIN i_cuestionarios_diligenciados USING (cod_interno) WHERE cod_digitador = '$cod_interno'";
      return $this->db->table_query($sql);
    }

 }

require_once 'ITipo.inc';

?>
