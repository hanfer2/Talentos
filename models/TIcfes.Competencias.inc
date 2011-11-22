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
      echo "Los componentes son : "."<br/>";
			foreach($_componentes as $componente){
        echo "componente : ".$componente."<br/>";
				$puntajes[$componente] = array();
				$competencias = TIcfes::competencias($cod_prueba, $componente);
        echo "las competencias para este componente son : "."<br/>";
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
          
          $puntaje = TIcfes::llamarConsultarUnico($sql);
          echo $sql;
          $pruebadelaconsulta == DB::query($sql);
          echo "<br/>"."el puntaje competencia: "."<br/>";
          echo $puntaje."<br/>";
          
          print_r($puntaje);
          echo "<br/>";
        //  echo "ese tal any : ".any($puntaje,0.00);
           //echo "<br/>";
           echo "el puntaje competencia en consulta para mirar: "."<br/>";
           print_r ($pruebadelaconsulta);
           echo "<br/>";
           
				//	$_puntajes[$componente][$competencia] = any($puntaje, 0.00);
         // echo "$_puntajes[$componente][$competencia]"; 
         // echo "<br/>";
				}
			}
			return $_puntajes;
		}
//revizar esta funcion puede estar fallando
		function calcular_x_subgrupo($cod_curso, $cod_prueba){
			$_puntajes = array();
			$estudiantes = TEstudiante::cedulas_presentaron_icfes_x_subgrupo($cod_curso, $cod_prueba);
  	//$estudiantes = TIcfes::estudiantesConIcfes($cod_curso, $cod_prueba);
   // print_r($estudiantes);
    echo "cedulas de estudiantes "."<br/>";
			foreach($estudiantes as $cedula){
        
        echo "cedula : ".$cedula."<br/>";
				$_puntajes[$cedula] = TIcfes_Competencias::calcular_x_persona($cedula, $cod_prueba);
      }
			return $_puntajes;
		}

		function calcular_x_grupo($letra, $cod_prueba){
			$_puntajes = array();
			$subgrupos = TGrupo::subgrupos('003',$letra, 'cod_grupo');
      echo "Los Cursos del grupo son : "."<br/>";
			foreach($subgrupos as $subgrupo){
        echo "Cursos : ".$subgrupo."<br/>";
				$_puntajes[$subgrupo] = TIcfes_Competencias::calcular_x_subgrupo($subgrupo, $cod_prueba);
      }
			return $_puntajes;
		}

		function calcular_todos($cod_prueba){
      
  // echo "la prueba es : ".$cod_prueba;
   $cod_prueba='15';
			$_puntajes = array();
      $param ='003';
			$letras = TGrupo::letras( $param);
      
			foreach($letras as $letra){
     // echo "<br/>";
      echo "**El grupo es".$letra."<br/>";
				$_puntajes[$letra] = TIcfes_Competencias::calcular_x_grupo($letra, $cod_prueba);
        }
        echo "El resultado total es esto "."<br/>";
        print_r($_puntajes);
			return $_puntajes;
    
		}
    
	}

?>
