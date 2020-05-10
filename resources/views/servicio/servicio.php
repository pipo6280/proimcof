<?php

use system\Helpers\Form;
use app\dtos\ServicioDto;

$object = $object instanceof ServicioDto ? $object : new ServicioDto(); 
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>
            <?php echo lang('servicio.form_search'); ?>
        </h5>
    </div>
    <div class="ibox-content">
        <div class="pull-right">
            <?php 
                echo Form::button(lang('general.add_button_icon'), [
                    'class' => "ladda-button ladda-button-demo btn btn-outline btn-success {$object->getPermisoDto()->getIconAdd()}",
                    'data-id_servicio' => null,
                    'data-nombre' => null,
                    'id' => 'btnAddServicio'
                ]);
            ?>
        </div>
        <div class="clearfix"></div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover datatable" >
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            <?php echo lang('servicio.descripcion'); ?>
                        </th>
                        <th class="text-center ">
                            <?php echo lang('servicio.activo'); ?>
                        </th>
                        <th class="text-center nosort">
                            <?php echo lang('general.edit_button'); ?>
                        </th>
                        <th class="text-center nosort">
                            <?php echo lang('general.delete_button'); ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    foreach ($object->getList() as $key => $lis) {
                        if ($lis instanceof ServicioDto) { ?>
                            <tr class="gradeX">
                                <td class="text-center ">
                                    <?php echo $count; ?>
                                </td>
                                <td class="text-center ">
                                    <?php echo $lis->getDescripcion(); ?>
                                </td>
                                <td class="text-center ">
                                    <?php echo $lis->getTitleEstado(); ?>
                                </td>
                                <td class="text-center" >
                                   <a href="javascript:void(0)" class="editServicio <?php echo $object->getPermisoDto()->getIconEdit(); ?>" data-id_servicio="<?php echo $lis->getId_servicio(); ?>" data-nombre="<?php echo $lis->getDescripcion(); ?>" data-toggle="tooltip" title="<?php echo lang('general.title_edit', [$count]); ?>">
                                        <i class=" <?php echo $object->getPermisoDto()->getClassEdit(); ?> fa-2x"></i>
                                   </a>
                                </td>
                                <td class="text-center" >
                                   <a href="javascript:void(0)" class="deleteServicio<?php echo $object->getPermisoDto()->getIconDelete(); ?>" data-toggle="tooltip" title="<?php echo lang('general.title_delete', [$count]); ?>" data-id_servicio="<?php echo $lis->getId_servicio(); ?>" data-nombre="<?php echo $lis->getDescripcion(); ?>">
                                        <i class=" <?php echo $object->getPermisoDto()->getClassDelete(); ?> fa-2x"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php $count++;?>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
                        
$('button#btnAddServicio,a.editServicio').click(function () {
	var options = jQuery.extend({ id_servicio : null, nombre : null }, $(this).data());
	var l = Ladda.create(this);
    l.start();
	Framework.setLoadData({
		pagina: '<?php echo site_url('servicio/edit'); ?>',
		data: { 
    		txtId_servicio : options.id_servicio 
        },
		success: function (data) { 
    		l.stop();
    	}
	});
});

$(document).ready(function () {
    $('a.deleteServicio').each(function () {
    	$(this).click(function () {
    		var options = jQuery.extend({
    			id_servicio : null,
    			nombre : null 
    		}, $(this).data());
    		Framework.setConfirmar({
    			contenido : 'Está a punto de eliminar el servicio: <b>'+ options.nombre +'</b> ¿Desea Continuar?',
    			aceptar : function() {
    				Framework.setLoadData({
    					id_contenedor_body : false,
    					pagina : '<?php echo site_url('servicio/delete'); ?>',
    					data : {
    						txtId_servicio : options.id_servicio
    					},
    					success : function(data) {
    						if (data.contenido) {
    							var message = '<?php echo lang('servicio.gasto_guardado_ok'); ?>';
    	                    	message = message.replace('{0}', data.contenido);
    	                        Framework.setSuccess(message);
    							Framework.setLoadData({
        							pagina : '<?php echo site_url('servicio/inicio'); ?>',
    								data : {
    									txtId_servicio : null
    								}
    							});
    						} else {
    							titulo = '<?php echo lang('servicio.no_delete'); ?>';
    			    			titulo = titulo.replace('{0}', options.nombre);
    							Framework.setError(titulo);
    						}							
    					}
    				});
    			}
    		});
        });
    });
});
</script>
