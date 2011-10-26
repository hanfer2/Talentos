<?php

	if (!function_exists('array_combine')) {

	 function array_combine($arr1, $arr2) {
		$out = array();
		foreach ($arr1 as $key1 => $value1) {
		 $out[$value1] = $arr2[$key1];
		}
		return $out;
	 }

	}

	function range_assoc($low, $high, $step=1) {
	 $array = array();
	 $counter = $low;
	 while ($counter <= $high) {
		$array[$counter] = $counter;
		$counter += $step;
	 }
	 return $array;
	}

	/**
	 * determina si un arreglo es asociativo o no
	 * @param array $array arreglo a analizar
	 * @return bool TRUE si el arreglo es asociativo, de lo contrario, FALSE
	 */
	function is_assoc($array) {
	 return (is_array($array) && (0 !== count(array_diff_key($array, array_keys(array_keys($array)))) || count($array) == 0));
	}

	function arrayize($o) {
	 if (is_array($o))
		return $o;
	 return array($o);
	}

	function transpose($array) {
	 $arr = array();
	 for ($i = 0; $i < count($array); $i++)
		for ($j = 0; $j < count($array[$i]); $j++)
		 $arr[$i][$j] = $array[$j][$i];
	 return $arr;
	}

	function extract_assoc_array($array) {
	 $assoc = array();
	 foreach ($array as $k => $v)
		if (is_string($k))
		 $assoc[$k] = $v;
	 return $assoc;
	}

	/**
	 *
	 * @param array $array
	 * @param <type> $item
	 * @param <type> $default
	 * @return <type>
	 */
	function array_item($array, $item, $default = null) {
	 if (!is_array($array)) {
		//trigger_error("array_item: $array is not array", E_USER_WARNING);
	 }
	 return any($array[$item], $default);
	}

	/**
	 * concatena los argumentos con $glue
	 * @param string $glue separador de los argumentos
	 * @param string
	 * @return string
	 */
	function joins($glue, $pieces) {
	 $glue = str_replace("\n", '<br/>', $glue);
	 $arrays = array_slice(func_get_args(), 1);
	 $arrays = array_filter($arrays);
	 return implode($glue, $arrays);
	}

	function array_take($key, &$array) {
	 $element = null;
	 if (array_key_exists($key, $array)) {
		$element = $array[$key];
		unset($array[$key]);
	 }
	 return $element;
	}
	
	/**
	 * Extrae un subarreglo de un arreglo basandose en las llaves. 
	 * @params array $array arreglo original
	 * @params string $keys 
	 * 	Si la cantidad de argumentos es superior a dos, indicaran el nombre de las claves a extraer,.
	 *  de lo contrario, indicara el nombre de las claves a extraer separadas por comas.
	 */
	function subarray($array, $keys){
		$subarray = array();
		if(func_num_args() > 2)
			$keys = array_slice(func_get_args(), 1);
		elseif(!is_array($keys))
			$keys = explode(',', $keys);
		foreach($array as $k=>$v)
			if(in_array($k,$keys))
				$subarray[$k] = $v;
		return $subarray;
	}

	if(!function_exists('array_fill_keys')){
		function array_fill_keys($keys, $value){
			return array_combine($keys,array_fill(0,count($keys),$value));
		}
	}
	
	if (!function_exists('array_diff_key')) {

	 function array_diff_key() {
		$arrs = func_get_args();
		$result = array_shift($arrs);
		foreach ($arrs as $array) {
		 foreach ($result as $key => $v) {
			if (array_key_exists($key, $array)) {
			 unset($result[$key]);
			}
		 }
		}
		return $result;
	 }

	function multisize_param_assoc_array($params){
		if(!is_array($params))
			return null;
		$multi = array();
		foreach($params as $k=>$param){
			$multi[] = array('codigo'=>$k, 'nombre'=>$param);
		}
		return $multi;
	}
  
  /**
   * Permite remover uno o varios items de un arreglo.
   * 
   * @param $array array arreglo que contiene los items
   * @param $item mixed item a eliminar.
   */
  function array_remove_item($array){
    $args = func_get_args();
    $items = array_shift($args);
    
    if (empty($array) || !is_array($array)) 
      return false;

    foreach($array as $key => $value) {
      if (in_array($value, $items)) 
        unset($array[$key]);
    }
    return $array;
  }
}
?>
