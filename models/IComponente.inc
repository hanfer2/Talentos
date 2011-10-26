<?php
/**
 * Clase Icomponente extendida de TBase
 */
class IComponente extends TBase {

		/**
		 * Devuelve un arreglo con los componentes
                 * 
		 * @staticvar array $componentes
		 * @return array
		 * @access private
		 */
		function &_componentes() {
			static $componentes = null;
			if ($componentes === null)
				$componentes = array(
					'LENGUAJE' => 'Lenguaje',
					'MATEMATICA' => 'Matem&aacute;ticas',
					'SOCIALES' => 'C. Sociales',
					'FILOSOFIA' => 'Filosof&iacute;a',
					'BIOLOGIA' => 'Biología',
					'QUIMICA' => 'Qu&iacute;mica',
					'FISICA' => 'F&iacute;sica',
					'INTERDISCIPLINAR' => 'Interdisc.',
					'IDIOMA' => 'Idioma',
					'GEOGRAFIA' => 'Geograf&iacute;a',
					'HISTORIA' => 'Historia'
				);
			return $componentes;
		}


		/**
		 * Listado de componentes
                 *
		 * @return array
		 */
		function componentes() {
			return array_keys(IComponente::_componentes());
		}

		/**
		 * Retorna el nombre correcto de un componente
                 *
		 * @param string|int $campo nombre del campo o codigo
		 * @return string nombre correcto de un componente indicado. FALSE si $campo es nulo o vacio.
		 */
		function nombre($campo) {
			if (is_numeric($campo)) {
				$campo = parent::get(__CLASS__,$campo, 'nombre');
			}
			$campos = IComponente::_componentes();
			$campos['NUM_REGISTRO_ICFES'] = 'Registro';
			return ucwords($campos[upper($campo)]);
		}

		/**
		 * Devuelve el resultado de una consulta con las opciones especificadas
                 * 
		 * @param array $options opciones
		 * @return array Listado de Componentes que coinciden con la busqueda.
		 */
		function all($cod_prueba=null, $options=array()){
			if($cod_prueba !== null)
				$options['conditions']=  "codigo IN (SELECT cod_componente FROM ".Config::get('ICuestionario','Pregunta')." WHERE cod_prueba = '$cod_prueba')";
			return DB::query(parent::toSQL(__CLASS__,$options));
		}

	}
?>
