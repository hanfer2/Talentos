<?php
/**
 *	Verifica si un valor esta comprendido entre dos numeros
 * @param int $value valor a evaluar
 * @param int $min limite inferior
 * @param int $max limite superior
 * @return bool TRUE si el valor está comprendido entre $min y $max, FALSE de lo contrario.
 */
function	is_between($value,	$min,	$max)	{
	return	$value	>=	$min	&&	$value	<=	$max;
}

function	truncate_num($value,	$decimals	=	2)	{
	if	(is_double($value))
		return	floatval(number_format($value,	$decimals));
	return	intval(number_format($value,	$decimals));
}

function	increment($value,	$increment=1)	{
	if	(empty($value))
		return	$increment;
	return	$value	+	$increment;
}


function	percent($value,	$total,	$format="%3.2f %%")	{
	if	($total === 0)
		return sprintf($format, $total);
	if(empty($total))
		trigger_error("percent: $total es un valor invalido", E_USER_ERROR);
	else{
		$percent =	$value	*	100	/	$total;
  	return sprintf($format, $percent);
  }
}

?>
