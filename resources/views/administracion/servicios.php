<?php
    use system\Helpers\Lang;
    use app\dtos\AdministracionDto;
use app\dtos\ServicioDto;
use system\Support\Number;
    $object = $object instanceof AdministracionDto ? $object : new AdministracionDto();
?>
<div class="main-box clearfix">
    <div class="main-box-body clearfix">
        <div class="row">
            <div class="col-md-12">
                <div class="pull-right BUTTON_ADD">
                    <a class="tooltipstered" id="addServicio" href="javascript:void(0)" data-id_categoria="" data-nombre="" title="<?php echo Lang::text('administracion_add_servicios'); ?>">
                        <span class="fa-stack <?php echo $object->getPermisoDto()->getIconAdd(); ?>">
                            <i class="fa fa-square fa-stack-2x"></i>
                            <i class="<?php echo $object->getPermisoDto()->getClassAdd(); ?> fa-stack-1x fa-inverse"></i>
                        </span>
                    </a>
                </div>
                <div class="clearfix"></div>
                <table id="table-fixed" class="table table-hover table-striped ">
                    <thead>
                        <tr role="row">
                            <th>
                                #
                            </th>
                            <th>
                                <?php echo Lang::text('administracion_nombre_servicio'); ?>
                            </th>
                            <th>
                                <?php echo Lang::text('administracion_precio_servicio'); ?>
                            </th>
                            <th class="text-center">
                                <?php echo Lang::text('administracion_activo_servicio'); ?>
                            </th>
                            <th class="text-center">
                                <?php echo Lang::text('administracion_representante_servicio'); ?>
                            </th>
                            <th class="text-center">
                                <?php echo Lang::text('general_edit_button'); ?>
                            </th>
                            <th class="text-center">
                                <?php echo Lang::text('general_delete_button'); ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($object->getList() as $key => $lis) { ?>
                            <?php if ($lis instanceof ServicioDto) { ?>
                                <tr>
                                    <td>
                                        <?php echo $lis->getId_servicio(); ?>
                                    </td>
                                    <td>
                                        <?php echo $lis->getNombre(); ?>
                                    </td>
                                    <td>
                                        $<?php echo Number::format($lis->getPrecio_base()); ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="estadoServicio <?php echo $object->getPermisoDto()->getIconEdit(); ?>" data-id_servicio="<?php echo $lis->getId_servicio(); ?>" data-nombre="<?php echo $lis->getNombre(); ?>" data-yn_activo="<?php echo $lis->getYn_activo(); ?>">
                                            <i class="<?php echo $lis->getClassEstado(); ?>"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="servicesRepresentante tooltipstered" data-id_servicio="<?php echo $lis->getId_servicio(); ?>" data-nombre="<?php echo $lis->getNombre(); ?>" title="<?php echo Lang::text('administracion_title_representantes', [$lis->getNombre()]); ?>">
                                            <i class="fa fa-users fa-2x"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                       <a href="javascript:void(0)" class="editServicio tooltipstered <?php echo $object->getPermisoDto()->getIconEdit(); ?>" data-id_servicio="<?php echo $lis->getid_servicio(); ?>" data-nombre="<?php echo $lis->getNombre(); ?>" title="<?php echo Lang::text('general_title_edit', [$lis->getNombre()]); ?>">
                                            <i class="<?php echo $object->getPermisoDto()->getClassEdit(); ?> fa-2x"></i>
                                       </a>
                                    </td>
                                    <td class="text-center">
                                       <a href="javascript:void(0)" class="deleteServicio tooltipstered <?php echo $object->getPermisoDto()->getIconDelete(); ?>" data-id_servicio="<?php echo $lis->getid_servicio(); ?>" data-nombre="<?php echo $lis->getNombre(); ?>" title="<?php echo Lang::text('general_title_delete', [$lis->getNombre()]); ?>">
                                            <i class="<?php echo $object->getPermisoDto()->getClassDelete(); ?> fa-2x"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
	$('a.estadoServicio').each(function () {
    	$(this).click(function () {
    		var options = jQuery.extend({
    			id_servicio : null,
    			yn_activo : null
    		}, $(this).data());
    		Framework.Confirmar({
    			contenido : 'Está a punto de cambiar el estado del servicio: <b>'+ options.nombre +'</b> ¿Desea Continuar?',
    			aceptar : function() {
            		Framework.LoadData({
            			id_contenedor_body : false,
            			pagina : '<?php echo site_url('administracion/cambiar_estado_servicio'); ?>',
            			data : {
            				txtId_servicio : options.id_servicio,
            				txtYn_activo : options.yn_activo
            		    },
            			success : function (data) {
            				if (data.contenido) {
                				Framework.Alerta('<?php echo Lang::text('general_edit_message'); ?>');
                				Framework.LoadData({
                					pagina : '<?php echo site_url('administracion/consultar_servicio'); ?>',
                					data : {
                						txtId_perfil : null
                					}
                				});
            				} else {
            					Framework.Alerta('<?php echo Lang::text('administracion_mensaje_estado_servicio'); ?>');
            				}
            			}
            		});
    			}
    		});
    	});
    });
	$('a.servicesRepresentante').each(function () {
    	$(this).click(function () {
    		var options = jQuery.extend({
    			id_servicio : null,
    			nombre : null
    		}, $(this).data());
    		
    		var	titulo = '<?php echo Lang::text('administracion_title_representantes'); ?>';
    			titulo = titulo.replace('{0}', options.nombre);
    		Framework.AutoDialog({
    			id_dialog 	: 'Dialog-Form-Servicio',
    			title : titulo,
    			width : '50%',
    			height : '350',
    			id_contenedor_body 	: false,
    			pagina : '<?php echo site_url('representante/representante'); ?>',
    			data : {
    				txtId_servicio : options.id_servicio    			
    			},
    			buttons : {
    				Cerrar : function() {
    					$(this).dialog("close");
    				}
    			}
    		});
    	});
    });
	
    $('a#addServicio, a.editServicio').each(function () {
    	$(this).click(function () {
    		var options = jQuery.extend({
    			id_servicio : null,
    			nombre : null
    		}, $(this).data());
    		var titulo = '<?php echo Lang::text('administracion_add_servicio_form'); ?>';
    		if (options.nombre != '') {
    			titulo = '<?php echo Lang::text('administracion_edit_servicio_form'); ?>';
    			titulo = titulo.replace('{0}', options.nombre);
        	}
    		Framework.AutoDialog({
    			id_dialog 	: 'Dialog-Form-Servicio',
    			title : titulo,
    			width : '50%',
    			height : 'auto',
    			pagina : '<?php echo site_url('administracion/editar_servicio'); ?>',
    			data : {
    				txtId_servicio : options.id_servicio
    			},
    			buttons : {
    				Guardar : function() {
						var exito = Framework.setValidaForm('frmServicio');
						if (exito) {
							$(this).dialog("close");
							Framework.LoadData({
								id_contenedor_body 	: false,
								pagina : '<?php echo site_url('administracion/guardar_servicio'); ?>',
								data : $('#frmServicio').serialize(),
								success : function(data) {
									if (data.contenido) {
										Framework.Alerta('El servicio <b>'+ data.contenido +'</b> se ha guardado correctamente');
    									Framework .LoadData({
    										pagina : '<?php echo site_url('administracion/consultar_servicio'); ?>',
    										data 	: {
    											txtId_servicio : null
    										}
    									});
									} else {
										Framework.Alerta('Error: El servicio <b>'+ data.contenido +'</b> no se ha guardado correctamente');
									}
								}
							});
						}
					},
    				Cerrar : function() {
    					$(this).dialog("close");
    				}
    			}
    		});
    	});
    });
    $('a.deleteServicio').each(function () {
    	$(this).click(function () {
    		var options = jQuery.extend({
    			id_servicio : null,
    			nombre : null 
    		}, $(this).data());
    		Framework.Confirmar({
    			contenido : 'Está a punto de eliminar el servicio: <b>'+ options.nombre +'</b> ¿Desea Continuar?',
    			aceptar : function() {
    				Framework.LoadData({
    					id_contenedor_body : false,
    					pagina : '<?php echo site_url('administracion/eliminar_servicio'); ?>',
    					data : {
    						txtId_servicio : options.id_servicio
    					},
    					success : function(data) {
    						if (data.contenido) {
    							Framework.Alerta('<?php echo Lang::text('general_process_message'); ?>');
    							Framework.LoadData({
        							pagina : '<?php echo site_url('administracion/consultar_servicio'); ?>',
    								data : {
    									txtId_servicio : null
    								}
    							});
    						} else {
    							titulo = '<?php echo Lang::text('administracion_services_delete'); ?>';
    			    			titulo = titulo.replace('{0}', options.nombre);
    							Framework.Alerta(titulo);
    						}							
    					}
    				});
    			}
    		});
        });
    });
});
</script>