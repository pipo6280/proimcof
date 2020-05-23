<?php

use system\Helpers\Form;
use app\dtos\ServicioDto;
use app\dtos\MantenimientoDto;
use app\dtos\EquipoDto;

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
                        <?php echo Form::label(lang('mantenimiento.serial_equipo'), 'txtSearch_equipo'); ?>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fas fa-search"></i></span>
                            <?php echo Form::text('txtSearch_equipo', $object->getSearch_equipo(), [
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
                        <th>
                            <?php echo lang('servicio.descripcion'); ?>
                        </th>
                        <th class="text-center ">
                            <?php echo lang('servicio.activo'); ?>
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
                                    <?php echo $lis->getNombreEquipo(); ?>
                                </td>
                                <td class="text-center ">
                                    <?php echo $lis->getNombreEquipo(); ?>
                                </td>
                                <td class="text-center ">
                                    <?php echo $lis->getTitleEstado(); ?>
                                </td>
                                <td class="text-center" >
                                   <a href="javascript:void(0)" class="editServicio <?php echo $object->getPermisoDto()->getIconEdit(); ?>" data-id_servicio="<?php echo $lis->getId_equipo(); ?>" data-nombre="<?php echo $lis->getNombreEquipo(); ?>" data-toggle="tooltip" title="<?php echo lang('general.title_edit', [$lis->getNombreEquipo()]); ?>">
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
    $(function(){

    	$('button#btnBuscar').click(function () {
    		BUTTON_CLICK = this;
    	});

    	if($("#frmBuscarEquipos").length>0) {
    		$("#frmBuscarEquipos").validate({
    			ignore: ":hidden:not(select)",
    			submitHandler: function(form) {
    				var l = Ladda.create(BUTTON_CLICK);
    	            if( $("#txtSearch_equipo").val() == "" && $("#txtId_cliente").val() == "") {
    	            	Framework.setError('<?php echo lang('general.error_no_select_any_campo'); ?>');
    	            } else {
    	            	l.start();
    	            	Framework.setLoadData({                                                        
                            pagina : '<?php echo site_url('mantenimiento/buscar_equipos'); ?>',
                            data: $(form).serialize(),
                            success: function(data) {
                    		    l.stop();
                            }
                        });
        	        }
    			},
    			rules: {
    				'txtSearch_equipo': { minlength: 3 }
    			},
    			errorPlacement: function(error, element) {
    			    if (element.attr("class").indexOf('chosen-select') != -1) {
    				    var idInput = element.attr("id").split('-');
    			        error.insertAfter("#" + idInput.join('_') + '_chosen');
    			    } else if(element.parents('.input-group').size() > 0) {
    			    	error.insertAfter(element.parents('.input-group'));
    			    } else {
    			        error.insertAfter(element);
    			    }
    			}
    		});
    	};

		    	
    });
</script>
