<?php
use app\dtos\UsuarioPerfilDto;
use system\Core\Persistir;
use system\Helpers\Form;    
use system\Support\Util;
use system\Support\Str;
use app\enums\ESiNo;
    
    $object = $object instanceof UsuarioPerfilDto ? $object : new UsuarioPerfilDto();
?>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>
            <?php echo lang('perfil.search_representante'); ?>
        </h5>
    </div>
    <div class="ibox-content">
        <?php echo Form::open(['id' => 'frmAsociarPerfil','class' => 'col s12']); ?>
            <div class="row">
                <div class="form-group col-lg-6">
                    <?php echo Form::label(lang('perfil.nombre_representante'), 'txtNombre'); ?>
                    <div class="input-group m-b">
                        <span class="input-group-addon">
                            <i class="fa fa-search"></i>
                        </span>
                        <?php
                            echo Form::text('txtNombre', Persistir::getParam('txtNombre'), [
                                'data-input_hidden_value' => Persistir::getParam('txtId_usuario'),
                                'data-control' => 'auto_usuarios_perfil',
                                'data-on_search' => 'javascript:setDesactivarGrillaPerfil',
                                'data-on_select' => 'javascript:setActivarGrillaPerfil',
                                'data-input_hidden_name' => 'txtId_usuario',
                                'class' => 'form-control autocompletado'
                            ]);
                        ?>
                    </div>
                </div>
            </div>
            <?php if (! Util::isVacio(Persistir::getParam('txtId_usuario'))) { ?>
                <div class="row" id="vistaAsociarPerfil">
                    <div class="col-lg-6">
                        <table id="" class="table table-hover table-striped ">
                            <thead>
                                <tr>
                                    <th>
                                        <?php echo lang('perfil.perfil'); ?>
                                    </th>
                                    <th>
                                        <?php echo lang('perfil.asociar'); ?>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $iNactivo = ESiNo::index(ESiNo::NO)->getId();
                                    $activoC = ESiNo::index(ESiNo::SI)->getId();
                                    foreach ($object->getList() as $lis) { ?>
                                    <tr>
                                        <td>
                                            <?php echo Str::ucWords($lis->getPerfilDto()->getNombre()); ?>
                                        </td>
                                        <td>
                                            <div class="i-checks" data-cclass="icheckbox_square-blue">
                                    			<label for="<?php echo "txtListaPerfil{$lis->getPerfilDto()->getId_perfil()}"; ?>">
                                                    <?php echo Form::checkbox('txtListaPerfil[]', $lis->getPerfilDto()->getId_perfil(), ! Util::isVacio($lis->getId_usuario()), ['id' => "txtListaPerfil{$lis->getPerfilDto()->getId_perfil()}"]); ?> 
                                                    <i></i>
                                    			</label>
                                    		</div>
                	        			</td>
                                    </tr>
                                <?php } ?>
                                <tr><td height="50" colspan="3"></td></tr>
                                <tr>
                                    <td colspan="3">
                                        <?php 
                                            echo Form::button(lang('general.save_button_icon'), [
                                                'class' => "btn btn-primary {$object->getPermisoDto()->getIconEdit()}",
                                                'id' => 'btnEditAsociarPerfil'
                                            ]);
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } ?>
        <?php echo Form::close(); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#btnEditAsociarPerfil').click(function () {
        	Framework.setLoadData({
                id_contenedor_body: false,
                pagina: '<?php echo site_url('perfil/save_associated_profile'); ?>',
                data: $('#frmAsociarPerfil').serialize(),
                success: function(data) {
                    console.log(data.contenido);
                	if (data.contenido) {
                		Framework.setSuccess('<?php echo lang('general.process_message'); ?>');
                		Framework.setLoadData({
                    		pagina : '<?php echo site_url('perfil/permisos'); ?>',
                        	data: {
                            	txtId_usuario : null,
                            	txtNombre : null 
                            }
                        });
                	} else {
                		Framework.setError('<?php echo lang('general.operation_message')?>');
                	}
                }
            });
        });
    });
    
    /**
     * @tutorial Metodo Descripcion: desactiva la grilla de asociar cargos
     * @author Rodolfo Perez ~~ pipo6280@gmail.com 
     * @since 2015/06/09
     * @param valor
     */
    function setDesactivarGrillaPerfil(valor) {
    	$("#vistaAsociarPerfil").css('display', 'none');
    }
    /**
	 * @tutorial Metodo Descripcion: activa la grilla para asociar cargos
	 * @author Rodolfo Perez ~~ pipo6280@gmail.com 
	 * @since 2015/06/09
	 * @param valor
	 */
	function setActivarGrillaPerfil(valor) {
		Framework.setLoadData({
			pagina: '<?php echo site_url('perfil/associated_profile'); ?>',
            data : {
            	txtId_usuario: valor.id,
            	txtNombre: valor.label
            }
        });
	}
</script>