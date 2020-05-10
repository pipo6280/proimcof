<?php
use system\Helpers\Form;
use app\dtos\RhCargoDto;
use system\Support\Util;
use app\enums\ESiNo;

$object = $object instanceof RhCargoDto ? $object : new RhCargoDto(); 
$object->getDto()->setYn_activo(Util::isVacio($object->getDto()->getYn_activo()) ? ESiNo::index(ESiNo::SI)->getId() : $object->getDto()->getYn_activo()); ?>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>
            <?php echo Util::isVacio($object->getNombre()) ? lang('perfil.add_form') : lang('cargo.edit_form', [$object->getNombre()]); ?>
        </h5>
    </div>
    <div class="ibox-content">
        <?php echo Form::open(['action' => 'Cargo@save', 'id' => 'frmEditCargo']); ?>
            <div class="form-group">
                <?php 
                    echo Form::hide('txtDto-txtId_cargo', $object->getDto()->getId_cargo());
                    echo Form::label(lang('cargo.nombre'), 'txtDto-txtNombre');
                    echo Form::text('txtDto-txtNombre', $object->getDto()->getNombre(), ['class' => 'form-control notnull']);
                ?>
            </div>
            <div class="form-group">
                <?php 
                    echo Form::label(lang('cargo.activo'), 'txtDto-txtYn_activo');
                    echo Form::selectEnum('txtDto-txtYn_activo', $object->getDto()->getYn_activo(), ESiNo::data());
                ?>
            </div>
            <div class="form-group">
                <?php
                    echo Form::button(lang('general.back_button_icon'), [
                        'class' => "ladda-button btn btn-outline btn-warning",
                        'id' => 'btnBack'                        
                    ]);
                    echo '&nbsp;';
                    echo Form::button(lang('general.save_button_icon'), [
                        'class' => "ladda-button btn btn-primary {$object->getPermisoDto()->getIconEdit()}",
                        'id' => 'btnCargoEdit',
                        'type' => 'submit'
                    ]);
                ?>
            </div>
        <?php echo Form::close(); ?>
    </div>
</div>
<script type="text/javascript">
    $(function(){
    	$('input[type=text]').setCase({caseValue : 'upper'});
    	$('button#btnBack').click(function () {
    		var l = Ladda.create(this);
            l.start();
    		Framework.setLoadData({
        		pagina: '<?php echo base_url('cargo/cargo'); ?>',
        		success: function () { l.stop(); }
        	});
    	});
    	$('button#btnCargoEdit').click(function () {
    		BUTTON_CLICK = this;
    	});
    	if($("#frmEditCargo").length>0) {
    		$("#frmEditCargo").validate({
    			ignore: ":hidden:not(select)",
    			submitHandler: function(form) {
    				var l = Ladda.create(BUTTON_CLICK);
    	            l.start();
                    Framework.setLoadData({                                                        
                        id_contenedor_body: false,
                        pagina : '<?php echo site_url('cargo/save'); ?>',
                        data: $(form).serialize(),
                        success: function(data) {
                        	if (data.contenido == 0) {
                		    	Framework.setWarning('<?php echo lang('general.process_message_fail'); ?>');
                		    } else if (data.contenido) {
                		    	var message = '<?php echo lang('cargo.cargo_guardado_ok'); ?>';
		                    	message = message.replace('{0}', data.contenido);
		                        Framework.setSuccess(message);
                                Framework.setLoadData({
                            		pagina : '<?php echo base_url('cargo/cargo'); ?>'
                            	});
                		    } else {
                		    	Framework.setError('<?php echo lang('general.operation_message'); ?>');
                		    }
                		    l.stop();
                        }
                    });
    			},
    			rules: {
    				'txtDto-txtNombre': { required: true, minlength: 4 },
    				'txtDto-txtYn_activo': "required"
    			},
    			errorPlacement: function(error, element) {
    			    if (element.attr("class").indexOf('chosen-select') != -1) {
    			        error.insertAfter("#" + element.attr("id").replace('-', '_') + '_chosen');
    			    } else {
    			        error.insertAfter(element);
    			    }
    			}
    		});
    	};
    });
</script>