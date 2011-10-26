<?php 
  function smarty_function_info($params, &$smarty){
    $args = explode(",", $params['args']);
		$info =  call_user_func_array(array($params['classname'], $params['func']), $args);
		if(!is_array($info))
		 $info = t($info);
		if(empty($params['assign']))
		    return  $info;
		$smarty->assign($params['assign'], $info);
  }
?>
