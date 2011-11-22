<?php /* Smarty version 2.6.26, created on 2011-11-01 15:05:26
         compiled from ./modules/digita_icfes/templates//view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'link_to', './modules/digita_icfes/templates//view.tpl', 8, false),)), $this); ?>
<div class="ui-widget decorated">
  <h1>Formularios Digitados Por <?php echo $this->_tpl_vars['nombre_persona']; ?>
</h1>
  <?php if ($this->_tpl_vars['cod_prueba'] == null): ?>
    <p>No hay prueba activa actualmente</p>
  <?php else: ?>
    <h3><?php echo $this->_tpl_vars['nombre_prueba']; ?>
</h3>
    <div class="ui-toolbar">
      <?php echo smarty_function_link_to(array('name' => 'Reporte Digitadores','action' => 'reporte'), $this);?>

    </div>
    <?php if ($this->_tpl_vars['estudiantes'] == null): ?>
      <p>Este Digitador No reporta Formularios Diligenciados</p>
    <?php else: ?>
      <table class="table dataTable dt-non-paginable">
        <thead>
          <tr>
            <th>Doc. Id</th>
            <th>Nombre</th>
            <th>Curso</th>
            <th>Correcciones</th>
          </tr>
        </thead>
        
        <tbody>
          <?php $_from = $this->_tpl_vars['estudiantes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['estudiante']):
?>
          <tr>
            <td><?php echo $this->_tpl_vars['estudiante']['cedula']; ?>
</td>
            <td><?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['estudiante']['fullname'],'controller' => 'icfes','action' => 'add','cedula' => $this->_tpl_vars['estudiante']['cedula']), $this);?>
</td>
            <td><?php echo $this->_tpl_vars['estudiante']['nombre_grupo']; ?>
</td>
            <td><?php echo $this->_tpl_vars['estudiante']['correcciones']; ?>
</td>
          </tr>
          <?php endforeach; endif; unset($_from); ?>
        </tbody>
      </table>
      <?php endif; ?>
  <?php endif; ?>
</div>