<?php 
use system\Support\Util;
use system\Helpers\Form;
use app\dtos\PaqueteDto;
use system\Support\Arr;
use app\enums\ESiNo;

$object = $object instanceof PaqueteDto ? $object : new PaqueteDto();
?>
<?php echo Form::open(['action' => 'Paquete@save', 'id' => 'frmEditPaquete']); ?>
 <div class="row">
    <div class="col-sm-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?php echo Util::isVacio($object->getNombre()) ? lang('paquete.add_form') : lang('paquete.edit_form', [$object->getNombre()]); ?></h5>
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
                                echo Form::hide('txtDto-txtId_paquete', $object->getDto()->getId_paquete());
                                echo Form::label(lang('paquete.nombre'), 'txtDto-txtNombre');
                                echo Form::text('txtDto-txtNombre', $object->getDto()->getNombre());
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <?php 
                                echo Form::label(lang('paquete.clases_concurrentes'), 'txtDto-txtClases_concurrentes');
                                echo Form::number('txtDto-txtClases_concurrentes', $object->getDto()->getClases_concurrentes(), [
                                    'min' => 1
                                ]);
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <?php 
                                echo Form::label(lang('paquete.cupo'), 'txtDto-txtCupo');
                                echo Form::number('txtDto-txtCupo', $object->getDto()->getCupo(), [
                                    'min' => 1
                                ]);
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                        <?php 
                            echo Form::label(lang('paquete.grupal'), 'txtDto-txtYn_grupal');
                            echo Form::selectEnum('txtDto-txtYn_grupal', $object->getDto()->getYn_grupal(), ESiNo::data(),null,false);
                        ?>
                        </div>          
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?php echo lang('paquete.horario'); ?></h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <?php $count = 0;?>
                <?php foreach ($object->getDto()->getList_horario() as $k => $lis) { ?>
                    <div class="row">
                        <div class="form-group col-sm-5">
                            <?php  
                                echo Form::label(lang('paquete.hora_inicial'), "txtDto-txtHora_inicio_$k");
                                echo Form::hide("txtFechaId[{$k}]", $lis->getId_horario_paquete());
                            ?>
                            <div class="input-group clockpicker" data-autoclose="true">
                                <?php 
                                $hora = "";
                                $minuto = "";
                                $sep = "";
                                if(! Util::isVacio($lis->getHora_inicio())) {
                                    $sep = ":";
                                    list ($hora, $minuto) = Arr::explode($lis->getHora_inicio(), ':');
                                }
                                echo Form::text("txtDto-txtHora_inicio[$k]",($hora.$sep.$minuto),['id'=>"txtDto-txtHora_inicio_$k"] );
                                ?>
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                            </div>
                        </div>
                        <div class=" form-group col-sm-5">
                            <?php  echo Form::label(lang('paquete.hora_final'), "txtDto-txtHora_fin_$k");?>
                            <div class="input-group clockpicker" data-autoclose="true">
                                <?php 
                                if(! Util::isVacio($lis->getHora_fin())) {
                                    list ($hora, $minuto) = Arr::explode($lis->getHora_fin(), ':');
                                }
                                echo Form::text("txtDto-txtHora_fin[$k]",($hora.$sep.$minuto),['id'=>"txtDto-txtHora_fin_$k"] );
                                ?>
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                            </div>
                        </div>
                        <div class=" form-group col-sm-2 center-align">
                            <div class="input-group" style="text-align: center;">
                                <?php if( $count > 0) { ?>
                                    <?php  echo Form::label(lang('general.delete_button'), 'txtDto-delete');?>
                                    <a href="javascript:void(0)" class="deletePaquete <?php echo $object->getPermisoDto()->getIconDelete(); ?>" data-toggle="tooltip" data-idx_horario="<?php echo $k; ?>">
                                        <i class=" <?php echo $object->getPermisoDto()->getClassDelete(); ?> fa-2x"></i>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div><br>
                    <?php $count++;?>
                <?php }?>
                <div class="row">
                    <div class="form-group col-sm-2">
                    <?php 
                        echo Form::button(lang('general.add_button_icon'), [
                            'class' => "ladda-button ladda-button-demo btn btn-outline btn-success {$object->getPermisoDto()->getIconAdd()}",
                            'data-id_paquete' => $object->getDto()->getId_paquete(),
                            'id' => 'btnAddHorario',
                            'type' => 'submit'                            
                        ]);
                    ?>
                    </div>
                </div>
            </div>
       </div>
   </div> 
    <div class="col-sm-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?php echo lang('paquete.relacion_paquetes'); ?></h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <?php foreach ($object->getList() as $lis) {?>
                        <div class="i-checks">
                            <div class="col-sm-6">
                                <label>
                                <?php 
                                 echo Form::checkbox('txtDto-txtList_paquetes[]', 
                                     $lis->getId_paquete(), 
                                     !Arr::isNullArray($lis->getId_paquete(), 
                                     $object->getDto()->getList_paquetes()), [
                                        'id' => "txtDto-txtList_paquetes{$lis->getId_paquete()}"
                                     ]);
                                ?>
                                <i><?php echo title($lis->getNombre()); ?></i>
                                </label>     
                            </div>
                        </div>    
                    <?php }?>
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
		pagina: '<?php echo base_url('paquete/crear'); ?>',
		success: function () { l.stop(); }
	});
});

$('.deletePaquete').each(function () {
	var options = jQuery.extend({
		idx_horario : null
	}, $(this).data());
	$(this).click(function() {
		Framework.setLoadData({
	    	pagina : '<?php echo site_url('paquete/delete-horario'); ?>/'+options.idx_horario,
	    	data: $('form').serialize()
	    });
	});
});

$('button#btnAddHorario').click(function () {
	BUTTON_CLICK = this;
	ACCION = 'ADD';
});
$('button#btnGuardarPaquete').click(function () {
	BUTTON_CLICK = this;
	ACCION = 'SAVE';
});
$.validator.addMethod("formatHora",
    function(value, element) {
        return value.match(/^([0-1]?[0-9]|2[0-3])(:[0-5][0-9])$/);
    },
    "Por favor, escribe una hora válida con formato (hh:mm)."
);
if($("#frmEditPaquete").length>0) {
	$("#frmEditPaquete").validate({
		ignore: ":hidden:not(select)",
		submitHandler: function(form) {
			console.log(ACCION);
			var l = Ladda.create(BUTTON_CLICK);
            l.start();
            switch(ACCION) {
                case 'ADD': {
                	Framework.setLoadData({
                    	pagina : '<?php echo site_url('paquete/add_horario/1'); ?>',
                    	data: $(form).serialize(),
                    	success: function () {
                    		l.stop();
                    	}
                    });
                }break;
                case 'SAVE': {
                	Framework.setLoadData({
            			id_contenedor_body: false,
                		pagina: '<?php echo base_url('paquete/save'); ?>',
                		data: $(form).serialize(),
                		success: function (data) {
        	        		if (data.contenido == 0) {
        	        			Framework.setWarning('<?php echo lang('general.process_message_fail'); ?>');
        	        		} else if (data.contenido) {
        	        			var message = '<?php echo lang('paquete.save_ok'); ?>';
                            	message = message.replace('{0}', data.contenido);
                                Framework.setSuccess(message);
        	        			Framework.setLoadData({
            			    		pagina: '<?php echo base_url('paquete/crear'); ?>',
            			    	});
        	        		} else {
        	        			Framework.setError('<?php echo lang('general.operation_message'); ?>');	
        	        		}
        	        		l.stop();
                		}
        			});	
                }break;
            }						
		},
		rules: {
			'txtDto-txtNombre': { required: true, minlength: 5 },
			'txtDto-txtClases_concurrentes': { required: true, minlength: 1 },
			'txtDto-txtCupo': { required: true, minlength: 1 },
			<?php foreach ($object->getDto()->getList_horario() as $k => $lis) { ?>
    			'txtDto-txtHora_inicio[<?php echo $k; ?>]': {
        			required: true,
        			formatHora: true
    			}, 
    			'txtDto-txtHora_fin[<?php echo $k; ?>]': {
        			required: true,
      			    formatHora: true
    			},
			<?php } ?>
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