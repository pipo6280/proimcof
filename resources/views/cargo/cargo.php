<?php
use app\dtos\RhCargoDto;
use system\Helpers\Form;
$object = $object instanceof RhCargoDto ? $object : new RhCargoDto(); ?>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>
            <?php echo lang('cargo.form_search'); ?>
        </h5>
    </div>
    <div class="ibox-content">
        <div class="pull-right">
            <?php 
                echo Form::button(lang('general.add_button_icon'), [
                    'class' => "ladda-button ladda-button-demo btn btn-outline btn-success {$object->getPermisoDto()->getIconAdd()}",
                    'data-id_cargo' => null,
                    'data-nombre' => null,
                    'id' => 'btnAddCargo'
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
                            <?php echo lang('cargo.nombre'); ?>
                        </th>
                        <th class="text-center nosort">
                            <?php echo lang('cargo.activo'); ?>
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
                    <?php foreach ($object->getList() as $key => $lis) { ?>
                        <?php if ($lis instanceof RhCargoDto) { ?>
                            <tr class="gradeX">
                                <td>
                                    <?php echo $lis->getId_cargo(); ?>
                                </td>
                                <td>
                                    <?php echo $lis->getNombre(); ?>
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0);" class="changeState <?php echo $object->getPermisoDto()->getIconEdit(); ?>" data-id_cargo="<?php echo $lis->getId_cargo(); ?>" data-nombre="<?php echo $lis->getNombre(); ?>" data-yn_activo="<?php echo $lis->getYn_activo(); ?>" data-toggle="tooltip" title="<?php echo $lis->getTitleEstado(); ?>">
                                        <i class="<?php echo $lis->getClassEstado(); ?> fa-2x"></i>
                                    </a>
                                </td>
                                <td class="text-center" width="250">
                                   <a href="javascript:void(0)" class="editCargo <?php echo $object->getPermisoDto()->getIconEdit(); ?>" data-id_cargo="<?php echo $lis->getId_cargo(); ?>" data-nombre="<?php echo $lis->getNombre(); ?>" data-toggle="tooltip" title="<?php echo lang('general.title_edit', [$lis->getNombre()]); ?>">
                                        <i class=" <?php echo $object->getPermisoDto()->getClassEdit(); ?> fa-2x"></i>
                                   </a>
                                </td>
                                <td class="text-center" width="250">
                                   <a href="javascript:void(0)" class="deleteCargo <?php echo $object->getPermisoDto()->getIconDelete(); ?>" data-toggle="tooltip" title="<?php echo lang('general.title_delete', [$lis->getNombre()]); ?>" data-id_cargo="<?php echo $lis->getId_cargo(); ?>" data-nombre="<?php echo $lis->getNombre(); ?>">
                                        <i class=" <?php echo $object->getPermisoDto()->getClassDelete(); ?> fa-2x"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
	$('button#btnAddCargo,a.editCargo').click(function () {
		var options = jQuery.extend({ id_cargo : null, nombre : null }, $(this).data());
		var l = Ladda.create(this);
        l.start();
		Framework.setLoadData({
			pagina: '<?php echo site_url('cargo/edit'); ?>',
			data: { txtId_cargo : options.id_cargo },
			success: function (data) { l.stop(); }
		});
    });
	$('a.changeState').each(function () {
    	$(this).click(function () {
    		var options = jQuery.extend({
    			id_cargo: null,
    			yn_activo: null,
    			nombre: null
    		}, $(this).data());        		
    		Framework.setConfirmar({
    			contenido: '<?php echo lang('cargo.mensaje_confirmacion'); ?>',
    		    aceptar: function () {
    		        Framework.setLoadData({
    		            id_contenedor_body: false,
    		            pagina: '<?php echo site_url('cargo/change_state'); ?>',
    		            data: {
    		                txtId_cargo: options.id_cargo,
    		                txtYn_activo: options.yn_activo
		                },
		                success: function (data) {
		                    if (data.contenido) {
		                    	var message = '<?php echo lang('cargo.cargo_change_ok'); ?>';
		                    	message = message.replace('{0}', options.nombre);
		                        Framework.setSuccess(message);
		                        Framework.setLoadData({
		                            pagina: '<?php echo site_url('cargo/cargo'); ?>',
		                            data: {
		                                txtId_perfil: null
	                                }
            				    });
	                        } else {
	                        	Framework.setError('<?php echo lang('general.operation_message'); ?>');
                        	}
	                    }
	                });
 			   }	
    	    });
    	});
    });
    $('a.deleteCargo').each(function () {
    	$(this).click(function () {
    		var options = jQuery.extend({
    			id_cargo : null,
    			nombre : null 
    		}, $(this).data());
    		Framework.setConfirmar({
    			contenido : 'Está a punto de eliminar el cargo: <b>'+ options.nombre +'</b> ¿Desea Continuar?',
    			aceptar : function() {
    				Framework.setLoadData({
    					id_contenedor_body : false,
    					pagina : '<?php echo site_url('cargo/delete'); ?>',
    					data : {
    						txtId_cargo : options.id_cargo
    					},
    					success : function(data) {
    						if (data.contenido) {
    							var message = '<?php echo lang('cargo.cargo_guardado_ok'); ?>';
		                    	message = message.replace('{0}', data.contenido);
		                        Framework.setSuccess(message);
    							Framework.setLoadData({
        							pagina : '<?php echo site_url('cargo/cargo'); ?>',
    								data : {
    									txtId_cargo : null
    								}
    							});
    						} else {
    							titulo = '<?php echo lang('cargo.no_delete'); ?>';
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