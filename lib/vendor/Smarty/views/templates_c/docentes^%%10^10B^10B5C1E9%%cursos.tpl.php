<?php /* Smarty version 2.6.26, created on 2011-07-06 16:49:16
         compiled from modules/docentes/templates/cursos.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'info', 'modules/docentes/templates/cursos.tpl', 7, false),array('function', 'html_select', 'modules/docentes/templates/cursos.tpl', 8, false),array('function', 'persona_url', 'modules/docentes/templates/cursos.tpl', 26, false),array('function', 'include_template', 'modules/docentes/templates/cursos.tpl', 30, false),array('function', 'link_to', 'modules/docentes/templates/cursos.tpl', 35, false),array('function', 'join', 'modules/docentes/templates/cursos.tpl', 55, false),array('modifier', 'escape', 'modules/docentes/templates/cursos.tpl', 55, false),array('modifier', 'lower', 'modules/docentes/templates/cursos.tpl', 55, false),)), $this); ?>
<?php if (! ( isset ( $this->_tpl_vars['cedula'] ) || isset ( $this->_tpl_vars['cod_componente'] ) )): ?>
  <div class="ui-widget decorated">
    <h1>Listado de Docentes Por Curso</h1>
    <div class='ui-form'>
      <div class="ui-field">
        <label for="cod_programa"><?php echo $this->_config[0]['vars']['PNAT']; ?>
</label>
        <?php echo smarty_function_info(array('classname' => 'TPrograma','func' => 'toSQL','assign' => 'programas_sql'), $this);?>

        <?php echo smarty_function_html_select(array('name' => 'cod_programa','options' => $this->_tpl_vars['programas_sql']), $this);?>

      </div>
      <div class="ui-field">
        <label for="cod_componente">Componente</label>
        <?php echo smarty_function_info(array('classname' => 'TComponente','func' => 'toSQL','assign' => 'componentes_sql'), $this);?>

        <?php echo smarty_function_html_select(array('name' => 'cod_componente','options' => $this->_tpl_vars['componentes_sql'],'extra' => 'TODOS'), $this);?>

      </div>
      <div class='ui-toolbar'>
		<button id='bt-listadoDocentesCursos'>Aceptar</button>
      </div>
    </div>
  </div>
  <div class='ajax-response' id='ajax-listadoDocentesCursos'></div>
<?php else: ?>
  
    <div class="ui-widget decorated">
      <h1><?php if (( isset ( $this->_tpl_vars['cedula'] ) )): ?> Listado de Cursos <?php else: ?> Listado de Docentes Por Curso <?php endif; ?></h1>
      <?php if (isset ( $this->_tpl_vars['cedula'] )): ?> 
        <h2><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['cedula']), $this);?>
 - <?php echo smarty_function_info(array('classname' => 'TPersona','func' => 'nombre','args' => $this->_tpl_vars['cedula']), $this);?>
</h2>
      <?php endif; ?>
      
      <?php if (( empty ( $this->_tpl_vars['docentes'] ) )): ?>
         <?php echo smarty_function_include_template(array('file' => 'message_empty_results'), $this);?>

      <?php else: ?>
      
      <?php if (is_admin_login ( )): ?>
      <div class="ui-toolbar">
        <?php echo smarty_function_link_to(array('name' => 'Listado Completo de Docentes','controller' => 'docentes'), $this);?>
 |
        <?php echo smarty_function_link_to(array('name' => 'Listado de Docentes Por Curso','controller' => 'docentes','action' => 'cursos'), $this);?>
<br/>
        <?php echo smarty_function_link_to(array('name' => 'Informe de Docentes','controller' => 'docentes','action' => 'informe'), $this);?>

      </div>
      <?php endif; ?>
      <table class="table dataTable dt-unsortable" id='table-cursosDocente'>
        <thead>
          <tr>
            <?php if (( ! isset ( $this->_tpl_vars['cedula'] ) )): ?>
              <th class="column-hidden">Docente</th>
            <?php endif; ?>
            <th>Componente</th>
            <th>Curso</th>
            <th><?php echo $this->_config[0]['vars']['PNAT']; ?>
</th>
          </tr>
        </thead>
        <tbody>
          <?php $_from = $this->_tpl_vars['docentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['docente']):
?>
          <tr>
            <?php if (! isset ( $this->_tpl_vars['cedula'] )): ?>
              <td><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['docente']['cedula']), $this);?>
 - <?php echo ((is_array($_tmp=$this->_tpl_vars['docente']['fullname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
.<br/> Tels: <?php echo smarty_function_join(array('sep' => ",",'parts' => ((is_array($_tmp=($this->_tpl_vars['docente']['telefono']).";".($this->_tpl_vars['docente']['tel_celular']))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp))), $this);?>
; E-mail:<?php echo ((is_array($_tmp=$this->_tpl_vars['docente']['email'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
</td>
            <?php endif; ?>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['docente']['nombre_componente'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            <td><?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['docente']['nombre_grupo'],'controller' => 'cursos','action' => 'view','cod_curso' => $this->_tpl_vars['docente']['cod_curso']), $this);?>
</td>
            <td><?php echo $this->_tpl_vars['docente']['cod_programa']; ?>
</td>
         </tr>
          <?php endforeach; endif; unset($_from); ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
<?php endif; ?>