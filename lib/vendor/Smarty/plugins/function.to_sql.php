<?php
	function smarty_function_to_sql($params, &$smarty){
		$settings = explode(";", $params['options']);
		$toSQL = call_user_func_array(array($params['classname'], 'toSQL'), $settings);
		if(empty($params['assign']))
			return $toSQL;
		$smarty->assign($params['assign'], $toSQL);
	}
?>