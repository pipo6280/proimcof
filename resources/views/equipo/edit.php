<?php
use system\Support\Util;
use system\Helpers\Form;
use app\dtos\EquipoDto;
use app\enums\EEstadoEquipo;

$object = $object instanceof EquipoDto ? $object : new EquipoDto(); 
//$object->getDto()->setYn_activo(Util::isVacio($object->getDto()->getYn_activo()) ? ESiNo::index(ESiNo::SI)->getId() : $object->getDto()->getYn_activo()); ?>
<?php echo Form::open(['action' => 'Equipo@save', 'id' => 'frmEditEquipo']); ?>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>
                <?php echo Util::isVacio($object->getDto()->getSerial_equipo()) ? lang('equipo.add_form') : lang('equipo.edit_form', [$object->getDto()->getSerial_equipo()]); ?>
            </h5>
        </div>
        <div class="ibox-content">
            <div class="col-lg-8 col-md-8 col-xs-12">
                <div class="row ">
                    <div class="col-lg-6 col-md-6 col-xs-12 m-b">
                    <?php 
                        echo Form::hide('txtDto-txtId_equipo', $object->getDto()->getId_equipo());
                        echo Form::label(lang('equipo.modelo'), 'txtDto-txtId_modelo'); 
                        echo Form::selectEnum('txtDto-txtId_modelo', $object->getDto()->getId_modelo(), $object->getList_modelos_enum(), ['class' => 'form-control chosen-select'], false);
                    ?>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-12 m-b">
                        <?php 
                            echo Form::label(lang('equipo.serial'), 'txtDto-txtSerial_equipo'); 
                            echo Form::text('txtDto-txtSerial_equipo', $object->getDto()->getSerial_equipo(), ['id' => 'txtDto-txtSerial_equipo', 'class' => 'form-control']); 
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-xs-12 m-b">
                        <?php 
                            echo Form::label(lang('equipo.estado'), 'txtDto-txtEstado'); 
                            echo Form::selectEnum('txtDto-txtEstado', $object->getDto()->getEstado(), EEstadoEquipo::data(), ['class' => 'form-control chosen-select'], false);
                        ?>
                    </div>
                    <?php /*?>
                    <div class="col-lg-4 col-md-4 col-xs-12 m-b">
                        <?php 
                            echo Form::label(lang('equipo.contador_copias'), 'txtDto-txtContador_inicial_copia'); 
                            echo Form::number('txtDto-txtContador_inicial_copia', $object->getDto()->getContador_inicial_copia(), ['id' => 'txtDto-txtContador_inicial_copia', 'class' => 'form-control numeros']); 
                        ?>
                    </div>
                    <div class="col-lg-4 col-md-4 col-xs-12 m-b">
                        <?php 
                            echo Form::label(lang('equipo.contador_scanner'), 'txtDto-txtContador_inicial_scanner'); 
                            echo Form::number('txtDto-txtContador_inicial_scanner', $object->getDto()->getContador_inicial_scanner(), ['id' => 'txtDto-txtContador_inicial_scanner', 'class' => 'form-control numeros']); 
                        ?>
                    </div>
                    <?*/?>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-12 m-b">
                <div class="form-group">
                    <?php 
                        echo Form::label(lang('equipo.descripcion'), 'txtDto-txtDescripcion'); 
                       echo Form::textarea('txtDto-txtDescripcion', $object->getDto()->getDescripcion(), ['id' => 'txtDto-txtDescripcion', 'rows' => '5']);
                    ?>
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
                
    $(document).ready(function () {
    	$('#txtDto-txtSerial_equipo').blur(function () {
    		if ($.trim($(this).val()) != '') {
        		Framework.setLoadData({
        			id_contenedor_body 	: false,
            		pagina : '<?php echo base_url('equipo/validate_serial'); ?>',
            		data : {
            			'txtDto-txtSerial_equipo' : $(this).val(),
            			'txtDto-txtId_equipo' : $('#txtDto-txtId_equipo').val()            			
            		},
            		success : function (data) {
                		if (data.contenido) {
                    		Framework.setError('<?php echo lang('equipo.serial_duplicado'); ?>');
                    		$('#txtDto-txtSerial_equipo').val(null);
                    	}
                	}
            	});
    		}
    	});
    });

    $(function(){
    	$('input[type=text]').setCase({caseValue : 'upper'});
    	$('button#btnBack').click(function () {
    		var l = Ladda.create(this);
            l.start();
    		Framework.setLoadData({
        		pagina : '<?php echo base_url('equipo/inicio'); ?>',
        		success: function () { l.stop(); }
        	});
    	});

    	$('button#btnGuardar').click(function () {
    		BUTTON_CLICK = this;
    	});
    	
    	if($("#frmEditEquipo").length>0) {
    		$("#frmEditEquipo").validate({
    			ignore: ":hidden:not(select)",
    			submitHandler: function(form) {
    				var l = Ladda.create(BUTTON_CLICK);
    	            l.start();
    				Framework.setLoadData({
    	    			id_contenedor_body: false,
    	        		pagina: '<?php echo base_url('equipo/save'); ?>',
    	        		data: $(form).serialize(),
    	        		success: function (data) {
    	        			Framework.setSuccess('<?php echo lang('general.save_message')?>');
    	        			Framework.setLoadData({
        			    		pagina : '<?php echo base_url('equipo/inicio'); ?>',
        			    		success: function () {
        			    			l.stop();
        			    		}
        			    	});
    	        		}
    				});
    			},
    			rules: {
    				'txtDto-txtContador_inicial_copia': { required: true, number: true },
    				'txtDto-txtSerial_equipo': {required: true, minlength: 3},
    				'txtDto-txtContador_inicial_scanner': { number: true },
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