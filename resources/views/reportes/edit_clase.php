<?php 
use system\Support\Util;
use system\Helpers\Form;
use app\dtos\PaqueteDto;
use system\Support\Arr;
use app\enums\EDuracionPaquete;

$object = $object instanceof PaqueteDto ? $object : new PaqueteDto();
?>
<?php echo Form::open(['action' => 'Paquete@saveSubPaquete', 'id' => 'frmEditPaquete']); ?>
 <div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?php echo Util::isVacio($object->getNombre()) ? lang('paquete.add_form_sp') : lang('paquete.edit_form_sp', [$object->getNombre()]); ?></h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <?php 
                                echo Form::hide('txtDto-txtId_sub_paquete', $object->getDto()->getId_sub_paquete());
                                echo Form::label(lang('paquete.paquete'), 'txtDto-txtId_paquete');
                                echo Form::selectEnum('txtDto-txtId_paquete', $object->getDto()->getId_paquete(), $object->getList());
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <?php 
                                echo Form::label(lang('paquete.nombre'), 'txtDto-txtNombre');
                                echo Form::text('txtDto-txtNombre', $object->getDto()->getNombre());
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <?php 
                                echo Form::label(lang('paquete.precio'), 'txtDto-txtPrecio');
                                echo Form::number('txtDto-txtPrecio', $object->getDto()->getPrecio(), [
                                    'min' => 0
                                ]);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <?php 
                                echo Form::label(lang('paquete.sesiones'), 'txtDto-txtNumero_sesiones');
                                echo Form::number('txtDto-txtNumero_sesiones', $object->getDto()->getNumero_sesiones(), ['min' => 1]);
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <?php 
                                echo Form::label(lang('paquete.excusas'), 'txtDto-txtNumero_excusas');
                                echo Form::number('txtDto-txtNumero_excusas', $object->getDto()->getNumero_excusas(), ['min' => 0]);
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                        <?php 
                            echo Form::label(lang('paquete.duracion'), 'txtDto-txtDuracion');
                            echo Form::selectEnum('txtDto-txtDuracion', $object->getDto()->getDuracion(), EDuracionPaquete::data());
                        ?>
                        </div>
                    </div>
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
    'id' => 'btnGuardarPaquete',
    'type' => 'submit'
]); ?>

<?php echo Form::close(); ?>

<script type="text/javascript">
$('button#btnBack').click(function () {
	var l = Ladda.create(this);
    l.start();
	Framework.setLoadData({
		pagina: '<?php echo base_url('paquete/clases'); ?>',
		success: function () { l.stop(); }
	});
});
$('button#btnGuardarPaquete').click(function () {
	BUTTON_CLICK = this;
});
if($("#frmEditPaquete").length>0) {
	$("#frmEditPaquete").validate({
		ignore: ":hidden:not(select)",
		submitHandler: function(form) {
			var l = Ladda.create(BUTTON_CLICK);
            l.start();
			Framework.setLoadData({
    			id_contenedor_body: false,
        		pagina: '<?php echo base_url('paquete/saveSubPaquete'); ?>',
        		data: $(form).serialize(),
        		success: function (data) {
	        		if (data.contenido == 0) {
	        			Framework.setWarning('<?php echo lang('general.process_message_fail'); ?>');
	        		} else if (data.contenido) {
	        			var message = '<?php echo lang('paquete.save_ok'); ?>';
                    	message = message.replace('{0}', data.contenido);
                        Framework.setSuccess(message);
	        			Framework.setLoadData({
    			    		pagina: '<?php echo base_url('paquete/clases'); ?>',
    			    	});
	        		} else {
	        			Framework.setError('<?php echo lang('general.operation_message'); ?>');	
	        		}
	        		l.stop();
        		}
			});				
		},
		rules: {
			'txtDto-txtId_paquete': { required: true},
			'txtDto-txtDuracion': { required: true},
			'txtDto-txtNombre': { required: true, minlength: 5 },
			'txtDto-txtPrecio': { required: true, minlength: 1 },
			'txtDto-txtNumero_sesiones': { required: true, minlength: 1 },
			'txtDto-txtNumero_excusas': { required: true, minlength: 1 },
		},
		errorPlacement: function(error, element) {
		    if (element.attr("class").indexOf('chosen-select') != -1) {
			    var idInput = element.attr("id").split('-');
		        error.insertAfter("#" + idInput.join('_') + '_chosen');
		    }  else if(element.parents('.input-group').size() > 0) {
		    	error.insertAfter(element.parents('.input-group'));
		    } else {
		        error.insertAfter(element);
		    }
		}
	});
};
</script>