<?php /* Smarty version 2.6.26, created on 2011-07-06 16:44:34
         compiled from ./modules/salones/templates//index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_partial', './modules/salones/templates//index.tpl', 31, false),)), $this); ?>
<div class="ui-widget decorated">
<?php if (! empty ( $this->_tpl_vars['salones'] )): ?>
  <h1>Listado de Salones</h1>  
  <table class="table dataTable" id="table-listadoSalones" width="450px">
    <thead>
      <tr>
				<th class='column-select-filter'>Sede</th>
        <th class='column-select-filter'>Edificio</th>				
				<th>Salon</th>
			</tr>
    </thead>
    <tbody>
			<?php $_from = $this->_tpl_vars['salones']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['salon']):
?>
        <tr>          
          <td><?php echo $this->_tpl_vars['salon']['sede']; ?>
</td>
          <td><?php echo $this->_tpl_vars['salon']['edificio']; ?>
</td>
          <td><?php echo $this->_tpl_vars['salon']['salon']; ?>
</td>					
        </tr>
      <?php endforeach; endif; unset($_from); ?>
    </tbody>
  </table>  
  <div class="toTop">Arriba<span class="ui-icon"></span></div>
<?php else: ?>
	<h1>No se hallaron registros</h1>
	<p>No se hallaron salones</p>
<?php endif; ?>
  <div class="ui-toolbar">
    <a href="#" id="link-crearSalon">Registrar Nuevo Sal&oacute;n</a>
  </div>
  <div id="wrapper-form-nuevoSalon" class="ui-helper-hidden boxed">
    <?php echo smarty_function_include_partial(array('file' => "add.tpl"), $this);?>

  </div>
  <script type="text/javascript">
    <?php echo '
    $("#link-crearSalon").click(function(){
      $("#wrapper-form-nuevoSalon").slideToggle();
      return false;
    })
    '; ?>

  </script>
</div>
<?php if (isset ( $this->_tpl_vars['message'] )): ?>
	<script type='text/javascript'>jAlert("<?php echo $this->_tpl_vars['message']; ?>
")</script>
<?php endif; ?>