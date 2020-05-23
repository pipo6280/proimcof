<?php

use system\Helpers\Form;
use app\dtos\ServicioDto;
use app\dtos\MantenimientoDto;

$object = $object instanceof MantenimientoDto ? $object : new MantenimientoDto(); 
?>

<?php echo Form::open(['action' => 'Mantenimiento@buscar_equipos', 'id' => 'frmBuscarEquipos']); ?>
    <div class="ibox float-e-margins">
        <div class="ibox-content">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-xs-12">
                    <div class="form-group">
                        <?php echo Form::label(lang('mantenimiento.cliente'), 'txtId_cliente'); ?>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fas fa-hotel"></i></span>
                            <?php echo Form::selectEnum('txtId_cliente', $object->getId_cliente(), $object->getList_clientes_enum(),[
                                'class' => 'form-control chosen-select ch'
                            ]);?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-xs-12">
                    <div class="form-group">
                        <?php echo Form::label(lang('mantenimiento.serial_equipo'), 'txtId_equipo'); ?>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fas fa-search"></i></span>
                            <?php echo Form::text('txtId_equipo', $object->getId_equipo(), [
                                'class' => 'form-control ch']
                            );?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-xs-12">
                    <div class="form-group">
                        <?php 
                        echo Form::button(lang('general.search_button_icon'), [
                            'class' => "ladda-button btn btn-info m-t-md pull-right {$object->getPermisoDto()->getIconEdit()}",
                            'id' => 'btnBuscar',
                            'type' => 'submit'
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo Form::close(); ?>

<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>
            <?php echo lang('mantenimiento.form_search'); ?>
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

</script>
