<div class="ui-widget decorated non-printable">
  <h3><?php echo $title_for_layout?></h3>
  <div class="ui-form form-select-grupo" id="form-<?php echo camelize($title_for_layout)?>">
    <div class="ui-field">
      <label for="cod_programa"><?php echo html_PNAT()?></label>
      <?php echo html_select('cod_programa',TPrograma::toSQL())?>
    </div>
    <div class="ui-field">
      <label for="cod_curso">Curso</label>
      <?php echo html_select('cod_grupo', TGrupo::toSQL())?>
    </div>
    <div class="ui-button-bar">
      <button id="bt-<?php echo camelize($title_for_layout)?>">Consultar</button>
    </div>
    <?php if(!empty($links)) echo join(' | ', $links)?>
  </div>
</div>
