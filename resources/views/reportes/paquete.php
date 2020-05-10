<?php
use app\dtos\PaqueteDto;
use system\Helpers\Form;
use app\enums\ESiNo;
$object = $object instanceof PaqueteDto ? $object : new PaqueteDto();
?>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>
            <?php echo lang('paquete.form_search'); ?>
        </h5>
    </div>
    <div class="ibox-content">
        <div class="pull-right">
            <?php 
                echo Form::button(lang('general.add_button_icon'), [
                    'class' => "ladda-button ladda-button-demo btn btn-outline btn-success {$object->getPermisoDto()->getIconAdd()}",
                    'data-id_paquete' => null,
                    'data-nombre' => null,
                    'id' => 'btnAddPaquete'
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
                            <?php echo lang('paquete.nombre'); ?>
                        </th>
                        <th class="text-center">
                            <?php echo lang('paquete.clases_concurrentes'); ?>
                        </th>
                        <th class="text-center">
                            <?php echo lang('paquete.cupo'); ?>
                        </th>
                        <th class="text-center">
                            <?php echo lang('paquete.grupal'); ?>
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
                        <?php if ($lis instanceof PaqueteDto) { ?>
                            <tr class="gradeX">
                                <td>
                                    <?php echo $lis->getId_paquete(); ?>
                                </td>
                                <td>
                                    <?php echo $lis->getNombre(); ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $lis->getClases_concurrentes()?>
                                </td>
                                <td class="text-center">
                                    <?php echo $lis->getCupo()?>
                                </td>
                                <td class="text-center">
                                    <?php echo ESiNo::result($lis->getYn_grupal())->getDescription()?>
                                </td>
                                <td class="text-center" width="250">
                                   <a href="javascript:void(0)" class="editPaquete <?php echo $object->getPermisoDto()->getIconEdit(); ?>" data-id_paquete="<?php echo $lis->getId_paquete(); ?>" data-nombre="<?php echo $lis->getNombre(); ?>" data-toggle="tooltip" title="<?php echo lang('general.title_edit', [$lis->getNombre()]); ?>">
                                        <i class=" <?php echo $object->getPermisoDto()->getClassEdit(); ?> fa-2x"></i>
                                   </a>
                                </td>
                                <td class="text-center" width="250">
                                   <a href="javascript:void(0)" class="deletePaquete <?php echo $object->getPermisoDto()->getIconDelete(); ?>" data-toggle="tooltip" title="<?php echo lang('general.title_delete', [$lis->getNombre()]); ?>" data-id_paquete="<?php echo $lis->getId_paquete(); ?>" data-nombre="<?php echo $lis->getNombre(); ?>">
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
$('button#btnAddPaquete,a.editPaquete').click(function () {
	var options = jQuery.extend({id_paquete : null, nombre : null }, $(this).data());
	var l = Ladda.create(this);
    l.start();
	Framework.setLoadData({
		pagina: '<?php echo site_url('paquete/edit'); ?>',
		data: { txtId_paquete : options.id_paquete },
		success: function (data) { l.stop(); }
	});
});
            
$('a.deletePaquete').each(function () {
	$(this).click(function () {
		var options = jQuery.extend({
			id_paquete : null,
			nombre : null 
		}, $(this).data());
		Framework.setConfirmar({
			contenido : 'Está a punto de eliminar el paquete: <b>'+ options.nombre +'</b> ¿Desea Continuar?',
			aceptar : function() {
				Framework.setLoadData({
					id_contenedor_body : false,
					pagina : '<?php echo site_url('paquete/delete'); ?>',
					data : {
						txtId_paquete : options.id_paquete
					},
					success : function(data) {
						if (data.contenido) {
							var message = '<?php echo lang('paquete.save_ok'); ?>';
	                    	message = message.replace('{0}', data.contenido);
	                        Framework.setSuccess(message);
							Framework.setLoadData({
    							pagina : '<?php echo site_url('paquete/crear'); ?>',
								data : {
									txtId_paquete : null
								}
							});
						} else {
							titulo = '<?php echo lang('paquete.no_delete'); ?>';
			    			titulo = titulo.replace('{0}', options.nombre);
							Framework.setError(titulo);
						}							
					}
				});
			}
		});
    });
});
</script>
