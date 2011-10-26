<?php 
	function smarty_function_str_join($params){
		return call_user_func_array('joins', $params);
	}
?>
