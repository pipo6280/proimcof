<?php

use system\Helpers\Form;
use app\dtos\ClienteDto;
use system\Support\Util;
use app\dtos\ClienteSedeDto;
use system\Support\Arr;
use app\dtos\ClienteSedeEquipoDto;
use app\enums\ESiNo;
use app\enums\ETipoEquipo;
use app\enums\EEstilo;

$idNo = ESiNo::index(ESiNo::NO)->getId();
$idMulfuncion = ETipoEquipo::index(ETipoEquipo::MULTIFUNCION)->getId();
$idBlanco = EEstilo::index(EEstilo::BLANCO_NEGRO)->getId();

$object = $object instanceof ClienteDto ? $object : new ClienteDto();  ?>
<?php echo Form::open(['action' => 'Cliente@get_equipos_cliente', 'id' => 'frmCliente', 'class' => 'col s12']); ?>
    <div class="ibox float-e-margins">
        <div class="ibox-content">
            <div class="row">        		
                <div class="form-group col-md-2 col-lg-2">
                    <?php echo Form::label(lang('cliente.anho'), 'txtAnho_actual'); ?>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <?php echo Form::selectEnum('txtAnho_actual', $object->getAnho_actual(), Util::getYearEnum()); ?>
                    </div>
                </div>
                
                <div class="form-group col-md-2 col-lg-2">
                    <?php echo Form::label(lang('cliente.mes'), 'txtId_mes'); ?>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <?php echo Form::selectMonth('txtId_mes', $object->getId_mes());?>
                    </div>
                </div>
                
                <div class="form-group col-md-3 col-lg-3">
                    <?php echo Form::label(lang('cliente.cliente'), 'txtId_cliente'); ?>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                        <?php 
                        echo Form::selectEnum('txtId_cliente', $object->getId_cliente(), $object->getList());
                        ?>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-3 col-xs-12">
    				<div class="form-group">
                        <?php
                        echo Form::button(lang('general.search_button_icon'), [
                            'class' => "ladda-button btn btn-info m-t-md pull-right {$object->getPermisoDto()->getIconEdit()}",
                            'id' => 'btnBuscar',
                            'type' => 'submit'
                        ]);
                        ?>
                    </div>
    			</div>
            </div>
        </div>
    </div>
<?php echo Form::close(); ?>
<?php echo Form::open(['action' => 'Cliente@registrar_pago', 'id' => 'frmPago', 'class' => 'col s12']); ?>    
    <?php if( !Arr::isEmptyArray($object->getDto()->getList_sedes()) ) { ?>
        <div class="ibox float-e-margins vistaPago" >
            <div class="ibox-content">
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" >
                        <tbody>
                            <?php foreach ( $object->getDto()->getList_sedes() as $k => $lis) { ?>
                            <?php $lis instanceof ClienteSedeDto; ?>
                                <tr class="gradeX">
                                    <th class="text-left" colspan="6">
                                        <?php echo $lis->getNombre(); ?>
                                    </th> 
                                </tr>
                                <?php foreach ($lis->getList_equipos() as $ke => $eqp) { ?>
                                    <?php $eqp instanceof ClienteSedeEquipoDto; ?>
                                    <tr class="">
                                        <td class="text-center ">
                                            <?php echo $eqp->getNameEquipo(); ?>
                                        </td>
                                        <td class="text-center ">
                                            <div class="form-group">
                                                <?php echo Form::label(lang('cliente.contador_copia_bn'), "txtEquipo-txtContador_scanner{$ke}"); ?>   
                                                <div class="input-group">
                                                    <span class="input-group-btn"><span class="btn btn-success"><?php echo lang('cliente.inicial').$eqp->getContador_copia_bn_ant() ?></span></span>
                                                    <?php echo Form::number("txtEquipo-txtContador_scanner[{$ke}]", $eqp->getContador_copia_bn(), [
                                                        'class' => "form-control CONTADOR CNT_{$eqp->getId_cliente_sede_equipo()}",
                                                        'data-id_cliente_sede_equipo' => $eqp->getId_cliente_sede_equipo(),
                                                        'data-id_cliente_sede_equipo_fecha' => $eqp->getId_cliente_sede_equipo_fecha(),                                                        
                                                        'data-val_inicial' => $eqp->getContador_copia_bn_ant(),
                                                        'data-idx' => 1,
                                                    ]); ?>
                                                </div>
                                            </div>
                                        </td> 
                                        <td class="text-center ">
                                            <div class="form-group">
                                                <?php echo Form::label(lang('cliente.contador_copia_color'), "txtEquipo-txtContador_scanner{$ke}"); ?>
                                                <div class="input-group">
                                                    <span class="input-group-btn"><span class="btn btn-success"><?php echo lang('cliente.inicial').$eqp->getContador_copia_color_ant() ?></span></span>
                                                    <?php
                                                    $options = array(
                                                        'class' => "form-control CONTADOR CNT_{$eqp->getId_cliente_sede_equipo()}",
                                                        'data-id_cliente_sede_equipo' => $eqp->getId_cliente_sede_equipo(),
                                                        'data-id_cliente_sede_equipo_fecha' => $eqp->getId_cliente_sede_equipo_fecha(),
                                                        'data-val_inicial' => $eqp->getContador_copia_color_ant(),
                                                        'data-idx' => 2
                                                    );                                                    
                                                    $options['disabled'] = ($eqp->getEquipoDto()->getModeloDto()->getEstilo() == $idBlanco);
                                                    echo Form::number("txtEquipo-txtContador_scanner[{$ke}]", $eqp->getContador_copia_color(), $options);
                                                    unset($options);
                                                    ?>
                                                </div>
                                            </div>
                                        </td>  
                                        <td class="text-center ">
                                            <div class="form-group">
                                                <?php echo Form::label(lang('cliente.contador_impresion_bn'), "txtEquipo-txtContador_scanner{$ke}"); ?>
                                                <div class="input-group">
                                                    <span class="input-group-btn"><span class="btn btn-success"> <?php echo lang('cliente.inicial').$eqp->getContador_impresion_bn_ant() ?></span></span>
                                                    <?php
                                                    $options = array(
                                                        'class' => "form-control CONTADOR CNT_{$eqp->getId_cliente_sede_equipo()}",
                                                        'data-id_cliente_sede_equipo' => $eqp->getId_cliente_sede_equipo(),
                                                        'data-id_cliente_sede_equipo_fecha' => $eqp->getId_cliente_sede_equipo_fecha(),
                                                        'data-val_inicial' => $eqp->getContador_impresion_bn_ant(),
                                                        'data-idx' => 3
                                                    );
                                                    $options['disabled'] = $eqp->getSeparar_copia_impresion() == $idNo;
                                                    echo Form::number("txtEquipo-txtContador_scanner[{$ke}]", $eqp->getContador_impresion_bn(), $options);
                                                    unset($options);
                                                    ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center ">
                                            <div class="form-group">
                                                <?php echo Form::label(lang('cliente.contador_impresion_color'), "txtEquipo-txtContador_scanner{$ke}"); ?>
                                                <div class="input-group">
                                                    <span class="input-group-btn"><span class="btn btn-success"> <?php echo lang('cliente.inicial').$eqp->getContador_impresion_color_ant() ?></span></span>
                                                    <?php 
                                                    $options = array(
                                                        'class' => "form-control CONTADOR CNT_{$eqp->getId_cliente_sede_equipo()}",
                                                        'data-id_cliente_sede_equipo' => $eqp->getId_cliente_sede_equipo(),
                                                        'data-id_cliente_sede_equipo_fecha' => $eqp->getId_cliente_sede_equipo_fecha(),
                                                        'data-val_inicial' => $eqp->getContador_impresion_color_ant(),
                                                        'data-idx' => 4
                                                    );
                                                    $options['disabled'] = ($eqp->getEquipoDto()->getModeloDto()->getEstilo() == $idBlanco || $eqp->getSeparar_copia_impresion() == $idNo);
                                                    echo Form::number("txtEquipo-txtContador_scanner[{$ke}]", $eqp->getContador_impresion_color(), $options);
                                                    unset($options);
                                                    ?>
                                                </div>
                                            </div>
                                        </td>  
                                        <td class="text-center ">
                                            <div class="form-group">
                                                <?php echo Form::label(lang('cliente.contador_scanner'), "txtEquipo-txtContador_scanner{$ke}"); ?>
                                                <div class="input-group">
                                                    <span class="input-group-btn"><span class="btn btn-success"> <?php echo lang('cliente.inicial').$eqp->getContador_scanner_ant() ?></span></span>
                                                    <?php 
                                                    $options = array(
                                                        'class' => "form-control CONTADOR CNT_{$eqp->getId_cliente_sede_equipo()}",
                                                        'data-id_cliente_sede_equipo' => $eqp->getId_cliente_sede_equipo(),
                                                        'data-id_cliente_sede_equipo_fecha' => $eqp->getId_cliente_sede_equipo_fecha(),
                                                        'data-val_inicial' => $eqp->getContador_scanner_ant(),
                                                        'data-idx' => 5
                                                    );
                                                    $options['disabled'] = ($eqp->getEquipoDto()->getModeloDto()->getTipo() != null && $idMulfuncion != $eqp->getEquipoDto()->getModeloDto()->getTipo());
                                                    echo Form::number("txtEquipo-txtContador_scanner[{$ke}]", $eqp->getContador_scanner(), $options);
                                                    unset($options);
                                                    ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>                            
                        </tbody>
                    </table>
                </div>      
            </div>
        </div>
    <?php } ?>
<?php Form::close(); ?>

<script type="text/javascript">
$(function(){    
	$('.CONTADOR').blur(function() {
		var options = jQuery.extend({ id_cliente_sede_equipo : null, val_inicial : null, idx : null }, $(this).data());
		var val_final = Number($(this).val());
    	if(val_final >= Number(options.val_inicial)) {
        	console.log(options.id_cliente_sede_equipo_fecha);
        	Framework.setLoadData({
        		id_contenedor_body 	: false,
        		pagina: '<?php echo site_url('cliente/set_save_contador'); ?>',
        		data: { 
            		txtId_cliente_sede_equipo : options.id_cliente_sede_equipo,
            		txtId_cliente_sede_equipo_fecha : $(this).attr('data-id_cliente_sede_equipo_fecha'),
            		txtValor_final : val_final,
            		txtValor_inicial : options.val_inicial,            		
            		txtAnho_actual: $('#txtAnho_actual').val(),
            		txtId_mes:	$('#txtId_mes').val(),
            		txtIdx: options.idx,
                },
        		success: function (data) {
        			if (data.contenido) {
            			$('.CNT_'+options.id_cliente_sede_equipo).each(function(){
            				$(this).attr('data-id_cliente_sede_equipo_fecha', data.contenido);
            			});              		
                	}
            	}
        	});
    	} else {
    		Framework.setError('<?php echo lang('cliente.contador_error')?>');
        	$(this).val(options.val_inicial);
        	$(this).focus();
        }
	});
	
    function setDesactivarGrillaPago(valor) {
    	$(".vistaPago").css('display', 'none');
    }

    $('button#btnBuscar').click(function () {
		BUTTON_CLICK = this;
	});
	
	if($("#frmCliente").length>0) {
		$("#frmCliente").validate({
			ignore: ":hidden:not(select)",
			submitHandler: function(form) {
				var l = Ladda.create(BUTTON_CLICK);
            	l.start();
            	Framework.setLoadData({                                                        
                    pagina : '<?php echo site_url('cliente/get_equipos_cliente'); ?>',
                    data: $(form).serialize(),
                    success: function(data) {
            		    l.stop();
                    }
                });
			},
			rules: {
				'txtId_cliente': { 'required': true},
				'txtId_mes': { 'required': true},
				'txtAnho_actual' : {'required': true},
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