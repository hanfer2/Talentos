<?php
	function smarty_modifier_lpad($string, $length, $char='0'){
		return str_pad($string, $length, $char, STR_PAD_LEFT);
	}
?>