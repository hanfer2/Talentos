<?php
require_once 'TEstudiante.inc';
require_once 'TGrupo.inc';

	class TIcfes_Competencias{

		function nombre($cod){
			$db = DB_new();
			return $db->consultar("SELECT nombre FROM i_competencias WHERE codigo = $cod");
		}

		function calcular_x_persona($cedula, $cod_prueba){
			$bd = DB_new();
			$_puntajes = array();
			$_componentes = TIcfes::componentes($cod_prueba);
     
			foreach($_componentes as $componente){
       
				$puntajes[$componente] = array();
				$competencias = TIcfes::competencias($cod_prueba, $componente);
       
				if(is_null($competencias))
					continue;
				foreach($competencias as $competencia){
          echo $competencia."<br/>";////esta tabla i_puntaje_competencia no seesta llenando
          
					$sql = "SELECT puntaje
									 FROM i_puntajes_competencias
									 WHERE cod_interno = (SELECT cod_interno FROM v_estudiantes_activos where cedula = '$cedula')
									 			AND cod_prueba = '$cod_prueba'
									 			AND cod_componente = (SELECT codigo FROM i_componentes WHERE nombre = '$componente')
									 			AND cod_competencia = $competencia";

					//$puntaje = $bd->consultar_unico($sql);
          //$puntaje = DB::query($sql);
          
          //$puntaje = TIcfes::llamarConsultarUnico($sql);
          //echo $sql;
          $pruebadelaconsulta = DB::query($sql);
        
				//	$_puntajes[$componente][$competencia] = any($puntaje, 0.00);
				}
			}
			return $_puntajes;
		}
//revizar esta funcion puede estar fallando
		function calcular_x_subgrupo($cod_curso, $cod_prueba){
			$_puntajes = array();
			$estudiantes = TEstudiante::cedulas_presentaron_icfes_x_subgrupo($cod_curso, $cod_prueba);
  	//$estudiantes = TIcfes::estudiantesConIcfes($cod_curso, $cod_prueba);
   
			foreach($estudiantes as $cedula){
        
     
				$_puntajes[$cedula] = TIcfes_Competencias::calcular_x_persona($cedula, $cod_prueba);
      }
			return $_puntajes;
		}

		function calcular_x_grupo($letra, $cod_prueba){
			$_puntajes = array();
			$subgrupos = TGrupo::subgrupos('003',$letra, 'cod_grupo');
  
			foreach($subgrupos as $subgrupo){
   
				$_puntajes[$subgrupo] = TIcfes_Competencias::calcular_x_subgrupo($subgrupo, $cod_prueba);
      }
			return $_puntajes;
		}

		function calcular_todos($cod_prueba){
      
 
   $cod_prueba='15';
			$_puntajes = array();
      $param ='003';
			$letras = TGrupo::letras( $param);
      
			foreach($letras as $letra){
    
				$_puntajes[$letra] = TIcfes_Competencias::calcular_x_grupo($letra, $cod_prueba);
        }
        echo "El resultado total es esto "."<br/>";
      //  print_r($_puntajes);
			return $_puntajes;
    
		}
    
	}

?>
