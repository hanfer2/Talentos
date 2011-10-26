<?php

  class InformeEgresado {
    /**
     * @var string codigo del programa 
     */
    var $cod_programa;
    /**
     *
     * @var array tabla con el informe inicial sin procesar. 
     */
    var $informe;
    /**
     * Almacena los totales del informe
     * @var array 
     */
    var $totales = array();

    function InformeEgresado($cod_programa) {
      $this->cod_programa = $cod_programa;
      $this->totales['IES'] = 0;
    }

    /**
     * Genera la tabla con el informe inicial.
     * @access private
     */
    function __retrieve() {
      $sql = "
        SELECT cod_universidad, nombre_universidad, cod_carrera, nombre_carrera, count(cod_interno)
        FROM " . Config::get('TEgresado', 'TUniversidad');
      if ($this->cod_programa != '0')
        $sql .= " WHERE cod_programa = '$this->cod_programa'";

      $sql .= " GROUP BY cod_universidad, nombre_universidad, cod_carrera, nombre_carrera
                ORDER BY cod_universidad, cod_carrera";
      $this->informe = DB::aquery($sql);
    }
    
    /**
     * Inicializa el contador de la Universidad
     * @param string $cod_universidad codigo de la universidad
     * @param string $nombre_universidad  nombre de la universidad
     * @access private
     */
    function __registerUniversity($cod_universidad, $nombre_universidad){
      if(!isset($this->totales['universidades'][$cod_universidad])){
        $settings = array('nombre'=>$nombre_universidad, 'counter'=>0);
        $this->totales['universidades'][$cod_universidad] = $settings;
        $this->totales['carreras'][$cod_universidad] = array();
        }
    }
    function __registerCareer($cod_carrera, $nombre_carrera, $cod_universidad){
      if(!isset($this->totales['carreras'][$cod_universidad][$cod_carrera])){
        $settings = array('nombre'=>$nombre_carrera, 'counter'=>0);
        $this->totales['carreras'][$cod_universidad][$cod_carrera] = $settings;
      }
    }
    function __incrementCounter($cod_universidad, $cod_carrera, $counter){
      $this->totales['universidades'][$cod_universidad]['counter'] += $counter;
      $this->totales['carreras'][$cod_universidad][$cod_carrera]['counter'] += $counter;
      $this->totales['IES'] += $counter;
    }
    
    function process(){
      $this->__retrieve();
      if(empty($this->informe))
        return null;
      foreach( $this->informe as $registro){
        $this->__registerUniversity($registro['cod_universidad'], $registro['nombre_universidad']);
        $this->__registerCareer($registro['cod_carrera'], $registro['nombre_carrera'], $registro['cod_universidad']);
        $this->__incrementCounter($registro['cod_universidad'], $registro['cod_carrera'], $registro['count']);
      }
      return $this->totales;
    }

  }

?>
