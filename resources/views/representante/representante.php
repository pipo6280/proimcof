<?php
use app\dtos\RhRepresentanteDto;
use system\Support\Util;
use system\Helpers\Html;
use system\Support\Arr;
use system\Helpers\Form;

$object = $object instanceof RhRepresentanteDto ? $object : new RhRepresentanteDto(); ?>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>
            <?php echo lang('representante.form_search'); ?>
        </h5>
    </div>
    <div class="ibox-content">
        <div class="pull-right">
            <?php 
                echo Form::button(lang('general.add_button_icon'), [
                    'class' => "ladda-button ladda-button-demo btn btn-outline btn-success {$object->getPermisoDto()->getIconAdd()}",
                    'id' => 'btnAddRepresentante',
                    'data-id_representante' => null,
                    'data-nombre' => null                    
                ]);
            ?>
        </div>
        <div class="clearfix"></div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover datatable" >
                <thead>
                    <tr role="row">
                        <th>#</th>
                        <th>
                            <?php echo lang('representante.representantente'); ?>
                        </th>
                        <th>
                            <?php echo lang('representante.direccion'); ?>
                        </th>
                        <th>
                            <?php echo lang('representante.numero_fijo'); ?> - <?php echo lang('representante.movil'); ?>
                        </th>
                        <th>
                            <?php echo lang('representante.email'); ?>
                        </th>
                        <th class="text-center nosort">
                            <?php echo lang('representante.usuario'); ?>
                        </th>
                        <th class="text-center nosort">
                            <?php echo lang('representante.reset_password'); ?>
                        </th>
                        <th class="text-center nosort">
                            <?php echo lang('general.edit_button'); ?>
                        </th>
                        <th class="text-center nosort">
                            <?php echo lang('general.delete_button'); ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($object->getList() as $lis) { ?>
                        <?php if ($lis instanceof RhRepresentanteDto) { ?>
                            <tr>
                                <td nowrap="nowrap">
                                    <?php echo $lis->getId_representante(); ?>
                                </td>
                                <td>
                                    <?php echo $lis->getPersonaDto()->getNombreCliente(); ?>
                                </td>
                                <td>
                                    <?php echo $lis->getPersonaDto()->getDireccionBarrio(); ?>
                                </td>
                                <td>
                                    <?php echo $lis->getPersonaDto()->getContactoPersona(); ?>
                                </td>
                                <td>
                                    <?php echo $lis->getPersonaDto()->getEmail(); ?>
                                </td>
                                <td class="text-center" nowrap="nowrap">
                                    <?php echo $lis->getPersonaDto()->getLoggin(); ?>
                                    <?php 
                                    /*
                                        $arrayList = [];
                                        foreach ($lis->getListServices() as $ser) {
                                            $arrayList[] = $ser->getServicioDto()->getNombre();
                                        }       
                                        echo Html::link('#', '<i class="fa fa-user fa-2x"></i>', [
                                            'data-id_representante' => $lis->getId_representante(),
                                            'data-nombre' => $lis->getPersonaDto()->getNombreCompleto(),
                                            'data-modal' => "modal-{$lis->getId_representante()}",
                                            'data-target'=> "#myModal{$lis->getId_representante()}",
                                            'data-toggle' => 'modal'
                                        ], false);
                                        
                                    <div class="modal inmodal" id="myModal<?php echo $lis->getId_representante(); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content animated flipInY">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                    <h4 class="modal-title">Modal title</h4>
                                                    <small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Lorem Ipsum is simply dummy</strong> text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
                                                        printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
                                                        remaining essentially unchanged.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    */?> 
                                </td>
                                <td class="text-center" nowrap="nowrap">
                                    <a href="javascript:void(0)" class="resetPasword <?php echo $object->getPermisoDto()->getIconEdit(); ?>" data-id_usuario="<?php echo $lis->getPersonaDto()->getId_usuario(); ?>" data-nombre="<?php echo $lis->getPersonaDto()->getNombreCompleto(); ?>" title="<?php echo lang('general.title_edit', [$lis->getPersonaDto()->getNombreCompleto()]); ?>">
                                        <i class="fa fa-key fa-2x"></i>
                                    </a>
                                </td>
                                <td class="text-center" nowrap="nowrap">
                                   <a href="javascript:void(0)" class="editRepresentante <?php echo $object->getPermisoDto()->getIconEdit(); ?>" data-id_representante="<?php echo $lis->getId_representante(); ?>" data-nombre="<?php echo $lis->getPersonaDto()->getNombreCompleto(); ?>" title="<?php echo lang('general.title_edit', [$lis->getPersonaDto()->getNombreCompleto()]); ?>">
                                        <i class="<?php echo $object->getPermisoDto()->getClassEdit(); ?> fa-2x"></i>
                                   </a>
                                </td>
                                <td class="text-center" nowrap="nowrap">
                                   <a href="javascript:void(0)" class="deleteRepresentante <?php echo $object->getPermisoDto()->getIconEdit(); ?>" title="<?php echo lang('general.title_delete', [$lis->getPersonaDto()->getNombreCompleto()]); ?>" data-id_representante="<?php echo $lis->getId_representante(); ?>" data-nombre="<?php echo $lis->getPersonaDto()->getNombreCompleto(); ?>">
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
<script type="text/javascript">
$(document).ready(function () {
	$('button#btnAddRepresentante,a.editRepresentante').click(function () {
		var options = jQuery.extend({
			id_representante : null,
			nombre : null
		}, $(this).data());
		var l = Ladda.create(this);
        l.start();
		Framework.setLoadData({
			pagina: '<?php echo site_url('representante/edit'); ?>',
			data: {
				txtId_representante : options.id_representante
			},
			success: function (data) {
				l.stop();
			}
		});
    });
	$('a.resetPasword').each(function () {
    	$(this).click(function () {
    		var options = jQuery.extend({
    			id_usuario : null,
    			nombre : null
    		}, $(this).data());
    		var confirma = '<?php echo lang('representante.reset_password_confirma'); ?>';
    		confirma = confirma.replace('{0}', options.nombre);
    		Framework.setConfirmar({
    			contenido : confirma,
    			aceptar : function() {
    				Framework.setLoadData({
    					id_contenedor_body : false,
    					pagina : '<?php echo site_url('representante/reset_password'); ?>',
    					data : {
    						txtId_usuario : options.id_usuario
    					},
    					success : function(data) {
    						if (data.contenido) {
    							Framework.setAlerta({
        							title: 'Cambio de contraseña',
        							contenido: 'La nueva contraseña para el representante: <b>'+ options.nombre +'</b> es: <br><b>' + data.contenido + '</b>'
    							});
    							Framework.setLoadData({
        							pagina : '<?php echo site_url('representante/representante'); ?>',
    							});
    						} else {
    							titulo = '<?php echo lang('representante.no_reset_password'); ?>';
    			    			titulo = titulo.replace('{0}', options.nombre);
    							Framework.setError(titulo);
    						}							
    					}
    				});
    			}
    		});
    	});
	});
    $('a.deleteRepresentante').each(function () {
    	$(this).click(function () {
    		var options = jQuery.extend({
    			id_representante : null,
    			nombre : null 
    		}, $(this).data());
    		Framework.setConfirmar({
    			contenido : 'Está a punto de eliminar el especilista: <b>'+ options.nombre +'</b> ¿Desea Continuar?',
    			aceptar : function() {
    				Framework.setLoadData({
    					id_contenedor_body : false,
    					pagina : '<?php echo site_url('representante/eliminar_representante'); ?>',
    					data : {
    						txtId_representante : options.id_representante
    					},
    					success : function(data) {
    						if (data.contenido) {
    							Framework.Alerta('<?php echo lang('general.process_message'); ?>');
    							Framework.setLoadData({
        							pagina : '<?php echo site_url('representante/representante'); ?>',
    								data : {
    									txtId_representante : null
    								}
    							});
    						} else {
    							titulo = '<?php echo lang('representante.no_delete'); ?>';
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