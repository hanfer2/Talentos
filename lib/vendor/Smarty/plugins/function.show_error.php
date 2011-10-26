<?php
function smarty_function_show_error($params, &$smarty)
{
		$smarty->assign($params);
		return $smarty->fetch('../_shared/error.tpl');
}
?>
