<?php

 /**
  * Verifica si una solicitud fue enviada mediante Ajax
  * @return bool
  */
 function	is_xhr() {
   //echo "is_xhr()";
   return	isset($_SERVER['HTTP_X_REQUESTED_WITH'])	&&	($_SERVER['HTTP_X_REQUESTED_WITH']	==	'XMLHttpRequest');
 }

 function request_method(){
  return $_SERVER['REQUEST_METHOD'];
 }

 function is_get_request(){
  return request_method() == 'GET';
 }

 function is_post_request(){
  return request_method() == 'POST';
 }

 function	params($vars	=	array()) {
   $params	=	array_merge($_GET,	$_POST);
   unset($params['controlador']);
   unset($params['accion']);
   return	array_merge($params,	$vars);
 }
 
 function module_folder_dir($module){
   return AppConst::get('siat_modules_dir'). uncamelize($module) . DS  ;
 }

 function	getLink($url,	$params=array(),	$use_existing_arguments=false) {
   if	($use_existing_arguments)
     $params	=	$params	+	$_GET;
   if	(!$params)
     return	$url;
   $link	=	$url;
   if	(strpos($link,	'?')	===	false)
     $link	.=	'?';	//If there is no '?' add one at the end
   elseif	(!preg_match('/(\?|\&(amp;)?)$/',	$link))
     $link	.=	'&';	//If there is no '&' at the END, add one.

   $params_arr	=	array();
   foreach	($params	as	$key	=>	$value) {
     if	(gettype($value)	==	'array') {	//Handle array data properly
       foreach	($value	as	$val) {
         $params_arr[]	=	strtolower($key)	.	'[]='	.	urlencode($val);
       }
     }	else {
       $params_arr[]	=	strtolower($key)	.	'='	.	urlencode($value);
     }
   }
   $link	.=	implode('&',	$params_arr);
   return	$link;
 }


 function	url_for($controller,	$action="index",	$params=array()) {
	 if(is_blank($action))
		$action = "index";
   $params	=	array_merge($params,	array('controlador'	=>	$controller,	'accion'	=>	$action));
   return	getLink(INDEX_FILE,	$params);
 }

 function	link_url_for($name,	$params=array(),	$options=array()) {
   $controller = $params['controller'];
   if(is_blank($controller))
     $controller = $_GET['controlador'];
   unset($params['controller']);
   $action = is_blank($params['action'])? 'index' : $params['action'];
   unset($params['action']);
	 
   return	html_link_to($name,	url_for($controller,	$action,	$params),	$options);
 }

 function	persona_url($cedula, $options = array()) {
   return	html_link_to((!isset($options['name']))?$cedula: $options['name'],	url_for('personas',	'view',	array('cedula'	=>	$cedula)),	array_merge((array)$options, array('class'	=>	'link-cedula')));
 }
 
 
 function redirect_to($controller, $action='index', $params=array()) {
   header("location:".url_for($controller, $action, $params));
 }

?>
