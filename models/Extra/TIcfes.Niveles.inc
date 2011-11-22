<?php

  class	Niveles_Por_Puntaje {

    function	niveles() {
      return	explode("|", 'SIGNIF. BAJO|MUY BAJO|BAJO|MEDIO BAJO|MEDIO ESTANDAR|MEDIO ALTO|ALTO|SUPERIOR');
    }

    function	rangos() {
      return	array(array(0.00,	10.00),	array(10.01,	20.00),	array(20.01,	30.00),
          array(30.01,	40.00),	array(40.01,	60.00),	array(60.01,	70.00),
          array(70.01,	80.00),	array(80.01,	100.00));
    }

    function	nombre_para_solo_superiores($value) {
      if	($value	<	30.01)
        return	'INFERIOR';
      else
        return	Niveles_Por_Puntaje::nombre($value);
    }

    function	superniveles() {
      return	array('BAJO',	'MEDIO',	'ALTO');
    }
    
    function nivelesConSuperniveles(){
			$result = array();
			$superniveles = Niveles_Por_Puntaje::superniveles();
			foreach($superniveles as $supernivel)
				$result[$supernivel] = Niveles_Por_Puntaje::niveles_segun_supernivel($supernivel);
			return $result;
		}

    function	niveles_segun_supernivel($supernivel) {
      $superniveles	=	Niveles_Por_Puntaje::superniveles();
      $niveles	=	Niveles_Por_Puntaje::niveles();
      switch	($supernivel) {
        case	$superniveles[0]:
          return	array_slice($niveles,	0,	3);
        case	$superniveles[1]:
          return	array_slice($niveles,	3,	3);
        case	$superniveles[2]:
          return	array_slice($niveles,	6,	2);
        default:
          return	null;
      }
    }

    function	cantidad_niveles_segun_supernivel($supernivel) {
      $superniveles	=	Niveles_Por_Puntaje::superniveles();
      switch	($supernivel) {
        case	$superniveles[0]:
        case	$superniveles[1]:
          return	3;
        case	$superniveles[2]:
          return	2;
        default:
          return	0;
      }
    }

    function	supernivel($nivel) {
      $niveles	=	Niveles_Por_Puntaje::niveles();
      $superniveles	=	Niveles_Por_Puntaje::superniveles();
      switch	($nivel) {
        case($nivel	===	0):
        case	$niveles[0]:
        case	1:
        case	$niveles[1]:
        case	2:
        case	$niveles[2]:
          return	$superniveles[0];

        case	3:
        case	$niveles[3]:
        case	4:
        case	$niveles[4]:
        case	5:
        case	$niveles[5]:
          return	$superniveles[1];

        case	6:	case	$niveles[6]:
        case	7:	case	$niveles[7]: {
            return	$superniveles[2];
          }
        default:
          return	null;
      }
    }

    function	niveles_superiores() {
      //DESDE EL TERCER NIVEL EN ADELANTE
      return	array_slice(Niveles_Por_Puntaje::niveles(),	3);
    }

    function	niveles_inferiores() {
      //TRES PRIMEROS NIVELES
      return	array_slice(Niveles_Por_Puntaje::niveles(),	0,	3);
    }

    function	nombre($value) {
      $niveles	=	Niveles_Por_Puntaje::niveles();
      if	(is_blank($value))
        return	$niveles[0];
      switch	($value) {
        case(is_between($value,	0.00,	10.00)):
          return	$niveles[0];
        case(is_between($value,	10.00,	20.00)):
          return	$niveles[1];
        case(is_between($value,	20.00,	30.00)):
          return	$niveles[2];
        case(is_between($value,	30.00,	40.00)):
          return	$niveles[3];
        case(is_between($value,	40.00,	60.00)):
          return	$niveles[4];
        case(is_between($value,	60.00,	70.00)):
          return	$niveles[5];
        case(is_between($value,	70.00,	80.00)):
          return	$niveles[6];
        case(is_between($value,	80.00,	100.00)):
          return	$niveles[7];
        default:
          return	null;
      }
    }

  }

  AppLoader::load_model('TGrupo');
  
  class	TIcfes_ContadorNiveles {

		/**
		 * ALMACENA LA CANTIDAD DE ESTUDIANTES POR NIVELES POR COMPONENTE
		 */
    var	$data = array();
    /**
     *  ALMACENA LA CANTIDAD DE ESTUDIANTES POR GRUPO POR COMPONENTE
     */
    var $cant_estud = array();
    var $cod_prueba;
    var $resumen = array();
    var $subgrupos;

    function	TIcfes_ContadorNiveles($subgrupos,	$cod_prueba) {
      $this->cod_prueba	=	$cod_prueba;

      $cod_programa =	ITipo::programa($cod_prueba);
      $componentes	=	ITipo::componentes($cod_programa);
      $superniveles	=	Niveles_Por_Puntaje::superniveles();
      $niveles	=	Niveles_Por_Puntaje::niveles();
     
      foreach	($subgrupos	as	$subgrupo) {
      	$nombre_curso = TSubgrupo::nombre($subgrupo);
        $this->data[$subgrupo]	=	array('nombre_curso'=>$nombre_curso,'niveles'=>array());
        $this->cant_estud[$subgrupo]	=	array();
        foreach	($superniveles	as	$supernivel) {
          $this->data[$subgrupo]['niveles'][$supernivel]	=	array();
          foreach	(Niveles_Por_Puntaje::niveles_segun_supernivel($supernivel)	as	$nivel) {
            $this->data[$subgrupo]['niveles'][$supernivel][$nivel]	=	array();
            foreach	($componentes	as	$componente)
              $this->data[$subgrupo]['niveles'][$supernivel][$nivel][$componente]	=	0.0;
          }
        }
      }

      foreach	($subgrupos	as	$subgrupo)
        foreach	($componentes	as	$componente)
          $this->cant_estud[$subgrupo][$componente]	=	0.0;

      $cursos = TSubgrupo::all(array('conditions'=>array('cod_programa'=>$cod_programa),'from'=>'v_grupo'));
      foreach($cursos as $curso){
        $this->subgrupos[$curso['cod_grupo']] = $curso['grupo'];
      }
    }
/*aca hay errorees*/
    function	resumir() {
//echo "prueba ".$this->cod_prueba." programa es ".ITipo::programa($this->cod_prueba)."<br/>";
      $grupos	=	TGrupo::all2(ITipo::programa($this->cod_prueba));
      
     // echo "grupos no cargan son"."<br/>";
     // print_r($grupos);
      $superniveles	=	Niveles_Por_Puntaje::superniveles();
      $_componentes	=	ITipo::componentes($this->cod_prueba);
      $this->totales = array('resumen'=>array(),'cant'=>array());
      
      
      /* Initialize summary array*/
      foreach	($grupos	as	$grupo) {
        $this->resumen[$grupo]	=	array();
        foreach	($superniveles	as	$supernivel) {
          $this->resumen[$grupo][$supernivel]	=	array();
          $niveles_con_totales	=	array_merge(Niveles_Por_Puntaje::niveles_segun_supernivel($supernivel),	array('TOTAL'));
          foreach	($niveles_con_totales	as	$nivel) {
            $this->resumen[$grupo][$supernivel][$nivel]	=	array();
            foreach	($_componentes	as	$componente) {
              $this->resumen[$grupo][$supernivel][$nivel][$componente]	=	0.0;
            }
          }
        }
      }

      foreach	($this->data	as	$subgrupo	=>	$superniveles) {
        $grupo = $this->subgrupos[$subgrupo];
        foreach	($superniveles['niveles']	as	$supernivel	=>	$niveles)
          foreach	($niveles	as	$nivel	=>	$componentes)
            foreach	($componentes	as	$componente	=>	$valor) {
              $this->resumen[$grupo][$supernivel][$nivel][$componente]	+=	$valor;
              
              if(!isset($this->totales['resumen'][$supernivel][$nivel][$componente]))
								$this->totales['resumen'][$supernivel][$nivel][$componente] = 0;
							$this->totales['resumen'][$supernivel][$nivel][$componente] += $valor;
            }
      }
      
      foreach($grupos as $grupo){
					foreach($_componentes as $componente){
						if(!isset($this->totales['cant'][$componente]))
							$this->totales['cant'][$componente] = 0;
						$this->totales['cant'][$componente] += $this->cant_estud[$grupo][$componente];
					}
			}
      return	$this->resumen;
    }
    
    function incrementar($subgrupo,	$componente,	$valor) {
      $nivel	=	Niveles_Por_Puntaje::nombre($valor);
      $supernivel	=	Niveles_Por_Puntaje::supernivel($nivel);
      $grupo = $this->subgrupos[$subgrupo];
      ++$this->cant_estud[$subgrupo][$componente];
      ++$this->cant_estud[$grupo][$componente];

      return ++$this->data[$subgrupo]['niveles'][$supernivel][$nivel][$componente];
    }

  }

  class TIcfes_CalculaNiveles {

    var $clasificador = null;
    var $icfes = null;
    var $cod_prueba = null;


    function TIcfes_CalculaNiveles($icfes, $cursos, $cod_prueba) {
      $this->icfes = $icfes;
      $cursos = arrayize($cursos);
      $this->cod_prueba = $cod_prueba;
      $this->clasificador = new TIcfes_ContadorNiveles($cursos, $cod_prueba);
    }

    function procesar() {
      $componentes = ITipo::componentes($this->cod_prueba);

      foreach($this->icfes as $registro)
        foreach($componentes as $componente) {
          $curso = $registro['cod_grupo'];
          if(!is_blank($curso))
            $this->clasificador->incrementar	($curso,	$componente,	$registro[lower($componente)]);
        }

      return $this->clasificador->data;
    }

  }

?>
