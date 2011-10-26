<?php 
	function smarty_function_link_open_external($params, $smarty){
		if(! is_xhr())
			return "";
		
		$action = $_GET['accion'];
		$controller = $_GET['controlador'];
		$vars = $_GET;
		unset($var['accion']);
		unset($var['controlador']);
		$html = "
		<div class='link-openExt'><a href='". url_for($controller,$action, $vars)."' target='_blank'>Nueva ventana<span class='ui-icon'></span></a></div>";
		return $html;
	}
?>
