<?php
    function smarty_function_include_script($params, &$smarty){
      if(upper($params['type'])=='CSS')
        return includeCSS($params['file'], $params['module']);
      return includeJS($params['file'], $params['module']);
  }
?>
