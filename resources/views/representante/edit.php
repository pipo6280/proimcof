<?php
use system\Helpers\Form;
use app\dtos\RhRepresentanteDto;
use app\enums\ETipoDocumento;
use app\enums\EGenero;
use system\Support\Arr;

$object = $object instanceof RhRepresentanteDto ? $object: new RhRepresentanteDto();
echo Form::open(['action' => 'Representante@save', 'id' => 'frmEditRepresentante']); ?>
    <div class="row">
        <div class="col-sm-7">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo lang('representante.info_basica'); ?></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <?php  
                                    echo Form::hide('txtDto-txtId_representante', $object->getDto()->getId_representante());
                                    echo Form::hide('txtDto-txtId_persona', $object->getDto()->getPersonaDto()->getId_persona());
                                    echo Form::hide('txtDto-txtPersonaDto-txtId_persona', $object->getDto()->getPersonaDto()->getId_persona());
                                    echo Form::label(lang('representante.primer_nombre'), 'txtDto-txtPersonaDto-txtPrimer_nombre');
                                ?>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-user-circle-o"></i></span>
                                    <?php 
                                        echo Form::text('txtDto-txtPersonaDto-txtPrimer_nombre', $object->getDto()->getPersonaDto()->getPrimer_nombre(), [
                                            'class' => 'form-control letras',
                                            'maxlength' => 20,
                                            'tabindex' => 1,
                                        ]);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php
                                    echo Form::label(lang('representante.primer_apellido'), 'txtDto-txtPersonaDto-txtPrimer_apellido');
                                    echo Form::text('txtDto-txtPersonaDto-txtPrimer_apellido', $object->getDto()->getPersonaDto()->getPrimer_apellido(), [
                                        'class' => 'form-control letras', 
                                        'maxmaxlength' => 20,
                                        'tabindex' => 3
                                    ]);
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                    echo Form::label(lang('representante.tipo_documento'), 'txtDto-txtPersonaDto-txtTipo_identificacion');
                                    echo Form::selectEnum('txtDto-txtPersonaDto-txtTipo_identificacion', $object->getDto()->getPersonaDto()->getTipo_identificacion(), ETipoDocumento::data(), [
                                        'tabindex' => 5,
                                    ]); 
                                ?>
                        	</div>
                        	<div class="form-group">
                                <?php echo Form::label(lang('representante.genero'), 'txtGeneroMale'); ?>
                                <div class="i-checks">
                        			<label>
                                        <?php 
                                            echo Form::radio('txtDto-txtPersonaDto-txtGenero', EGenero::index(EGenero::MALE)->getid(), ($object->getDto()->getPersonaDto()->getGenero() == EGenero::index(EGenero::MALE)->getid()), [
                                                'id' => 'txtGeneroMale',
                                                'tabindex' => 7
                                            ]); 
                                        ?> 
                                        <i><?php echo Form::label('M'); ?></i>
                        			</label>
                        			<label>
                                        <?php 
                                            echo Form::radio('txtDto-txtPersonaDto-txtGenero', EGenero::index(EGenero::FEMALE)->getid(), ($object->getDto()->getPersonaDto()->getGenero() == EGenero::index(EGenero::FEMALE)->getid()), [
                                                'id' => 'txtGeneroFemale'
                                            ]);
                                        ?> 
                                        <i><?php echo Form::label('F', 'txtGeneroFemale');?></i>
                        			</label>
                        		</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <?php
                                    echo Form::label(lang('representante.segundo_nombre'), 'txtDto-txtPersonaDto-txtSegundo_nombre');
                                    echo Form::text('txtDto-txtPersonaDto-txtSegundo_nombre', $object->getDto()->getPersonaDto()->getSegundo_nombre(), [
                                        'class' => 'form-control letras',
                                        'maxlength' => 20,
                                        'tabindex' => 2
                                    ]);
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                    echo Form::label(lang('representante.segundo_apellido'), 'txtDto-txtPersonaDto-txtSegundo_apellido');
                                    echo Form::text('txtDto-txtPersonaDto-txtSegundo_apellido', $object->getDto()->getPersonaDto()->getSegundo_apellido(), [
                                        'class' => 'form-control letras', 
                                        'maxmaxlength' => 20,
                                        'tabindex' => 4                                
                                    ]);
                                ?>
                            </div>
                            <div class="form-group">
                               <?php  
                                    echo Form::label(lang('representante.numero_documento'), 'txtDto-txtPersonaDto-txtNumero_identificacion');
                                    echo Form::text('txtDto-txtPersonaDto-txtNumero_identificacion', $object->getDto()->getPersonaDto()->getNumero_identificacion(), [
                                        'class' => 'form-control', 
                                        'maxlength' => 15,
                                        'tabindex' => 6
                                    ]);
                               ?>
                            </div>
                            <div class="form-group fecha-normal">
                                <?php echo Form::label(lang('representante.fecha_nacimiento'), 'txtDto-txtPersonaDto-txtFecha_nacimiento');?>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <?php 
                                        echo Form::text('txtDto-txtPersonaDto-txtFecha_nacimiento', $object->getDto()->getPersonaDto()->getFecha_nacimiento(), [
                                            'class' => 'form-control',
                                            'tabindex' => 8
                                        ]); 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo lang('representante.info_contacto'); ?></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <?php echo Form::label(lang('representante.direccion'), 'txtDto-txtPersonaDto-txtDireccion'); ?>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                    <?php 
                                        echo Form::text('txtDto-txtPersonaDto-txtDireccion', $object->getDto()->getPersonaDto()->getDireccion(), [
                                            'class' => 'form-control',
                                            'tabindex' => 9
                                        ]);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php echo Form::label(lang('representante.numero_fijo'), 'txtDto-txtPersonaDto-txtTelefono'); ?>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-phone-square"></i></span>
                                    <?php 
                                        echo Form::text('txtDto-txtPersonaDto-txtTelefono', $object->getDto()->getPersonaDto()->getTelefono(), [
                                            'class' => 'form-control ',
                                            'tabindex' => 11
                                        ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <?php echo Form::label(lang('representante.barrio'), 'txtDto-txtPersonaDto-txtBarrio'); ?>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                    <?php 
                                        echo Form::text('txtDto-txtPersonaDto-txtBarrio', $object->getDto()->getPersonaDto()->getBarrio(), [
                                            'class' => 'form-control letras',
                                            'tabindex' => 10
                                        ]);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php echo Form::label(lang('representante.movil'), 'txtDto-txtPersonaDto-txtMovil'); ?>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                    <?php 
                                   		echo Form::text('txtDto-txtPersonaDto-txtMovil', $object->getDto()->getPersonaDto()->getMovil(), [
                                   		    'tabindex' => 12
                                   		]);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo Form::label(lang('representante.email'), 'txtDto-txtPersonaDto-txtEmail'); ?>
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                            <?php 
                                echo Form::email('txtDto-txtPersonaDto-txtEmail', $object->getDto()->getPersonaDto()->getEmail(), [
                                    'tabindex' => 13
                                ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-7">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo lang('representante.cargos_asociados'); ?></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="form-group">
                        <?php 
                            $listCargos = $object->getListCargos();
                            $current = Arr::current($listCargos);
                            echo Form::label(lang('representante.cargos'), "txtDto-txtCargo{$current->getId()}", 'hide');
                            $arrayCargos = $object->getDto()->getListCargos();
                            $sec = 12;
                            foreach ($listCargos as $key => $lis) { ?>
                                <div class="i-checks">
                                    <label>
                                        <?php 
                                            $sec ++;
                                            echo Form::checkbox('txtDto-txtListCargos[]', $lis->getId(), ! empty($arrayCargos[$lis->getId()]), [
                                                'id' => "txtDto-txtCargo{$lis->getId()}",
                                                'tabindex' => $sec
                                            ]);
                                        ?>
                                        <i><?php echo title($lis->getDescription()); ?></i>                                        
                                    </label>
                                </div>
                                <?php 
                            } 
                        ?>
                    </div>
                </div>
             </div>   
        </div>
    </div>
    <hr>
    <?php
        echo Form::button(lang('general.back_button_icon'), [
            'class' => "ladda-button btn btn-outline btn-warning",
            'id' => 'btnBack'                        
        ]);
        echo '&nbsp;';
        echo Form::button(lang('general.save_button_icon'), [
            'class' => "ladda-button btn btn-primary {$object->getPermisoDto()->getIconEdit()}",
            'id' => 'btnGuardarRepresentante',
            'type' => 'submit'
        ]);
echo Form::close(); ?>
<script type="text/javascript">
$(function() {
	$('input[type=text]').setCase({caseValue: 'upper'});
	$('#txtDto-txtPersonaDto-txtEmail').blur(function () {
		if ($.trim($(this).val()) != '') {
    		Framework.setLoadData({
    			id_contenedor_body: false,
        		pagina: '<?php echo base_url('representante/validate_email'); ?>',
        		data: {
        			'txtDto-txtPersonaDto-txtEmail': $(this).val(),
        			'txtDto-txtPersonaDto-txtId_persona': $('#txtDto-txtPersonaDto-txtId_persona').val()            			
        		},
        		success: function (data) {
            		if (data.contenido) {
                		Framework.setWarning('<?php echo lang('representante.email_duplicado'); ?>');
                		$('#txtDto-txtPersonaDto-txtEmail').val(null);
                	}
            	}
        	});
		}
	});
	$('#txtDto-txtPersonaDto-txtNumero_identificacion').blur(function () {
    	if ($.trim($(this).val()) != '') {
        	var object = $(this);
    		Framework.setLoadData({
    			id_contenedor_body: false,
				pagina: '<?php echo site_url('representante/validate_documento'); ?>',
				data: {
					"txtDto-txtPersonaDto-txtId_persona": $('#txtDto-txtPersonaDto-txtId_persona').val(),
					"txtDto-txtPersonaDto-txtNumero_identificacion": $(object).val()
				},
				success: function (data) {
				    if (data.contenido) {
					    var message = '<?php echo lang('representante.message_confirm_duplicate'); ?>';
					    message = message.replace('{0}', $(object).val());
					    Framework.setConfirmar({
						    contenido: message,
						    aceptar: function () {
						    	Framework.setLoadData({
							    	pagina: '<?php echo site_url('representante/representante_datos'); ?>',
							    	data: {
							    		"txtDto-txtPersonaDto-txtNumero_identificacion": $(object).val()
							    	}
						    	});
						    },
						    cancelar: function () {
						    	$("#frmEditRepresentante").get(0).reset();							    	
						    }
					    });
				    }
				}					
			});
        }
	});
	$('button#btnBack').click(function () {
		var l = Ladda.create(this);
        l.start();
		Framework.setLoadData({
    		pagina: '<?php echo base_url('representante/representante'); ?>',
    		success: function () { l.stop(); }
    	});
	});
	$('button#btnGuardarRepresentante').click(function () {
		BUTTON_CLICK = this;
	});
	if($("#frmEditRepresentante").length>0) {
		$("#frmEditRepresentante").validate({
			ignore: ":hidden:not(select)",
			submitHandler: function(form) {
				var l = Ladda.create(BUTTON_CLICK);
	            l.start();
				Framework.setLoadData({
	    			id_contenedor_body: false,
	        		pagina: '<?php echo base_url('representante/save'); ?>',
	        		data: $(form).serialize(),
	        		success: function (data) {
		        		if (data.contenido == 0) {
		        			Framework.setWarning('<?php echo lang('general.process_message_fail'); ?>');
		        		} else if (data.contenido) {
		        			var message = '<?php echo lang('representante.message_save_ok'); ?>';
	                    	message = message.replace('{0}', data.contenido);
	                        Framework.setSuccess(message);
		        			Framework.setLoadData({
	    			    		pagina: '<?php echo base_url('representante/representante'); ?>',
	    			    	});
		        		} else {
		        			Framework.setError('<?php echo lang('general.operation_message'); ?>');	
		        		}
		        		l.stop();
	        		}
				});				
			},
			rules: {
				'txtDto-txtPersonaDto-txtPrimer_nombre': { required: true, minlength: 2 },
				'txtDto-txtPersonaDto-txtPrimer_apellido': { required: true, minlength: 2 },
				'txtDto-txtPersonaDto-txtTipo_identificacion': { required: true},
				'txtDto-txtPersonaDto-txtNumero_identificacion': { required: true, minlength: 2 },
				'txtDto-txtPersonaDto-txtFecha_nacimiento': { required: true },
				'txtDto-txtPersonaDto-txtGenero': { required: true },
				'txtDto-txtPersonaDto-txtEstado_civil': { required: true },
				'txtDto-txtPersonaDto-txtMovil': { required: true, digits: true, minlength: 10 },
				'txtDto-txtPersonaDto-txtTelefono': { digits: true, minlength: 3 },
				'txtDto-txtPersonaDto-txtEmail': { required: true, email: true },
				'txtDto-txtListCargos[]': "required"						
			},
			messages: {
				'txtDto-txtListCargos[]': "Seleeccione al menos uno de los cargos"
			}, 
			errorPlacement: function(error, element) {
			    if (element.attr("class").indexOf('chosen-select') != -1) {
				    var idInput = element.attr("id").split('-');
			        error.insertAfter("#" + idInput.join('_') + '_chosen');
			    } else if(element.attr('name') == 'txtDto-txtPersonaDto-txtGenero' || element.attr('name') == 'txtDto-txtListCargos[]') {
			    	error.insertAfter(element.parents('.i-checks'));
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