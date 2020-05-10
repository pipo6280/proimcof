<?php
use system\Helpers\Form;
use app\dtos\UsuarioMenuDto;
use app\enums\EUbicacion;
use app\enums\ETarget;
use system\Support\Util;
use app\enums\ESiNo;

$object = $object instanceof UsuarioMenuDto ? $object : new UsuarioMenuDto();
?>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>
            <?php echo lang('menu.form_edit', [$object->getNombre()]); ?>
        </h5>
    </div>
    <div class="ibox-content">
        <?php echo Form::open(['action' => 'Menu@save', 'id' => 'frmEditMenu','class' => 'col s12']); ?>
            <div class="row">
                <div class="col-sm-4">
                    <?php 
                        echo $menuPrint;
                    ?>
                </div>
                <?php if (! Util::isVacio($object->getId_menu())) { ?>
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php 
                                        echo Form::hide('txtId_menu', $object->getDto()->getId_menu());
                                        echo Form::label(lang('menu.name'), 'txtNombre');
                                        echo Form::text('txtNombre', $object->getDto()->getNombre());
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php echo Form::label(lang('menu.parent'), 'txtId_menu_padre'); ?>
                                    <select name="txtId_menu_padre" id="txtId_menu_padre" class="form-control chosen-select">
                                        <option value="" selected><?php echo lang('general.option_choose'); ?></option>
                                        <?php echo $object->getDto()->getListMenus(); ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <?php 
                                        echo Form::label(lang('menu.target'), 'txtTarget');
                                        echo Form::selectEnum('txtTarget', $object->getDto()->getTarget(), ETarget::data());
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php 
                                        echo Form::label(lang('menu.container'), 'txtVisualizar_en');
                                        echo Form::text('txtVisualizar_en', $object->getDto()->getVisualizar_en(), ['class' => 'typeahead_2 form-control']);
                                    ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php 
                                        echo Form::label(lang('menu.url'), 'txtUrl');
                                        echo Form::text('txtUrl', $object->getDto()->getUrl());
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php echo Form::label(lang('menu.icon_class'), 'txtClass_icon'); ?>
                                    <div class="input-group m-b">
                                        <span class="input-group-addon">
                                            <i class="fa fa-search"></i>
                                        </span> 
                                        <?php 
                                            echo Form::text('txtClass_icon', $object->getDto()->getClass_icon(), [
                                                'data-input_hidden_value' => $object->getDto()->getClass_icon(),
                                                'data-input_hidden_name' => 'txtClass_icon',
                                                'class' => 'form-control autocompletado',
                                                'data-control' => 'auto_class_iconos',
                                                'id' => 'txtClass_icon'
                                            ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <?php 
                                        echo Form::label(lang('menu.show_in'), 'txtUbicacion');
                                        echo Form::selectEnum('txtUbicacion', $object->getDto()->getUbicacion(), EUbicacion::data());
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php 
                                        echo Form::label(lang('menu.activo'), 'txtYn_activo');
                                        echo Form::selectEnum('txtYn_activo', $object->getDto()->getYn_activo(), ESiNo::data());
                                    ?>
                                </div>
                                <div class="form-group">
                                    <?php 
                                        echo Form::button(lang('general.save_button_icon'), [
                                            'class' => "ladda-button btn btn-primary {$object->getPermisoDto()->getIconEdit()}",
                                            'id' => 'btnMenuEdit',
                                            'type' => 'submit'
                                        ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php echo Form::close(); ?>
    </div>
</div>
<script type="text/javascript">
    $(function(){
    	$('button#btnMenuEdit').click(function () {
    		BUTTON_CLICK = this;
    	});
    	$('a.classEditMenu').each(function () {
            $(this).click(function () {
                var data = $(this).data();
            	Framework.setLoadData({
            		pagina : '<?php echo base_url('menu/consult'); ?>',
            		data : {
            			id_contenedor_body 	: false,
            			txtId_menu : data.id_menu            			
            		}
            	});
            	return false;
            });
        });
    	if($("#frmEditMenu").length>0) {
    		$("#frmEditMenu").validate({
    			ignore: ":hidden:not(select)",
    			submitHandler: function(form) {
    				var l = Ladda.create(BUTTON_CLICK);
    	            l.start();
    				Framework.setLoadData({
            		    id_contenedor_body 	: false,
            		    pagina : '<?php echo base_url('menu/save'); ?>',
            		    data : $('#frmEditMenu').serialize(),
            		    success : function(data) {
                		    if (data.contenido == 0) {
                		    	Framework.setWarning('<?php echo lang('general.process_message_fail'); ?>');
                		    } else if (data.contenido) {
                    		    var message = '<?php echo lang('menu.menu_save_ok'); ?>';
                    		    message = message.replace('{0}', data.contenido);
                		        Framework.setSuccess(message);
                		        Framework.setLoadData({ pagina : '<?php echo base_url('menu/edit'); ?>' });
                		    } else {
                		    	Framework.setError('<?php echo lang('general.operation_message'); ?>');
                		    }
                		    l.stop();
            		    }
    			    });
    			},
    			rules: {
    				txtNombre: { required: true, minlength: 5 },
    				txtUrl: { required: true, minlength: 1 },
    				txtUbicacion : "required",
    				txtYn_activo : "required",
    				txtTarget : "required",
    				txtVisualizar_en: { required: true, minlength: 5 }
    			},
    			errorPlacement: function(error, element) {
    			    if (element.attr("class").indexOf('chosen-select') != -1) {
    			        error.insertAfter("#" + element.attr("id") + '_chosen');
    			    } else {
    			        error.insertAfter(element);
    			    }
    			}
    		});
    	};
    });
</script>