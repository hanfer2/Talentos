<div class='ui-widget decorated'>
  <h1>Reporte Detallado por Cursos por Niveles</h1>
  <h3>{$nombre_prueba} - {$nombre_curso}</h3>
  
  {*<?php if(!is_xhr()): ?>
   <div class="ui-toolbar">
        <?php
         $cod_programa = TTiposIcfes::programa($cod_prueba);
         $pruebas = TTiposIcfes::segunPrograma($cod_programa);
         $cant_pruebas = count($pruebas);
         $links_pruebas = array();
         for($i= 0; $i<$cant_pruebas; $i++) {
           if($pruebas[$i]['codigo']==$cod_prueba)
             continue;
           $links_pruebas[]=link_url_for($pruebas[$i]['nombre'], 'icfes', 'reporteComponentes',
              params(array('cod_prueba'=>$pruebas[$i]['codigo'],
                'componentes[tipo]'=>'detallado',
                'componentes[porNiveles]'=>'1')));
         }
         echo implode(' | ', $links_pruebas);
        ?><br/>
   <?php endif?>
  </div>*}
  <table class='table' id="table-icfes-reporteDetalladoPorNiveles">
    <thead>
      <tr>
        <th rowspan='2'>Curso</th>
        <th rowspan='2'>Nivel</th>
        <th rowspan='2'>Subnivel</th>
        <th colspan='{$_componentes|@count}'>Componentes</th>
      </tr>
      <tr>
      	{foreach from=$_componentes item=componente}
        <th>{$componente|upper|truncate:12}</th>
        {/foreach}
      </tr>
    </thead>
    <tbody>
    	{foreach from=$icfes_niveles key=codigo_curso item=superniveles}
      <tr>
        <th rowspan='{$_niveles|@count}'>
        	{link_to name=$superniveles.nombre_curso action=view cod_curso=$codigo_curso cod_prueba=$cod_prueba}
        </th>

				{foreach from=$superniveles.niveles key=supernivel item=niveles}
        	<th rowspan='{$niveles|@count}'> {$supernivel}</th>
        	{foreach from=$niveles key=nivel item=componentes}
        		<th style='text-align: left'>{$nivel}</th>
        		{foreach from=$componentes key=componente item=registro }
      			  <td title="Cantidad Estudiantes de {$superniveles.nombre_curso} para {$componente} en Nivel {$nivel} = {$registro}">
                <div class='porcentaje'>
                	{math equation="100 *  registro / cantidad"  registro=$registro cantidad=$clasificador->cant_estud.$cod_curso.$componente format="%.2f%%"}
                </div>
                <div class='ratio'>{"`$registro` / `$clasificador->cant_estud.$cod_curso.$componente`"}</div>
        			</td>
             {/foreach}
      			</tr>
          {/foreach}
        {/foreach}
      {/foreach}
    </tbody>
  </table><br/>
  <!-- Convenciones -->
  <table id='table-icfes-convencionesNiveles' class="table table-convenciones">
    <caption>CONVENCIONES</caption>
    <thead>
      <tr><th>Subnivel</th><th>Rango</th></tr>
    </thead>
    <tbody>
    	{foreach from=$_niveles key=id item=nivel}
          <tr><td>{$nivel}</td><td>{$rangos.$id[0]|string_format:"%.2f"} - {$rangos.$id[1]|string_format:"%.2f"}</td></tr>
			{/foreach}
  </table>
</div>
