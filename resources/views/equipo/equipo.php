<?php

use system\Helpers\Form;
use app\dtos\EquipoDto;
use system\Support\Util;

$object = $object instanceof EquipoDto ? $object : new EquipoDto(); 
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>
            <?php echo lang('equipo.form_search'); ?>
        </h5>
    </div>
    <div class="ibox-content">
        <div class="pull-right">
            <?php 
                echo Form::button(lang('general.add_button_icon'), [
                    'class' => "ladda-button ladda-button-demo btn btn-outline btn-success {$object->getPermisoDto()->getIconAdd()}",
                    'data-id_equipo' => null,
                    'data-serial' => null,
                    'id' => 'btnAddEquipo'
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
                            <?php echo lang('equipo.marca'); ?>
                        </th>
                        <th class="text-center ">
                            <?php echo lang('equipo.modelo'); ?>
                        </th>
                        <th class="text-center ">
                            <?php echo lang('equipo.tipo'); ?>
                        </th>
                        <th class="text-center ">
                            <?php echo lang('equipo.estilo'); ?>
                        </th>
                        <th class="text-center ">
                            <?php echo lang('equipo.serial'); ?>
                        </th>
                        <th class="text-center ">
                            <?php echo lang('equipo.estado'); ?>
                        </th>
                        <th class="text-center ">
                            <?php echo lang('equipo.contador_copias'); ?>
                        </th>
                        <th class="text-center ">
                            <?php echo lang('equipo.contador_scanner'); ?>
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
                        if ($lis instanceof EquipoDto) { ?>
                            <tr class="gradeX">
                                <td class="text-center ">
                                    <?php echo $count; ?>
                                </td>
                                <td class="text-center ">
                                    <?php echo $lis->getMarcaDto()->getNombre(); ?>
                                </td>
                                <td class="text-center ">
                                    <?php echo $lis->getModeloDto()->getModelo(); ?>
                                </td>
                                <td class="text-center ">
                                    <?php echo $lis->getModeloDto()->getTitleTipo(); ?>
                                </td>
                                <td class="text-center ">
                                    <?php echo $lis->getModeloDto()->getTitleEstilo(); ?>
                                </td>
                                <td class="text-center ">
                                    <?php echo $lis->getSerial_equipo(); ?>
                                </td>
                                <td class="text-center ">
                                    <?php echo $lis->getTitleEstado(); ?>
                                </td>
                                <td class="text-center ">
                                    <?php echo Util::formatNumber($lis->getContador_inicial_copia()); ?>
                                </td>
                                <td class="text-center ">
                                    <?php echo Util::formatNumber($lis->getContador_inicial_scanner()); ?>
                                </td>
                                <td class="text-center" >
                                   <a href="javascript:void(0)" class="editEquipo <?php echo $object->getPermisoDto()->getIconEdit(); ?>" data-id_equipo="<?php echo $lis->getId_equipo(); ?>" data-serial="<?php echo $lis->getSerial_equipo(); ?>" data-toggle="tooltip" title="<?php echo lang('general.title_edit', [$lis->getSerial_equipo()]); ?>">
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
$(document).ready(function () {
	
    $('button#btnAddEquipo,a.editEquipo').click(function () {
    	var options = jQuery.extend({ id_equipo : null, serial : null }, $(this).data());
    	var l = Ladda.create(this);
        l.start();
    	Framework.setLoadData({
    		pagina: '<?php echo site_url('equipo/edit'); ?>',
    		data: { 
        		txtId_equipo : options.id_equipo 
            },
    		success: function (data) { l.stop(); }
    	});
    });
    
});
</script>
