<?php

use system\Helpers\Form;
use app\dtos\ServicioDto;
use app\dtos\MantenimientoDto;
use app\dtos\EquipoDto;
use app\enums\EEstadoMantenimiento;

$object = $object instanceof MantenimientoDto ? $object : new MantenimientoDto(); 
?>

<?php echo Form::open(['action' => 'Mantenimiento@buscar_equipos', 'id' => 'frmBuscarEquipos']); ?>
    <div class="ibox float-e-margins">
        <div class="ibox-content">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-xs-12">
                    <div class="form-group">
                        <?php echo Form::label(lang('mantenimiento.estado'), 'txtEstado'); ?>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fas fa-hotel"></i></span>
                            <?php echo Form::selectEnum('txtEstado', $object->getEstado(), EEstadoMantenimiento::data(),[
                                'class' => 'form-control chosen-select ch'
                            ]);?>
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
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover datatable">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th class="text-center ">
                            <?php echo lang('mantenimiento.equipo'); ?>
                        </th>
                        <th class="text-center " >        
                            <?php echo lang('mantenimiento.ubicacion'); ?>
                        </th>
                        <th class="text-center " >        
                            <?php echo lang('mantenimiento.solicitud'); ?>
                        </th>
                        <th class="text-center ">
                            <?php echo lang('mantenimiento.estado'); ?>
                        </th>
                        <th class="text-center nosort">
                            <?php echo lang('mantenimiento.registrar'); ?>
                        </th>           
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    foreach ($object->getList_mantenimientos() as $key => $lis) {
                        if ($lis instanceof MantenimientoDto) { ?>
                            <tr class="gradeX">
                                <td class="text-center ">
                                    <?php echo $count; ?>
                                </td>
                                <td class="text-center ">
                                    <?php echo $lis->getEquipoDto()->getNombreEquipo(); ?>
                                </td>
                                <td class="text-center ">                                 
                                    <?php echo $lis->getEquipoDto()->getClienteSedeDto()->getClienteDto()->getNombre_empresa(); ?>
                                </td>
                                <td class="text-justify ">
                                    <?php echo $lis->getAntecedente(); ?>
                                </td>
                                <td class="text-center ">
                                    <?php echo $lis->getTitleEstado(); ?>
                                </td>
                                <td class="text-center" >
									<a href="#" class="editMantenimiento <?php echo $object->getPermisoDto()->getIconEdit(); ?>" data-id_mantenimiento="<?php echo $lis->getId_mantenimiento(); ?>"  data-nombre="<?php echo $lis->getEquipoDto()->getNombreEquipo(); ?>" data-toggle="tooltip" title="<?php echo lang('general.title_edit', [$lis->getEquipoDto()->getNombreEquipo()]); ?>">
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
    	$('a.editMantenimiento').click(function () {
    		var options = jQuery.extend({ id_equipo : null, id_cliente : null, search_equipo : null}, $(this).data());
    		//var l = Ladda.create(this);
    	    //l.start();
    		Framework.setLoadData({
    			pagina: '<?php echo site_url('mantenimiento/edit'); ?>',
    			data: { 
    				txtSearch_equipo: options.search_equipo,
    	    		txtId_equipo : options.id_equipo,
    	    		txtId_cliente : options.id_cliente 
    	        },    			
    		});
    	});

    	$('a.historyMantenimiento').click(function () {
    		var options = jQuery.extend({ id_equipo : null, id_cliente : null, search_equipo : null}, $(this).data());
    		//var l = Ladda.create(this);
    	    //l.start();
    		Framework.setLoadData({
    			pagina: '<?php echo site_url('mantenimiento/historial'); ?>',
    			data: { 
    				txtSearch_equipo: options.search_equipo,
    	    		txtId_equipo : options.id_equipo,
    	    		txtId_cliente : options.id_cliente 
    	        },    			
    		});
    	});

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
                            pagina : '<?php echo site_url('mantenimiento/inicio'); ?>',
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
