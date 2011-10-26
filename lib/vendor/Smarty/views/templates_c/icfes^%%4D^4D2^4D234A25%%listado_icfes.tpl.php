<?php /* Smarty version 2.6.26, created on 2011-07-06 16:53:40
         compiled from ./modules/icfes/templates//listado_icfes.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', './modules/icfes/templates//listado_icfes.tpl', 2, false),array('function', 'persona_url', './modules/icfes/templates//listado_icfes.tpl', 31, false),array('function', 'math', './modules/icfes/templates//listado_icfes.tpl', 45, false),array('modifier', 'escape', './modules/icfes/templates//listado_icfes.tpl', 32, false),array('modifier', 'number_format', './modules/icfes/templates//listado_icfes.tpl', 43, false),)), $this); ?>
<?php if (! isset ( $this->_tpl_vars['cod_prueba'] )): ?>
	<?php echo smarty_function_include_template(array('file' => 'programas_icfes','title' => 'Reporte Icfes Estudiantes'), $this);?>

	<div class='ajax-response' id="ajax-reporteIcfesEstudiantes"></div>
<?php else: ?>
	<div class='ui-widget decorated'>
		<h1>Listado de Puntajes Icfes</h1>
		<h2><?php echo $this->_tpl_vars['nombre_prueba']; ?>
</h2>
		<table class="table dataTable" id="table-listadoIcfes">
		<thead>
			<tr>
				<th >Doc. Id.</th>
        <th >Nombre</th>
        <th class="column-hidden" >Email</th>
        <th class="column-hidden">Tel&eacute;fono</th>
				<th >Registro Icfes</th>
				<th >Lenguaje</th>				
        <th >Matem&aacute;ticas</th>				
        <th >Sociales</th>				
        <th >Filosof&iacute;a</th>				
        <th >Biolog&iacute;a</th>				
        <th >Qu&iacute;mica</th>				
        <th >F&iacute;sica</th>				
        <th >Idioma</th>				
        <th title="Interdisciplinar" >Interdisc.</th>				
        <th class="total">Promedio</th>
			</tr>
			</thead>
			<tbody>
			<?php $_from = $this->_tpl_vars['icfes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['l_icfes']):
?>
				<tr>
					<td><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['l_icfes']['cedula']), $this);?>
</td>
					<td><?php echo ((is_array($_tmp=$this->_tpl_vars['l_icfes']['nombrecompleto'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
          <td><?php echo $this->_tpl_vars['l_icfes']['email']; ?>
</td>
          <td><?php echo $this->_tpl_vars['l_icfes']['telefono']; ?>
</td>
          <td><?php echo $this->_tpl_vars['l_icfes']['num_registro_icfes']; ?>
</td>
					<td><?php echo $this->_tpl_vars['l_icfes']['lenguaje']; ?>
</td>          
          <td><?php echo $this->_tpl_vars['l_icfes']['matematica']; ?>
</td>          
          <td><?php echo $this->_tpl_vars['l_icfes']['sociales']; ?>
</td>          
          <td><?php echo $this->_tpl_vars['l_icfes']['filosofia']; ?>
</td>          
          <td><?php echo $this->_tpl_vars['l_icfes']['biologia']; ?>
</td>          
          <td><?php echo $this->_tpl_vars['l_icfes']['quimica']; ?>
</td>          
          <td><?php echo $this->_tpl_vars['l_icfes']['fisica']; ?>
</td>          
          <td><?php echo ((is_array($_tmp=$this->_tpl_vars['l_icfes']['idioma'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2) : number_format($_tmp, 2)); ?>
</td>         
          <td><?php echo $this->_tpl_vars['l_icfes']['interdisciplinar']; ?>
</td>          
          <td class="total"><?php echo smarty_function_math(array('equation' => "(l+m+s+f+b+q+c+i+d)/9",'format' => "%.2f",'l' => $this->_tpl_vars['l_icfes']['lenguaje'],'m' => $this->_tpl_vars['l_icfes']['matematica'],'s' => $this->_tpl_vars['l_icfes']['sociales'],'f' => $this->_tpl_vars['l_icfes']['filosofia'],'q' => $this->_tpl_vars['l_icfes']['quimica'],'c' => $this->_tpl_vars['l_icfes']['fisica'],'i' => $this->_tpl_vars['l_icfes']['idioma'],'d' => $this->_tpl_vars['l_icfes']['interdisciplinar']), $this);?>
</td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
			</tbody>
		</table>
		<div>		
<?php endif; ?>