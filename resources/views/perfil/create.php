<?php
use system\Helpers\Form;
use app\dtos\UsuarioPerfilDto;
use app\enums\ESiNo;
use system\Support\Util;
$object = $object instanceof UsuarioPerfilDto ? $object : new UsuarioPerfilDto(); ?>
<style type="text/css">
    #menu-select {margin-top: 15px;}
</style>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>
            <?php echo lang('perfil.add_form'); ?>
        </h5>
    </div>
    <div class="ibox-content">
        <?php echo Form::open(['action' => 'Perfil@save', 'id' => 'frmEditPerfil','class' => 'col s12']); ?>
            <div class="row">
                <div class="form-group col-sm-6">
                    <?php 
                        echo Form::hide('txtId_menu', $object->getId_perfil());
                        echo Form::label(lang('perfil.name_perfil'), 'txtNombre');
                        echo Form::text('txtNombre', $object->getNombre(), ['class' => 'form-control notnull']);
                    ?>
                </div>
                <div class="form-group col-sm-6">
                    <?php 
                        echo Form::label(lang('perfil.activo'), 'txtYn_activo');
                        echo Form::selectEnum('txtYn_activo', (Util::isVacio($object->getYn_activo()) ? ESiNo::index(ESiNo::SI)->getId() : $object->getYn_activo()), ESiNo::data());
                    ?>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="form-group col-sm-4">
                    <h3>
                        <label for="txtMenu_1">
                            <?php echo lang('perfil.list_menus'); ?>
                        </label>
                    </h3>
                    <?php echo $object->getMenuCheck(); ?>
                </div>
                <div class="form-group col-sm-8">
                    <?php echo $object->getModuleCheck(); ?>
                </div>
            </div>
            <div class="form-group">
                <?php
                    echo Form::button(lang('general.back_button_icon'), [
                        'class' => "btn btn-outline btn-default",
                        'id' => 'btnBack'                        
                    ]);
                    echo '&nbsp;';
                    echo Form::button(lang('general.save_button_icon'), [
                        'class' => "btn btn-primary {$object->getPermisoDto()->getIconEdit()}",
                        'id' => 'btnMenuEdit',
                        'type' => 'submit'
                    ]);
                ?>
            </div>
        <?php echo Form::close(); ?>
    </div>
</div>
<script type="text/javascript">
    $(function(){
    	$('input[type=text]').setCase({caseValue : 'title'});
    	$('.chkAll').on('ifChecked', function(event){
    		var idPerfil = $(this).val();
    		$('#txtFilaMenu' + idPerfil).show();
    		$('#txtYn_view_' + idPerfil).iCheck('check');
  		});
    	$('.chkAll').on('ifUnchecked', function(event){
    		var idPerfil = $(this).val();
    		$('#txtFilaMenu' + idPerfil).hide();
    		$('#txtFilaMenu' + idPerfil).iCheck('uncheck');
  		});
    	$('button#btnBack').click(function () {
    		Framework.setLoadData({
        		pagina : '<?php echo base_url('perfil/perfil/'); ?>'
        	});
    	});
    	if($("#frmEditPerfil").length>0) {
    		$("#frmEditPerfil").validate({
    			ignore: ":hidden:not(select)",
    			submitHandler: function(form) {
    				Framework.setLoadData({
            		    id_contenedor_body 	: false,
            		    pagina : '<?php echo base_url('perfil/save'); ?>',
            		    data : $('#frmEditPerfil').serialize(),
            		    success : function(data) {
            		        Framework.setSuccess('<?php echo lang('general.edit_message'); ?>');
            		        Framework.setLoadData({
        						pagina : '<?php echo base_url('perfil/perfil'); ?>'
        					});
            		    }
    			    });
    			},
    			rules: {
    				txtNombre: { required: true, minlength: 5 },
    				txtYn_activo: "required",
    				'txtMenu[]': "required" 
    			},
    			messages: {
    				'txtMenu[]': {
    					required: "<?php echo lang('perfil.error_menus'); ?>",
    				}
        		},
    			errorPlacement: function(error, element) {
    			    if (element.attr("class").indexOf('chosen-select') != -1) {
    			        error.insertAfter("#" + element.attr("id") + '_chosen');
    			    } else if (element.attr("type") == 'checkbox') {
    			        error.insertAfter("h3");
    			    } else {
    			        error.insertAfter(element);
    			    }
    			}
    		});
    	};
    });
</script>