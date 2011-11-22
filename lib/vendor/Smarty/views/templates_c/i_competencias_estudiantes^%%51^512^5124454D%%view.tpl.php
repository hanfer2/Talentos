<?php /* Smarty version 2.6.26, created on 2011-11-17 14:36:26
         compiled from ./modules/i_competencias_estudiantes/templates//view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', './modules/i_competencias_estudiantes/templates//view.tpl', 2, false),array('function', 'persona_url', './modules/i_competencias_estudiantes/templates//view.tpl', 10, false),array('function', 'url_for', './modules/i_competencias_estudiantes/templates//view.tpl', 17, false),array('function', 'math', './modules/i_competencias_estudiantes/templates//view.tpl', 35, false),array('modifier', 'count', './modules/i_competencias_estudiantes/templates//view.tpl', 30, false),array('modifier', 'escape', './modules/i_competencias_estudiantes/templates//view.tpl', 30, false),array('modifier', 'capitalize', './modules/i_competencias_estudiantes/templates//view.tpl', 30, false),array('modifier', 'string_format', './modules/i_competencias_estudiantes/templates//view.tpl', 34, false),)), $this); ?>
<?php if (is_blank ( $this->_tpl_vars['cod_prueba'] )): ?>
  <?php echo smarty_function_include_template(array('file' => 'simulacros_con_cuestionario','title' => 'Reporte Individual por Competencias'), $this);?>

  <div class="ajax-response" id='ajax-reporteIndividualCompetencias-prueba'></div>
<?php elseif (is_blank ( $this->_tpl_vars['cedula'] )): ?>
  <?php echo smarty_function_include_template(array('file' => "persona.form",'title' => 'Reporte Individual Por Competencias'), $this);?>

  <div class="ajax-response" id='ajax-reporteIndividualCompetencias-estudiante'></div>
<?php else: ?>
  <div class="ui-widget decorated">
    <h1>Reporte Individual Por Competencias</h1>
    <h2><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['cedula']), $this);?>
 - <?php echo $this->_tpl_vars['nombre_persona']; ?>
</h2>
    <h3><?php echo $this->_tpl_vars['nombre_prueba']; ?>
</h3>

    <?php if (empty ( $this->_tpl_vars['reporte'] )): ?>
    <p>No se hallaron registros de competencias para este participante en este prueba.</p>
    <?php else: ?>
    <div class="ui-toolbar">
      <a href="<?php echo smarty_function_url_for(array('controller' => 'i_cuestionarios_estudiantes','action' => 'view','cod_prueba' => $this->_tpl_vars['cod_prueba'],'cedula' => $this->_tpl_vars['cedula']), $this);?>
">Consultar Respuestas de esta Prueba</a> | 
    <a href="<?php echo smarty_function_url_for(array('controller' => 'icfes','action' => 'view','cod_prueba' => $this->_tpl_vars['cod_prueba'],'cedula' => $this->_tpl_vars['cedula']), $this);?>
">Consultar Icfes del Participante</a>
    <br/>
<a href="<?php echo smarty_function_url_for(array('controller' => 'i_cualitativos_estudiantes','action' => 'view','cod_prueba' => $this->_tpl_vars['cod_prueba'],'cedula' => $this->_tpl_vars['cedula']), $this);?>
">Reporte por Componentes Cualitativos</a>
    </div>
    <div>
      <table class="table" id="table-competencias_estudiantes-individual">
        <thead>
          <tr><th class="ui-state-default">Componente/Área</th><th class="ui-state-default">Competencia</th>
	       <th class="ui-state-default" title="Número de Respuestas Correctas">N&deg; Resp. Correctas</th><th class=" ui-state-default porcentaje total">%</th></tr>
        </thead>
          <?php $_from = $this->_tpl_vars['__componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente'] => $this->_tpl_vars['competencias']):
?>
          <tr>
            <td class="header-row" rowspan="<?php echo count($this->_tpl_vars['competencias']); ?>
"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['componente'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</td>
             <?php $_from = $this->_tpl_vars['competencias']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['competencia']):
?>
              <td><?php echo ((is_array($_tmp=$this->_tpl_vars['competencia']['nombre_competencia'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 (<?php echo $this->_tpl_vars['competencia']['cantidad_preguntas']; ?>
)</td>
              <?php $this->assign('cod_competencia', $this->_tpl_vars['competencia']['cod_competencia']); ?>
              <td><?php echo ((is_array($_tmp=$this->_tpl_vars['reporte'][$this->_tpl_vars['componente']][$this->_tpl_vars['cod_competencia']]['puntaje'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.0f") : smarty_modifier_string_format($_tmp, "%.0f")); ?>
</td>
	      <td class="total"><?php echo smarty_function_math(array('equation' => "x*100/y",'x' => $this->_tpl_vars['reporte'][$this->_tpl_vars['componente']][$this->_tpl_vars['cod_competencia']]['puntaje'],'y' => $this->_tpl_vars['competencia']['cantidad_preguntas'],'format' => "%.2f%%"), $this);?>
</td>
              </tr>
              <?php endforeach; endif; unset($_from); ?>
          
          <?php endforeach; endif; unset($_from); ?>
       </table>
    </div>

    <?php endif; ?>
  </div>
<?php endif; ?>