App.ProgramasController={
	"_aAssignedComponents": {'added':[], "removed":[]},
	"_aEditComponentsDialogs":[],
	/************************************ ACTIONS *******************************************************/
	"_actions":{
		"actionEditComponentList": function(ev){
			var icon = this;
			var params ={"semestre": ev.data.semestre, "cod_programa": ev.data.cod_programa};
			var programasController = App.ProgramasController;
			var dialog = programasController._aEditComponentsDialogs[params.semestre];
			
			if(dialog == undefined){
				var nDialogWidth = 670;
				var oDialogOptions={
					'width': nDialogWidth,
					'title': "Asignación de Componentes | PNAT "+params.cod_programa+"-"+params.semestre,
					'buttons': {
						"Cancelar": function(){ 
							delete programasController._aEditComponentsDialogs[params.semestre];
							jQuery(this).dialog("destroy")
						},
						"Aceptar": function(){
							var postParams = jQuery.extend({},params,{'componentes': programasController._aAssignedComponents})
							if(postParams.componentes.added.length == 0 && postParams.componentes.removed.length == 0 ){
								jQuery(this).dialog('close')
								return false;
							}
							var dialog = $(this).parents(".ui-dialog")
							dialog.processingIcon("show");
							jQuery.post(url_for('programas_componentes','add'),postParams, function(html){
								dialog.processingIcon("remove");
								//location.reload();
							})
							return false;
						}
					}
				}
				$.waitLoading.show(icon);
				dialogWidget = jQuery("<div/>").appendTo(jQuery(".dialog-componentes-edit", "#wrapper-programas-componentes-"+params.semestre));
				dialogWidget.load(
					url_for("programas_componentes","edit"), params, 
					function(){
						programasController._aEditComponentsDialogs[params.semestre] = dialogWidget.dialog(oDialogOptions);
						$.waitLoading.close(icon);
						jQuery(".list-componentes-disponibles .item-list",dialogWidget).click(programasController._actions.actionAddComponent)
						jQuery(".list-componentes-asignados .ui-icon-close",dialogWidget).click(programasController._actions.actionRemoveComponent)
					})
			}else{
				dialog.dialog('open');
			}
			
		},
		"actionAddComponent": function(ev){
			var programasController = App.ProgramasController;
			var $item = jQuery(this);
			var dialog = $item.parents(".widget-programas-componentes-edit");
			
			var cod_componente = jQuery(".cod_componente-value", $item).html()
			var nombre_componente = jQuery(".nombre_componente-value", $item).html()
			
			programasController._aAssignedComponents.added.push(cod_componente);
			
			var $addedComponentList = jQuery("ul.list-componentes-adicionados", dialog);
			
			if($addedComponentList.length == 0){
				$addedComponentList = jQuery("<ul class='list-componentes basic-list list-componentes-adicionados'/>")
															.insertAfter(jQuery(".list-componentes-asignados", dialog))
			}
			
			var sListItemsClassname = "dark-highlighted-text";
			var sCloseIconTag = "<span class='ui-icon ui-icon-close inline-icon right-icon clickable'/>";
			
			$item.slideUp(); 
			$addedComponentList.append("<li class='"+sListItemsClassname+"'> "+nombre_componente+sCloseIconTag+"</li>")
												 .find(".ui-icon-close").click({"cod_componente":cod_componente}, programasController._actions.actionRemoveAddedComponent)
		},
		"actionRemoveAddedComponent":function(ev){
			var cod_componente = ev.data.cod_componente;
			var $item = jQuery(this).parent();
			var dialog = $item.parents(".widget-programas-componentes-edit");

			var $availableComponent = dialog.find(".list-componentes-disponibles .componente-"+cod_componente)
			var programasController = App.ProgramasController;
			
			programasController._aAssignedComponents.added.erase(cod_componente);
			$item.remove();
			$availableComponent.slideDown();
			
			if(programasController._aAssignedComponents.added.length == 0){
				jQuery("ul.list-componentes-adicionados", dialog).remove()
			}
		},
		"actionRemoveComponent": function(ev){
			var programasController = App.ProgramasController;
			var $icon = $(this)
			var $item = $icon.parent()
			var dialog = $item.parents(".widget-programas-componentes-edit");
			
			var cod_componente = jQuery(".cod_componente-value", $item).html();
			var nombre_componente = jQuery(".nombre_componente-value", $item).html()
			
			programasController._aAssignedComponents.removed.push(cod_componente);
			
			var $availableComponentsList = jQuery(".list-componentes-disponibles",dialog)
			
			var sListItemsClassname = "dark-highlighted-text item-list ui-corner-all";
			var sUndoIconTag = "<span class='ui-icon ui-icon-arrowreturn-1-w inline-icon right-icon clickable'/>";
			
			$item.slideUp(); 
			$availableComponentsList.prepend("<div class='"+sListItemsClassname+"'> "+nombre_componente+sUndoIconTag+"</div>")
						.find(".ui-icon-arrowreturn-1-w").click({"cod_componente":cod_componente}, programasController._actions.actionUndoRemovedComponent)
			
		},
		"actionUndoRemovedComponent":function(ev){
			var cod_componente = ev.data.cod_componente;
			var $item = jQuery(this).parent();
			var dialog = $item.parents(".widget-programas-componentes-edit");

			var $availableComponent = dialog.find(".list-componentes-asignados .componente-"+cod_componente)
			console.log($availableComponent, cod_componente)
			var programasController = App.ProgramasController;
			
			programasController._aAssignedComponents.removed.erase(cod_componente);
			$item.remove();
			$availableComponent.slideDown();
			
			if(programasController._aAssignedComponents.removed.length == 0){
				jQuery("ul.list-componentes-adicionados", dialog).remove()
			}
		}
	},
	/************************************ FUNCTIONS *******************************************************/
	"_fnShowComponentList": function(cod_programa){
			var programasController = this;
			jQuery(".placeholder-listado-componentes").each(function(){
				var id = this.id
				var semestre = id.substring(id.lastIndexOf("-")+1)
				var params = {"cod_programa":cod_programa,"semestre":semestre};
				jQuery(this).ajax_img()
					.load(url_for("programas_componentes","index"), params,
								function(){
									jQuery(".edit-icon", this).click(params, programasController._actions.actionEditComponentList)
								});
			})
		},
	"view": function(){
			var cod_programa = $("#sp-value-cod_programa").html();
			this._fnShowComponentList(cod_programa);
      $("#link-cerrar").click(function(){
        return confirm("Esta seguro que desea cerrar este programa?");
      })
		},
  'configurar': function(){
    var jqTableCupos = $("#table-cuposCursos");
    $("tbody input", jqTableCupos).change(function(){
      var aCuposGrupos = [];
      var aCuposTotal = 0;
      jqTableCupos.find("tbody tr").each(function(){
        $("input", this).each(function(idx){
          var _this = $(this);
          var sValue = this.value;
          var iValue = parseInt(sValue);  
          if(iValue == "" || isNaN(iValue))
            return true;
            
          if(aCuposGrupos[idx] == undefined)
            aCuposGrupos[idx] = 0;
            
         
          aCuposGrupos[idx] += iValue;
          aCuposTotal += iValue;
        })
      });
      $("tfoot tr:first th:gt(0)").each(function(idx){
        this.innerHTML = aCuposGrupos[idx]
      })
      var jqTotal = $("tfoot tr:last th").html(aCuposTotal+" estudiantes")
      var jqBtCrearCursos = $("#bt-crearCursos");
      if(aCuposTotal == 1500){
        jqTotal.removeClass("ui-state-error-text");
        jqTotal.append(" <span style='color: green; font-size: 14pt'>&#10004;</span>")
        jqBtCrearCursos.removeAttr('disabled');
      }else{
        jqTotal.addClass("ui-state-error-text");
        jqTotal.prepend("<span class='ui-icon ui-icon-alert inline-icon'/>")
        jqBtCrearCursos.attr('disabled','disabled');
      }
   }).filter(":first").change();
  }
}

$(function(){
	
	var form=$$("form-registrarNuevoPrograma")

	$("#link-registrarNuevoPlan").click(function(){
    $("input.date",form).val("");
    $(".validity-modal-msg").remove();
    $("#form-registrarNuevoPrograma").slideToggle(500);
    return false;
  })
	if(form.length > 0)
		$("input.date",form).datepicker({"minDate":new Date(2009,1,1)});
	
	var Programa={
		siguienteCodigo: function(){
			var talentos = $(".dataTable").getColumn(0);
			if($.isArray(talentos))
				return talentos.max() + 1;
			return null;
		}
	}
	$("#programa_codigo").val(new String(Programa.siguienteCodigo()).pad(3,'0','left'))
	$("#programa_nombre").val("TALENTOS "+Programa.siguienteCodigo())
	$("#programa_fecha_inicio_1").change(function(){
		$("#programa_fecha_cierre_1").val(new Date($F(this)).addWeeks(16).toString('yyyy-MM-dd'))
	})
	$("#programa_fecha_inicio_2").change(function(){
		$("#programa_fecha_cierre_2").val(new Date($F(this)).addWeeks(16).toString('yyyy-MM-dd'))
	})

	function validarNuevoPrograma(){$.validity.start()
		$("input",form).require().nonHtml()
		$("#programa_fecha_cierre_1").greaterThan(new Date($F("#programa_fecha_inicio_1")))
		$("#programa_fecha_inicio_2").greaterThan(new Date($F("#programa_fecha_cierre_1")))
		$("#programa_fecha_cierre_1").greaterThan(new Date($F("#programa_fecha_inicio_2")))
		var result=$.validity.end()
		return result.valid;
	}
	$("#bt-registrarNuevoPrograma").click(function(){if(validarNuevoPrograma())
	$.post(url_for('programas','add'),$("input, select",form).serialize(),function(html){jAlert(html)})})
	
  //TODO permitir modificar los valores
 // $("tbody input").attr('readonly','readonly')
})
