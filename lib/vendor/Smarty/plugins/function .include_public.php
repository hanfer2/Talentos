<?php
function smarty_function_include_public($params, &$smarty)
{
    $file = $params['file'];
		if(!endsWith($file,".tpl"))
			$file .= ".tpl";
		unset($params['file']);
    
		$smarty->assign($params);
		return $smarty->fetch("templates".DS.'_public'.DS."$file");
}
?>
