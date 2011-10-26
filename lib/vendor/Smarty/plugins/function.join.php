<?php 
	function smarty_function_join($params){
		$parts =trim(str_replace(";", "",$params['parts']));
		if(strlen($parts)==0)
			return $params['default'];
		$args = explode(";", $params['parts']);
		array_unshift($args, $params['sep']);
		return call_user_func_array('joins', $args);
	}
?>
