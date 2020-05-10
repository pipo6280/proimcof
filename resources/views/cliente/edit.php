<?php
use app\dtos\ClienteDto;
use system\Support\Util;
use system\Helpers\Form;
use app\enums\ESiNo;
use app\enums\ETipoEmpresa;
use app\dtos\ClienteSedeDto;

$object = $object instanceof ClienteDto ? $object : new ClienteDto();  ?>
<?php echo Form::open(['action' => 'Cliente@save', 'id' => 'frmEditCliente']); ?>
    <div class="row">
        <div class="col-sm-8">   
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>
                        <?php echo Util::isVacio($object->getNombre_empresa()) ? lang('cliente.add_form') : lang('cliente.edit_form', [$object->getNombre_empresa()]); ?>
                    </h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-xs-12">
                            <div class="form-group">
                                <?php 
                                    echo Form::hide('txtDto-txtId_cliente', $object->getDto()->getId_cliente());
                                    echo Form::label(lang('cliente.nombre'), 'txtDto-txtNombre_empresa');
                                    echo Form::text('txtDto-txtNombre_empresa', $object->getDto()->getNombre_empresa(), [
                                        'placeholder' => lang('cliente.nombre')
                                    ]);
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-xs-12">
                            <div class="form-group">
                                <?php 
                                    echo Form::label(lang('cliente.razon_social'), 'txtDto-txtRazon_social');
                                    echo Form::text('txtDto-txtRazon_social', $object->getDto()->getRazon_social(), [
                                        'placeholder' => lang('cliente.razon_social')
                                    ]);
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-xs-12">
                            <div class="form-group">
                                <?php 
                                    echo Form::label(lang('cliente.nit'), 'txtDto-txtNit');
                                    echo Form::text('txtDto-txtNit', $object->getDto()->getNit(), [
                                        'placeholder' => lang('cliente.nit')
                                    ]);
                                ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="hr-line-dashed"></div>
                    
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-xs-12">
                            <div class="form-group">
                                <?php echo Form::label(lang('cliente.telefono'), 'txtDto-txtTelefono'); ?>
                                <div class="input-group">    
                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                    <?php     
                                        echo Form::text('txtDto-txtTelefono', $object->getDto()->getTelefono(), [
                                            'placeholder' => lang('cliente.telefono')
                                        ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-xs-12">
                            <div class="form-group">
                                <?php echo Form::label(lang('cliente.movil'), 'txtDto-txtMovil'); ?>
                                <div class="input-group">    
                                    <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                    <?php 
                                        echo Form::text('txtDto-txtMovil', $object->getDto()->getMovil(), [
                                            'placeholder' => lang('cliente.movil')
                                        ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-xs-12">
                            <div class="form-group">
                                <?php echo Form::label(lang('cliente.email'), 'txtDto-txtEmail'); ?>
                                <div class="input-group">    
                                    <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                                    <?php 
                                        echo Form::text('txtDto-txtEmail', $object->getDto()->getEmail(), [
                                            'placeholder' => lang('cliente.email')
                                        ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-xs-12">
                            <div class="form-group">
                                <?php echo Form::label(lang('cliente.contacto'), 'txtDto-txtContacto'); ?>
                                <div class="input-group">    
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <?php 
                                        echo Form::text('txtDto-txtContacto', $object->getDto()->getContacto(), [
                                            'placeholder' => lang('cliente.contacto')
                                        ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-xs-12">
                            <div class="form-group">
                                <?php echo Form::label(lang('cliente.ciudad'), 'txtId_ciudad');  ?>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                                    <?php echo Form::text('txtDto-txtCiudadDto-txtNombre_ciudad', $object->getDto()->getCiudadDto()->getNombre_ciudad(), [
                                            'id' => 'txtId_ciudad', 
                                            'class' => 'form-control autocompletado  letras', 
                                            'data-control' => 'auto_ciudad', 
                                            'data-input_hidden_name' => 'txtDto-txtCiudadDto-txtId_ciudad', 
                                            'data-input_hidden_value' => $object->getDto()->getCiudadDto()->getId_ciudad()
                                        ]); 
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-xs-12">
                            <div class="form-group">
                                <?php echo Form::label(lang('cliente.direccion'), 'txtDto-txtDirecion'); ?>
                                <div class="input-group">    
                                    <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                    <?php 
                                        echo Form::text('txtDto-txtDirecion', $object->getDto()->getDirecion(), [
                                            'placeholder' => lang('cliente.direccion')
                                        ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-xs-12">
                            <div class="form-group">
                                <?php 
                                    echo Form::label(lang('cliente.tipo'), 'txtDto-txtTipo_cliente'); 
                                    echo Form::selectEnum('txtDto-txtTipo_cliente', $object->getDto()->getTipo_cliente(), ETipoEmpresa::data(), [
                                        'class' => 'form-control chosen-select'
                                    ], false);
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-xs-12">
                            <div class="form-group">
                                <?php echo Form::label(lang('cliente.decuento'), 'txtDto-txtDescuento_scanner'); ?>
                                <div class="input-group">    
                                    <span class="input-group-addon"><i class="fa fa-print"></i></span>
                                    <?php 
                                        echo Form::number('txtDto-txtDescuento_scanner', $object->getDto()->getDescuento_scanner());
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-footer">
                    <div class="form-group">
                        <?php
                            echo Form::button(lang('general.back_button_icon'), [
                                'class' => "ladda-button btn btn-outline btn-warning",
                                'id' => 'btnBack'                        
                            ]);
                            echo '&nbsp;';
                            echo Form::button(lang('general.save_button_icon'), [
                                'class' => "ladda-button btn btn-primary {$object->getPermisoDto()->getIconEdit()}",
                                'id' => 'btnGuardar',
                                'type' => 'submit'
                            ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">   
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>
                        <?php echo lang('cliente.list_sede_depencias'); ?>
                    </h5>
                </div>
                <div class="ibox-content">
                    <?php foreach ( $object->getDto()->getList_sedes() as $k => $sede) { ?>
                        <?php $sede instanceof ClienteSedeDto; ?>
                            <?php if($k > 0 ) { ?>
                                <div class="hr-line-dashed"></div>
                            <?php } ?>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <?php 
                                            echo Form::hide("txtSede_key[{$k}]", $k);
                                            echo Form::hide("txtSede_id[{$k}]", $sede->getId_cliente_sede());
                                            echo Form::label(lang('cliente.nombre'), "txtSede_nombre{$k}");
                                            echo Form::text("txtSede_nombre[{$k}]", $sede->getNombre(), [
                                                'placeholder' => lang('cliente.nombre'),
                                                'id' => "txtSede_nombre{$k}"
                                            ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <?php echo Form::label(lang('cliente.direccion'), "txtSede_direccion{$k}"); ?>
                                        <div class="input-group">    
                                            <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>    
                                            <?php echo Form::text("txtSede_direccion[{$k}]", $sede->getDireccion(), [
                                                    'placeholder' => lang('cliente.direccion'),
                                                    'id' => "txtSede_direccion{$k}"
                                                ]);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                           </div>
                           <div class="row">     
                                <div class="col-lg-6 col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <?php echo Form::label(lang('cliente.telefono'), "txtSede_telefono{$k}"); ?>
                                        <div class="input-group">    
                                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>    
                                            <?php echo Form::text("txtSede_telefono[{$k}]", $sede->getTelefono(), [
                                                    'placeholder' => lang('cliente.telefono'),
                                                    'id' => "txtSede_telefono{$k}"
                                                ]);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php if($k > 0 ) { ?>
                                    <div class=" form-group col-sm-2 center-align">
                                        <div class="input-group" style="text-align: center;">
                                            <?php //if( $k > 0) { ?>
                                                <?php  echo Form::label(lang('general.delete_button'), 'txtDto-delete');?>
                                                <a href="javascript:void(0)" class="deleteSede <?php echo $object->getPermisoDto()->getIconDelete(); ?>" data-toggle="tooltip" data-id_sede="<?php echo $k; ?>" data-nombre="<?php echo $sede->getNombre() ?>" >
                                                    <i class=" <?php echo $object->getPermisoDto()->getClassDelete(); ?> fa-2x"></i>
                                                </a>
                                            <?php //} ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                      <?php } ?>
                </div>
                <div class="ibox-footer">
                    <div class="form-group">
                        <?php 
                            echo Form::button(lang('general.add_button_icon'), [
                                'class' => "ladda-button btn btn-outline btn-success {$object->getPermisoDto()->getIconAdd()}",
                                'data-id_paquete' => $object->getDto()->getId_cliente(),
                                'id' => 'btnAddSede',
                                'type' => 'submit'                            
                            ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo Form::close(); ?>
<script type="text/javascript">
    $(document).ready(function () {
    	$('#txtDto-txtNit').blur(function () {
    		if ($.trim($(this).val()) != '') {
        		Framework.setLoadData({
        			id_contenedor_body 	: false,
            		pagina : '<?php echo base_url('cliente/validate_nit'); ?>',
            		data : {
            			'txtDto-txtNit' : $(this).val(),
            			'txtDto-txtId_cliente' : $('#txtDto-txtId_cliente').val()            			
            		},
            		success : function (data) {
                		if (data.contenido) {
                    		Framework.setError('<?php echo lang('cliente.nit_duplicado'); ?>');
                    		$('#txtDto-txtNit').val(null);
                    	}
                	}
            	});
    		 }
    	});
    });	
    		
    $(function(){
    	$('#txtDto-txtNombre_empresa').setCase({caseValue : 'upper'});
    	$('button#btnBack').click(function () {
    		var l = Ladda.create(this);
            l.start();
    		Framework.setLoadData({
        		pagina : '<?php echo base_url('cliente/cliente'); ?>',
        		success: function () { l.stop(); }
        	});
    	});

    	$('.deleteSede').each(function () {
    		var options = jQuery.extend({
    			id_sede : null,
    			nombre : null
    		}, $(this).data());
    		$(this).click(function() {
    			Framework.setConfirmar({
        			contenido : 'Está a punto de eliminar : <b>'+ options.nombre +'</b> ¿Desea Continuar?',
        			aceptar : function() {
        				Framework.setLoadData({
        					pagina : '<?php echo site_url('cliente/delete_sede'); ?>/'+options.id_sede,
            		    	data: $('form').serialize(),
        					success : function(data) {
        						if (data.contenido) {
        							var message = '<?php echo lang('cliente.delete_ok'); ?>';
        	                    	message = message.replace('{0}', options.nombre);
        	                        Framework.setSuccess(message);
        						} else {
        							titulo = '<?php echo lang('cliente.no_delete'); ?>';
        			    			titulo = titulo.replace('{0}', options.nombre);
        							Framework.setError(titulo);
        						}							
        					}
        				});
        			 }
    		    });
    		});
    	});

    	$('button#btnAddSede').click(function () {
    		BUTTON_CLICK = this;
    		ACCION = 'ADD';
    	});
    	
    	$('button#btnGuardar').click(function () {
    		BUTTON_CLICK = this;
    		ACCION = 'SAVE';
    	});
    	
    	if($("#frmEditCliente").length>0) {
    		$("#frmEditCliente").validate({
    			ignore: ":hidden:not(select)",
    			submitHandler: function(form) {
    				var l = Ladda.create(BUTTON_CLICK);
    	            l.start();
    	            switch(ACCION) {
        	            case 'SAVE': {
            				Framework.setLoadData({
            					id_contenedor_body : false,
            	        		pagina: '<?php echo base_url('cliente/save'); ?>',
            	        		data: $(form).serialize(),
            	        		success: function (data) {
                	        		//console.log(data.titulo);
            	        			Framework.setSuccess('<?php echo lang('general.save_message')?>');
            	        			Framework.setLoadData({
            	        				data: {'txtId_cliente' : data.titulo },
                			    		pagina : '<?php echo base_url('cliente/consultar_sedes'); ?>',
                			    		success: function () {
                			    			l.stop();
                			    		}
                			    	});
            	        		}
            				});
        	            } break;
        	            case 'ADD': {
        	            	Framework.setLoadData({
                            	pagina : '<?php echo site_url('cliente/add_sede/1'); ?>',
                            	data: $(form).serialize(),
                            	success: function () {
                            		l.stop();
                            	}
                            });
        	            } break;
    	            }
    			},
    			rules: {
    				'txtDto-txtNombre_empresa': { required: true, minlength: 3 },
    			    'txtDto-txtNit': { required: true, minlength: 3 },
    			    'txtDto-txtMovil': { required: true, number: true, minlength: 10 }, 
    			    'txtDto-txtTelefono': { number: true, minlength: 6 }, 
    			    'txtDto-txtEmail': { required: true, email: true },
    			    'txtDto-txtCiudadDto-txtNombre_ciudad': { required: true},
    			    'txtDto-txtDescuento_scanner' : {min: 0},
    			    <?php foreach ($object->getDto()->getList_sedes() as $k => $sede) { ?>
            			'txtSede_nombre[<?php echo $k; ?>]': {
                			required: true,
                			minlength: 3
            			}, 
            			'txtSede_telefono[<?php echo $k; ?>]': {
            				number: true,
            			    minlength: 6
            			}, 
    			   <?php } ?>		    
    			},
    			errorPlacement: function(error, element) {
    			    if (element.attr("class").indexOf('chosen-select') != -1) {
    				    var idInput = element.attr("id").split('-');
    			        error.insertAfter("#" + idInput.join('_') + '_chosen');
    			    } else if(element.parents('.input-group').size() > 0) {
    			    	error.insertAfter(element.parents('.input-group'));
    			    } else {
    			        error.insertAfter(element);
    			    }
    			}
    		});
    	};
    });
</script>