<?
use system\Helpers\Form;
use system\Support\Util;
use app\dtos\ReporteDto;
use system\Support\Arr;
use app\dtos\GastoDto;

$object = $object instanceof ReporteDto ? $object:new ReporteDto();
echo Form::open(['action' => 'reporte@gastos', 'id' => 'frmReporte']); ?>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group fecha-normal">
                                <?php echo Form::hide('txtSearch', 1)?>
                                <?php echo Form::label(lang('reporte.fecha_inicio'), 'txtFecha_inicio');?>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <?php 
                                        echo Form::text('txtFecha_inicio', Util::fecha($object->getFecha_inicio(), "d-m-Y")); 
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group fecha-normal">
                                <?php echo Form::label(lang('reporte.fecha_fin'), 'txtFecha_fin');?>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <?php 
                                        echo Form::text('txtFecha_fin', Util::fecha($object->getFecha_fin(), "d-m-Y")); 
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <?php echo Form::label(" ", " ");?>
                            <div class="form-group">
                                <?php
                                    echo Form::button(lang('general.search_button_icon', '<i class="fa fa-search"></i>&nbsp;&nbsp;'), [
                                        'class' => "ladda-button btn btn-success",
                                        'id' => 'btnGenerate',
                                        'type' => 'submit'
                                    ]);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (! Arr::isEmptyArray($object->getList())) { ?>
            <div id="REPORTE" class="col-sm-12 col-md-12 col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php echo lang('reporte.listado_gastos')?></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover datatable" >
                                <thead>
                                    <tr>
                                        <th>
                                            #
                                        </th>
                                        <th>
                                            <?php echo lang('reporte.descripcion'); ?>
                                        </th>
                                        <th class="text-center">
                                            <?php echo lang('reporte.fecha'); ?>
                                        </th>
                                        <th class="text-center ">
                                            <?php echo lang('reporte.valor'); ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $count = 1;
                                $sum = 0;
                                foreach ($object->getList() as $key => $lis) {
                                    if ($lis instanceof GastoDto) { ?>
                                    <tr class="gradeX">
                                        <td class="text-center ">
                                            <?php echo $count; ?>
                                        </td>
                                        <td class="text-center ">
                                            <?php echo $lis->getDescripcion(); ?>
                                        </td>
                                        <td class="text-center ">
                                            <?php echo $lis->getFechaFormato(); ?>
                                        </td>
                                        <td class="text-center ">
                                            <?php echo $lis->getValor(); ?>
                                        </td>
                                    </tr>
                                    <?php
                                       $count++;
                                       $sum += $lis->getValor();
                                    }
                                 } ?>
                                 <tr>
                                    <td class="text-center ">
                                            <?php echo $count; ?>
                                        </td>
                                        <td class="text-center ">
                                        </td>
                                        <td class="text-center ">
                                            <?php echo lang('reporte.total')?>
                                        </td>
                                        <td class="text-center ">
                                            <?php echo $sum; ?>
                                        </td>
                                 </tr>
                                </tbody>
                            </table>
                        </div>    
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php 
    echo Form::close();
?>
<script type="text/javascript">
    $.validator.addMethod("formatDate",
	    function(value, element) {
	        return value.match(/^(0?[1-9]|[12][0-9]|3[0-1])[/., -](0?[1-9]|1[0-2])[/., -](19|20)?\d{2}$/);
	    },
	    "Por favor, escribe una fecha válida con formato (dd-mm-yyyy)."
	); 

    function setDesactivarGrilla() {
    	$("#REPORTE").css('display', 'none');
    }
	
    $('button#btnGenerate').click(function () {
		BUTTON_CLICK = this;
	});   

    $('#txtFecha_fin, #txtFecha_inicio, #txtId_representante').change(function () {
    	setDesactivarGrilla();
	});   
 	
	if($("#frmReporte").length>0) {
		$("#frmReporte").validate({
			ignore: ":hidden:not(select)",
			submitHandler: function(form) {
				var l = Ladda.create(BUTTON_CLICK);
	            l.start();
                Framework.setLoadData({
                    pagina:'<?php echo site_url('reporte/gastos'); ?>',
                    data: $(form).serialize(),
                    success: function(data) {
                        if (data.contenido) {} else {
                        	Framework.setError('<?php echo lang('general.operation_message'); ?>');
                        }
                        l.stop();
                    }
                });
			},
			rules: {
				'txtFecha_inicio': { required: true, formatDate:true },
				'txtFecha_inicio': { required: true, formatDate:true }
			},
			errorPlacement: function(error, element) {
				if (element.attr("class").indexOf('chosen-select') != -1) {
				    var idInput = element.attr("id").split('-');
			        error.insertAfter("#" + idInput.join('_') + '_chosen');
			    } else if (element.parents('.i-checks').size() > 0) {
    				error.insertAfter(element.parents('.i-checks'));
    			} else if (element.parents('.input-group').size() > 0) {
    				error.insertAfter(element.parents('.input-group'));
    			} else {
			        error.insertAfter(element);
			    }
			}
		});
	}
</script>