<?php /* Smarty version 2.6.26, created on 2011-07-06 16:54:06
         compiled from ./modules/digita_icfes/templates//reporte.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'link_to', './modules/digita_icfes/templates//reporte.tpl', 26, false),)), $this); ?>
<div class="ui-widget decorated">
  <h1>Reporte de Digitadores Icfes</h1>
  <?php if ($this->_tpl_vars['cod_prueba'] == null): ?>
    <p>No hay prueba activa actualmente</p>
  <?php else: ?>
    <h2><?php echo $this->_tpl_vars['nombre_prueba']; ?>
</h2>
    
    <div style="font-size: 14pt">
      Total Formularios Diligenciados: <span id="sp-totalDiligenciados"></span>
    </div>
    
    <table class="table dataTable dt-non-paginable" id="table-reporte-formulariosDiligenciados">
      <thead>
        <tr>
          <th>Doc. Id</th>
          <th>Nombre Digitador</th>
          <th>Formularios</th>
          <th>Correcciones</th>
        </tr>
      </thead>
      
      <tbody>
        <?php $_from = $this->_tpl_vars['digitadores']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['digitador']):
?>
        <tr>
          <td><?php echo $this->_tpl_vars['digitador']['cedula']; ?>
</td>
          <td><?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['digitador']['fullname'],'action' => 'view','cedula' => $this->_tpl_vars['digitador']['cedula']), $this);?>
</td>
          <td class="td-diligenciados"><?php echo $this->_tpl_vars['digitador']['diligenciados']; ?>
</td>
          <td><?php echo $this->_tpl_vars['digitador']['correcciones']; ?>
</td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
      </tbody>
    </table>
    <br/>
    
    <?php echo '
    <script type="text/javascript">
      $(function(){
        var suma = 0;
        $(".td-diligenciados").each(function(){
          suma += parseInt(this.innerHTML);
        })
        $("#sp-totalDiligenciados").html(suma);
      })
    </script>
    <style type="text/css">
      #table-reporte-formulariosDiligenciados_wrapper{width: 500px}
    </style>
    '; ?>

  <?php endif; ?>
</div>