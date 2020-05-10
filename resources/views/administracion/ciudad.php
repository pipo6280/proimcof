<?php
    use system\Helpers\Lang;
    use app\dtos\AdministracionDto;
    
    $object = $object instanceof AdministracionDto ? $object : new AdministracionDto();?>
    <div class="main-box clearfix">
        <div class="main-box-body clearfix">
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-right BUTTON_ADD">
                        <a class="tooltipstered" id="addCiudad" href="javascript:void(0)" data-id_categoria="" data-nombre="" title="<?php echo Lang::text('administracion_add_ciudad_form'); ?>">
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
                                    <?php echo Lang::text('administracion_nombre_ciudad'); ?>
                                </th>
                                <th class="text-center" width="250">
                                    <?php echo Lang::text('general_edit_button'); ?>
                                </th>
                                <th class="text-center" width="250">
                                    <?php echo Lang::text('general_delete_button'); ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($object->getList() as $key => $lis) {
                                if ($lis instanceof \app\dtos\CiudadDto) { ?>
                                    <tr>
                                        <td>
                                            <?php echo $lis->getId_ciudad(); ?>
                                        </td>
                                        <td>
                                            <?php echo $lis->getNombre(); ?>
                                        </td>
                                        <td class="text-center" nowrap="nowrap">
                                            <a href="javascript:void(0)" class="editCiudad tooltipped <?php echo $object->getPermisoDto()->getIconEdit(); ?>" data-id_ciudad="<?php echo $lis->getId_ciudad(); ?>" data-nombre="<?php echo $lis->getNombre(); ?>" data-tooltip="<?php echo Lang::text('general_title_edit', [$lis->getNombre()]); ?>">
                                                <i class="<?php echo $object->getPermisoDto()->getClassEdit(); ?> fa-2x"></i>
                                            </a>
                                        </td>
                                        <td class="text-center" nowrap="nowrap">
                                            <a href="javascript:void(0)" class="deleteCiudad tooltipped <?php echo $object->getPermisoDto()->getIconEdit(); ?>" data-tooltip="<?php echo Lang::text('general_title_delete', [$lis->getNombre()]); ?>" data-id_ciudad="<?php echo $lis->getId_ciudad(); ?>" data-nombre="<?php echo $lis->getNombre(); ?>">
                                                <i class="<?php echo $object->getPermisoDto()->getClassDelete(); ?>  fa-2x"></i>
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
        $('a#addCiudad, a.editCiudad').each(function () {
        	$(this).click(function () {
        		var options = jQuery.extend({
        			id_ciudad : null,
        			nombre : null
        		}, $(this).data());
        		var titulo = '<?php echo Lang::text('administracion_add_ciudad_form'); ?>';
        		if (options.nombre != '') {
        			titulo = '<?php echo Lang::text('administracion_edit_ciudad_form'); ?>';
        			titulo = titulo.replace('{0}', options.nombre);
            	}
        		Framework.AutoDialog({
        			id_dialog 	: 'Dialog-Form-Ciudad',
        			title : titulo,
        			width : '50%',
        			height : 'auto',
        			pagina : '<?php echo site_url('administracion/editar_ciudad'); ?>',
        			data : {
        				txtId_ciudad : options.id_ciudad
        			},
        			buttons : {
        				Guardar : function() {
    						var exito = Framework.setValidaForm('frmCiudad');
    						if (exito) {
    							$(this).dialog("close");
    							Framework.LoadData({
    								id_contenedor_body 	: false,
    								pagina : '<?php echo site_url('administracion/guardar_ciudad'); ?>',
    								data : $('#frmCiudad').serialize(),
    								success : function(data) {
    									if (data.contenido) {
    										Framework.Alerta('La Ciudad <b>'+ options.nombre +'</b> se ha guardado correctamente');
        									Framework .LoadData({
        										pagina : '<?php echo site_url('administracion/consultar_ciudad'); ?>',
        										data 	: {
        											txtId_ciudad : null
        										}
        									});
    									} else {
    										Framework.Alerta('Error: La Ciudad <b>'+ data.contenido +'</b> no se ha guardado correctamente');
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
        $('a.deleteCiudad').each(function () {
        	$(this).click(function () {
        		var options = jQuery.extend({
        			id_ciudad : null,
        			nombre : null 
        		}, $(this).data());
        		Framework.Confirmar({
        			contenido : 'Está a punto de eliminar la ciudad: <b>'+ options.nombre +'</b> ¿Desea Continuar?',
        			aceptar : function() {
        				Framework.LoadData({
        					id_contenedor_body : false,
        					pagina : '<?php echo site_url('administracion/eliminar_ciudad'); ?>',
        					data : {
        						txtId_ciudad : options.id_ciudad
        					},
        					success : function(data) {
        						if (data.contenido) {
        							Framework.Alerta('<?php echo Lang::text('general_process_message'); ?>');
        							Framework.LoadData({
            							pagina : '<?php echo site_url('administracion/consultar_ciudad'); ?>',
        								data : {
        									txtId_ciudad : null
        								}
        							});
        						} else {
        							titulo = '<?php echo Lang::text('administracion_no_delete'); ?>';
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
