<?php
use system\Helpers\Form;
use app\dtos\UsuarioMenuDto;
use app\enums\EUbicacion;
use app\enums\ETarget;
use app\enums\ESiNo;

$object = $object instanceof UsuarioMenuDto ? $object : new UsuarioMenuDto();
?>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>
            <?php echo lang('menu.form_create'); ?>
        </h5>
    </div>
    <div class="ibox-content">
        <?php echo Form::open(['action' => 'Menu@save', 'id' => 'frmMenu']); ?>
            <div class="row">
                <div class="col-sm-6 b-r">
                    <div class="form-group">
                        <?php 
                            echo Form::label(lang('menu.name'), 'txtNombre');
                            echo Form::text('txtNombre', $object->getNombre(), [
                                'class' => 'form-control',
                                'tabindex' => 1
                            ]);
                        ?>
                    </div>
                    
                    <div class="form-group">
                        <?php echo Form::label(lang('menu.parent'), 'txtId_menu_padre'); ?>
                        <select name="txtId_menu_padre" id="txtId_menu_padre" class="form-control chosen-select" tabindex="3">
                            <option value=""><?php echo lang('general.option_choose'); ?></option>
                            <?php echo $object->getListMenus(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <?php 
                            echo Form::label(lang('menu.target'), 'txtTarget');
                            echo Form::selectEnum('txtTarget', $object->getTarget(), ETarget::data(), [
                                'class' => 'form-control chosen-select',
                                'tabindex' => 5
                            ]);
                        ?>
                    </div>
                    <div class="form-group">
                        <?php 
                            echo Form::label(lang('menu.container'), 'txtVisualizar_en');
                            echo Form::text('txtVisualizar_en', 'main_content', [
                                'class' => 'form-control',
                                'tabindex' => 7
                            ]);
                        ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <?php 
                            echo Form::label(lang('menu.url'), 'txtUrl');
                            echo Form::text('txtUrl', $object->getUrl(), [
                                'class' => 'form-control',
                                'tabindex' => 2
                            ]);
                        ?>
                    </div>
                    <div class="form-group">
                        <?php echo Form::label(lang('menu.icon_class'), 'txtClass_icon'); ?>
                        <div class="input-group m-b">
                            <span class="input-group-addon">
                                <i class="fa fa-search"></i>
                            </span>
                            <?php 
                                echo Form::text('txtClass_icon', $object->getClass_icon(), [
                                    'data-input_hidden_value' => $object->getClass_icon(),
                                    'data-input_hidden_name' => 'txtClass_icon',
                                    'class' => 'form-control autocompletado',
                                    'data-control' => 'auto_class_iconos',
                                    'id' => 'txtClass_icon',
                                    'tabindex' => 4
                                ]);
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php 
                            echo Form::label(lang('menu.show_in'), 'txtUbicacion');
                            echo Form::selectEnum('txtUbicacion', $object->getUbicacion(), EUbicacion::data(), [
                                'class' => 'form-control chosen-select',
                                'tabindex' => 6
                            ]);
                        ?>
                    </div>
                    <div class="form-group">
                        <?php 
                            echo Form::label(lang('menu.activo'), 'txtYn_activo');
                            echo Form::selectEnum('txtYn_activo', $object->getYn_activo(), ESiNo::data(), [
                                'class' => 'form-control chosen-select',
                                'tabindex' => 8
                            ]);
                        ?>
                    </div>
                    <div class="form-group">
                        <?php 
                            echo Form::button(lang('general.save_button_icon'), [
                                'class' => "ladda-button btn btn-primary {$object->getPermisoDto()->getIconEdit()}",
                                'id' => 'btnMenuCreate',
                                'type' => 'submit',
                                'tabindex' => 9
                            ]); 
                        ?>
                    </div>
                </div>
            </div>
        <?php echo Form::close(); ?>
    </div>
</div>
<script type="text/javascript">
    $(function(){
    	$('button#btnMenuCreate').click(function () {
    		BUTTON_CLICK = this;
    	});
    	if($("#frmMenu").length>0) {
    		$("#frmMenu").validate({
    			ignore: ":hidden:not(select)",
    			submitHandler: function(form) {
    				var l = Ladda.create(BUTTON_CLICK);
    	            l.start();
    				Framework.setLoadData({
            		    id_contenedor_body 	: false,
            		    pagina : '<?php echo base_url('menu/save'); ?>',
            		    data : $('#frmMenu').serialize(),
            		    success : function(data) {
            		    	if (data.contenido) {
                		    	var message = '<?php echo lang('menu.menu_save_ok'); ?>';
    	                    	message = message.replace('{0}', data.contenido);
    	                        Framework.setSuccess(message);
                		        Framework.setLoadData({
            						pagina : '<?php echo base_url('menu/create'); ?>',
            						data : {
            							txtId_menu : null
            						}
            					});
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
    				txtTarget : "required",
    				txtYn_activo : "required",
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