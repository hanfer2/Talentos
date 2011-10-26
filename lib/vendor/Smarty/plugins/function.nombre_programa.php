<?php
	function smarty_function_nombre_programa($params, $smarty){
		if(!isset($params['cod_programa']))
			$params['cod_programa'] = $smarty->_tpl_vars['cod_programa'];
		return html_PNAT($params['cod_programa']);
	}
?>
