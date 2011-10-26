<?php
function smarty_function_include_template($params, &$smarty)
{
		$file = $params['file'];
		if(!endsWith($file,".tpl"))
			$file .= ".tpl";
		unset($params['file']);
    
    $folder = (isset($params['folder']))? $params['folder'] : '_shared';
    unset($params['folder']);
    
		$smarty->assign($params);
		return $smarty->fetch("templates".DS.$folder.DS."$file");
}
?>
