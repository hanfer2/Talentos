<?php
	function smarty_function_html_input($params){
		return html_input_tag($params['name'], $params, $params['value']);
	}
?>