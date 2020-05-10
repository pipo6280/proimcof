$(".range-valor").livequery(function () {
	var options = jQuery.extend({
		grid_snap: true,
		type: 'single',
		max: 100000,
		step: 5000,	    
	    grid: true,
		min: 0,
	}, $(this).data);
	$(this).ionRangeSlider({
		grid_snap: options.grid_snap,
		type: options.type,
	    min: options.min,
	    max: options.max,
	    step: options.step,
	    grid: options.grid,
	    onFinish: function (data) {
            calcularPrecio();
        }
	});
});
$('.autosize').livequery(function () {
	$(this).autosize({append: "\n"});
});
$('.clockpicker').livequery(function () {
	$(this).clockpicker({
		'default': 'now',
	    placement: 'top',
	    align: 'left',
	    donetext: 'Done'
	});
});
$('.fecha-normal .input-group.date').livequery(function () {
	$(this).datepicker({
		todayBtn: "linked",
		keyboardNavigation: false,
	    forceParse: false,
	    calendarWeeks: true,
	    autoclose: true,
	    format: "dd-mm-yyyy",
	    language: 'es'
	});
});
$('.i-checks').livequery(function() {
	var options = jQuery.extend({
		cclass: 'icheckbox_square-green',
		rclass: 'iradio_square-green',
	}, $(this).data());
	$(this).iCheck({
		checkboxClass: options.cclass,
		radioClass: options.rclass,
	});
});
$('table.datatable').livequery(function() {
	Framework.setDataTable({
		object: $(this)
	});
});
$(".touchspin").livequery(function() {
	$(this).TouchSpin({
		decimals:2,
		step:0.1,
	    verticalbuttons: true,
	    buttondown_class: 'btn btn-white',
	    buttonup_class: 'btn btn-white'
	});
});
$(".touchspinNegative").livequery(function() {
	$(this).TouchSpin({
		min: -99,
		decimals:2,
		step:0.1,
	    verticalbuttons: true,
	    buttondown_class: 'btn btn-white',
	    buttonup_class: 'btn btn-white'
	});
});
$('.numero').livequery(function() {
	$(this).keypress(function(e) {
		var keynum = window.event ? window.event.keyCode : e.which;
		if ((keynum == 8) || (keynum == 46) || (keynum == 0) || (keynum == 13))
			return true;
		if (!/\d/.test(String.fromCharCode(keynum))) {
			// Materialize.toast('El valor para este campo debe ser numérico',
			// 2000);
			return false;
		}

	});
});
$('.letras').livequery(function() {
	$(this).keypress(function(e) {
		key = e.keyCode || e.which;
		tecla = String.fromCharCode(key).toLowerCase();
		letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
		especiales = "8-37-39-46";
		tecla_especial = false
		for ( var i in especiales) {
			if (key == especiales[i]) {
				tecla_especial = true;
				break;
			}
		}
		if (letras.indexOf(tecla) == -1 && !tecla_especial) {
			return false;
		}
	});
});
$('.file').livequery(function() {
	var _URL = window.URL || window.webkitURL;
	$(this).change(function(e) {
		var options = jQuery.extend({
			minimo : false,
			height : 60,
			width : 60
		}, $(this).data());
		var file, img;
		var object = $(this);
		if ((file = this.files[0])) {
			img = new Image();
			img.onload = function() {
				if (options.minimo) {
					if (this.width < options.width || this.height < options.height) {
						Framework.setAlerta('El archivo no cumple con el ancho y alto permitido ('+ options.width +' x '+ options.height +'): ' + file.name);
						$(object).val(null);
					}
				} else if (this.width > options.width || this.height > options.height) {
					Framework.setAlerta('El archivo no cumple con el ancho y alto permitido ('+ options.width +' x '+ options.height +'): ' + file.name);
					$(object).val(null);
				}
			};
			img.onerror = function() {
				Framework.setAlerta('El archivo no es permitido: ' + file.type);
				$(object).val(null);
			};
			img.src = _URL.createObjectURL(file);
		}
	});
});
/**
 * @tutorial funcion para evitar que ingresen un valor mayor a 100, a los campos con la clase porcentaje.
 * @author Rodolfo Perez ~~ pipo6280@gmail.com
 * @since 2015/06/21
 */
$('.porcentaje').livequery(function() {
	$(this).keyup(function(e) {
		var keynum = window.event ? window.event.keyCode : e.which;
		if ((keynum == 8) || (keynum == 46))
			return true;
		if (/\d/.test(String.fromCharCode(keynum))) {
			if ($(this).val() > 100) {
				$(this).val(100);
			}
		}
	});
});

/**
 * @tutorial selecciona todos los checkbox disponibles
 * @author Rodolfo Perez ~~ pipo6280@gmail.com
 * @since 2015/05/06
 */
$('#txtCheckAll').livequery(function() {
	$(this).click(function() {
		var object = $(this);
		$('input[type="checkbox"]').each(function() {
			$(this).prop('checked', $(object).prop('checked'));
		});
	});
});

/**
 * @tutorial cargar un menu lateral en un contenedor especifico, al hacer click
 * @author Rodolfo Perez ~~ pipo6280@gmail.com
 * @since 2015/10/07
 */
$('a.a_menu_horizontal_json').livequery(function() {
	$(this).click(function() {
		var object = $(this);
		var data = object.data();
		id_smenu = data.id_smenu;
		Framework.setLoadData({
			id_contenedor_body : data.contenedor,
			pagina : data.pagina,
			data : data
		});
		$(object).parents('ul').each(function() {
			$(this).find('li').removeClass('current');
		});
		$(object).parents('li').addClass('current');
	});
});

/**
 * @tutorial cargar el contenido de un menu lateral de forma automatica
 * @author Rodolfo Perez ~~ pipo6280@gmail.com
 * @since 2015/10/07
 */
$('ul.sky-mega-menu li:first-child a').livequery(function() {
	var object = $(this);
	var data = object.data();
	id_smenu = data.id_smenu;
	Framework.setLoadData({
		id_contenedor_body : data.contenedor,
		pagina : data.pagina,
		data : data
	});
	$(object).parents('li').addClass('current');
});

/**
 * @tutorial asignar la funcion de autocompletado a los elementos con la clase autocompletado
 * @author Rodolfo Perez ~~ pipo6280@gmail.com
 * @since 2015/10/07
 */
$('.autocompletado').livequery(function() {
	var object = $(this);
	Framework.setAutocompletado({
		inputText : object
	});
});

// Auto select 2
$(".select2-select").livequery(function() {
	var object = $(this);
	var data = object.data();
	// Removemos la clase inicial
	object.removeClass('select2-select');
	// valores por defecto
	var options = jQuery.extend({
		dropdownCssClass : 'select-dropdown',
		placeholder : "Seleccione",
		allowClear : true,
		width : '100%',
	// formatResult : Framework.setsetFormatResult,
	}, data);
	object.select2(options);
});
$(".chosen-select").livequery(function() {
	var object = $(this);
	var data = object.data();
	var options = jQuery.extend({
		placeholder : "Seleccione",
		width : '100%',
	}, data);
	object.chosen(options);
});
$('span.input-group-addon').livequery(function() {
	$(this).click(function() {
		$(this).next('.hasDatepicker').focus();
	});
});
$(".fecha-params").livequery(function() {
	var options = jQuery.extend({
		date_format : 'dd-mm-yy',
		change_month : true,
		change_year : true,
		animation : 'drop',
		default_date : '',
		range_year : '-100:+1',
		min_date : '',
		max_date : ''
	}, $(this).data());
	$(this).datepicker({
		yearRange : options.range_year,
		minDate : options.min_date,
		maxDate : options.max_date,
		showAnim : options.animation,
		changeMonth : options.change_month,
		changeYear : options.change_year,
		dateFormat : options.date_format,
		defaultDate : options.default_date,
		monthNames : [ 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre' ],
		monthNamesShort : [ 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic' ],
		dayNames : [ 'Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado' ],
		dayNamesShort : [ 'Dom', 'Lun', 'Mar', 'Mie', 'Juv', 'Vie', 'Sab' ],
		dayNamesMin : [ 'Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa' ],
		weekHeader : 'Sm'
	});
});
// Autofecha
$(".fecha").livequery(function() {
	var object = $(this);
	var data = object.data();
	// valores por defecto
	var options = jQuery.extend({
		dateFormat : "yy-mm-dd",
		changeMonth : true,
		changeYear : true,
		yearRange : '-100:+1'
	}, data);
	object.datepicker(options);
});

// Autofecha con hora
$(".fechahora").livequery(function() {
	var object = $(this);
	var data = object.data();
	// valores por defecto
	var options = jQuery.extend({
		dateFormat : "yy-mm-dd",
		changeMonth : true,
		changeYear : true,
		yearRange : '-100:+1',
	}, data);
	object.datetimepicker(options);
});

// AutoTimepo con hora y minutos
$(".horaminutos").livequery(function() {
	var object = $(this);
	object.timepicker();
})

$('.ckeditor-basic').livequery(function(){
	var options = jQuery.extend({
		name : $(this).attr('name'),
		full : false,
	}, $(this).data());
	for(name in CKEDITOR.instances) {
		CKEDITOR.instances[name].destroy(true); 
	}
	Framework.setAutoEditor(options);
});
// Asignar un ckeditor full
$('.ckeditor-full').livequery(function() {
	var options = jQuery.extend({
		name : $(this).attr('name'),
		full : true,
	}, $(this).data());
	for(name in CKEDITOR.instances) {
		CKEDITOR.instances[name].destroy(true); 
	}
	Framework.setAutoEditor(options);
});
// Auto select 2 con hidden autocompletado
$(".select2-autocomplete").livequery(function() {
	var object = $(this);
	var options = object.data();
	var options = jQuery.extend({
		control : '',
		select2 : 1,
		minimumInputLength : 1,
		placeholder : "Seleccione",
		data : ''
	}, options);
	object.select2({
		placeholder : options.placeholder,
		width : '100%',
		ajax : {
			url : "app/ajax/autocompletado.php?control="
					+ options.control + "&txtSelect2="
					+ options.select2 + '&' + options.data,
			dataType : 'json',
			delay : 250,
			data : function(params) {
				return {
					q : params.term, // search term
					page : params.page
				};
			},
			processResults : function(data, params) {
				// parse the results into the format expected by
				// Select2. since we are using custom formatting
				// functions we do not need to alter the remote
				// JSON data
				params.page = params.page || 1;
				return {
					results : data.results,
					pagination : {
						more : (params.page * 30) < data.total_count
					}
				};
			},
			cache : false
		},
		// let our custom formatter work
		escapeMarkup : function(markup) {
			return markup;
		},
		minimumInputLength : options.minimumInputLength,
		// omitted for brevity, see the source of this page
		templateResult : formatRepo,
		templateSelection : formatRepoSelection
	// omitted for brevity, see the source of this page
	});
});
$('.tooltipster').livequery(function(e) {
	if ($(this).attr('title') != '') {
		$(this).tooltipster({
			animation : 'fade',
			theme : 'tooltipster-light',
			delay : 200,
			contentAsHTML : true,
		});
	}
});
function formatRepo(repo) {
	if (repo.loading)
		return repo.text;
}

function formatRepoSelection(repo) {
	return repo.value;
}
var Plugins;
(function() {
	Plugins = {
		__construct : function() {
			this.setEventos();
		},
		setLoadTooltips : function() {
			$('.tooltipstered').livequery(function() {
				if($(this).attr('title') != '') {
					$(this).tooltipster({
						animation: 'fade',
		   			 	theme: 'tooltipster-light',
		   			 	delay: 200,
		   			 	contentAsHTML: true,
		   		 	});
		   	 	}
		    });
		},
		textCounter : function(field, countfield, maxlimit) {
			if ($(field).val().length > maxlimit)
				$(field).val($(field).val().substring(0, maxlimit));
			else
				countfield.value = maxlimit - $(field).val().length;
		},
		/**
		 * @tutorial Metodo Descripcion: ejecuta el proceso para agregar un menu a un perfil en particular
		 * @author Rodolfo Perez ~~ pipo6280@gmail.com
		 * @since 2015/10/07
		 * 
		 * @param options
		 */
		setPermisosShow : function(idPerfil) {
			$('#txtFilaMenu' + idPerfil).show();
			$('#txtMenu_' + idPerfil).removeAttr("onclick");
			$('#txtYn_view_' + idPerfil).prop('checked', true);
			$('#txtMenu_' + idPerfil).attr("onclick", "Plugins.setPermisosHide(" + idPerfil + ")");
		},
		/**
		 * @tutorial Metodo Descripcion: ejecuta el proceso para quitar
		 *           temporalmente un menu a un perfil en particular
		 * @author Rodolfo Perez ~~ pipo6280@gmail.com
		 * @since 2015/10/07
		 * 
		 * @param options
		 */
		setPermisosHide : function(idPerfil) {
			$('#txtFilaMenu' + idPerfil).hide();
			$('#txtMenu_' + idPerfil).removeAttr("onclick");
			$('#txtYn_view_' + idPerfil).prop('checked', false);
			$('#txtMenu_' + idPerfil).attr("onclick", "Plugins.setPermisosShow(" + idPerfil + ")");
		},
		setActivarGrillaPago : function(valor) {
			Framework.setLoadData({
				pagina : 'pago/gestion_pago',
				data : {
					txtId_representante : valor.id,
					txtNombre : valor.label
				}
			});
		},
		setDesactivarGrillaPago : function(valor) {
			$("#vistaPago").css('display', 'none');
		},
		formatRepoSelection : function (repo) {
			return repo.value;
		},
		formatRepo : function(repo) {
			if (repo.loading) return repo.text;
			var markup = 'Eminson';
			return markup;
		},
		/**
		 * @tutorial Metodo Descripcion: carga los eventos por defectos
		 * @author Rodolfo Perez ~~ pipo6280@gmail.com
		 * @since 2015/06/09
		 */
		setEventos : function() {
			
		}
	};
	Plugins.__construct();
})();


//Create plugin named setCase
(function($) {
	$.fn.setCase = function(settings) {
		// Defaults
		var config = {
			caseValue : 'Upper',
			changeonFocusout : false
		};

		// Merge settings
		if (settings)
			$.extend(config, settings);

		this.each(function() {
			// keypress event
			if (config.changeonFocusout == false) {
				$(this).keypress(function() {
					if (config.caseValue == "upper") {
						var currVal = $(this).val();
						$(this).val(currVal.toUpperCase());
					} else if (config.caseValue == "lower") {
						var currVal = $(this).val();
						$(this).val(currVal.toLowerCase());
					} else if (config.caseValue == "title") {
						var currVal = $(this).val();
						$(this).val(currVal.charAt(0).toUpperCase() + currVal.slice(1) .toLowerCase());
					} else if (config.caseValue == "pascal") {
						var currVal = $(this).val();
						currVal = currVal.toLowerCase().replace(
								/\b[a-z]/g, function(txtVal) {
									return txtVal.toUpperCase();
								});
						$(this).val(currVal);
					}
				});
			}
			// blur event
			$(this).change(function() {
				if (config.caseValue == "upper") {
					var currVal = $(this).val();
					$(this).val(currVal.toUpperCase());
				} else if (config.caseValue == "lower") {
					var currVal = $(this).val();
					$(this).val(currVal.toLowerCase());
				} else if (config.caseValue == "title") {
					var currVal = $(this).val();
					$(this).val(
							currVal.charAt(0).toUpperCase()
									+ currVal.slice(1).toLowerCase());
				} else if (config.caseValue == "pascal") {
					var currVal = $(this).val();
					currVal = currVal.toLowerCase().replace(/\b[a-z]/g,
							function(txtVal) {
								return txtVal.toUpperCase();
							});
					$(this).val(currVal);
				}
			});
		});
	};
})(jQuery);