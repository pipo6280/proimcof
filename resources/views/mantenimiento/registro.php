<?php

//use system\Support\Util;
use system\Helpers\Form;
use app\dtos\MantenimientoDto;
use system\Support\Util;
use app\enums\EDateFormat;

$object = $object instanceof MantenimientoDto ? $object : new MantenimientoDto(); 
//$object->getDto()->setYn_activo(Util::isVacio($object->getDto()->getYn_activo()) ? ESiNo::index(ESiNo::SI)->getId() : $object->getDto()->getYn_activo()); ?>
<?php echo Form::open(['action' => 'Mantenimiento@save', 'id' => 'frmEditMantenimiento']); ?>
 <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">       
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h4 class="media-heading">
                    <i class="fas fa-print"></i> 
                    <?php echo $object->getEquipoDto()->getNombreEquipo(); ?>
                </h4>
                <p> 
                    <i class="fas fa-map-marker-alt"></i> 
                    <?php echo $object->getEquipoDto()->getUbicacionEquipo(); ?>
                </p>
                <?php echo Form::hide('txtId_cliente_equipo', $object->getId_cliente());
                  echo Form::hide('txtId_equipo', $object->getId_equipo());
                  echo Form::hide('txtSearch_equipo', $object->getSearch_equipo());?>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xs-12">
                        <div class="form-group">
                            <?php echo Form::label(lang('mantenimiento.servicios'), 'txtId_servicio'); ?>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-cubes"></i></span>
                                <?php echo Form::selectEnum('txtId_servicio', $object->getId_servicio(), $object->getList_servicios_enum(),[
                                    'class' => 'form-control chosen-select ch',
                                    'required' => true
                                ]);?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-12">
                        <div class="form-group fecha-normal">
                            <?php echo Form::label(lang('mantenimiento.fecha'), 'txtFecha');?>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <?php 
                                    echo Form::text('txtFecha', $object->getFecha(), [
                                        'class' => 'form-control',
                                        'tabindex' => 8,
                                        'required' => true
                                    ]); 
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col-lg-12 col-md-12 col-xs-12">
                        <div class="form-group fecha-normal">
                        	<?php 
                                echo Form::label(lang('mantenimiento.descripcion'), 'txtDescripcion'); 
                  			    echo Form::textarea('txtDescripcion', $object->getDescripcion(), ['id' => 'txtDescripcion', 'rows' => '4', 'required' => true]); 
                  			 ?>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <div class="form-group fecha-normal">
                        	<?php 
                                echo Form::label(lang('mantenimiento.pendientes'), 'txtPendientes'); 
                  			    echo Form::textarea('txtPendientes', $object->getPendientes(), ['id' => 'txtPendientes', 'rows' => '4']); 
                  			 ?>
                        </div>
                    </div>
                </div>
            </div>
           <div class="ibox-footer">
                <div class="form-group">
                    <?php
                        echo Form::button(lang('general.back_button_icon'), [
                            'class' => "ladda-button btn btn-outline btn-warning",
                            'id' => 'btnBack'                        
                        ]);
                        echo '&nbsp;';
                        echo Form::button(lang('general.save_button_icon'), [
                            'class' => "ladda-button btn btn-primary {$object->getPermisoDto()->getIconEdit()}",
                            'id' => 'btnGuardar',
                            'type' => 'submit'
                        ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">       
        <div class="ibox float-e-margins">
             <div class="ibox-title">
             	<h4 class="media-heading"><?php echo lang('mantenimiento.form_historial') ?></h4> 
             </div>
             <div class="ibox-content"> 
             	<div class="scroller">   
                    <?php foreach ($object->getList_mantenimientos() as $mant) { ?>
                    	<?php $mant instanceof MantenimientoDto ?>
                        <div id="vertical-timeline" class="vertical-container dark-timeline" >                                      
                            <div class="vertical-timeline-block">
                                <div class="vertical-timeline-icon blue-bg">
                                    <i class="fas fa-tools"></i>                            
                                </div>          
                                <div class="vertical-timeline-content">
                                    <h2><?php echo $mant->getServicioDto()->getDescripcion()?> - <?php echo $mant->getPersonaDto()->getNombreCompletoPrimeraMayuscula() ?></h2>
                                    <span class="vertical-date">
                                        <small style="color:#1d84c6; font-weight:100%; "><?php echo Util::formatDate($mant->getFecha(), EDateFormat::index(EDateFormat::DIA_MES_ANO_LETTER)->getId() );  ?></small>
                                    </span>
                                    <br>
                                    <h3><?php echo lang('mantenimiento.descripcion') ?></h3>
                                    <p style="text-align: justify;">
                                    	<?php echo $mant->getDescripcion(); ?>
                                    </p>
                                    
                                    <h3><?php echo lang('mantenimiento.pendientes')?></h3>
                                    <p style="text-align: justify;">
                                    	<?php echo $mant->getPendientes(); ?>
                                    </p>
                                    
<!--                                     <a href="#" class="btn btn-sm btn-primary">More info</a>                             -->
                                </div>
                            </div>                                                                                                            
                        </div>
                    <?php } ?>                    
                </div> 
			</div>
		</div>                               
	</div>    
</div>
<?php echo Form::close(); ?>
<script type="text/javascript">
    $(function(){
        
    	$('button#btnBack').click(function () {
    		var l = Ladda.create(this);
            l.start();
            Framework.setLoadData({
    			pagina: '<?php echo site_url('mantenimiento/buscar_equipos'); ?>',
    			data: { 
    				txtSearch_equipo: $('#txtSearch_equipo').val(),
    	    		txtId_equipo : $('#txtId_equipo').val(),
    	    		txtId_cliente : $('#txtId_cliente_equipo').val() 
    	        },    			
    		});
    	});
    	

    	if($("#frmEditMantenimiento").length>0) {
    		$("#frmEditMantenimiento").validate({
    			ignore: ":hidden:not(select)",
    			submitHandler: function(form) {
    				var l = Ladda.create(BUTTON_CLICK);
    	            l.start();
    				Framework.setLoadData({
    					id_contenedor_body : false,
    	        		pagina: '<?php echo base_url('mantenimiento/save'); ?>',
    	        		data: $(form).serialize(),
    	        		success: function (data) {
        	        		//console.log(data.titulo);
    	        			Framework.setSuccess('<?php echo lang('general.save_message')?>');
    	        			$('button#btnBack').click();
    	        		}
    				});
    			},
    			/*rules: {
    				'txtDto-txtNombre_empresa': { required: true, minlength: 3 },
    			    'txtDto-txtNit': { required: true, minlength: 3 },
    			    'txtDto-txtMovil': { required: true, number: true, minlength: 10 }, 
    			    'txtDto-txtTelefono': { number: true, minlength: 6 }, 
    			    'txtDto-txtEmail': { required: true, email: true },
    			    'txtDto-txtCiudadDto-txtNombre_ciudad': { required: true},
    			    'txtDto-txtDescuento_scanner' : {min: 0},		    
    			},*/
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