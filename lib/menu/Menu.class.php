<?php 

class Menu{

    function Menu()
    {
    }
    
    function display()
    {
      
    }
}

function smarty_function_include_menu($params, &$smarty){
  $filename = $params['file'];
  $file = 'templates/_public/pages/menu/'.$filename.'.tpl';
  $smarty->_display($file);
}

?>
