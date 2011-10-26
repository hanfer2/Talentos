<?php 
  function smarty_function_url_for($params, $smarty){
    $controller = $params['controller'];
		if(is_blank($controller))
			$controller= $_GET['controlador'];
    unset($params['controller']);
    $action = $params['action'];
    unset($params['action']);
    return url_for($controller, $action, $params);
  }
?>
