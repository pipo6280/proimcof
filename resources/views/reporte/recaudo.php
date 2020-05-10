<?php
    use system\Helpers\Lang;
    use app\dtos\ReporteDto;
    use system\Helpers\Form;
    use system\Support\Util;
use system\Support\Number;
    
    $object = $object instanceof ReporteDto ? $object : new ReporteDto();
?>
<div class="main-box clearfix">
    <div class="main-box-body clearfix">
        <?php echo Form::open(array('id' => 'frmRecaudo')); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="BUTTON_ADD">
                        <?php echo Lang::text('reporte_text_recaudo'); ?>
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <?php echo Form::label(Lang::text('reporte_fecha_inicio'), 'txtFecha_inicio'); ?>
                            <div class="input-group">
                                <span class="input-group-addon blue"><i class="fa fa-calendar"></i></span>
                                <?php echo Form::text('txtFecha_inicio', (Util::isVacio($object->getFecha_inicio()) ? Util::restarFecha(Util::fechaActual(true), array('m' => 1)) : $object->getFecha_inicio()), ['class' => 'form-control datepicker notnull']); ?>
                            </div> 
                        </div>
                        <div class="form-group col-md-3">
                            <?php echo Form::label(Lang::text('reporte_fecha_fin'), 'txtFecha_fin'); ?>
                            <div class="input-group">
                                <span class="input-group-addon blue"><i class="fa fa-calendar"></i></span>
                                <?php echo Form::text('txtFecha_fin', (Util::isVacio($object->getFecha_fin()) ? Util::fechaActual() : $object->getFecha_fin()), ['class' => 'form-control datepicker']); ?>
                            </div>  
                        </div>
                        <div class="form-group col-md-3"><br>
                            <?php echo Form::button(Lang::text('general_search_button'), 'btnBuscar'); ?>  
                        </div>    
                    </div>
                </div>
            </div>
            <?php if (! Util::isVacio($object->getFecha_inicio())) { ?>
                <div class="row">
                    <div class="col-md-6">
                        <table id="" class="table table-hover table-striped ">
                            <thead>
                                <tr role="row">
                                    <th>
                                        <?php echo Lang::text('reporte_recaudo_servicio'); ?>
                                    </th>
                                    <th>
                                        <?php echo Lang::text('reporte_recaudo_total'); ?>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $totalRecaudo = 0; ?>
                                <?php foreach ($object->getListServicios() as $lis) { ?>
                                    <?php $totalRecaudo += $lis->getTotalRecaudo(); ?>
                                    <tr>
                                        <td>
                                            <?php echo $lis->getNombre(); ?>
                                        </td>
                                        <td>
                                            $ <?php echo Number::format($lis->getTotalRecaudo()); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                 <tr>
                                    <td>
                                        Total
                                    </td>
                                    <td>
                                        $ <?php echo Number::format($totalRecaudo); ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } ?>
        <?php echo Form::close(); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
    	$('#btnBuscar').click(function () {
    		Framework.LoadData({
        		pagina : '<?php echo site_url('reporte/recaudo'); ?>',
        		data : $('#frmRecaudo').serialize()
        	});
        });
    });
</script>