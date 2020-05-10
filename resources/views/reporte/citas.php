<?php
    use system\Helpers\Lang;
    use app\dtos\ReporteDto;
    use system\Helpers\Form;
    use system\Support\Util;
    use system\Helpers\Html;
use app\dtos\ClienteCitaDto;
    
    $object = $object instanceof ReporteDto ? $object : new ReporteDto();
    echo Html::style('css/libs/timeline.css');
?>
<div class="main-box clearfix">
    <div class="main-box-body clearfix">
        <div class="row">
            <div class="col-md-12">
                <div class="BUTTON_ADD">
                    <?php echo Lang::text('reporte_text_citas_odontologos'); ?>
                </div>
                <br>
                <?php echo Form::open(array('id' => 'frmCitas')); ?>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <?php 
                                echo Form::label(Lang::text('reporte_representante'), 'txtFecha_inicio');
                                echo Form::selectEnum('txtId_representante', $object->getId_representante(), $object->getList(), array('class' => 'form-control select2-select notnull')); 
                            ?>
                        </div>
                        <div class="form-group col-md-4">
                            <?php echo Form::label(Lang::text('reporte_fecha_cita'), 'txtFecha_inicio'); ?>
                            <div class="input-group">
                                <span class="input-group-addon blue"><i class="fa fa-calendar"></i></span>
                                <?php echo Form::text('txtFecha_inicio', (Util::isVacio($object->getFecha_inicio()) ? Util::fechaActual() : $object->getFecha_inicio()), ['class' => 'form-control datepicker']); ?>
                            </div>  
                        </div>
                        <div class="form-group col-md-4"><br>
                            <?php echo Form::button(Lang::text('general_search_button'), 'btnBuscar'); ?>  
                        </div>    
                    </div>
                    <?php if (! Util::isVacio($object->getListControles())) { ?>
                        <div class="row">
                            <div class="form-group">
                                <table id="table-fixed" class="table table-hover table-striped ">
                                    <thead>
                                        <tr role="row">
                                            <th>
                                                <?php echo Lang::text('reporte_hora_inicio_cita'); ?>
                                            </th>
                                            <th>
                                                <?php echo Lang::text('reporte_hora_fin_cita'); ?>
                                            </th>
                                            <th>
                                                <?php echo Lang::text('reporte_cliente_cita'); ?>
                                            </th>
                                            <th>
                                                <?php echo Lang::text('reporte_observaciones_cita'); ?>
                                            </th>
                                            <th>
                                                <?php echo Lang::text('reporte_tipo_cita'); ?>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($object->getListControles() as $lis) {
                                            if ($lis instanceof ClienteCitaDto) { ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $lis->getHora_inicio(); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $lis->getHora_fin(); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $lis->getClienteDto()->getPersonaDto()->getNombreCompleto(); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $lis->getObservaciones(); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $lis->getServicioDto()->getNombre(); ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } ?>
                <?php echo Form::close(); ?>
            </div>
        </div>
    </div>
</div>
<?php echo Html::script('js/timeline.js'); ?>
<script>
    $(document).ready(function () {
    	$('#btnBuscar').click(function () {
    		Framework.LoadData({
				pagina : '<?php echo site_url('reporte/citas'); ?>',
				data : $('#frmCitas').serialize()
			});
        });
    });
</script>