<?php
use system\Helpers\Form;
use app\dtos\ClienteDto;
use app\enums\ESiNo;
use app\enums\EEstadoEquipo;
use app\enums\ETipoEquipo;
use app\enums\EEstilo;
use system\Support\Util;
use system\Core\Input;

$idNo = ESiNo::index(ESiNo::NO)->getId();
$idMulfuncion = ETipoEquipo::index(ETipoEquipo::MULTIFUNCION)->getId();
$idBlanco = EEstilo::index(EEstilo::BLANCO_NEGRO)->getId();

$object = $object instanceof ClienteDto ? $object : new ClienteDto();  ?>

<?php echo Form::open(['action' => 'Cliente@asignar_sede', 'id' => 'frmAsignar', 'class' => 'col s12']); ?>
    <div class="ibox float-e-margins">
        <div class="ibox-content">
            <h2 class="no-margins">
                <?php 
                    echo form::hide('txtDto-txtId_cliente_sede', $object->getDto()->getId_cliente_sede());
                    echo $object->getDto()->getClienteDto()->getNombre_empresa()." - ".$object->getDto()->getNombre()
                ?>                             
            </h2>
            <h2>
                <small class="" > <i class="fa fa-phone"></i> <?php echo $object->getDto()->getTelefonoSede() ?></small>&nbsp;
                <small class="" > <i class="fa fa-map-marker"></i> <?php echo $object->getDto()->getDireccionSede() ?></small>
            </h2>
        </div>
        <div class="ibox-footer">
            <div class="row">
                <div class="form-group col-lg-9 col-md-6">
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
                <div class="form-group col-lg-3 col-md-6">
                    <?php 
                        echo Form::button(lang('general.add_button_icon'), [
                            'class' => " pull-right ladda-button btn btn-outline btn-success {$object->getPermisoDto()->getIconAdd()}",
                            'data-id_paquete' => $object->getDto()->getId_cliente(),
                            'id' => 'btnAddSede',
                            'type' => 'submit'                            
                        ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php foreach ($object->getDto()->getList_equipos() as $k => $eqp) {
         
            echo Form::hide("txtEquipo_key[{$k}]", $k);
            echo Form::hide("txtEquipo_id[{$k}]", $eqp->getId_cliente_sede_equipo());
        ?>
        <div class="col-lg-6 col-md-6 col-xs-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <?php if(!Util::isVacio($eqp->getId_equipo())) { ?>
                        <h3>
                            <?php echo $eqp->getEquipoDto()->getNombreEquipo(); ?>
                            <?php echo Form::hide("txtEquipo-txtId_equipo[{$k}]", $eqp->getId_equipo())?>
                        </h3>
                    <?php } else { ?>
                        <div class="form-group">
                            <?php
                                echo Form::label(lang('cliente.equipo'), "txtEquipo-txtId_equipo{$k}");
                                echo Form::selectEnum("txtEquipo-txtId_equipo[{$k}]", $eqp->getId_equipo(), $eqp->getList_equipos_enum(), [
                                   'id' => "txtEquipo-txtId_equipo{$k}",
                                   'required' => true
                                ]);
                              ?>
                        </div>
                    <?php } ?>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                    <div class="ibox-content">
                    <div class="row">
                        <?php /*?>
                        <div class="col-lg-3 col-md-3 col-xs-6">
                            <div class="form-group">
                                <?php
                                    echo Form::label(lang('cliente.equipo'), "txtEquipo-txtId_equipo{$k}");
                                    echo Form::selectEnum("txtEquipo-txtId_equipo[{$k}]", $eqp->getId_equipo(), $eqp->getListEnum(), [
                                       'id' => "txtEquipo-txtId_equipo{$k}"
                                    ], false);
                                  ?>
                            </div>
                        </div>
                        <?php */?>
                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <div class="form-group">
                                <?php 
                                    echo Form::label(lang('cliente.separar_copia_impresion'), "txtEquipo-txtSeparar_copia_impresion{$k}");
                                    echo Form::selectEnum("txtEquipo-txtSeparar_copia_impresion[{$k}]", $eqp->getSeparar_copia_impresion(), ESiNo::data(), [
                                        'id' => "txtEquipo-txtSeparar_copia_impresion{$k}",
                                        'data-idx' => $k,
                                        'class' => 'form-control chosen-select setActivarGrilla',
                                        'data-color' => $eqp->getEquipoDto()->getModeloDto()->getEstilo()
                                    ], false);
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <div class="form-group">
                                <?php echo Form::label(lang('cliente.contador_scanner'), "txtEquipo-txtContador_scanner{$k}"); ?>
                                <div class="input-group">    
                                    <span class="input-group-addon"><i class="fa fa-sort"></i></span>
                                    <?php    
                                        $options['id'] = "txtEquipo-txtContador_scanner{$k}";
                                        $options['readonly'] = ($eqp->getEquipoDto()->getModeloDto()->getTipo() != null && $idMulfuncion != $eqp->getEquipoDto()->getModeloDto()->getTipo());
                                        if($idMulfuncion == $eqp->getEquipoDto()->getModeloDto()->getTipo()) {
                                            $options['required'] = true;
                                        }
                                        echo Form::number("txtEquipo-txtContador_scanner[{$k}]", $eqp->getContador_scanner(), $options);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <div class="form-group">
                                <?php echo Form::label(lang('cliente.precio_scanner'), "txtEquipo-txtCosto_scanner{$k}"); ?>
                                <div class="input-group">    
                                    <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                    <?php     
                                        $options['id'] = "txtEquipo-txtCosto_scanner{$k}";
                                        echo Form::number("txtEquipo-txtCosto_scanner[{$k}]", $eqp->getCosto_scanner(), $options);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <div class="form-group">
                                <?php echo Form::label(lang('cliente.contador_copia_bn'), "txtEquipo-txtContador_copia_bn{$k}"); ?>
                                <div class="input-group">    
                                    <span class="input-group-addon"><i class="fa fa-sort"></i></span>
                                    <?php     
                                        echo Form::number("txtEquipo-txtContador_copia_bn[{$k}]", $eqp->getContador_copia_bn(), [
                                            'id' => "txtEquipo-txtContador_copia_bn{$k}"
                                        ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <div class="form-group">
                                <?php echo Form::label(lang('cliente.contador_impresion_bn'), "txtEquipo-txtContador_impresion_bn{$k}"); ?>
                                <div class="input-group">    
                                    <span class="input-group-addon"><i class="fa fa-sort"></i></span>
                                    <?php   
                                        unset($options);  
                                        $options['id'] = "txtEquipo-txtContador_impresion_bn{$k}";
                                        $options['readonly'] = $eqp->getSeparar_copia_impresion() == $idNo;
                                        if($eqp->getSeparar_copia_impresion() != $idNo) {
                                            $options['required'] = true;
                                        }
                                        echo Form::number("txtEquipo-txtContador_impresion_bn[{$k}]", $eqp->getContador_impresion_bn(), $options);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <div class="form-group">
                                <?php echo Form::label(lang('cliente.precio_impresion_bn'), "txtEquipo-txtCosto_impresion_bn{$k}"); ?>
                                <div class="input-group">    
                                    <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                    <?php     
                                        echo Form::number("txtEquipo-txtCosto_impresion_bn[{$k}]", $eqp->getCosto_impresion_bn(), [
                                            'id' => "txtEquipo-txtCosto_impresion_bn{$k}"
                                        ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <div class="form-group">
                                <?php echo Form::label(lang('cliente.contador_copia_color'), "txtEquipo-txtContador_copia_color{$k}"); ?>
                                <div class="input-group">    
                                    <span class="input-group-addon"><i class="fa fa-sort"></i></span>
                                    <?php     
                                        unset($options);
                                        $options['readonly'] = ($eqp->getEquipoDto()->getModeloDto()->getEstilo() == $idBlanco);
                                        $options['id'] = "txtEquipo-txtContador_copia_color{$k}";
                                        
                                        if($eqp->getEquipoDto()->getModeloDto()->getEstilo() != $idBlanco) {
                                            $options['required'] = true;
                                        }
                                        
                                        echo Form::number("txtEquipo-txtContador_copia_color[{$k}]", $eqp->getContador_copia_color(), $options);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <div class="form-group">
                                <?php echo Form::label(lang('cliente.contador_impresion_color'), "txtEquipo-txtContador_impresion_color{$k}"); ?>
                                <div class="input-group">    
                                    <span class="input-group-addon"><i class="fa fa-sort"></i></span>
                                    <?php
                                        unset($options);
                                        $options['readonly'] = ($eqp->getEquipoDto()->getModeloDto()->getEstilo() == $idBlanco || $eqp->getSeparar_copia_impresion() == $idNo);
                                        $options['id'] = "txtEquipo-txtContador_impresion_color{$k}";
                                        
                                        if($eqp->getEquipoDto()->getModeloDto()->getEstilo() != $idBlanco && $eqp->getSeparar_copia_impresion() != $idNo ) {
                                            $options['required'] = true;
                                        }
                                        
                                        echo Form::number("txtEquipo-txtContador_impresion_color[{$k}]", $eqp->getContador_impresion_color(), $options);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <div class="form-group">
                                <?php echo Form::label(lang('cliente.precio_impresion_color'), "txtEquipo-txtCosto_impresion_color{$k}"); ?>
                                <div class="input-group">    
                                    <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                    <?php     
                                        unset($options);
                                        $options['readonly'] = ($eqp->getEquipoDto()->getModeloDto()->getEstilo() == $idBlanco);
                                        $options['id'] = "txtEquipo-txtCosto_impresion_color{$k}";
                                        
                                        if($eqp->getEquipoDto()->getModeloDto()->getEstilo() != $idBlanco) {
                                            $options['required'] = true;
                                        }
                                        
                                        echo Form::number("txtEquipo-txtCosto_impresion_color[{$k}]", $eqp->getCosto_impresion_color(), $options);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <div class="form-group">
                                <?php echo Form::label(lang('cliente.plan_minimo'), "txtEquipo-txtPlan_minimo{$k}"); ?>
                                <div class="input-group">    
                                    <span class="input-group-addon"><i class="fa fa-sort"></i></span>
                                    <?php     
                                        echo Form::number("txtEquipo-txtPlan_minimo[{$k}]", $eqp->getPlan_minimo(), [
                                            'id' => "txtEquipo-txtPlan_minimo{$k}"
                                        ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <div class="form-group">
                                <?php 
                                    echo Form::label(lang('cliente.incluir_scanner'), "txtEquipo-txtIncluir_scanner{$k}");
                                    echo Form::selectEnum("txtEquipo-txtIncluir_scanner[{$k}]", $eqp->getIncluir_scanner(), ESiNo::data(), [
                                        'id' => "txtEquipo-txtIncluir_scanner{$k}",
                                        'disabled'=> ($eqp->getEquipoDto()->getModeloDto()->getTipo() != null && $idMulfuncion != $eqp->getEquipoDto()->getModeloDto()->getTipo())
                                    ], false);
                                    
                                    if( $idMulfuncion != $eqp->getEquipoDto()->getModeloDto()->getTipo() ) {
                                        echo Form::hide("txtEquipo-txtIncluir_scanner[{$k}]", $idNo);
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <div class="form-group">
                                <?php 
                                    echo Form::label(lang('cliente.estado'), "txtEquipo-txtEstado{$k}");
                                    echo Form::selectEnum("txtEquipo-txtEstado[{$k}]", $eqp->getEquipoDto()->getEstado(), EEstadoEquipo::dataCombo(), [
                                        'id' => "txtEquipo-txtEstado{$k}"
                                    ], false);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php echo Form::close(); ?>

<script type="text/javascript">

    var idBlanco = '<?php echo $idBlanco ?>'; 
    var idNo = '<?php echo $idNo ?>';
    
    $('.setActivarGrilla').change(function() {
        var idx = $(this).attr('data-idx');      
        var idColor = $(this).attr('data-color');  
        if($(this).val() != idNo) {
        	$('#txtEquipo-txtContador_impresion_bn'+idx).attr('readonly',false);
        	$('#txtEquipo-txtContador_impresion_bn'+idx).attr('required',true);
            if(idColor != idBlanco) {
            	$('#txtEquipo-txtContador_impresion_color'+idx).attr('readonly',false);
            	$('#txtEquipo-txtContador_impresion_color'+idx).attr('required',true);
            } 
        } else {
           $('#txtEquipo-txtContador_impresion_bn'+idx).attr('readonly',true);
           $('#txtEquipo-txtContador_impresion_bn'+idx).removeAttr('required');
           if(idColor != idBlanco ) {
              	$('#txtEquipo-txtContador_impresion_color'+idx).attr('readonly',true);
             	 $('#txtEquipo-txtContador_impresion_color'+idx).removeAttr('required');
           }
        }
    });
                
    $(function(){            
        $('button#btnBack').click(function () {
        	var l = Ladda.create(this);
            l.start();
        	Framework.setLoadData({
        		pagina : '<?php echo base_url('cliente/consultar_sedes'); ?>',
        		data: { 
        			txtId_cliente : '<?php echo $object->getDto()->getId_cliente() ?>'
                },
        		success: function () { l.stop(); }
        	});
        });

        $('button#btnAddSede').click(function () {
    		BUTTON_CLICK = this;
    		ACCION = 'ADD';
    	});
    	
    	$('button#btnGuardar').click(function () {
    		BUTTON_CLICK = this;
    		ACCION = 'SAVE';
    	});

        if($("#frmAsignar").length>0) {
    		$("#frmAsignar").validate({
    			ignore: ":hidden:not(select)",
    			submitHandler: function(form) {
    				var l = Ladda.create(BUTTON_CLICK);
    	            l.start();
    	            switch(ACCION) {
        	            case 'SAVE': {
            				Framework.setLoadData({
            	        		pagina: '<?php echo base_url('cliente/guardar_equipo'); ?>',
            	        		data: $(form).serialize(),
            	        		success: function (data) {
            	        			l.stop();
            	        			Framework.setSuccess('<?php echo lang('general.save_message')?>');
            	        		}
            				});
        	            } break;
        	            case 'ADD': {
        	            	Framework.setLoadData({
                            	pagina : '<?php echo site_url('cliente/add_equipo'); ?>',
                            	data: $(form).serialize(),
                            	success: function () {
                            		l.stop();
                            	}
                            });
        	            } break;
    	            }
    			},
    			rules: {
    			    <?php foreach ($object->getDto()->getList_equipos() as $k => $sede) { ?>
            			'txtEquipo-txtContador_copia_bn[<?php echo $k; ?>]': {
                			required: true,
                			min: 0,
                			number: true
            			},
            			'txtEquipo-txtCosto_impresion_bn[<?php echo $k; ?>]': {
                			required: true,
                			min: 1,
                			number: true
            			},
    			   <?php } ?>		    
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