<?php

/**
	* Formatea un fecha a al formato especificado.
	* @param string $format formato de fecha (strftime)
	* @param string $time fecha
	* @return string fecha ingresada formateada al formato especificado.
	*/
function	format_time($format,	$time='now')	{
	setlocale(LC_ALL,	'es_ES');
	return	ucwords(strftime($format,	strtotime($time)));
}

function	microtimef()	{
	list($usec,	$sec)	=	explode(" ",	microtime());
	return	((float)	$usec	+	(float)	$sec);
}

function week_days(){
	return explode(",",'Lunes,Martes,Mi&eacute;rcoles,Jueves,Viernes,Sábado,Domingo');
}

function week_days_en(){
	return  explode(",",'mon,tue,wed,thu,fri,sat,sun');
}

/**
 * 
 * @returns:
 * 			1 if $date1 > $date2
 * 			0 if $date1 = $date2
 * 		 -1 if $date1 < $date2
 */
function date_compare($date1, $date2){
  $rdate1 = array_combine(array('y','m','d'),explode('-', $date1));
  $rdate2 = array_combine(array('y','m','d'),explode('-', $date2));
  if($rdate1 === $rdate2)
    return 0;
  if($rdate1['y'] > $rdate2['y'] )
    return 1;
  if($rdate1['y'] < $rdate2['y'])
    return -1;
  if($rdate1['m'] > $rdate2['m'])
    return 1;
  if($rdate1['m'] < $rdate2['m'])
    return -1;
  if($rdate1['d'] > $rdate2['d'])
    return 1;
  return -1;
}

function date_contains($date_bottom, $date_top, $date=null){
  if(is_null($date))
    $date = date("Y-m-d");
  $compare_top = date_compare($date, $date_top);

  $compare_bottom = date_compare($date, $date_bottom);
  
  return $compare_top !== 1 && $compare_bottom !== -1;
}
?>
