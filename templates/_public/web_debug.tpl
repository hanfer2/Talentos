<div id="web_debug_toolbar">
  <span id="wdt-main-icon" class="ui-icon ui-icon-wrench"></span>
  <div id="web_debug_toolbar-nav">
    <a href="#wdt-db_queries" class="wdt-section-link"><span id='wdt-icon-db' class='wdt-icon ui-icon nuvola-icon ui-nuvola-db'></span><span class='wdt-lb'>{$siat_logger->registered_queries|@count}</span></a>
    <a href="#wdt-configs" class="wdt-section-link"><span id='wdt-icon-config' class='wdt-icon ui-icon nuvola-icon ui-nuvola-gear'></span></a>
    <a href="#wdt-user" class="wdt-section-link"><span id='wdt-icon-user' class='wdt-icon ui-icon nuvola-icon ui-nuvola-user-1'></span></a>
  </div>
  <div id="web_debug_toolbar-body">
    <div id="wdt-db_queries" class="wdt-content">
      <h3 class="wdt-title">SQL Queries</h3>
      <ol id="wdt-list-db_queries">
      {foreach from=$siat_logger->registered_queries item=query}
        <li class='{cycle values="even,odd"}'>{$query}</li>
      {/foreach}
      </ol>
    </div>
    
    <div id="wdt-configs" class="wdt-content">
      <h3 class="wdt-title">Configs</h3>
      <div class="wdt-subsection_name">[config/settings.ini]</div>
      <ol id="wdt-list-configs">
        {foreach from=$siat_config->settings key=setting item=value}
        <li class='{cycle values="even,odd"}'><span class="highlighted">{$setting}</span>:= {$value}</li>
        {/foreach}
      </ol>
    </div>
    
    <div id="wdt-user" class="wdt-content">
      <h3 class="wdt-title">User</h3>
      <ol id="wdt-list-user">
        <li class="even"><span class="highlighted">Doc. ID</span>:= {$siat_user->getCedula()} </li>
        <li class="odd"><span class="highlighted">Rol</span>:= [{$siat_user->getRoleId()}] {$siat_user->get('nombre_rol')}</li>
      </ol>
      <div class="wdt-subsection_name">[Credentials]</div>
      <ol>
        {foreach from=$siat_user->credentials item=credential}
          <li class='{cycle values="odd,even"}'>{$credential}</li>
        {/foreach}
      </ol>
    </div>
    
  </div>
</div>


<style type="text/css">
  {literal}
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
  {/literal}
</style>
<script type="text/javascript">
  {literal}
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
  {/literal}
</script>
