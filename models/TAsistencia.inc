<?php

	require_once 'TBaseModel.inc';

	/**
	 * Clase TAsistencia extendida de TBase
	 */
	class TAsistencia extends TBase {

		/**
		 * Devuelve un arreglo con el resultado de la consulta de asistencia de todos
		 * los estudiantes por cod_clase y/o cod_interno
		 *
		 * @param string $cod_clase
		 * @param string $cod_interno
		 * @return array
		 */
		function all($cod_clase, $cod_interno = null) {
			$conditions = array('cod_clase' => $cod_clase);
			if (!is_null($cod_interno))
				$conditions['cod_interno'] = $cod_interno;
			return parent::all(__CLASS__, array('conditions' => $conditions));
		}
    
    /*funcion que retorna todos los grupos con su inasistencia*/
function all2($cod_programa) {
  
     $sql = "SELECT * FROM inasistencia_grupo_motivos";
     
      return DB::query($sql);
    }
    
    function allSubgruposDeUnGrupo($grupo) {
      
     $sql = "SELECT justificadas.nombre_grupo, excusamedica, calamidad, estudio, transporte , trabajo,transportemenos,nojustificada ,justificadas.inasistencias 
FROM
(select uno.nombre_grupo, excusamedica, calamidad, estudio, transporte ,uno.inasistencias 
from
(select total.nombre_grupo, inasistencias, excusamedica
from
(SELECT nombre_grupo, SUM (inasistencias) as inasistencias
          FROM vi_inasistencias A1 , v_grupo B1 
WHERE grupo='$grupo' and cod_curso=cod_grupo AND B1.cod_programa='003' GROUP BY nombre_grupo order by nombre_grupo)as total

left join 

(SELECT nombre_grupo, sum(inasistencias)as excusamedica
          FROM vi_inasistencias A1 , v_grupo B1 
WHERE grupo='$grupo' and cod_curso=cod_grupo AND B1.cod_programa='003' and cod_motivo='1' GROUP BY nombre_grupo order by nombre_grupo)as excusamedica
ON(total.nombre_grupo=excusamedica.nombre_grupo)) as uno


left join

(select interna1.nombre_grupo, inasistencias, calamidad, estudio, transporte
from

(select total.nombre_grupo, inasistencias, transporte
from
(SELECT nombre_grupo, SUM (inasistencias) as inasistencias
          FROM vi_inasistencias A1 , v_grupo B1 
WHERE grupo='$grupo' and cod_curso=cod_grupo AND B1.cod_programa='003' GROUP BY nombre_grupo order by nombre_grupo)as total

left join 

(SELECT nombre_grupo, sum(inasistencias)as transporte
          FROM vi_inasistencias A1 , v_grupo B1 
WHERE grupo='$grupo' and cod_curso=cod_grupo AND B1.cod_programa='003' and cod_motivo='6' GROUP BY nombre_grupo order by nombre_grupo)as transporte

ON(total.nombre_grupo=transporte.nombre_grupo)

)as interna1

left join

(select calamidad.nombre_grupo, calamidad, estudio
from
(SELECT nombre_grupo, sum (inasistencias) as calamidad
          FROM vi_inasistencias A1 , v_grupo B1 
WHERE grupo='$grupo' and cod_curso=cod_grupo AND B1.cod_programa='003' and cod_motivo ='2' GROUP BY nombre_grupo order by nombre_grupo)as calamidad

left join 

(SELECT nombre_grupo, sum(inasistencias)as estudio
          FROM vi_inasistencias A1 , v_grupo B1 
WHERE grupo='$grupo' and cod_curso=cod_grupo AND B1.cod_programa='003' and cod_motivo='4' GROUP BY nombre_grupo order by nombre_grupo)as estudio
ON(calamidad.nombre_grupo=estudio.nombre_grupo)) interna2

ON(interna1.nombre_grupo=interna2.nombre_grupo)
)dos

ON(uno.nombre_grupo=dos.nombre_grupo))justificadas

LEFT JOIN

(select uno.nombre_grupo, trabajo,transportemenos,nojustificada, uno.inasistencias 
from
(select total.nombre_grupo, inasistencias, trabajo
from
(SELECT nombre_grupo, SUM (inasistencias) as inasistencias
          FROM vi_inasistencias A1 , v_grupo B1 
WHERE grupo='$grupo' and cod_curso=cod_grupo AND B1.cod_programa='003' GROUP BY nombre_grupo order by nombre_grupo)as total

left join 

(SELECT nombre_grupo, sum(inasistencias)as trabajo
          FROM vi_inasistencias A1 , v_grupo B1 
WHERE grupo='$grupo' and cod_curso=cod_grupo AND B1.cod_programa='003' and cod_motivo='3' GROUP BY nombre_grupo order by nombre_grupo)as trabajo
ON(total.nombre_grupo=trabajo.nombre_grupo)) as uno


left join

(select interna1.nombre_grupo, inasistencias, nojustificada, transportemenos
from

(select total.nombre_grupo, inasistencias, transportemenos
from
(SELECT nombre_grupo, SUM (inasistencias) as inasistencias
          FROM vi_inasistencias A1 , v_grupo B1 
WHERE grupo='$grupo' and cod_curso=cod_grupo AND B1.cod_programa='003' GROUP BY nombre_grupo order by nombre_grupo)as total

left join 

(SELECT nombre_grupo, sum(inasistencias)as transportemenos
          FROM vi_inasistencias A1 , v_grupo B1 
WHERE grupo='$grupo' and cod_curso=cod_grupo AND B1.cod_programa='003' and cod_motivo='5' GROUP BY nombre_grupo order by nombre_grupo)as transportemenos

ON(total.nombre_grupo=transportemenos.nombre_grupo)

)as interna1

left join

(SELECT nombre_grupo, sum(inasistencias) as nojustificada
          FROM vi_inasistencias A1 , v_grupo B1 
WHERE grupo='$grupo' and cod_curso=cod_grupo AND B1.cod_programa='003' and cod_motivo ='0' GROUP BY nombre_grupo order by nombre_grupo) interna2

ON(interna1.nombre_grupo=interna2.nombre_grupo)
)dos

ON(uno.nombre_grupo=dos.nombre_grupo))nojustificadas


ON(justificadas.nombre_grupo=nojustificadas.nombre_grupo)";
      return DB::query($sql);
    }
    
    /*Lista las inasitencias por componente en un programa*/
  function  allComponentes($codPrograma) {
    
$sql= "select a3.cod_componente, a1.nombre_componente, excusamedica, calamidad, transporte, estudio, nojustificada, trabajo, transportemenos, totalinasistencia
from inasistencia_componente_j a1 , inasistencia_componente_noj a2, total_inasistencia_componente a3
where 

a1.nombre_componente=a2.nombre_componente and a1.nombre_componente=a3.nombre_componente"
;
     
      return DB::query($sql);
    }
    
function  nombre($param) {
    
 $sql= "select cod_componente, nombre_componente
 from total_inasistencia_componente
 where cod_componente='$param'";
     
      return DB::query($sql);
}
    
    
function  allMotivoNoJustificadas($codNoJustificadas) {
      
     $sql = "select count(asiste) as inasistencia, asiste, nombre_componente, count(cod_motivo) as Nojustificada, cod_motivo
from cu_asistencias, (select cod_componente, nombre_componente from v_componentes_programas 
                      where semestre='1' and cod_programa='003') as componente 
where substr(codigo,1,6)= cod_componente and asiste=false  and cod_motivo='$codNoJustificadas' and cod_interno IN (select cod_interno from v_estudiantes_activos) group by cod_motivo, nombre_componente,asiste";
     
      return DB::query($sql);
    }
    
    function alljsutificadas(){
      
      $sql="select nombre from pe_motivos_inasistencias where valida=true";
      return DB::query($sql);
      }
      
    function  nojustificadas(){
      
      $sql="select nombre from pe_motivos_inasistencias where valida=false";
      return DB::query($sql);
      }
		/**
		 * Devuelve un arreglo con el resultado de la consulta de asistencia
		 * por cada estudiante
		 *
		 * @param string $cod_clase
		 * @param string $cod_interno
		 * @return array
		 */
		function porEstudiante($cod_clase, $cod_interno = null) {
			$estudiantes = TAsistencia::all($cod_clase);
			if($estudiantes == null)
				return null;
			$asistencias = array();
			foreach ($estudiantes as $estudiante) {
				$asistencias[$estudiante['cod_interno']] = array('asiste' => $estudiante['asiste'], 'cod_motivo' => $estudiante['cod_motivo']);
			}
			return $asistencias;
		}
/*cada componente tiene una inasistencia con su motivo, esta funcion me mostrara que cursos han generado esa inasistencia para esa clase*/

function cursoPorComponenteAsistencia($param){
  
  $sql="SELECT justificadas.curso, justificadas.total, justificadas.excusamedica, justificadas.calamidad, justificadas.estudio , justificadas.transportemas, nojustificadas.totalinasistencia, nojustificadas.trabajo, nojustificadas.nojustificada, nojustificadas.trasnportemenos

FROM
(select si1.curso, si1.total, si1.excusamedica, si1.calamidad, si2.estudio , si2.transportemas
from
(select no1.curso, no1.inasistencia as total, no1.inasistencia2 as excusamedica, no2.inasistencia2 as calamidad
from
  (select asistencia.curso, asistencia.inasistencia, motivo1.inasistencia2
   from
        (SELECT (grupo||'-'||subgrupo)as curso, inasistencia from a_grupos, (select substr(cu.codigo,7,3) as       
nombre,  count (asiste)as inasistencia from cu_asistencias cu where substr(cu.codigo,1,6)=(select     cod_componente 
from  v_componentes_programas where cod_componente='$param' and semestre='1' and     
cod_programa='003') and substr(cu.codigo,7,3) IN (select codigo from     a_grupos where cod_programa='003')     
and asiste=false and cod_interno IN (select cod_interno from     a_persona where cod_estado='11') group by    
nombre order by nombre asc)as pi where codigo=nombre and cod_programa='003') asistencia
left join
   (SELECT (grupo||'-'||subgrupo)as curso, inasistencia2 from a_grupos, 
   (select substr(cu.codigo,7,3) as nombre, count (asiste)as inasistencia2 from cu_asistencias cu where substr   
(cu.codigo,1,6)=(select cod_componente from v_componentes_programas where    
cod_componente='$param' and semestre='1' and cod_programa='003') and substr  
(cu.codigo,7,3) IN (select codigo from a_grupos where cod_programa='003') and asiste=false and  cod_motivo='1' 
and cod_interno IN (select cod_interno from a_persona where cod_estado='11') group by    nombre order by 
nombre asc)as pi where codigo=nombre and cod_programa='003') motivo1
ON(asistencia.curso= motivo1.curso))as no1
left join
(select asistencia.curso, asistencia.inasistencia, motivo1.inasistencia2
   from
        (SELECT (grupo||'-'||subgrupo)as curso, inasistencia from a_grupos, (select substr(cu.codigo,7,3) as       
nombre,      count (asiste)as inasistencia from cu_asistencias cu where substr(cu.codigo,1,6)=(select     
cod_componente from      v_componentes_programas where nombre_componente='$param' and 
semestre='1' and     cod_programa='003') and substr(cu.codigo,7,3) IN (select codigo from     a_grupos where 
cod_programa='003')     and asiste=false and cod_interno IN (select cod_interno from     a_persona where 
cod_estado='11') group by    nombre order by nombre asc)as pi where codigo=nombre and cod_programa='003') 
asistencia
left join
   (SELECT (grupo||'-'||subgrupo)as curso, inasistencia2 from a_grupos, 
   (select substr(cu.codigo,7,3) as nombre, count (asiste)as inasistencia2 from cu_asistencias cu where substr   
(cu.codigo,1,6)=(select cod_componente from v_componentes_programas where    
cod_componente='$param' and semestre='1' and cod_programa='003') and substr  
(cu.codigo,7,3) IN (select codigo from a_grupos where cod_programa='003') and asiste=false and    cod_motivo='2' 
and cod_interno IN (select cod_interno from a_persona where cod_estado='11') group by    nombre order by 
nombre asc)as pi where codigo=nombre and cod_programa='003') motivo1
ON(asistencia.curso= motivo1.curso))as no2
ON(no1.curso=no2.curso))as si1
left join
(select no1.curso, no1.inasistencia as total, no1.inasistencia2 as estudio , no2.inasistencia2 as transportemas
from
  (select asistencia.curso, asistencia.inasistencia, motivo1.inasistencia2
   from
        (SELECT (grupo||'-'||subgrupo)as curso, inasistencia from a_grupos, (select substr(cu.codigo,7,3) as       
nombre,  count (asiste)as inasistencia from cu_asistencias cu where substr(cu.codigo,1,6)=(select     cod_componente 
from  v_componentes_programas where cod_componente='$param' and semestre='1' and     
cod_programa='003') and substr(cu.codigo,7,3) IN (select codigo from     a_grupos where cod_programa='003')     
and asiste=false and cod_interno IN (select cod_interno from     a_persona where cod_estado='11') group by    
nombre order by nombre asc)as pi where codigo=nombre and cod_programa='003') asistencia
left join
   (SELECT (grupo||'-'||subgrupo)as curso, inasistencia2 from a_grupos, 
   (select substr(cu.codigo,7,3) as nombre, count (asiste)as inasistencia2 from cu_asistencias cu where substr   
(cu.codigo,1,6)=(select cod_componente from v_componentes_programas where    
cod_componente='$param' and semestre='1' and cod_programa='003') and substr  
(cu.codigo,7,3) IN (select codigo from a_grupos where cod_programa='003') and asiste=false and  cod_motivo='4' 
and cod_interno IN (select cod_interno from a_persona where cod_estado='11') group by    nombre order by 
nombre asc)as pi where codigo=nombre and cod_programa='003') motivo1
ON(asistencia.curso= motivo1.curso))as no1
left join
(select asistencia.curso, asistencia.inasistencia, motivo1.inasistencia2
   from
        (SELECT (grupo||'-'||subgrupo)as curso, inasistencia from a_grupos, (select substr(cu.codigo,7,3) as       
nombre,      count (asiste)as inasistencia from cu_asistencias cu where substr(cu.codigo,1,6)=(select     
cod_componente from      v_componentes_programas where cod_componente='$param' and 
semestre='1' and     cod_programa='003') and substr(cu.codigo,7,3) IN (select codigo from     a_grupos where 
cod_programa='003')     and asiste=false and cod_interno IN (select cod_interno from     a_persona where 
cod_estado='11') group by    nombre order by nombre asc)as pi where codigo=nombre and cod_programa='003') 
asistencia
left join
   (SELECT (grupo||'-'||subgrupo)as curso, inasistencia2 from a_grupos, 
   (select substr(cu.codigo,7,3) as nombre, count (asiste)as inasistencia2 from cu_asistencias cu where substr   
(cu.codigo,1,6)=(select cod_componente from v_componentes_programas where    
cod_componente='$param' and semestre='1' and cod_programa='003') and substr  
(cu.codigo,7,3) IN (select codigo from a_grupos where cod_programa='003') and asiste=false and    cod_motivo='6' 
and cod_interno IN (select cod_interno from a_persona where cod_estado='11') group by    nombre order by 
nombre asc)as pi where codigo=nombre and cod_programa='003') motivo1
ON(asistencia.curso= motivo1.curso))as no2
ON(no1.curso=no2.curso))as si2
ON(si1.curso=si2.curso)

)as justificadas

LEFT JOIN

(select no1.curso, no1.inasistencia as totalinasistencia, no1.inasistencia2 as trabajo, no2.inasistencia as nojustificada, no2.inasistencia2 as trasnportemenos
from
  (select asistencia.curso, asistencia.inasistencia, motivo1.inasistencia2
   from
        (SELECT (grupo||'-'||subgrupo)as curso, inasistencia from a_grupos, (select substr(cu.codigo,7,3) as       
nombre,  count (asiste)as inasistencia from cu_asistencias cu where substr(cu.codigo,1,6)=(select     
cod_componente from  v_componentes_programas where cod_componente='$param' and 
semestre='1' and     cod_programa='003') and substr(cu.codigo,7,3) IN (select codigo from     a_grupos where 
cod_programa='003')     and asiste=false and cod_interno IN (select cod_interno from     a_persona where 
cod_estado='11') group by    nombre order by nombre asc)as pi where codigo=nombre and cod_programa='003') 
asistencia
left join
   (SELECT (grupo||'-'||subgrupo)as curso, inasistencia2 from a_grupos, 
   (select substr(cu.codigo,7,3) as nombre, count (asiste)as inasistencia2 from cu_asistencias cu where substr   
(cu.codigo,1,6)=(select cod_componente from v_componentes_programas where    
cod_componente='$param' and semestre='1' and cod_programa='003') and substr  
(cu.codigo,7,3) IN (select codigo from a_grupos where cod_programa='003') and asiste=false and  cod_motivo='3' 
and cod_interno IN (select cod_interno from a_persona where cod_estado='11') group by    nombre order by 
nombre asc)as pi where codigo=nombre and cod_programa='003') motivo1
ON(asistencia.curso= motivo1.curso))as no1

left join
(select asistencia.curso, asistencia.inasistencia, motivo1.inasistencia2
   from
        (SELECT (grupo||'-'||subgrupo)as curso, inasistencia from a_grupos, (select substr(cu.codigo,7,3) as       
nombre,      count (asiste)as inasistencia from cu_asistencias cu where substr(cu.codigo,1,6)=(select     
cod_componente from      v_componentes_programas where cod_componente='$param' and 
semestre='1' and     cod_programa='003') and substr(cu.codigo,7,3) IN (select codigo from     a_grupos where 
cod_programa='003')     and asiste=false and cod_motivo='0' and cod_interno IN (select cod_interno from     a_persona 
where cod_estado='11') group by    nombre order by nombre asc)as pi where codigo=nombre and 
cod_programa='003') asistencia
left join
   (SELECT (grupo||'-'||subgrupo)as curso, inasistencia2 from a_grupos, 
   (select substr(cu.codigo,7,3) as nombre, count (asiste)as inasistencia2 from cu_asistencias cu where substr   
(cu.codigo,1,6)=(select cod_componente from v_componentes_programas where    
cod_componente='$param' and semestre='1' and cod_programa='003') and substr  
(cu.codigo,7,3) IN (select codigo from a_grupos where cod_programa='003') and asiste=false and    cod_motivo='5' 
and cod_interno IN (select cod_interno from a_persona where cod_estado='11') group by    nombre order by 
nombre asc)as pi where codigo=nombre and cod_programa='003') motivo1
ON(asistencia.curso= motivo1.curso))as no2
ON(no1.curso=no2.curso)) as nojustificadas

ON(justificadas.curso=nojustificadas.curso)";
return DB::query($sql);

  }
		/**
		 *
		 * @param string $cod_asistencia
		 * @return boolean
		 */
		function exists($cod_asistencia){
			$exists =  DB::query("SELECT 1 FROM ".Config::get(__CLASS__)." WHERE codigo = '$cod_asistencia'");
			return !empty($exists);
		}

		/**
		 * Guarda las asistencias de una clase
		 *
		 * @param array $asistencias
		 * @param string $clase
		 * @return true
		 */
		function guardar($asistencias, $clase, $ese) {
			$cod_clase = $clase['codigo'];
			$db = DB::instance();
			foreach ($asistencias as $cod_interno => $asistencia) {
				$data = array('codigo' => "$cod_clase-$cod_interno", 'cod_interno' => $cod_interno, 'cod_clase' => $cod_clase, 'updated_by'=>$ese);
				if ($asistencia['asiste'] == 't') {
					$data = array_merge($data, array('asiste' => 't'));
				} else {
					$data = array_merge($data, array('asiste' => 'f', 'cod_motivo' => $asistencia['justificacion']));
				}
				$sql = "";
				$reporta = TAsistencia::exists($data['codigo']);
				if($reporta)
					$sql = sql_update_from_array(Config::get(__CLASS__), $data, "codigo = '${data['codigo']}'");
				else
					$sql = sql_insert_from_array(Config::get(__CLASS__), $data);
   
				$db->query($sql);
			}
			return !$db->hasError();
		}

			/**
			 * Procesa asistencia por estudiante
			 * 
			 * @param string $cod_interno
			 * @return array
			 */
		function __procesarAsistenciaIndividual($cod_interno){
      
			$sql = "SELECT * FROM ".Config::get(__CLASS__)." WHERE cod_interno = '$cod_interno'";
			$asistencias = DB::table_query($sql);
			$motivos = TMotivoInasistencia::motivos();
			$reporte = array();
			$reporte['asistencia'] = array_fill_keys(array('t','f'), 0);
			$reporte['motivos'] = array_fill_keys(array_keys($motivos), 0);
			$reporte['validez'] = array_fill_keys(array('t','f'), 0);			
			$reporte['total'] = count($asistencias);

			foreach($asistencias as $asistencia){
				$reporte['asistencia'][$asistencia['asiste']]++;
				if($asistencia['asiste'] == 'f'){
					$cod_motivo = $asistencia['cod_motivo'];
					$reporte['motivos'][$cod_motivo]++;
					$reporte['validez'][$motivos[$cod_motivo]['valida']]++;					
				}
			}
			return $reporte;
		}

		
		function inasistenciasPorEstudiante($cedula){
			$cedula = q($cedula);
			$sql = "
				SELECT cu_clases.fecha, cu_asistencias.cod_clase, cu_asistencias.cod_motivo, 
								a_componentes.nombre AS nombre_componente 
				FROM cu_asistencias JOIN a_persona USING (cod_interno)
					JOIN cu_clases ON cu_asistencias.cod_clase::text = cu_clases.codigo::text
					JOIN v_horarios USING (cod_horario)
					JOIN a_componentes ON v_horarios.cod_componente = a_componentes.codigo
				WHERE cu_asistencias.asiste IS FALSE AND cedula = '$cedula'
				ORDER BY nombre_componente, fecha";
				$group_by = 'nombre_componente';
				$estudiante = DB::table_query($sql,'nombre_componente');
				return $estudiante;
		}
		/**
		 * Procesa inasistencias por estudiante, por programa o por curso
		 *
		 * @param array $filtro
		 * @return array|boolean
		 *
		 */
		function inasistencias($filtro){
			if(empty($filtro))
				return FALSE;
				
			$sql = "";
			if(isset($filtro['cedula'])){
				return TAsistencia::inasistenciasPorEstudiante($filtro['cedula']);
			}elseif(isset($filtro['cod_programa'])){
				$cod_programa = q($filtro['cod_programa']);
				$sql = " SELECT cedula, fullname, genero, edad(fecha_nacimiento), ".
								 " a.telefono, a.tel_celular, cod_curso, nombre_curso, cod_motivo, inasistencias ".
							 " FROM vi_inasistencias JOIN a_persona a USING(cedula)".
							 " WHERE cod_programa = '$cod_programa'";
								
			}elseif(isset($filtro['cod_curso'])){
				$cod_curso = q($filtro['cod_curso']);
				$sql = " SELECT cedula, fullname, genero, edad(fecha_nacimiento),".
								 " a.telefono, tel_celular, cod_motivo, inasistencias  ".
							 " FROM vi_inasistencias JOIN a_persona a USING(cedula) ".
							 " WHERE cod_curso = '$cod_curso'";
			}
			$estudiantes = DB::table_query($sql);
			if($estudiantes == null)
			return array();
		
			$reporte = array();
			foreach($estudiantes as $estudiante){
				$cedula = $estudiante['cedula'];
				if(!isset($reporte[$cedula])){
					$reporte[$cedula] = subarray($estudiante,'fullname','telefono','genero','edad', 'tel_celular');
					$reporte[$cedula]['inasistencias'] = array();
					if(isset($estudiante['cod_curso'])){
						$reporte[$cedula]['cod_curso'] = $estudiante['cod_curso'];
						$reporte[$cedula]['nombre_curso'] = $estudiante['nombre_curso'];
					}
				}
				$reporte[$cedula]['inasistencias'][$estudiante['cod_motivo']] = $estudiante['inasistencias'];
			}
			return $reporte;
		}
		
		function nClasesAsistidas($filtro){
      
			$sql = " SELECT cedula, n_asistencias ".
						 " FROM ".Config::get(__CLASS__, 'R-ClasesAsistidas')." JOIN ".Config::Get('TEstudiante','TGrupo'). " USING(cod_interno) ";
			if(isset($filtro['cod_programa'])){
				$cod_programa = q($filtro['cod_programa']);
				$sql .= " WHERE cod_programa = '$cod_programa'";
			}elseif(isset($filtro['cod_curso'])){
				$cod_curso = q($filtro['cod_curso']);
     
				$sql .= " WHERE cod_grupo = '$cod_curso'";
			}
			return DB::table_query($sql,'cedula');
      
		}
		
		/**
		 * 
		 *
		 * @param string $cedula
		 * @param string $options
		 * @return array
		 */
		function clases($cedula, $options=array()){
			$cod_interno = TPersona::cod_interno($cedula);
			$sql = "SELECT ";
			if(!isset($options['select']))
				$options['select'] = "*";
			if(isset($options['operation']))
				$sql .= $options['operation']."(".$options['select'].")";
			else 
				$sql .= $options['select'];
			
			$sql .= " FROM ".Config::Get(__CLASS__);
			$sql .= " WHERE cod_interno = '$cod_interno'";
			return DB::query($sql);
		}

	}

?>
