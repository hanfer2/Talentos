<?php

	/**
	 * Clase TObject
	 */
	class TObject {
		var $db = null;

		function __construct() {
			$this->db = &DB::instance();
		}

		function TObject() {
			$args = func_get_args();
			call_user_func_array(array(&$this, '__construct'), $args);
		}

	}

        /**
         * Clase TBase extendida de TObject
         */
	class TBase extends TObject {
		
		function __construct(){
			parent::__construct();
			$this->Config = Config::getInstance();
			$this->AppConfig = AppConfig::instance();
		}
		/**
		 * Crea un SQL para buscar modelos en la Base de Datos.
		 * @param array $options opciones para la consulta SQL:
		 *  select => campos a mostrar, por defecto: '*';
		 *  conditions => condiciones del WHERE
		 *  order => regla de ordenamiento
		 *  group => regla de agrupamiento
		 *  limit => numero limite de elementos a mostrar.
		 * @return string
		 */
		function toSQL($class_name, $options) {

			$model = Config::getModel($class_name);
			$tablename = $model['tablename'];
      
			if (is_blank($tablename)) {
				trigger_error("Missing TableName for ". hvalue($tablename), E_USER_ERROR);
				return FALSE;
			}
			$options['select'] = (!isset($options['select'])) ? '*' : join(',', arrayize($options['select']));
			$options['from'] = any($options['from'], $tablename);
     // echo $tablename." , ";
			$sql = sprintfn("SELECT %(select)s FROM %(from)s ", $options);
			if (!empty($options['join']))
				$sql .= " INNER JOIN {$options['join']} ";
			if (!empty($options['conditions']))
				$sql .= " WHERE " . TBase::parse_conditions_sql($options['conditions']);
			$order = any($options['order'], $model['order']);
			if ((in_array('order', $options) || array_key_exists('order', $options)) && !is_blank($order))
				$sql .= sprintf(" ORDER BY %s ", $order);
			if (!is_blank($options['group']))
				$sql .= sprintf(" GROUP BY %s ", $options['group']);
			if (!is_blank($options['limit']))
				$sql .= sprintf(" LIMIT %s ", $options['limit']);
			return $sql;
		}

                /**
                 * Analiza las condiciones (where) de la consulta
                 *
                 * @param string $conditions
                 * @return string
                 */
		function parse_conditions_sql($conditions) {
			if (empty($conditions))
				return "";
			if (is_string($conditions))
				return " $conditions";
			if (is_array($conditions)) {
				$parsed_conditions = array();

				foreach ($conditions as $k => $v) {
					if (is_blank($v))
						$parsed_conditions[] = " $k IS NULL ";
					else if (is_int($k))
						$parsed_conditions[] = " $v ";
					else if ($v == 'NULL')
						$parsed_conditions[] = " $k IS NULL ";
					else if (startsWith($v, "LIKE") || startsWith($v, "IN ") || startsWith($v, "NOT ") || startsWith($v, "="))
						$parsed_conditions[] = " $k $v ";
					else if(is_array($v)) {
						if ($k == 'OR' || $k == 'AND')
							$parsed_conditions[] = " (" . TBase::parse_conditions_sql($v[0]) . ") $k (" .
								TBase::parse_conditions_sql($v[0]) . ") ";
						else if ($k == 'NOT')
							$parsed_conditions[] = " $k NOT IN (" . sql_rangeize($v) . ") ";
						else
							$parsed_conditions[] = " $k  IN (" . sql_rangeize($v) . ") ";
					}else
					$parsed_conditions[] = "$k = '$v'";
				}
				return join(' AND ', $parsed_conditions);
			}
		}

                /**
                 * Devuelve el resultado de una consulta con todos los campos
                 *
                 * @param string $class
                 * @param array $options
                 * @return array
                 */
		function all($class, $options=array()) {
			$sql = TBase::toSQL($class, $options);
			return DB::aquery($sql);
		}

                /**
                 * Limita la consulta al primer resultado encontrado
                 *
                 * @param string $class
                 * @param array $options
                 * @return array
                 */
		function first($class, $options=array()) {
			$options['limit'] = 1;
			$sql = TBase::toSQL($class, $options);
			return DB::query($sql);
		}

                /**
                 * Devuelve el numero de filas en la respuesta a la consulta
                 *
                 * @param string $class
                 * @param array $options
                 * @return array
                 */
		function count($class, $options=array()) {
			return TBase::get($class, FALSE, 'count(*)', $options);
		}

		/**
                 * Devuelve el resultado de una consulta con algunos los campos
                 *
		 * @param string $class_name nombre de la clase
		 * @param array|string $codigo condicion primaria de busqueda.
		 * @param array|string $selects lista de campos a consultar.
		 * @param array $options demas condiciones de la consulta.
		 * @return mixed resultado de la consulta.
		 */
		function get($class_name, $codigo, $selects, $options=array()) {
			if (empty($selects))
				return null;
			if (!isset($options['conditions']))
				$options['conditions'] = array();
			if (is_array($codigo)) {
				$key = key($codigo);
				$options['conditions'][$key] = trim($codigo[$key]);
			} else
			if ($codigo !== FALSE) {
				$options['conditions'][Config::get($class_name, 'primary_key')] = $codigo;
			}
			$options['select'] = $selects;

			$sql = TBase::toSQL($class_name, $options);
			return DB::query($sql);
		}

		/**
		 * Devuelve el maximo valos de un campo especifico en una consulta
		 *
		 * @param string $from
		 * @param string $select
		 * @param string $conditions
		 * @return array
		 */
		function max($from, $select='codigo', $conditions="") {
			$select  = (is_null($select))? 'codigo' : $select;
			$sql = "SELECT MAX($select) FROM ".Config::Get($from)." $conditions";
			return DB::query($sql);
		}

			/**
			 * Devuelve si existe o no una condicion dentro de una tabla
			 *
			 * @param string $class_name
			 * @param array $conditions
			 * @return boolean
			 */
		function exists($class_name, $conditions=array()) {
			$args = array(
				'tablename' => Config::get('TEstudiante', 'viewname'),
				'conditions' => TBase::toSQL($conditions)
				);
			$sql = "SELECT 1 FROM %(tablename)s %(conditions)s";
			$result = DB::query($sql);
			return empty($result);
		}
		
		function toArray($class_name, $options=array()){
			return DB::aquery(TBase::toSQL($class_name, $options));
		}
		
		function Load($classname){
      AppLoader::load_model($classname);
			$this->$classname = new $classname();
		}
	}

?>
