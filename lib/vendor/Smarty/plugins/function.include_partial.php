<?php
function smarty_function_include_partial($params, &$smarty)
{
		$file = $params['file'];
		if(!endsWith($file,".tpl"))
			$file .= ".tpl";
      
		unset($params['file']);
    
    $module = null;
    if(isset($params['module'])){
      $module = $params['module'];
      unset($params['module']);
    }else{
      $module = $smarty->getModule();
    }
    
		$smarty->assign($params);
    $path = "modules".DS.$module.DS."templates".DS;
		return $smarty->fetch($path.$file);
}
?>
