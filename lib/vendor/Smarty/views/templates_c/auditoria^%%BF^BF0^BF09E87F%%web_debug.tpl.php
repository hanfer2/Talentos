<?php /* Smarty version 2.6.26, created on 2011-07-06 16:43:50
         compiled from templates/_public/web_debug.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'templates/_public/web_debug.tpl', 4, false),array('function', 'cycle', 'templates/_public/web_debug.tpl', 13, false),)), $this); ?>
<div id="web_debug_toolbar">
  <span id="wdt-main-icon" class="ui-icon ui-icon-wrench"></span>
  <div id="web_debug_toolbar-nav">
    <a href="#wdt-db_queries" class="wdt-section-link"><span id='wdt-icon-db' class='wdt-icon ui-icon nuvola-icon ui-nuvola-db'></span><span class='wdt-lb'><?php echo count($this->_tpl_vars['siat_logger']->registered_queries); ?>
</span></a>
    <a href="#wdt-configs" class="wdt-section-link"><span id='wdt-icon-config' class='wdt-icon ui-icon nuvola-icon ui-nuvola-gear'></span></a>
    <a href="#wdt-user" class="wdt-section-link"><span id='wdt-icon-user' class='wdt-icon ui-icon nuvola-icon ui-nuvola-user-1'></span></a>
  </div>
  <div id="web_debug_toolbar-body">
    <div id="wdt-db_queries" class="wdt-content">
      <h3 class="wdt-title">SQL Queries</h3>
      <ol id="wdt-list-db_queries">
      <?php $_from = $this->_tpl_vars['siat_logger']->registered_queries; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['query']):
?>
        <li class='<?php echo smarty_function_cycle(array('values' => "even,odd"), $this);?>
'><?php echo $this->_tpl_vars['query']; ?>
</li>
      <?php endforeach; endif; unset($_from); ?>
      </ol>
    </div>
    
    <div id="wdt-configs" class="wdt-content">
      <h3 class="wdt-title">Configs</h3>
      <div class="wdt-subsection_name">[config/settings.ini]</div>
      <ol id="wdt-list-configs">
        <?php $_from = $this->_tpl_vars['siat_config']->settings; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['setting'] => $this->_tpl_vars['value']):
?>
        <li class='<?php echo smarty_function_cycle(array('values' => "even,odd"), $this);?>
'><span class="highlighted"><?php echo $this->_tpl_vars['setting']; ?>
</span>:= <?php echo $this->_tpl_vars['value']; ?>
</li>
        <?php endforeach; endif; unset($_from); ?>
      </ol>
    </div>
    
    <div id="wdt-user" class="wdt-content">
      <h3 class="wdt-title">User</h3>
      <ol id="wdt-list-user">
        <li class="even"><span class="highlighted">Doc. ID</span>:= <?php echo $this->_tpl_vars['siat_user']->getCedula(); ?>
 </li>
        <li class="odd"><span class="highlighted">Rol</span>:= [<?php echo $this->_tpl_vars['siat_user']->getRoleId(); ?>
] <?php echo $this->_tpl_vars['siat_user']->get('nombre_rol'); ?>
</li>
      </ol>
      <div class="wdt-subsection_name">[Credentials]</div>
      <ol>
        <?php $_from = $this->_tpl_vars['siat_user']->credentials; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['credential']):
?>
          <li class='<?php echo smarty_function_cycle(array('values' => "odd,even"), $this);?>
'><?php echo $this->_tpl_vars['credential']; ?>
</li>
        <?php endforeach; endif; unset($_from); ?>
      </ol>
    </div>
    
  </div>
</div>


<style type="text/css">
  <?php echo '
  #web_debug_toolbar{
    position: fixed; top:0;
  }
  #web_debug_toolbar-nav{
    position: fixed; 
    right:16px; top: 2px;
    text-align: right;
    z-index:2000;
    background-color: #EEE;
    border: 1px solid #CCC;
    display: none;
  }
  #wdt-main-icon{
    position: fixed;
    right:0;
    z-index: 3000;    
  }
  .wdt-content{
    width: 100%;
    position: fixed; 
    right:0; 
    border: 1px solid #666; 
    background-color: #F9F9F9; 
    z-index:1500; 
    display:none;
    font-family: monospace;
    font-size: 8pt;
  }
  .wdt-section-link{
    display: inline-block;
    padding: 2px 4px;
  }
  .wdt-icon{
    cursor: pointer; 
    display: inline-block;
  }
  .wdt-lb{
    font-size: 8pt;
    padding: 2px 3px;
  }
  .wdt-title{
    text-align: left;
    margin: 15px 10px 0;
  }
  .wdt-content li {
    padding: 5px 4px;
    margin-right: 15px;
  }
  .wdt-content .even {
    background-color: #DDD; 
  }
  .wdt-content .even .odd {
    background-color: #F9F9F9; 
  }
  .wdt-content .highlighted { color: #660066; font-weight:600}
  .wdt-subsection_name{font-weight: bold}
  '; ?>

</style>
<script type="text/javascript">
  <?php echo '
  $("#wdt-main-icon").click(function(){
    $("#web_debug_toolbar-nav").toggle("slide");
    $(".wdt-content").hide();
  });
  $(".wdt-section-link").click(function(){
    var target = $(this.hash)
    $(".wdt-content").not(target).hide();
    target.fadeToggle();
    return false;
  });
  '; ?>

</script>