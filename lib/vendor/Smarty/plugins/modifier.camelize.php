<?php
/**
 * Smarty camelize modifier plugin
 *
 * Type:     modifier<br>
 * Name:     camelize<br>
 * Purpose:  camelize words in the string
 * @author   Andres
 * @param string
 * @return string
 */
	function smarty_modifier_camelize($string){
		return camelize($string);
	}
?>