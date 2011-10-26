<?php
function smarty_function_empty_results($params, &$smarty)
{
		$smarty->assign($params);
		return $smarty->fetch('../_shared/message_empty_results.tpl');
}
?>
