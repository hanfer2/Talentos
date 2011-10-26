<?php 
	function smarty_function_html_select($params){
		if($params['options'] == null)
			$params['options'] = array();
		$settings = array('class'=>$params['class'], 'id'=>$params['id'], 'title'=>$params['title']);
		if(array_key_exists('multiple', $params))
			$settings['multiple'] = 'multiple';

		if($params['disabled'] == 'disabled')
			$settings['disabled'] = 'disabled';

		if(is_blank($params['extra']))
			return html_select($params['name'], $params['options'], $settings, $params['selected']);
		else{
			if($params['extra']==='TRUE')
				$params['extra'] = array('0'=>'TODOS');
			elseif($params['extra']=='NULL'){
				$params['extra'] = array('-1'=>'-');
				if($params['selected']==null)
					$params['selected'] = '-1';
			}
			return html_select_with($params['name'], $params['options'], $params['extra'], $settings, $params['selected']);
		}
	}

?>
