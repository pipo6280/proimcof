<?php
use app\dtos\UsuarioPerfilDto;
use app\dtos\UsuarioMenuDto;
use system\Helpers\Form;
use app\enums\ESiNo;
$object = $object instanceof UsuarioPerfilDto ? $object : new UsuarioPerfilDto();
?>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>
            <?php echo lang('perfil.edit_form', [$object->getDto()->getNombre()]); ?>
        </h5>
    </div>
    <div class="ibox-content">
        <div class="clearfix"></div>
        <div class="i-checks">
            <?php echo Form::hide('txtId_perfil', $object->getDto()->getId_perfil()); ?>
			<label>
                <?php 
                    echo Form::checkbox(NULL, NULL, TRUE, [
                        'disabled' => 'disabled',
                        'id' => 'txtCheckAll'                        
                    ]); 
                ?> 
                <i></i>
                <?php echo Form::label(lang('general.check_all'), 'txtCheckAll'); ?>
			</label>
		</div>
        <?php echo Form::open(['action' => 'Perfil@save_perfil', 'id' => 'frmEditPerfil']); ?>
            <div class="row">
                <div class="form-group col-sm-6">
                    <?php 
                        echo Form::hide('txtDto-txtId_menu', $object->getDto()->getId_perfil());
                        echo Form::label(lang('perfil.name_perfil'), 'txtDto-txtNombre');
                        echo Form::text('txtDto-txtNombre', $object->getDto()->getNombre(), ['class' => 'form-control notnull']);
                    ?>
                </div>
                <div class="form-group col-sm-6">
                    <?php 
                        echo Form::label(lang('perfil.activo'), 'txtDto-txtYn_activo');
                        echo Form::selectEnum('txtDto-txtYn_activo', $object->getDto()->getYn_activo(), ESiNo::data());
                    ?>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="tabListaPermisosToPerfil">
                    <thead>
                        <tr>
                            <th rowspan="2" class="text-center" style="vertical-align: middle;">#</th>
                            <th rowspan="2" class="text-center" style="vertical-align: middle;"><?php echo lang('perfil.menu'); ?></th>
                            <th colspan="5" class="text-center" style="vertical-align: middle;">Permisos</th>
                        </tr>
                        <tr>
                            <th class="text-center"><?php echo lang('perfil.select_all'); ?></th>
                            <th class="text-center"><?php echo lang('perfil.permiso_view'); ?></th>
                    		<th class="text-center"><?php echo lang('perfil.permiso_add'); ?></th>
                    		<th class="text-center"><?php echo lang('perfil.permiso_edit'); ?></th>
                    		<th class="text-center"><?php echo lang('perfil.permiso_del'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($object->getArbolMenu() as $keyPefil => $lis) {
                            if ($lis instanceof UsuarioMenuDto) {
                                $checked = $lis->getPerfilPermisoDto()->getYn_view() == ESiNo::index(ESiNo::SI)->getId();
                                $checked = ($checked && $lis->getPerfilPermisoDto()->getYn_add() == ESiNo::index(ESiNo::SI)->getId());
                                $checked = ($checked && $lis->getPerfilPermisoDto()->getYn_edit() == ESiNo::index(ESiNo::SI)->getId());
                                $checked = ($checked && $lis->getPerfilPermisoDto()->getYn_delete() == ESiNo::index(ESiNo::SI)->getId());
                                
                                $sClassFilaResaltada = '';
                                if ($lis->getNivelMenu() * 1 === 0) {
                                    $sClassFilaResaltada = 'fila_resaltada';
                                } ?>
                                <tr>
                                    <td class="text-center">
                                        <?php echo $lis->getId_menu(); ?>
                                    </td>
                                    <td class="<?php echo $sClassFilaResaltada; ?>">
                                        <?php echo $lis->getNombre(); ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="i-checks">
                                			<label for="<?php echo "txtCheckRow$keyPefil"; ?>">
                                                <?php echo Form::checkbox("txtCheckRow{$keyPefil}", NULL, $checked, ['class' => 'chkAll', 'title' => lang('perfil.marcar_desmarcar')]); ?> 
                                                <i></i>
                                			</label>
                                		</div>
                                    </td>
                                    <td class="text-center">
                                        <div class="i-checks" data-cclass="icheckbox_square-blue">
                                			<label for="<?php echo "txtYn_view_$keyPefil"; ?>">
                                                <?php echo Form::checkbox("txtYn_view_$keyPefil", NULL, ($lis->getPerfilPermisoDto()->getYn_view() == ESiNo::index(ESiNo::SI)->getId()), ['data-id_menu' => $lis->getId_menu(), 'data-header' => 'p_view', 'data-old_value' => $lis->getPerfilPermisoDto()->getYn_view()]); ?> 
                                                <i></i>
                                			</label>
                                		</div>
                                    </td>
                                    <td class="text-center">
                                        <div class="i-checks" data-cclass="icheckbox_square-red">
                                			<label for="<?php echo "txtYn_add_$keyPefil"; ?>">
                                                <?php echo Form::checkbox("txtYn_add_$keyPefil", NULL, ($lis->getPerfilPermisoDto()->getYn_add() == ESiNo::index(ESiNo::SI)->getId()), ['data-id_menu' => $lis->getId_menu(), 'data-header' => 'p_add', 'data-old_value' => $lis->getPerfilPermisoDto()->getYn_add()]); ?> 
                                                <i></i>
                                			</label>
                                		</div>                                        
                                    </td>
                                    <td class="text-center">
                                        <div class="i-checks" data-cclass="icheckbox_square-orange">
                                			<label for="<?php echo "txtYn_add_$keyPefil"; ?>">
                                                <?php echo Form::checkbox("txtYn_edit_$keyPefil", NULL, ($lis->getPerfilPermisoDto()->getYn_edit() == ESiNo::index(ESiNo::SI)->getId()), ['data-id_menu' => $lis->getId_menu(), 'data-header' => 'p_edit', 'data-old_value' => $lis->getPerfilPermisoDto()->getYn_edit()]); ?> 
                                                <i></i>
                                			</label>
                                		</div>
                                    </td>
                                    <td class="text-center">
                                        <div class="i-checks" data-cclass="icheckbox_square-purple">
                                			<label for="<?php echo "txtYn_add_$keyPefil"; ?>">
                                                <?php echo Form::checkbox("txtYn_delete_$keyPefil", NULL, ($lis->getPerfilPermisoDto()->getYn_delete() == ESiNo::index(ESiNo::SI)->getId()), ['data-id_menu' => $lis->getId_menu(), 'data-header' => 'p_del', 'data-old_value' => $lis->getPerfilPermisoDto()->getYn_delete()]); ?> 
                                                <i></i>
                                			</label>
                                		</div>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>   
                    </tbody>
                </table>
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
			var contenedorPadre = $(this).parents('tr').find('input');
			$(contenedorPadre).iCheck('check');
  		});
    	$('.chkAll').on('ifUnchecked', function(event){
			var contenedorPadre = $(this).parents('tr').find('input');
			$(contenedorPadre).iCheck('uncheck');
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
    				var aData = new Array();
                    var stdClass = null;                                                                                                    
                    var objSend = new Object();
                    objSend.id_perfil = $('#txtDto-txtId_menu').val();                                            
                    var nFilas = $("#tabListaPermisosToPerfil tbody tr").length;
                    for (var c = 0; c < nFilas; c++) {
                        stdClass = new Object();                                                                                                
                        var aChFilaActual = $("#tabListaPermisosToPerfil tbody tr:eq("+ c +") input[type=checkbox]");
                        var nCheckbox = $("#tabListaPermisosToPerfil tbody tr:eq("+ c +") input[type=checkbox]").length;
                        var actualizarFila = false;
                        var id_menu = $(aChFilaActual[1]).data('id_menu');
                        stdClass['id_menu'] = id_menu;
                        for (var i = 0; i < nCheckbox; i++) {
                        	var permiso_actual = $(aChFilaActual[i]).data('header');
                        	if (permiso_actual != undefined) {
                                var booleanNumber = 2;
                                var chChecked = aChFilaActual[i].checked;
                                var old_value = $(aChFilaActual[i]).data('old_value');                                                    
                                var id_menu = $(aChFilaActual[i]).data('id_menu');
                                if (chChecked) {
                                    booleanNumber = 1;
                                }
                                if (old_value !== booleanNumber) {
                                    actualizarFila = true;
                                }
                            	stdClass[permiso_actual] = booleanNumber;
                            }
                        }
                        if (actualizarFila) {
                            aData[aData.length] = stdClass;
                        }
                        stdClass = null;
                    }
                    if (aData.length < 1) {
                        Framework.setWarning('No se han detectado cambios!');
                        return false;
                    }
                    aData['id_perfil'] = $('#txtId_perfil').val();
                    objSend.nombre = $('#txtDto-txtNombre').val();
                    objSend.yn_activo = $('#txtDto-txtYn_activo').val();
                    objSend.dataJson = JSON.stringify(aData);
                    console.log(objSend);
                    Framework.setLoadData({                                                        
                        id_contenedor_body: false,
                        pagina : '<?php echo site_url('perfil/save_permissions'); ?>',
                        data: objSend,
                        success: function(data) {
                            Framework.setSuccess(data.contenido);
                            Framework.setLoadData({
                        		pagina : '<?php echo base_url('perfil/perfil/'); ?>'
                        	});
                        }
                    });
    			},
    			rules: {
    				'txtDto-txtNombre': { required: true, minlength: 5 },
    				'txtDto-txtYn_activo': "required"
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