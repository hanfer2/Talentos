<?php
  include_once "../include/Reporte_Estadistico.inc";
  include_once "../include/TIcfes_Competencias.inc";
  include_once "../include/TEstudiante.inc";
  include_once "../include/TGrupo.inc";

  class Reporte_Estadistico_Icfes extends Reporte_Estadistico {
  
    function Reporte_Estadistico_Icfes() {
      parent::Reporte_Estadistico();
      $this->data = array();
    }


    function procesar_niveles() {
      include_once '../include/TIcfes_niveles.inc';
      $componentes =TIcfes::componentes();
      if($this->cod_grupo != 0)
        $grupo = TGrupo::nombre($this->cod_grupo);
      $this->clasificador = new TIcfes_ContadorNiveles($grupo, $this->tipo_icfes);

      foreach($this->data as $register) {
        foreach($componentes as $componente) {
          $subgrupo = $register['nombre_grupo'];
          if(!is_blank($subgrupo))
            $this->clasificador->incrementar($subgrupo, $componente, $register[strtolower($componente)]);
        }
      }
      return $this->clasificador->data;
    }

    function imprimir_detallado_por_niveles() {
      if(is_null($this->data)) {
        echo html_decorated_div("No Hay Resultados Icfes Registrados","RESULTADOS ICFES");
        return FALSE;
      }
      $_table = $this->procesar_niveles();
      $_cantEst = $this->clasificador->cant_estud;
      $_niveles = Niveles_Por_Puntaje::niveles($this->cod_grupo==0? null: TGrupo::letra($this->cod_grupo));
      include("../templates/icfes/icfes_detallado_por_niveles.php");
      if($this->cod_grupo==0) {
        $_resumen = $this->clasificador->resumir();
        include("../templates/icfes/icfes_resumen_por_niveles.php");
      }
    }

    function imprimir_resumen_por_niveles() {
      if(is_null($this->data)) {
        echo html_decorated_div("No Hay Resultados Icfes Registrados","RESULTADOS ICFES");
        return FALSE;
      }

      $_table = $this->procesar_niveles();
      $_cantEst = $this->clasificador->cant_estud;
      $_resumen = $this->clasificador->resumir();
      $_niveles = Niveles_Por_Puntaje::niveles($this->cod_grupo==0? null: TGrupo::letra($this->cod_grupo));

      include("../templates/icfes/icfes_resumen_por_niveles.php");
    }


    /************************ para las estadisticas por componente *****************************/

    function consultar_detallado_por_grupo($tipo_icfes, $cod_grupo, $icfesRelacionado = 5) {
      $this->cod_grupo = $cod_grupo;
      $this->tipo_icfes = $tipo_icfes;
      $cod_grupo_sql = '';
      if($cod_grupo != 0)
        $cod_grupo_sql = " AND cod_grupo = '$cod_grupo'";

      $sql = sprintf("SELECT *
                       FROM a_estudiantes_icfes a
                              RIGHT OUTER JOIN v_estudiantes_grupos
                                  USING (cod_interno)
                       WHERE tipo = %s %s AND EXISTS (SELECT * from a_icfes b WHERE b.tipo = $icfesRelacionado and a.cod_interno = b.cod_interno )
                       ORDER BY cod_grupo", q($tipo_icfes), $cod_grupo_sql);
      $this->data = $this->bd->consultar_como_tabla($sql);
      return $this->data;
    }

    function imprimir_detallado_por_grupo() {
      if(is_null($this->data)) {
        echo html_decorated_div("No Hay Resultados Icfes Registrados","RESULTADOS ICFES");
        return FALSE;
      }
      include("../templates/icfes/icfes_completo.php");

    }

    function consultar_resumen_promedios_por_grupos($tipo_icfes) {
      $this->tipo_icfes = $tipo_icfes;
      $this->cod_grupo = null;

      $sql = sprintf("SELECT v_grupo.nombre_grupo, subgrupo, grupo,
														 COUNT(*) AS cantidad_estud,
														 AVG(lenguaje) AS lenguaje,
														 COUNT(lenguaje) AS clenguaje,
														 AVG(matematica) AS matematica,
														 COUNT(matematica) AS cmatematica,
														 AVG(biologia) AS biologia,
														 COUNT(biologia) AS cbiologia,
														 AVG(fisica) as fisica,
														 COUNT(fisica) as cfisica,
														 AVG(quimica) as quimica,
														 COUNT(quimica) as cquimica,
														 AVG(filosofia) as filosofia,
														 COUNT(filosofia) as cfilosofia,
														 AVG(historia) as historia,
														 COUNT(historia) as chistoria,
														 AVG(geografia) as geografia,
														 COUNT(geografia) as cgeografia,
														 AVG(sociales) as sociales,
														 COUNT(sociales) as csociales
	 									  FROM a_icfes
	 									  	RIGHT OUTER JOIN v_estudiantes_grupos
	 								 				USING (cod_interno)
	 								 			LEFT OUTER JOIN v_grupo
	 								 				USING(cod_grupo)
	 									  WHERE tipo = %s
	 									  GROUP BY v_grupo.nombre_grupo, v_grupo.subgrupo, grupo
	 									  HAVING v_grupo.nombre_grupo IS NOT NULL
	 									  ORDER BY v_grupo.nombre_grupo
	 									  ", q($tipo_icfes));
      $this->data = $this->bd->consultar_como_tabla($sql);
      $this->promedios_grupos = array();
      $sql = sprintf("SELECT grupo,
														 AVG(lenguaje) AS lenguaje,
														 AVG(matematica) AS matematica,
														 AVG(biologia) AS biologia,
														 AVG(fisica) as fisica,
														 AVG(quimica) as quimica,
														 AVG(filosofia) as filosofia,
														 AVG(historia) as historia,
														 AVG(geografia) as geografia,
														 AVG(sociales) as sociales
	 									  FROM a_icfes
	 									  	RIGHT OUTER JOIN v_estudiantes_grupos
	 								 				USING (cod_interno)
	 								 			LEFT OUTER JOIN v_grupo
	 								 				USING(cod_grupo)
	 									  WHERE tipo = %s
	 									  GROUP BY grupo
	 									  HAVING grupo IS NOT NULL
	 									  ORDER BY grupo
	 									  ", q($tipo_icfes));
      $this->promedios_grupos = $this->bd->consultar_como_tabla($sql);
      return $this->data;
    }

    function imprimir_resumen_por_grupos() {
      if(is_null($this->data)) {
        echo html_decorated_div("No Hay Resultados Icfes Registrados","RESULTADOS ICFES");
        return FALSE;
      }
      include("../templates/icfes/icfes_promedios_grupo.php");

    }

    /*********************************************************************************************/
    /************************ para las estadisticas por competencias *****************************/

    function consultar_competencia_detallado_por_curso($cod_prueba, $cod_grupo) {
      $this->cod_grupo = $cod_grupo;
      $this->cod_prueba = $cod_prueba;
      $this->data = TIcfes_Competencias::calcular_x_subgrupo($this->cod_grupo, $this->cod_prueba);
      return $this->data;
    }

    function procesar_promedios_por_competencia_por_curso() {
      $_sumas = array();
      foreach($this->data as $cedulas=>$componentes) {
        foreach($componentes as $componente=>$competencias) {
          $_sumas[$componente] = array();
          foreach($competencias as $competencia=>$puntaje) {
            $_sumas[$componente][$competencia] = 0.0;
          }
        }
      }
      foreach($this->data as $cedulas=>$componentes) {
        foreach($componentes as $componente=>$competencias) {
          foreach($competencias as $competencia=>$puntaje) {
            $_sumas[$componente][$competencia] += $puntaje ;
          }
        }
      }
      $_promedios = array();
      foreach($_sumas as $componente=>$competencias) {
        $_promedios[$componente] = array();
        foreach($competencias as $competencia=>$acumulado) {
          $_promedios[$componente][$competencia] = number_format($_sumas[$componente][$competencia]/count($this->data), 2);
        }
      }
      return $_promedios;
    }

    function imprimir_competencia_detallado_por_curso() {
      if(is_null($this->data)) {
        echo html_decorated_div("No Hay Resultados Icfes Registrados","RESULTADOS ICFES");
        return FALSE;
      }
      $_table = $this->data;
      $_promedios = $this->procesar_promedios_por_competencia_por_curso();
      $_componentes = TIcfes::componentesSegunIcfes($this->cod_prueba);
      include("../templates/icfes/icfes_detallado_por_competencias.php");
    }


    function consultar_resumen_competencias_por_grupo($cod_prueba, $letra) {
      $this->cod_prueba = $cod_prueba;
      $this->letra_grupo = $letra;
      $this->componentes = TIcfes::componentes($cod_prueba);
      $this->data = TIcfes_Competencias::calcular_x_grupo($letra,$cod_prueba);
    }

    function procesar_resumen_competencias_por_grupo() {
      $_sumas = array();
      $_promedios = array();
      $_componentes = &$this->componentes;

      foreach($this->data as $curso=>$estudiante) {
        $_sumas[$curso] = array();
        $_promedios[$curso] = array();

        foreach($_componentes as $componente) {
          $_sumas[$curso][$componente] = array();
          $_promedios[$curso][$componente] = array();
          $competencias = TIcfes::competencias($this->cod_prueba, $componente);
          foreach($competencias as $competencia)
            $_sumas[$curso][$componente][$competencia] = 0.0;
          $_promedios[$curso][$componente][$competencia] = 0.0;
        }
        foreach($estudiante as $cedula=>$componentes)
          foreach($componentes as $componente=>$competencias)
            foreach($competencias as $competencia=>$puntaje)
              $_sumas[$curso][$componente][$competencia] +=$puntaje;

        foreach($_componentes as $componente) {
          $competencias = TIcfes::competencias($this->cod_prueba, $componente);
          foreach($competencias as $competencia)
            $_promedios[$curso][$componente][$competencia] = truncate($_sumas[$curso][$componente][$competencia]/count($estudiante));
        }
      }
      return $_promedios;
    }

    function imprimir_resumen_competencia_por_grupo() {
      $_tabla = $this->procesar_resumen_competencias_por_grupo();
      $_codPrueba = &$this->cod_prueba;
      $_letra = &$this->letra_grupo;
      $_cursos = TGrupo::subgrupos($_letra, 'cod_grupo');
      $_componentes = &$this->componentes;
      include_once '../templates/icfes/icfes_reporte_resumen_competencias_x_grupo.php';
    }

    /****************************************************************************************/


  }

?>
