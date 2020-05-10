<?php
use app\dtos\ServicioDto;
use system\Support\Util;
use system\Helpers\Form;
use app\enums\ESiNo;

$object = $object instanceof ServicioDto ? $object : new ServicioDto(); 
$object->getDto()->setYn_activo(Util::isVacio($object->getDto()->getYn_activo()) ? ESiNo::index(ESiNo::SI)->getId() : $object->getDto()->getYn_activo()); ?>
<?php echo Form::open(['action' => 'Servicio@save', 'id' => 'frmEditServicio']); ?>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>
                <?php echo Util::isVacio($object->getNombre()) ? lang('servicio.add_form') : lang('servicio.edit_form', [$object->getNombre()]); ?>
            </h5>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <?php 
                            echo Form::hide('txtDto-txtId_servicio', $object->getDto()->getId_servicio());
                            echo Form::label(lang('servicio.descripcion'), 'txtDto-txtDescripcion');
                            echo Form::text('txtDto-txtDescripcion', $object->getDto()->getDescripcion(), [
                                'placeholder' => lang('servicio.descripcion')
                            ]);
                        ?>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <?php 
                            echo Form::label(lang('servicio.activo'), 'txtDto-txtYn_activo');
                            echo Form::selectEnum('txtDto-txtYn_activo', $object->getDto()->getYn_activo(), ESiNo::data());
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
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
<?php echo Form::close(); ?>
<script type="text/javascript">
    $(function(){
    	$('button#btnBack').click(function () {
    		var l = Ladda.create(this);
            l.start();
    		Framework.setLoadData({
        		pagina : '<?php echo base_url('servicio/inicio'); ?>',
        		success: function () { l.stop(); }
        	});
    	});
    	
    	$('button#btnGuardar').click(function () {
    		BUTTON_CLICK = this;
    	});
    	
    	if($("#frmEditServicio").length>0) {
    		$("#frmEditServicio").validate({
    			ignore: ":hidden:not(select)",
    			submitHandler: function(form) {
    				var l = Ladda.create(BUTTON_CLICK);
    	            l.start();
    				Framework.setLoadData({
    	    			id_contenedor_body: false,
    	        		pagina: '<?php echo base_url('servicio/save'); ?>',
    	        		data: $(form).serialize(),
    	        		success: function (data) {
    	        			Framework.setSuccess('<?php echo lang('general.save_message')?>');
    	        			Framework.setLoadData({
        			    		pagina : '<?php echo base_url('servicio/inicio'); ?>',
        			    		success: function () {
        			    			l.stop();
        			    		}
        			    	});
    	        		}
    				});
    			},
    			rules: {
    				'txtDto-txtDescripcion': { required: true, minlength: 3 },
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