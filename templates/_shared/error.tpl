<div class="ui-corner-all err-block msg-s{$size|default:8}">
		<h1><span class="ui-icon-alert"></span>{$title|default:"Registro No Hallado"}</h1>
		<div class="error-message msg-s7">
			<div class="err-content-msg ui-corner-all">{$message}</div>
		</div>
		{if isset($links)}
		<div class="ui-toolbar">{$links}</div>
		{/if}
</div>
