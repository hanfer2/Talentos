<?php 
	function smarty_filter_html_attrs($params){
		$exclusive = array_flip(array('class', 'title', 'id', 'name','assign','icon','disabled'));
		return array_diff_key($params, $exclusive);
	}
	
	function smarty_generate_disabled_link($name, $html){
		$html['href'] = 'javascript:void(0)';
		return html_content_tag('a',$name, $html);
	}
	
  function smarty_function_link_to($params, &$smarty){
		if(isset($params['hidden']))
			return "";
    $html = array("class"=>$params['class'], 'title'=>$params['title'], 'id'=>$params['id']);
    if(isset($params['disabled']))
			$html['class'] .=' ui-state-disabled';
		$args = smarty_filter_html_attrs($params);
    
    $name = h($params['name']);
    
    if(isset($params['icon']))
			$name = "<span class='ui-icon item-icon ".$params['icon']."'></span>" . $name;
		
		$assign = $params['assign'];
		$url = null;
		if(isset($params['disabled']))
			$url = smarty_generate_disabled_link($name, $html);
		else
			$url = link_url_for($name, $args, $html);
		if(!empty($assign))
			$smarty->assign($assign, $url);
    else
			return $url;
  }
?>
