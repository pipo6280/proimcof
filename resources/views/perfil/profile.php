 <?php
use app\dtos\UsuarioPerfilDto;    
use app\enums\ESiNo;
use system\Helpers\Form;
$object = $object instanceof UsuarioPerfilDto ? $object : new UsuarioPerfilDto(); ?>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>
            <?php echo lang('perfil.form_search'); ?>
        </h5>
    </div>
    <div class="ibox-content">
        <div class="pull-right">
            <?php 
                echo Form::button(lang('general.add_button_icon'), [
                    'class' => "btn btn-outline btn-success {$object->getPermisoDto()->getIconAdd()}",
                    'data-id_perfil' => null,
                    'data-nombre' => null,
                    'id' => 'btnAddProfile'
                ]);
            ?>
        </div>
        <div class="clearfix"></div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover datatable" >
                <thead>
                    <tr>
                        <th>
                            <?php echo lang('perfil.codigo'); ?>
                        </th>
                        <th>
                            <?php echo lang('perfil.perfil'); ?>
                        </th>
                        <th class="text-center nosort">
                            <?php echo lang('perfil.activo'); ?>
                        </th>
                        <th class="text-center nosort">
                            <?php echo lang('general.edit_button'); ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($object->getListPerfiles() as $lis) { 
                            if ($lis instanceof UsuarioPerfilDto) { ?> 
                                <tr class="gradeX">
                                    <td>
                                        <?php echo $lis->getId_perfil(); ?>
                                    </td>
                                    <td>
                                        <?php echo $lis->getNombre(); ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0);" class="changeStateProfile <?php echo $object->getPermisoDto()->getIconEdit(); ?>" data-id_perfil="<?php echo $lis->getId_perfil(); ?>" data-yn_activo="<?php echo $lis->getYn_activo(); ?>" data-toggle="tooltip" title="<?php echo ESiNo::result($lis->getYn_activo())->getDescription(); ?>">
                                            <i class="<?php echo $lis->getClassEstado(); ?> fa-2x"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0);" class="editPermissionProfile <?php echo $object->getPermisoDto()->getIconEdit(); ?>" data-id_perfil="<?php echo $lis->getId_perfil(); ?>" data-nombre="<?php echo $lis->getNombre(); ?>" data-toggle="tooltip" title="<?php echo lang('general.title_edit', [$lis->getNombre()]); ?>">
                                            <i class="<?php echo $object->getPermisoDto()->getClassEdit(); ?>"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php 
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
    	$('button#btnAddProfile').click(function () {
    		var options = jQuery.extend({
    			id_perfil : null,
    			nombre : null
    		}, $(this).data());
    		Framework.setLoadData({
    			pagina: '<?php echo site_url('perfil/create/'); ?>',
    			data: {
    				txtId_perfil : options.id_perfil
    			}
    		});
        });
    	$('a.editPermissionProfile').each(function (e) {
        	$(this).click(function () {
        		var options = jQuery.extend({
        			id_perfil: 0,
        			nombre: '' 
        		}, $(this).data());
        		Framework.setLoadData({
        			pagina: '<?php echo site_url('perfil/edit'); ?>',
        			data: {
        				txtId_perfil: options.id_perfil,
        				txtNombre: options.nombre 
        			}
        		});        				
            });
        });
        $('a.changeStateProfile').each(function () {
        	$(this).click(function () {
        		var options = jQuery.extend({
        			id_perfil : null,
        			yn_activo : null
        		}, $(this).data());        		
        		Framework.setConfirmar({
        			contenido : '<?php echo lang('perfil.mensaje_confirmacion'); ?>',
        		    aceptar : function () {
        		        Framework.setLoadData({
        		            id_contenedor_body : false,
        		            pagina : '<?php echo site_url('perfil/change_state_profile'); ?>',
        		            data : {
        		                txtId_perfil : options.id_perfil,
        		                txtYn_activo : options.yn_activo
    		                },
    		                success : function (data) {
    		                    if (data.contenido) {
    		                        Framework.setSuccess('<?php echo lang('general.edit_message'); ?>');
    		                        Framework.setLoadData({
    		                            pagina : '<?php echo site_url('perfil/perfil'); ?>',
    		                            data : {
    		                                txtId_perfil : null
		                                }
   	            				    });
		                        } else {
		                            Framework.setError('<?php echo lang('perfil.mensaje_estado'); ?>');
	                            }
		                    }
		                });
     			   }	
        	    });
        	});
        });
    });
</script>