App.IPruebasController = {
	'index': function(){
		addListener_sysPruebas = function(){
			$("#link-sysPruebas").click(function(){
				$("#frm-sys-pruebas").slideToggle();
				return false;
			})
		};// fin listener
		
		addListener_nuevaPrueba= function(){
			
			$$("link-registrarPrueba").click(function(){
				$$("form-registrarPrueba").slideToggle(function(){
					if(!$(this).is(":visible")){
						$(".validity-modal-msg").remove()
						$("input", this).val("")
					}	
				})
				return false;
			})// fin click
		
			$$("bt-registrarPrueba").click(function(){
					$.validity.start()
					$(".required").require()
					var result = $.validity.end().valid
					if(result){
						$.post(url_for("create"), $(":field","#form-registrarPrueba").serialize(), function(){
							$$("bt-listadoDePruebas").click();
						})
					}
					return false;
			})//fin click
	 }; // fin listener
	 
	 addListener_chkVisibilidadPrueba = function(){
		 $(".chk-visibilidadPrueba").click(function(){
			 var _this = $(this);
				var cod_prueba = _this.parent("tr").find(":hidden").val();
				var visibility = _this.is(':checked');
				var nombre_prueba = _this.parents("tr").find(".nombre_prueba").html();
				$.wDialog("show");
				$.post(url_for('edit_visibility'), {'pr':cod_prueba, 'vis': (visibility)?'t':'f'}, function(html){
					$.wDialog("close");
					var msg = "Ahora la Prueba '"+nombre_prueba+"' "+ (visibility ? "" :"NO ") +"es VISIBLE";
					$.notify(msg);
				})
			});// fin click chk
	 }// fin listener;
	 
	 addListener_guardarConfiguraciones = function(){
		 var jqForm = $("#frm-sys-pruebas");
		 $("#bt-i_pruebas-guardarConfiguraciones").click(function(){
			 $.wDialog("show");
			 $.post(url_for("save_settings"), $(":field",jqForm).serialize(), function(){
				 $.wDialog("close");
				 $.notify("Configuraciones Guardadas");
				 jqForm.slideUp("fast");
			 });
		 });
	 };// fin listener
	
	addListeners = function(){
		addListener_sysPruebas();
		addListener_nuevaPrueba();
		addListener_chkVisibilidadPrueba();
		addListener_guardarConfiguraciones();
	};// fin addListeners
	
		$("#bt-listadoDePruebas").click(function(){
			$(".ajax-response").ajax_img();
			$.get(url_for(), {"cod_programa": $F("#cod_programa")}, function(html){
				$(".ajax-response").html(html)
				addListeners();
			})
		})// fin click
		
		addListeners();
	}
}
