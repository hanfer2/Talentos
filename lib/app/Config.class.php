<?php

	class Config {

		/**
		 * @var array arreglo de configuraciones.
		 */
		var $__settings = array();
		/**
		 *
		 * @var string
		 */
		var $currentModel = null;

		/**
		 * Método getInstance
		 *
		 * Devuelve una instancia de Config
		 *
		 * @staticvar string $config
		 * @return Config
		 */
    function &getInstance() {
			static $config = null;
			if ($config === null)
				$config = new Config();
			return $config;
		}

		/**
		 * Método updateCurrentModel
		 *
		 * Actualiza el modelo actual
		 *
		 * @param string $model
		 */
		function updateCurrentModel($model) {
			$this->currentModel = lower($model);
		}

		/**
		 * Método add
		 *
		 * Adiciona un atributo al modelo
		 *
		 * @param string $atributo
		 * @param string $valor
		 * @param string $model
		 */
		function add($atributo, $valor, $model=null) {
			$modelo = null;
			if (is_null($model)){
				//si se omite el nombre del modelo:
				$modelo = $this->currentModel;
			}else{
				//Si se indica el nombre del modelo:
				$this->currentModel = null;
				$modelo = lower($atributo);
				$atributo = $valor;
				$valor = $model;
			}
			$atributo = lower($atributo);
			if (!isset($this->__settings[$modelo]))
				$this->__settings[$modelo] = array();
			$this->__settings[$modelo][$atributo] = $valor;
		}

		/**
		 * Método reset
		 *
		 * Quita un atributo del modelo
		 *
		 * @param string $atributo
		 */
		function reset($atributo) {
			unset($this->__settings[$this->currentModel][$atributo]);
		}

		/**
		 * Método inheritsFrom
		 *
		 * Hereda un modelo de otro
		 *
		 * @param string $parentModel
		 */
		function inheritsFrom($parentModel) {
			$parentModel = lower($parentModel);
			if (!isset($this->__settings[$parentModel]))
				return;
			foreach ($this->__settings[$parentModel] as $attr => $value)
				if (!isset($this->__settings[$this->currentModel][$attr]))
					$this->__settings[$this->currentModel][$attr] = $value;
		}
		
		
		function getAppAttribute($attr){
			$AppConfig = &AppConfig::instance();
			return $AppConfig->get($attr);
		}

		/**
		 * Método getAttribute
		 *
		 * Devuelve un atributo
		 *
		 * @param string $model
		 * @param int|string $attribute
		 * @return int|string
		 */
		function getAttribute($model, $attribute='tablename') {
			$model = lower($model);
      if($model == 'app')
				return $this->getAppAttribute($attribute);
			if (!isset($this->__settings[$model]))
				trigger_error("Config::getAttribute: Modelo $model no hallado", E_USER_ERROR);
			$attribute = lower($attribute);
			
			if (isset($this->__settings[$model][$attribute]))
				return $this->__settings[$model][$attribute];
			return $this->__settings['default'][$attribute];
		}

		/**
		 * Método get
		 *
		 * @param string $model nombre del modelo o seccion.
		 * @param string $attribute nombre del atributo
		 * @return string valor de la atributo.
		 * @static
		 */
		function get($model, $attribute='tablename') {
			$config = null;
			if(is_a($this, __CLASS__))
				$config = $this;
			else
				$config = &Config::getInstance();
			return $config->getAttribute($model, $attribute);
		}

	/**
	 * Método model
	 *
	 * @param string $model
	 * @return array arreglo de configuracion
	 */
	 function model($model) {
			$model = lower($model);
			$settings = $this->__settings[$model];
			foreach ($this->__settings['default'] as $attr => $val)
				if (!isset($settings[$attr]))
					$settings[$attr] = $val;
			return $settings;
		}

		/**
		 * Retorna la configuracion del modelo indicado.
		 * @param string $model nombre del modelo
		 * @return array arreglo de configuracion del modelo indicado.
		 * @static
		 */
		function getModel($model) {
			$config = &Config::getInstance();
			return $config->model($model);
		}

	}

?>
