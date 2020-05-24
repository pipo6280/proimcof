<?php

//use system\Support\Util;
use system\Helpers\Form;
use app\dtos\MantenimientoDto;

$object = $object instanceof MantenimientoDto ? $object : new MantenimientoDto(); 
//$object->getDto()->setYn_activo(Util::isVacio($object->getDto()->getYn_activo()) ? ESiNo::index(ESiNo::SI)->getId() : $object->getDto()->getYn_activo()); ?>
<?php echo Form::open(['action' => 'Mantenimiento@save', 'id' => 'frmEditMantenimiento']); ?>
 <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">       
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>
                        <?php echo lang('servicio.edit_form'); 
                              echo Form::hide('txtId_cliente_equipo', $object->getId_cliente());
                              echo Form::hide('txtId_equipo', $object->getId_equipo());
                              echo Form::hide('txtSearch_equipo', $object->getSearch_equipo());
                        ?>
                    </h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-xs-12">
                            <div class="form-group">
                                <?php echo Form::label(lang('mantenimiento.servicios'), 'txtId_servicio'); ?>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-cubes"></i></span>
                                    <?php echo Form::selectEnum('txtId_servicio', $object->getId_servicio(), $object->getList_servicios_enum(),[
                                        'class' => 'form-control chosen-select ch'
                                    ]);?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-xs-12">
                            <div class="form-group fecha-normal">
                                <?php echo Form::label(lang('mantenimiento.fecha_nacimiento'), 'txtFecha');?>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <?php 
                                        echo Form::text('txtFecha', $object->getFecha(), [
                                            'class' => 'form-control fecha-params',
                                            'tabindex' => 8,
                                            'readonly' => true
                                        ]); 
                                    ?>
                                </div>
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
        </div>
    </div>
<?php echo Form::close(); ?>
<script type="text/javascript">
    $(function(){
        
    	$('button#btnBack').click(function () {
    		var l = Ladda.create(this);
            l.start();
            Framework.setLoadData({
    			pagina: '<?php echo site_url('mantenimiento/buscar_equipos'); ?>',
    			data: { 
    				txtSearch_equipo: $('#txtSearch_equipo').val(),
    	    		txtId_equipo : $('#txtId_equipo').val(),
    	    		txtId_cliente : $('#txtId_cliente_equipo').val() 
    	        },    			
    		});
    	});
    	
//     	$('button#btnGuardar').click(function () {
//     		BUTTON_CLICK = this;
//     	});
    	
//     	if($("#frmEditServicio").length>0) {
//     		$("#frmEditServicio").validate({
//     			ignore: ":hidden:not(select)",
//     			submitHandler: function(form) {
//     				var l = Ladda.create(BUTTON_CLICK);
//     	            l.start();
//     				Framework.setLoadData({
//     	    			id_contenedor_body: false,
//    	        		pagina: '<?php //echo base_url('servicio/save'); ?>',
//     	        		data: $(form).serialize(),
//     	        		success: function (data) {
//    	        			Framework.setSuccess('<?php //echo lang('general.save_message')?>');
//     	        			Framework.setLoadData({
//        			    		pagina : '<?php //echo base_url('servicio/inicio'); ?>',
//         			    		success: function () {
//         			    			l.stop();
//         			    		}
//         			    	});
//     	        		}
//     				});
//     			},
//     			rules: {
//     				'txtDto-txtDescripcion': { required: true, minlength: 3 },
//     				'txtDto-txtYn_activo': "required"
//     			},
//     			errorPlacement: function(error, element) {
//     			    if (element.attr("class").indexOf('chosen-select') != -1) {
//     			        error.insertAfter("#" + element.attr("id").replace('-', '_') + '_chosen');
//     			    } else {
//     			        error.insertAfter(element);
//     			    }
//     			}
//     		});
//     	};
    });
</script>