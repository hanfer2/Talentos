<?php
/**
 * Funciones de debug de ayuda para el Sistema
 */
/**
 *
 * @return <type>
 */
 function	any() {
   if	(func_num_args()	==	0)
     return	null;

   $args	=	func_get_args();
   for	($i	=	0;	$i	<	count($args);	$i++)
     if	(!is_null($args[$i]))
       return	$args[$i];
   return	null;
 }

 function	debug() {
	 if (!is_root_login() && !is_bg_user())
	 	return;
   $args	=	func_get_args();
   echo	"<pre class='ui-helper-debug' style='text-align: left'>";
   foreach	($args	as	$arg) {
     inspect($arg);
     echo	'<br/>';
   }
   echo	"</pre>";
 }
 
 /**
  * Metodo hvalue
  *
  * Con fines de debug, permite conocer el valor de una variable
  *
  * @param mixed $arg variable a evaluar
  * @return string valor de la variable
  */
 function hvalue($arg) {
   if	(is_null($arg))
     return	"NULL";
   elseif	($arg	===	TRUE)
     return 'TRUE';
   elseif	($arg	===	FALSE)
     return 'FALSE';
   elseif	(is_string($arg) && trim($arg)	===	"")
     return "EMPTY_ESPACE";
   else
     return $arg;
 }

  /**
  * Metodo inspect
  *
  * Con fines de debug, muestra el valor de una variable
  *
  * @param mixed $arg
  */
 function inspect($arg) {
   if	(is_null($arg))
     echo	"NULL";
   elseif	($arg	===	TRUE)
     echo	'TRUE';
   elseif	($arg	===	FALSE)
     echo	'FALSE';
   elseif	(is_string($arg) && trim($arg)	===	"")
     echo	"EMPTY_ESPACE";
   else
     print_r($arg);
 }

?>
