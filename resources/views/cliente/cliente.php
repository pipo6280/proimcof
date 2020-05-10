<?php

use system\Helpers\Form;
use app\dtos\ClienteDto;
use app\enums\ETipoEmpresa;

$object = $object instanceof ClienteDto ? $object : new ClienteDto(); 
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>
            <?php echo lang('cliente.form_search'); ?>
        </h5>
    </div>
    <div class="ibox-content">
        <div class="pull-right">
            <?php 
                echo Form::button(lang('general.add_button_icon'), [
                    'class' => "ladda-button ladda-button-demo btn btn-outline btn-success {$object->getPermisoDto()->getIconAdd()}",
                    'data-id_cliente' => null,
                    'data-nombre' => null,
                    'id' => 'btnAddCliente'
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
                            <?php echo lang('cliente.nit'); ?>
                        </th>
                        <th class="text-center ">
                            <?php echo lang('cliente.nombre'); ?>
                        </th>
                        <th class="text-center ">
                            <?php echo lang('cliente.numero_fijo'); ?>
                        </th>
                        <th class="text-center ">
                            <?php echo lang('cliente.email'); ?>
                        </th>
                        <th class="text-center ">
                            <?php echo lang('cliente.tipo'); ?>
                        </th>
                        <th class="text-center ">
                            <?php echo lang('cliente.direccion'); ?>
                        </th>
                        <th class="text-center ">
                            <?php echo lang('cliente.ciudad'); ?>
                        </th>
                        <th class="text-center nosort">
                            <?php echo lang('general.edit_button'); ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    foreach ($object->getList() as $key => $lis) {
                        if ($lis instanceof ClienteDto) { ?>
                            <tr class="gradeX">
                                <td class="text-center ">
                                    <?php echo $count; ?>
                                </td>
                                <td class="text-center ">
                                    <?php echo $lis->getNit() ?>
                                </td>
                                <td class="text-center ">
                                    <?php echo $lis->getNombre_empresa(); ?>
                                </td>
                                <td class="text-center ">
                                    <?php echo $lis->getTelefono()." - ".$lis->getMovil(); ?>
                                </td>
                                <td class="text-center ">
                                    <?php echo $lis->getEmail(); ?>
                                </td>
                                <td class="text-center ">
                                    <?php echo $lis->getTitleTipo(); ?>
                                </td>
                                <td class="text-center ">
                                    <?php echo $lis->getDirecion(); ?>
                                </td>
                                <td class="text-center ">
                                    <?php echo $lis->getCiudadDto()->getNombre_ciudad(); ?>
                                </td>
                                <td class="text-center" >
                                   <a href="javascript:void(0)" class="editCliente <?php echo $object->getPermisoDto()->getIconEdit(); ?>" data-id_cliente="<?php echo $lis->getId_cliente(); ?>" data-nombre="<?php echo $lis->getNombre_empresa(); ?>" data-toggle="tooltip" title="<?php echo lang('general.title_edit', [$lis->getNombre_empresa()]); ?>">
                                        <i class=" <?php echo $object->getPermisoDto()->getClassEdit(); ?> fa-2x"></i>
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
//$(document).ready(function () {
    $('button#btnAddCliente,a.editCliente').click(function () {
    	var options = jQuery.extend({ id_cliente : null, nombre : null }, $(this).data());
    	var l = Ladda.create(this);
        l.start();
    	Framework.setLoadData({
    		pagina: '<?php echo site_url('cliente/edit'); ?>',
    		data: { 
        		txtId_cliente : options.id_cliente 
            },
    		success: function (data) { 
        		l.stop();
        	}
    	});
    });
//});
</script>
