<?php
	function smarty_function_persona_url($params, $smarty){
		if($params['cedula'] == null)
			$params['cedula'] = $smarty->_tpl_vars['cedula'];
		$options = $params;
		unset($options['cedula']);
		return persona_url(h($params['cedula']), $options);
	}
?>
