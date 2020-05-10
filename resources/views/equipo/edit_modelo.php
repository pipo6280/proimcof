<?php
use system\Support\Util;
use system\Helpers\Form;
use app\dtos\EquipoDto;
use app\enums\ETipoEquipo;
use app\enums\EEstilo;

$object = $object instanceof EquipoDto ? $object : new EquipoDto(); 
//$object->getDto()->setYn_activo(Util::isVacio($object->getDto()->getYn_activo()) ? ESiNo::index(ESiNo::SI)->getId() : $object->getDto()->getYn_activo()); ?>
<?php echo Form::open(['action' => 'Equipo@save_modelo', 'id' => 'frmEditModelo']); ?>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>
            <?php echo Util::isVacio($object->getDto()->getModelo()) ? lang('equipo.add_form_model') : lang('equipo.edit_form_model', [$object->getDto()->getModelo()]); ?>
        </h5>
    </div>
    <div class="ibox-content">
        <div class="col-lg-8 col-md-8 col-xs-12">
            <div class="row">
                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <?php 
                        echo Form::label(lang('equipo.marca'), 'txtId_marca'); 
                        echo Form::hide('txtDto-txtId_modelo', $object->getDto()->getId_modelo());
                    ?>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-search"></i>
                        </span>
                        <?php echo Form::text('txtDto-txtMarcaDto-txtNombre', $object->getDto()->getMarcaDto()->getNombre(), ['id' => 'txtId_marca', 'class' => 'form-control autocompletado  letras', 'data-control' => 'auto_marca', 'data-input_hidden_name' => 'txtDto-txtMarcaDto-txtId_marca', 'data-input_hidden_value' => $object->getDto()->getMarcaDto()->getId_marca()]); ?>
                    </div>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <?php 
                        echo Form::label(lang('equipo.modelo'), 'txtDto-txtModelo'); 
                        echo Form::text('txtDto-txtModelo', $object->getDto()->getModelo(), ['id' => 'txtDto-txtModelo', 'class' => 'form-control']);
                    ?>
                </div>
            </div>
            <div class="row">   
                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <?php 
                        echo Form::label(lang('equipo.tipo'), 'txtDto-txtTipo'); 
                        echo Form::selectEnum('txtDto-txtTipo', $object->getDto()->getTipo(), ETipoEquipo::data(), ['class' => 'form-control chosen-select'], false);
                    ?>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <?php 
                        echo Form::label(lang('equipo.estilo'), 'txtDto-txtEstilo'); 
                        echo Form::selectEnum('txtDto-txtEstilo', $object->getDto()->getEstilo(), EEstilo::data(), ['class' => 'form-control chosen-select'], false);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-xs-12">
            <div class="form-group">
                <?php 
                    echo Form::label(lang('equipo.descripcion'), 'txtDto-txtDescripcion'); 
                    echo Form::textarea('txtDto-txtDescripcion', $object->getDto()->getDescripcion(), ['rows' => '5', 'placeholder' => lang('equipo.descripcion')]);
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
    $(function(){
    	$('input[type=text]').setCase({caseValue : 'upper'});
    	$('button#btnBack').click(function () {
    		var l = Ladda.create(this);
            l.start();
    		Framework.setLoadData({
        		pagina : '<?php echo base_url('equipo/modelo'); ?>',
        		success: function () { l.stop(); }
        	});
    	});
    	
    	$('button#btnGuardar').click(function () {
    		BUTTON_CLICK = this;
    	});
    	
    	if($("#frmEditModelo").length>0) {
    		$("#frmEditModelo").validate({
    			ignore: ":hidden:not(select)",
    			submitHandler: function(form) {
    				var l = Ladda.create(BUTTON_CLICK);
    	            l.start();
    				Framework.setLoadData({
    	    			id_contenedor_body: false,
    	        		pagina: '<?php echo base_url('equipo/save_modelo'); ?>',
    	        		data: $(form).serialize(),
    	        		success: function (data) {
    	        			Framework.setSuccess('<?php echo lang('general.save_message')?>');
    	        			Framework.setLoadData({
        			    		pagina : '<?php echo base_url('equipo/modelo'); ?>',
        			    		success: function () {
        			    			l.stop();
        			    		}
        			    	});
    	        		}
    				});
    			},
    			rules: {
    				'txtDto-txtMarcaDto-txtNombre': { required: true },
    				'txtDto-txtModelo': { required: true, minlength: 3 },
    				'txtDto-txtTipo': { required: true },
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