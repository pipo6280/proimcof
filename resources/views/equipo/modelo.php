<?php

use system\Helpers\Form;
use app\dtos\EquipoDto;
use system\Support\Util;
use app\dtos\ModeloDto;

$object = $object instanceof EquipoDto ? $object : new EquipoDto(); 
?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>
            <?php echo lang('equipo.form_search_model'); ?>
        </h5>
    </div>
    <div class="ibox-content">
        <div class="pull-right">
            <?php 
                echo Form::button(lang('general.add_button_icon'), [
                    'class' => "ladda-button ladda-button-demo btn btn-outline btn-success {$object->getPermisoDto()->getIconAdd()}",
                    'data-id_equipo' => null,
                    'data-serial' => null,
                    'id' => 'btnAddModelo'
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
                        <th class="text-center nosort">
                            <?php echo lang('general.edit_button'); ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    foreach ($object->getList() as $key => $lis) {
                        if ($lis instanceof ModeloDto) { ?>
                            <tr class="gradeX">
                                <td class="text-center ">
                                    <?php echo $count; ?>
                                </td>
                                <td class="text-center ">
                                    <?php echo $lis->getMarcaDto()->getNombre(); ?>
                                </td>
                                <td class="text-center ">
                                    <?php echo $lis->getModelo(); ?>
                                </td>
                                <td class="text-center ">
                                    <?php echo $lis->getTitleTipo(); ?>
                                </td>
                                <td class="text-center ">
                                    <?php echo $lis->getTitleEstilo(); ?>
                                </td>
                                <td class="text-center" >
                                   <a href="javascript:void(0)" class="editModelo <?php echo $object->getPermisoDto()->getIconEdit(); ?>" data-id_modelo="<?php echo $lis->getId_modelo(); ?>" data-modelo="<?php echo $lis->getModelo(); ?>" data-toggle="tooltip" title="<?php echo lang('general.title_edit', [$count]); ?>">
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
	
    $('button#btnAddModelo,a.editModelo').click(function () {
    	var options = jQuery.extend({ id_modelo : null, modelo : null }, $(this).data());
    	var l = Ladda.create(this);
        l.start();
    	Framework.setLoadData({
    		pagina: '<?php echo site_url('equipo/edit_modelo'); ?>',
    		data: { 
        		txtId_modelo : options.id_modelo 
            },
    		success: function (data) { l.stop(); }
    	});
    });
    
});
</script>
