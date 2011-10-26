<?php
	function smarty_function_pluralize($params, &$smarty){
		$pluralized = pluralize($params['count'], $params['singular'], $params['plural']);
		if(!empty($params['assign']))
			$smarty->assign($params['assign'], $pluralized);	
		else
			return $pluralized;
	}
?>