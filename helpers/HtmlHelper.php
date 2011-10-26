<?php

 function t($text){
	return check_utf8($text)? $text: utf8_encode($text);
 }
 
 function h($text) {
   return htmlentities(t($text), ENT_COMPAT, CHARSET);
 }

 function html_format_attribute($input) {
   $input = str_remove_accents(trim($input));
   $input = str_replace(" ","_",$input);
   return $input;
 }

 function html_ungroup_attr($input) {
   $input = preg_replace("/\]$/","",$input);
   $input = preg_replace("/\[|\.|\]/","_", $input);
   $input = preg_replace("/_+/","_", $input);
   return $input;
 }

 function html_attrs_to_str($attrs) {
   if(is_null($attrs))
     return "";
   $options_html ="";
	 $underscored_attr = array('id','name');
	 foreach($attrs as $attr => $value) {
		 if(in_array($attr, $underscored_attr))
			 $value = html_format_attribute($value);
		 if($attr == 'id')
			 $value = html_ungroup_attr($value);
		 $options_html .= lower($attr)." = '$value' ";
	 }
   return $options_html;
 }
 
 function _getTitle($name){
	if(is_blank($name))
		return "";
	$coincidencias = array();
	preg_match("/\[(.+)\]/", $name, $coincidencias);
	//debug($coincidencias);
	if(!isset($coincidencias[1]))
		return $name;
	return $coincidencias[1];
 }

 function html_content_tag($tag, $content, $options=null, $autoclose = false) {
   if(!array_key_exists('title', (array)$options))
		$options['title'] = _getTitle($options['name']);
	 $options_html = html_attrs_to_str($options);
   if($autoclose)
     return "<$tag $options_html/>\n";
   return "<$tag $options_html>".$content."</$tag>";
 }


 function html_tag($tag, $options=null) {
   return sprintf("<%s %s>",$tag, html_attrs_to_str($options));
 }

 function html_close_tag($tag) {
   return "</$tag>";
 }

 function html_include_option_to_tag($option, &$options, $html) {

   if(!is_null($options) && array_key_exists($option, $options)) {
     unset($options[$option]);
     return $html;
   }
   return "";
 }


 function html_input_tag($name, $options=null, $val='') {
   $id_text = $name;
   $name_text = $name;
   if(is_array($name)) {
     $id_text = implode('_', $name);
     $name_text = "$name[0]";
     foreach(array_slice($name,1) as $input)
       $name_text .= "[$input]";
   }
   $val = is_null($val)?'': $val;
   $options = array_merge(array (
     "type"=>"text",
     "class"=>"",
     "id"=>"$id_text",
     "name"=>"$name_text",
     "size"=>15,
     "maxlength"=>30,
     "value"=>$val),
     (array)$options);
   return html_content_tag("input", null, $options, true)."\n";
 }


 function html_img_tag($src, $alt='',$options=null) {
   $options['src'] = AppConst::get('siat_public_templates_dir').'images'.$src;
   $options['alt'] = $alt;
   return html_content_tag('img',null, $options, true);
 }



 function html_link_to($name, $url, $options=null, $params=null) {
   $options['href']= "";
   if(empty($params))
     $options['href']= $url;
   else
     $options['href']= getLink($url, $params, false);
   if(is_blank($options['id'])) {
     $id_name = camelize(strip_tags($name));
     if(!is_blank($id_name))
       $options['id'] = "link-$id_name";
   }
   return html_content_tag("a", $name, $options);
 }


 function html_options_select_tag($value, $options=null, $selected=null) {
   $content = "";
   if(is_array($value)) {
     $options['value']= key($value);
     $content= current($value);
   }
   else
     $content = $value;

   if($selected != NULL && $options['value']== $selected)
     $options['selected']= 'selected';

   return html_content_tag("option", $content, $options)."\n";
 }

 function html_select_tag($name, $array_options, $options=array()) {

   $options = array_merge(array( "class"=>"",  "name"=>$name, "size"=>1), (array) $options);
	 if(is_blank($options['id']))
		$options['id'] = $name;
   $html = html_include_option_to_tag('blank', $options, html_options_select_tag($options['blank']));

   if (is_array($array_options))
     foreach($array_options as $col)
       $html .= $col ."\n";
   else
     $html .= $array_options;

   return html_content_tag("select", "\n" . $html, $options);
 }

 function html_select($name, $listOptions, $options=array(), $selected=null) {
   if(is_array($listOptions))
     return html_select_tag_by_array($name, $listOptions,$options,$selected);
   return html_select_tag_by_query($name, $listOptions, $options, $selected);
 }

 function html_select_with() {
   $args = func_get_args();
   return call_user_func_array('html_select_tag_by_query_with', $args);
 }

 function html_select_tag_by_query($name, $query, $options=array(), $selected=null) {
   $list_options = array();
   if(is_array($options) && array_key_exists('extra',$options)) {
     $list_options = (array)$options['extra'] + html_query_to_options($query);
     unset($options['extra']);
   }else
     $list_options = html_query_to_options($query);
   return html_select_tag_by_array($name, $list_options, $options, $selected);
 }

 function html_select_tag_by_query_with($name, $query, $extra=array('-1'=>'-'),$options = null, $selected= null) {
   $options['extra'] = $extra;
	 $options['class'] = $options['class'].' with-extra';
   return html_select_tag_by_query($name, $query, $options, $selected);
 }

 function html_query_to_options($query) {
	 if(is_array($query))
		return $query;
   $db = &DB::instance();
   $db->consulta($query);
   $numFilas = $db->numfilas();
   $numCampos = $db->numcampos();
   $options = array();
   for($i=0; $i<$numFilas; $i++) {
     $val = ($numcampos == 1)?$db->valcampo($i, 0):$db->valcampo($i, 1);
     $options[$db->valcampo($i, 0)] = h($val);
   }
   return $options;
 }

 function html_array_to_options($array, $selected) {
   $html = '';
   foreach($array as $k=>$v) {
     if(is_array($v)) {
     		$array_keys = array_keys($v);
				$html .= html_array_to_options(array($v[$array_keys[0]]=>$v[$array_keys[1]]), $selected);
				continue;
     }
     $opt = array('value'=>$k);
     if($k == $selected)
       $opt['selected'] = 'selected';
     $html .= html_content_tag('option',t($v), $opt);
   }
   return $html;
 }


 function html_select_tag_by_array($name, $array, $options=null, $selected=null) {
   $html= html_array_to_options($array, $selected);
   return html_select_tag($name, $html, $options);
 }


 function includeJS($js, $module = null) {
   $js_folder = null;
  if($module == null)
    $js_folder = AppConst::get('siat_public_templates_dir'). 'js'. DS;
  else
    $js_folder = AppConst::get('siat_modules_dir'). $module . DS . 'templates'.DS.'js'. DS;;
 	if(file_exists($js_folder.$js.".min.js"))
 		$js .= ".min";
   $script = sprintfn(
     "<script type='text/javascript' src='%(js_path)s%(js_file)s.js'></script>",
     array('js_path'=>$js_folder, 'js_file'=>$js));
   return $script;
 }

 function includeCSS($css, $module = null) {
   $css_folder = null;
  if($module == null)
    $css_folder = AppConst::get('siat_public_templates_dir'). 'css'. DS;
  else
    $css_folder = AppConst::get('siat_modules_dir'). $module . DS . 'templates'.DS.'css'. DS;
 	if(file_exists($css_folder.$css.".min.css"))
 		$css .= ".min"; 
   $script = sprintfn(
     "<link rel='stylesheet' type='text/css' href='%(css_path)s%(css_file)s.css'/>",
     array('css_path'=>$css_folder, 'css_file'=>$css)
   );
   return $script;
 }
 

 function html_PNAT($cod_programa = null) {
   $html =  '<abbr class="pnat" title="Plan de Nivelaci&oacute;n Acad&eacute;mico Talentos">PNAT</abbr> ';
   if(!is_null($cod_programa))
     $html .= TPrograma::nombre($cod_programa);
   return $html;
 }


 function header_iso() {
   header('Content-type: text/html; charset=UTF-8');
 }

 
?>
