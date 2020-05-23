var globalAppi = {};
Framework = function() {
	return {
		setLoadData: function(options) {
			var options = jQuery.extend({
				pagina: '',
				id_contenedor_header: 'title_content',
				id_contenedor_body: 'main_content',
				success: function() {},
				type: 'POST',
				dataType: 'json',
				insertType: 'html',
				data: {},
				loading: true,
			}, options);
			
			if (typeof (id_smenu) === "undefined") { id_smenu = false; }
			if (typeof (txtAjax) === "undefined") { txtAjax = true; }
			if (typeof (options.data) === "object") {
				if (!options.data.id_smenu && id_smenu) { options.data.id_smenu = id_smenu; }
			} else if (id_smenu) { options.data += '&id_smenu=' + id_smenu; }
			
			if (typeof (options.data) === "object") {
				if (!options.data.txtAjax && txtAjax) { options.data.txtAjax = txtAjax; }
			} else if (txtAjax) { options.data += '&txtAjax=' + txtAjax; }
			if (options.loading) { var loading = Framework.setLoading(); }
			
			Framework.setCloseTooltips();			
			
			$.ajax({
				type: options.type,
				dataType: options.dataType,
				url: options.pagina,
				data: options.data,
				success: function(data) {
					switch (options.dataType) {
						case 'json': {
							var data = jQuery.extend({
								contenido: '',
								error: false,
								titulo: null,
							}, data);
							if (data.error) {
								Framework.setAlerta({
									title: 'Error en la transacción realizada',
									contenido: data.error,
									type: 'error',
								});
								if (loading) {
									loading.remove();
								}
								return false;
							}
							// Si se definio un contenedor para el titulo mostramos el contenido retornado
							if (options.id_contenedor_header && data.titulo) {
								$('#' + options.id_contenedor_header).html( data.titulo);
							}
							// Si se definio un contenedor para el body mostramos el contenido retornado
							if (options.id_contenedor_body) {
								// Si el contenedor es un objeto, lo cargamos sin tratarlo como un id
								if (typeof (options.id_contenedor_body) == 'object') {
									Framework .InsertType({
										type: options.insertType,
										contenedor: $(options.id_contenedor_body),
										contenido: data.contenido
									});
								} else {
									Framework.setInsertType({
										type: options.insertType,
										contenedor: $('#' + options.id_contenedor_body),
										contenido: data.contenido
									});
								}
							}
							// Revisamos si la respuesta ajax nos retorno scripts para cargarlos
							if (data.script) {
								if (typeof (data.script) == 'object') {
									$.each(data.script, function(index, value) {
										Framework.setAutoLoadJS({
											src: value
										});
									});
								} else {
									Framework.setAutoLoadJS({
										src: data.script
									});
								}
							}	
							if (data.css) {
								if (typeof (data.css) == 'object') {
									$.each(data.css, function(index, value) {
										Framework.setAutoLoadCss({
											src: value
										});
									});
								} else {
									Framework.setAutoLoadCss({
										src: data.css
									});
								}
							}	
						}
						break;
						case 'html': {
							// Si el contenedor es un objeto, lo cargamos sin tratarlo como un id
							if (typeof (options.id_contenedor_body) == 'object') {
								Framework.setInsertType({ 
									type: options.insertType,
									contenedor: $(options.id_contenedor_body),
									contenido: data
								});
							} else {
								Framework.setInsertType({
									type: options.insertType,
									contenedor: $('#' + options.id_contenedor_body),
									contenido: data
								});
							}
						}
						break;
					}
					if (loading) {
						loading.remove();
					}
					options.success(data);
				},
				error: function(obj, typeError, text, data) {
					if (loading) {
						loading.remove();
					}
					Framework.setAlerta({
						type: 'error',
						title: 'Error en la transacción realizada',
						contenido: '<span>' + obj.responseText + '</span>'
					});
				},
			});
		},
		setAutoLoadJS: function(options) {
			var options = jQuery.extend({
				src: '',
				id: options.src
			}, options);
			var ele = document.getElementById(options.id); // ahora el nombre
			if (ele == undefined) {
				var tagjs = document.createElement("script");
				tagjs.setAttribute("type", "text/javascript");
				tagjs.setAttribute("id", options.id);
				tagjs.setAttribute("src", options.src);
				document.getElementsByTagName("head")[0].appendChild(tagjs);
			}
		},
		setAutoLoadCss: function(options) {
			var options = jQuery.extend({
				src: '',
				id: options.src
			}, options);
			var ele = document.getElementById(options.id); // ahora el nombre
			if (ele == undefined) {
				var tagjs = document.createElement("link");
				tagjs.setAttribute("type", "text/css");
				tagjs.setAttribute("rel", "stylesheet");
				tagjs.setAttribute("id", options.id);
				tagjs.setAttribute("src", options.src);
				document.getElementsByTagName("head")[0].appendChild(tagjs);
			}
		},
		setInsertType: function(options) {
			var options = jQuery.extend({
				type: 'html',
				contenedor: '',
				contenido: ''
			}, options);
			switch (options.type) {
				case 'html': {
					options.contenedor.html(options.contenido);
				}
				break;	
				case 'append': {
					options.contenedor.append(options.contenido);
				}
				break;	
				case 'before': {
					options.contenedor.before(options.contenido);
				}
				break;	
				case 'after': {
					options.contenedor.after(options.contenido);
				}
				break;
			}
		},
		setLoading: function() {
			// funcion para bloquear la pantalla mientras se ejecuta una accion
			var div = '<div id="loading-page"></div>';
			return $(div).appendTo('body');
		},
		// Funcion para abrir un dialogo
		setAutoDialog: function(options) {
			var options = jQuery.extend({
				title: 'Dialogo',
				modal: true,
				width: 'auto',
				height: 'auto',
				maxHeight: false,
				maxWidth: false,
				minHeight: false,
				minWidth: false,
				resizable: true,
				hide: 'slide',
				contenido: false,
				closeOnEscape: false,
				id_dialog: 'Dialog-Form',
				position: {
					my: "center",
					at: "center",
					of: window,
					collision: "fit",
					using: function(pos) {
						var topOffset = $(this).css(pos).offset().top;
						if (topOffset < 0) {
							$(this).css("top", pos.top - topOffset);
						}
					}
				},
				data: {},
				pagina: '',
				funcionOnLoad: function() {},
				dataType: 'json',
				buttons: {
					Cerrar: function() {
						$(this).dialog("close")
					}
				},
				close: function() {}
			}, options);
			if ($('#' + options.id_dialog).length == 0) {
				var Dialog = '<div id="' + options.id_dialog + '"></div>';
				// Insertamos el dialog al body del documento
				$('body').append(Dialog);
			}
			if (options.contenido) {
				$('#' + options.id_dialog).html(options.contenido);
				// Finalemente Abrimos el dialog
				$("#" + options.id_dialog).dialog(options);
				// Funcion q se ejecuta al abrir el dialog
				options.funcionOnLoad()
				// setTimeout(function(){options.funcionOnLoad()},1500);
			} else { 
				options.id_contenedor_body = options.id_dialog;
				options.success = function() {
					// Finalemente Abrimos el dialog
					$("#" + options.id_dialog).dialog(options);
					options.funcionOnLoad();
				}
				Framework.setLoadData(options);
			}
		},
		setFormat: function(options) {
			// Funcion para dar formato a una cadena, puede ser float, string etc
			var options = jQuery.extend({
				valor: 0,
				formato: 'float'
			}, options);
			switch (options.formato) {
				case 'float': {
					var valor = parseFloat(options.valor);
					if (isNaN(valor)) {
						valor = 0;
					}
				}
				break;
			}
			return valor;
		},
		setAutoEditor: function(options) {
			// Valores por defecto del ckeditor
			var options = jQuery.extend({
				name: 'txtDto-txtContenido',
				height: 700,
				full: true,
			}, options);
			if (options.full) {
				CKEDITOR.replace(options.name, {
					language: 'es',
			    	height: options.height,
			    	filebrowserBrowseUrl: SITE_URL + 'app/lib/filemanager/dialog.php?type=2&editor=ckeditor&lang=es&fldr=',
			    	filebrowserUploadUrl: SITE_URL + 'app/lib/filemanager/dialog.php?type=2&editor=ckeditor&lang=es&fldr=',
			    	filebrowserImageBrowseUrl: SITE_URL + 'app/lib/filemanager/dialog.php?type=1&editor=ckeditor&lang=es&fldr=',
				});
				CKEDITOR.config.toolbarGroups = [
     				{ name: 'document', groups: [ 'mode', 'document', 'doctools'] },
     				{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
     				{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
     				'/',
     				{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
     				{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
     				{ name: 'links', groups: [ 'links' ] },
     				{ name: 'insert', groups: [ 'insert' ] },
     				'/',
     				{ name: 'styles', groups: [ 'styles' ] },
     				{ name: 'colors', groups: [ 'colors' ] },
     				{ name: 'tools', groups: [ 'tools' ] },
     				{ name: 'others', groups: [ 'others' ] },
     				{ name: 'about', groups: [ 'about' ] }
     			];
				CKEDITOR.config.contentsCss = [ 
                       SITE_URL + 'public/plugins/bootstrap/css/bootstrap.min.css',
                       SITE_URL + 'public/css/style.css'
                ];
			} else {
				CKEDITOR.replace(options.name, {
					language: 'es',
			    	height: options.height
				});
				CKEDITOR.config.toolbar = [
		    		{ name: 'document', items: [ 'Source', '-', 'Preview', 'Print'] },
		    		{ name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
		    		{ name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
		    		'/',
		    		{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
		    		{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'] },
		    		{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
		    		{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
		    		'/',
		    		{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
		    		{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
		    		{ name: 'about', items: [ 'About' ] }
		    	];
			}
			CKEDITOR.config.allowedContent = true;
			CKEDITOR.config.extraAllowedContent = 'span;ul;li;a;table;td;style;*[id];*(*);*{*};ul li div(*);';
		},
		setAutoSuma: function(options) {
			// Funcion que me suma los valores de una clase definida, y me retorna el valor en un contenedor o como texto
			var options = jQuery.extend({
				clase 			: 'suma',
				contenedorId 	: false,
				contenedorType 	: 'html',
				inputType 		: 'checkbox',
				symbol 			: '$',
				funcionConValor: function() {
				},
				funcionSinValor: function() {
				}
			}, options);
			var total = 0;
			$('.' + options.clase).each(function() {
				var object 	= $(this);
				var valor 	= 0;
				switch (options.inputType) {
					case 'text': {
						valor = Framework.setFormat({
							valor: object.val()
						});
					}
					break;
					case 'checkbox': {
						if (object.is(':checked')) {
							valor = Framework.setFormat({
								valor: object.val()
							});
						}
					}
					break;
				}
				total += valor;
			});
			if (total > 0) {
				options.funcionConValor(total)
			} else {
				options.funcionSinValor(total)
			}
			if (options.contenedorId) {
				switch (options.contenedorType) {
					case 'text': {
						$('#' + options.contenedorId).val(total);
					}
						break;
					case 'html': {
						$('#' + options.contenedorId).html(
								options.symbol + '' + total);
					}
					break;
				}
			} else {
				return total;
			}
		},
		setAutocompletado: function(options) {
			if (options.inputText && options.inputText.length > 0) {
				var data = jQuery.extend({
					click: true
				}, options.inputText.data());
				var combo_id = '';
				if (typeof ($(options.inputText).attr('id')) !== "undefined") {
					combo_id = options.inputText.attr('id');
				}				
				var options = jQuery.extend({
					inputText: false,
					inputTextValue: options.inputText.val(),
					inputHiddenId: data.input_hidden_id,
					inputHiddenName: data.input_hidden_name,
					inputHiddenValue: data.input_hidden_value,
					control: data.control,
					click: data.click,
					data: data.data,
					check: data.check,
					checkData: data.check_data,
					checkTitle: data.check_title,
					onSearch: function() {
						if (data.on_search) {
							eval(data.on_search + '()');
						}
					},
					onSelect: function(term) {
						if (data.on_select) {
							var arrayTerm = '';
							$.each(term, function(index, value) {
								arrayTerm 	+= index + ':"' + value + '",';
							});
							$.each(data, function(index, value) {
								index = index.replace('-', '_');
								arrayTerm 	+= index + ':"' + value + '",';
							});
							var onSelect = data.on_select.split(';');
							$.each(onSelect, function(index, value) {
								jQuery.globalEval(value + '({' + arrayTerm + '}, "' + combo_id + '")');
							})
						}
					}
				}, options);				
				if (!options.data) {
					options.data = '';
				}
				// Asignamos la clase al input text, para que se muestre como un campo de busqueda
				$(options.inputText).addClass('search_txt');
				// Creamos una funcion para limpiar el autocompletado
				var clearAutocompletado = function() {
					options.inputText.val('');
					inputHidden.val(null);
					options.onSearch();
				}
				// Creamos la ruta del source principal
				var source = SITE_URL + "app/ajax/autocompletado.php?control=" + options.control + "&condicion=" + options.data;
				// Creamos un hidden, que alamcenara el id del registro al seleccionarlo
				var idHidden = '';
				var nameHidden = '';
				var valueHidden = '';
				// Si se definio un id
				if (options.inputHiddenId) {
					idHidden = 'id="' + options.inputHiddenId + '"';
				}
				// Si se definio un nombre
				if (options.inputHiddenName) {
					nameHidden = 'name="' + options.inputHiddenName + '"';
				}
				// Si se definio un value
				if (options.inputHiddenValue) {
					valueHidden = 'value="' + options.inputHiddenValue + '"';
				}
				var hidden = '<input type="hidden" ' + idHidden + ' ' + nameHidden + ' ' + valueHidden + '>';
				// Lo incluiemos despues de la caja de texto del autocompletado
				options.inputText.after(hidden);
				// Almacenamos en una variable el objeto hidden recien creado para q sea mas facil el manejo
				var inputHidden = options.inputText.next('INPUT');
				//Checkbox
				if (options.check) {
					if (!options.checkData) {
						options.checkData = '';
					}
					if (!options.checkTitle) {
						options.checkTitle = 'Todos';
					}
					// Creamos la ruta del source a ejecutar cuando se checkea el checkbox
					var sourceCheck = SITE_URL + "app/ajax/autocompletado.php?control=" + options.control + "&condicion=" + options.checkData;
					// Creamos un checkbox en caso de haberse solicitado
					var checkbox = '<input type="checkbox" title="' + options.checkTitle + '">';
					inputHidden.after(checkbox);
					// Almacenamos en una variable el objeto checkbox recien creado para q sea mas facil el manejo
					inputCheckbox = inputHidden.next();

					// Adicionamos el evento click, para activar la busqueda, del checkbox
					inputCheckbox.on('click', function() {
						var object = $(this);
						if (object.is(':checked')) {
							clearAutocompletado();
							options.inputText.autocomplete("option", "source", sourceCheck);
						} else {
							clearAutocompletado();
							options.inputText.autocomplete("option", "source", source);
						}
					});
				}
				options.inputText.autocomplete({
					delay: 600,
					source: source,
					search: function() {
						var term = Framework.setAutoExtractLast( this.value );
						if ( term.length < 3 ) {
							return false;
						}
						inputHidden.val(null);// blanqueamos el hiden
						options.onSearch();
			        },
			        focus: function() {			        	
			        	return false;
			        },
					select: function(event, ui) {
						inputHidden.val(ui.item.id);// cargamos el nuevo valor al hiden
						options.onSelect(ui.item, event);// Ejecutamos la funcion al seleccionar el registro asignamos el title al buscador
						options.inputText.attr('title', ui.item.value);
					}
				}).data("ui-autocomplete")._renderItem = function( ul, item ) {
					return $( "<li></li>" ).data( "item.autocomplete", item ).append( (item.icon != undefined ? item.icon: item.label)  ).appendTo( ul );
				};
				// Adicionamos comportamientos de click y keyup, a la caja de texto
				options.inputText.on({
					click: function(event) {
						if (options.click) {
							clearAutocompletado();
						}
					},
					keyup: function() {
						if (options.inputText.val() == '') {
							inputHidden.val(null);
						}
					}
				});
			} else {
				Framework.setAlerta({
					contenido: 'No se definio un objeto válido para el autocompletado',
					type: 'error',
				});
			}
		},		
		setAutoExtractLast: function( term ) {
			return Framework.setAutoSplit( term ).pop();
		},
		setAutoSplit: function( val ) {
			return val.split( /,\s*/ );
		},
		// Funcion para checkear o descheckear todos los checkbox de una clase en particular
		setAutoCheck: function(options) {
			var options = jQuery.extend({
				object 		: '',
				childClass: 'autoCheckeado',
				activeClass: 'resaltado',
				parents 	: 'tr'
			}, options);
			if ($(options.object).is(':checked')) {
				$('.' + options.childClass).attr("checked", true);
				$('.' + options.childClass).parents(options.parents).addClass(options.activeClass)
			} else {
				$('.' + options.childClass).attr("checked", false);
				$('.' + options.childClass).parents(options.parents).removeClass(options.activeClass)
			}
		},
		// Funcion para mostrar un mensaje en pantalla(reemplaza la funcion primitiva de alert)
		setAlerta: function(options) {
			if (typeof (options) == 'string') {
				options = {
					contenido : options
				}
			}
			var options = jQuery.extend({
				contenido: '',
				callback: function() {},
				title: 'Mensaje',
				id: 'dialog-message'
			}, options);
			Framework.setAutoDialog({
				id_dialog: options.id,
				contenido: options.contenido,
				title: options.title,
				position: {
					my: "center",
					at: "center",
					of: window,
					collision: "fit",
					using: function(pos) {
						var topOffset = $(this).css(pos).offset().top;
						if (topOffset < 0) {
							$(this).css("top", pos.top - topOffset);
						}
					}
				},
				buttons: {
					'Aceptar': function() {
						options.callback();
						$(this).remove();
					}
				}
			});
		},
		setSuccess: function(message, options) {
			options = jQuery.extend({
				type: 'success'
			}, options);
			toastr[options.type](message);
			toastr.options = jQuery.extend({
				"closeButton": true,
				"debug": false,
				"progressBar": true,
				"preventDuplicates": false,
				"positionClass": "toast-top-full-width",
				"onclick": null,
				"showDuration": "400",
				"hideDuration": "1000",
				"timeOut": "4000",
				"extendedTimeOut": "1000",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
			}, options)
		},
		setWarning: function(message, options) {
			options = jQuery.extend({
				type: 'warning'
			}, options);
			Framework.setSuccess(message, options);			
		},
		setError: function(message, options) {
			options = jQuery.extend({
				type: 'error'
			}, options);
			Framework.setSuccess(message, options);
		},
		setConfirmar: function(options) {
			// valores por defecto
			var options = jQuery.extend({
				title: 'Mensaje de confirmación',
				contenido: 'Esta seguro de realizar esta operación?',
				aceptar: function() {},
				cancelar : function() {}
			}, options);
			Framework.setAutoDialog({
				id_dialog: 'dialog-confirmar',
				contenido: options.contenido,
				title: options.title,
				position: {
					my: "center",
					at: "center",
					of: window,
					collision: "fit",
					using: function(pos) {
						var topOffset = $(this).css(pos).offset().top;
						if (topOffset < 0) {
							$(this).css("top", pos.top - topOffset);
						}
					}
				},
				buttons : {
					'Aceptar': function() {
						options.aceptar();
						$(this).remove();
					},
					'Cancelar': function() {
						options.cancelar();
						$(this).remove();
					}
				}
			});
		},
		setAlertaArray: function(array, printSubArray) {
			$.each(array, function(index, value) {
				if (typeof (value) === "object" && printSubArray) {
					alert('CONTIENE ARRAY');
					Framework.setAlertaArray(value, printSubArray)
				}
				alert(index + ": " + value);
			});
		},
		setCompararValor: function(options) {
			// Funcion util para verificar si la suma de los valores de una clase se exceden o son inferior a un valor dado
			var options = jQuery.extend({
				clase: 'valor',
				valor: 0,
				type: '<'
			}, options);
			var valor = 0;
			var valorComparar = 0;
			switch (typeof (options.valor)) {
				case 'numbre': {
					valorComparar = options.valor;
				}
				break
				case 'string': {
					$.each($(options.valor), function() {
						var object = $(this);
	
						if (object.attr('type') == 'checkbox') {
							if (object.is(':checked')) {
								valorComparar += Framework.setFormat({
									valor: object.val()
								});
							}
						} else {
							if (object.val()) {
								valorComparar += Framework.setFormat({
									valor: object.val()
								});
							} else {
								valorComparar += Framework.setFormat({
									valor: object.text()
								});
							}
						}
					});
				}
				break
			}
			$.each($('.' + options.clase), function() {
				var object = $(this);
				valor += Framework.setFormat({
					valor: object.val()
				});
			});
			switch (options.type) {
				case '<':
					if (valor < valorComparar) {
						Framework.setAlerta('la sumatoria de Pagos no puede ser menor a ' + valorComparar);
						return false
					}
					break;
				case '>':
					if (valor > valorComparar) {
						Framework.setAlerta('la sumatoria de Pagos no puede ser mayor a ' + valorComparar);
						return false
					}
					break;
			}
			return true;
		},
		setAleatorio: function() {
			numPosibilidades = 15245874;
			aleat = Math.random() * numPosibilidades;
			aleat = Math.round(aleat);
			return parseInt(aleat);
		},
		setValidarValorMaximo: function(options) {
			var options = jQuery.extend({
				object: '',
			}, options);
			var data = options.object.data();
			var valor = options.object.val();
			if (data.cantidad_maxima > 0 && data.cantidad_maxima < valor) {
				Framework.setAlerta("la cantidad maxima pemitida es " + data.cantidad_maxima);
				options.object.val(data.valor_default);
			}
		},
		setAutoDetectChange: function(options) {
			// Funcion para validar los cambios en los campos de formulario en determinado contenedor
			var options = jQuery.extend({
				object: '',
				parent: 'tr',
				changeClass: 'changed',
				notChangeClass: 'not-changed'
			}, options);

			$($(options.object).find("input,textarea,select")).on("change", function() {
				var parent = $(this).parents(options.parent);
				parent.addClass(options.changeClass);
				parent.removeClass(options.notChangeClass);
			});
		},
		setSendOnlyChanges: function(form_id) {
			// Devolver formulario serializado solo con las opciones que ha cambiado
			$('.not-changed').find("input,textarea,select").attr("disabled", true);
			var serialize = $("#" + form_id).serialize();
			$('.not-changed').find("input,textarea,select").attr("disabled", false);
			return serialize;
		},
		setReadQr: function(options) {
			// Función para leer codigos qr
			var options = jQuery.extend({
				contenedor: '',
				width: '300px',
				height: '300px',
				margin: '0 auto 0 auto',
				success: function(data) {
					alert(data);
					$('#' + options.contenedor).html('');
				},
				error: function() {
				},
				videoError: function() {
				},
				verResultado: false,
				verError: false,
				verVideoError: false,
			}, options);

			var contenedorQr = $('<div style="width:' + options.width + ';height:' + options.width + ';margin:' + options.margin + ';"></div>').appendTo($("#" + options.contenedor));
			var contenedorResultado = $('<div></div>').appendTo($("#" + options.contenedor));
			var contenedorError = $('<div></div>').appendTo($("#" + options.contenedor));
			var contenedorVideoError = $('<div></div>').appendTo($("#" + options.contenedor));
			$(contenedorQr).html5_qrcode(function(data) {
				if (options.verResultado) {
					$(contenedorResultado).html(data);
				}
				options.success(data);
			}, function(error) {
				if (options.verError) {
					$(contenedorError).html(error);
				}
				options.error(error);
			}, function(videoError) {
				if (options.verVideoError) {
					$(contenedorVideoError).html(videoError);
				}
				options.videoError(videoError);
			});
		},
		setPingImg: function(options) {
			// Funcion que nos sirve para determinar si se encuentra una imagen en una url especifica, ideal para simular un ping a un servidor de forma rapida
			var options = jQuery.extend({
				url: '',// Ejemplo: http://192.168.4.61/sysportal/imagenes/activo.png
				success: function() {
				},// Funcion que se ejecuta en caso de encontrar la imagen
				error: function() {
				},// Funcion que se ejecuta en caso de no encontrar la imagen
			}, options);
			var loaded = false;
			var pingImg = new Image();
			pingImg.onload = function(object) {
				// Framework.setAlertaArray(object)
				// Success callback
				options.success();
			}
			pingImg.onerror = function(object) {
				// Framework.setAlertaArray(object) Success callback
				options.error();
			}
			pingImg.src = options.url + "?" + (new Date().getTime());
		},
		setAutoTab: function(object, options) {
			// Auto tabs
			var options = jQuery.extend({}, options);
			if (object) {
				$(object).tabs(options);
			} else {
				Framework.setAlerta("No se especificó un objecto!");
			}
		},
		setExecuteJavascriptFromString: function(text) {
			var codigoJavascriptEncontrado = false;
			var scripts, scriptsFinder = /<script[^>]*>([\s\S]+)<\/script>/gi;
			var c = 0;
			while (scripts = scriptsFinder.exec(text)) {
				eval.call(window, scripts[1]);
				codigoJavascriptEncontrado = true;
				c++;
			}
			return codigoJavascriptEncontrado;
		},
		setDefineNameSpace: function(newvar, oProperties) {
			var resultado = false;
			var typeVariable = typeof (eval("globalAppi." + newvar));// return
			if (typeVariable === 'undefined') {
				var newObj = eval("globalAppi." + newvar + "= {}");// Creamos
				for (el in oProperties) {
					newObj[el] = oProperties[el];// Asignamos propiedades
				}
				resultado = true;
			}
			return resultado;
		},
		setAppModel: {
			createApp: function(newvar, oProperties) {
				var resultado = false;
				if (newvar.length > 0) {
					// CREAMOS NAMESPACE EN GLOBALAPPI
					var aPathFile = newvar.split('.');// partimos ruta file
					var nombreApp = aPathFile[aPathFile.length - 1];
					newvar = aPathFile.join('_');
					var typeVariable = typeof (eval("globalAppi." + newvar));// return
					if (typeVariable === 'undefined') {
						var newObj = eval("globalAppi." + newvar + "= {}");// Creamos
						for ( var property in oProperties) {
							newObj[property] = oProperties[property];
						}
						newObj.appName = nombreApp;// Asignamos propiedades
						resultado = true;
					}
				} else {
					console.error('createApp: string empty!!');
				}
				return resultado;
			},
			initApp: function(newvar) {
				if (newvar.length > 0) {
					var aPathFile = newvar.split('.');
					var appName = aPathFile[aPathFile.length - 1];
					newvar = aPathFile.join('_');
				}
				eval("globalAppi." + newvar + ".initApp()");
				console.log(appName + ': inicializado.');
			},
			getApp: function(newvar) {
				if (newvar.length > 0) {
					var aPathFile = newvar.split('.');
					var appName = aPathFile[aPathFile.length - 1];
					newvar = aPathFile.join('_');
				}
				return newvar;
			}
		},
		setSerializeObjToStringGet: function(objVariables) {
			var variablesAjax = "";
			for (key in objVariables) {
				if (variablesAjax.length > 0) {
					variablesAjax += "&" + key + "=" + objVariables[key];
				} else {
					variablesAjax += key + "=" + objVariables[key];
				}
			}
			return variablesAjax;
		},
		setFormatResult: function (iter)
		{
			var originalOption = iter.element;
		 
			if($(originalOption).data('foo'))
			{
				return $(originalOption).data('foo');
			}
			else
			{
				return iter.text;
			}
		},
		setCloseTooltips: function () {
			$('[data-toggle="tooltip"]').tooltip('hide');
		},
		setDataTable: function (options) {
			var options = jQuery.extend({
				responsive : true,
				pageLength : 25,
				object: null,
				buttons: true,
				language : {
					"lengthMenu" : "Mostrar _MENU_ registros por página",
					"zeroRecords" : "No se encontraron registros",
					"info" : "Mostrando _PAGE_ Página de _PAGES_",
					"infoEmpty" : "No hay registros disponibles",
					"infoFiltered" : "(filtrada de _MAX_ registros totales)",
					"oPaginate" : {
						"sFirst" : "Primero",
						"sPrevious" : "Atrás",
						"sNext" : "Siguiente",
						"sLast" : "Último"
					},
					"sSearch" : "Filtrar"
				},
				"columnDefs": [ 
	               	{
				      "targets": 'nosort',
				      "orderable": false
				    } 
				]
			}, options);
			if (options.buttons) {
				options = jQuery.extend(options, {
					dom: '<"html5buttons"B>lTfgitp',
					buttons: [ {extend: 'copy'}, {extend: 'csv'}, {extend: 'excel'}, {extend: 'pdf'}, { extend: 'print', customize: function (win){ $(win.document.body).addClass('white-bg'); $(win.document.body).css('font-size', '10px'); $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit'); } } ]
				});
			}
			$(options.object).DataTable(options);
		}		
	};
}();