<?php
	function smarty_function_count($params, &$smarty){
		$count = count($params['var']);
		if(empty($params['assign']))
			return $count;
		$smarty->assign($params['assign'], $count);
	}
?>