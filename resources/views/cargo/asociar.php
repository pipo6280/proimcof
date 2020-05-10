<?php
use app\dtos\RhCargoDto;
use system\Helpers\Form;
use system\Core\Persistir;
use system\Support\Util;
use app\enums\ESiNo;
use system\Support\Str;

$object = $object instanceof RhCargoDto ? $object: new RhCargoDto();
?>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>
            <?php echo lang('cargo.search_representante'); ?>
        </h5>
    </div>
    <div class="ibox-content">
        <?php echo Form::open(['id' => 'frmAsociarCargo']); ?>
            <div class="row">
                <div class="form-group col-lg-6">
                    <?php echo Form::label(lang('cargo.representante_title'), 'txtNombre'); ?>
                    <div class="input-group m-b">
                        <span class="input-group-addon">
                            <i class="fa fa-search"></i>
                        </span>
                        <?php
                            echo Form::text(
                                'txtNombre', 
                                Persistir::getParam('txtNombre'), 
                                [
                                    'data-input_hidden_value' => Persistir::getParam('txtId_representante'),
                                    'data-control' => 'auto_representantes',
                                    'data-on_search' => 'javascript:setDesactivarGrillaCargo',
                                    'data-on_select' => 'javascript:setActivarGrillaCargo',
                                    'data-input_hidden_name' => 'txtId_representante',
                                    'class' => 'form-control autocompletado'
                                ]
                            );
                        ?>
                    </div>
                </div>
            </div>
            <?php if (! Util::isVacio(Persistir::getParam('txtId_representante'))) { ?>
                <div class="clearfix"></div>
                <div class="row" id="vistaAsociarCargo">
                    <div class="col-lg-12">
                        <table id="" class="table table-hover table-striped ">
                            <thead>
                                <tr role="row">
                                    <th>
                                        <?php echo lang('cargo.nombre'); ?>
                                    </th>
                                    <th class="center-align">
                                        <?php echo lang('cargo.asociar'); ?>
                                    </th>
                                    <th class="center-align">
                                        <?php echo lang('cargo.activo'); ?>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $iNactivo = ESiNo::index(ESiNo::NO)->getId();
                                    $activoC = ESiNo::index(ESiNo::SI)->getId();
                                ?>
                                <?php foreach ($object->getList() as $lis) { ?>
                                    <tr class="<?php echo (! Util::isVacio($lis->getId_representante()) ? ($lis->getYn_activo() == $iNactivo ? 'red-text': 'green-text'): '' ); ?>">
                                        <td>
                                            <?php echo Str::ucWords($lis->getCargoDto()->getNombre()); ?>
                                        </td>
                                        <td class="center-align">
                                            <div class="i-checks" data-cclass="icheckbox_square-green">
                                    			<label>
                                                    <?php 
                                                        echo Form::checkbox('txtListaCargo[]', $lis->getCargoDto()->getId_cargo(), ! Util::isVacio($lis->getId_cargo()), [
                                                            'id' => "txtListCargo{$lis->getCargoDto()->getId_cargo()}",
                                                            'class' => 'icheck-cargo'
                                                        ]); 
                                                    ?> 
                                                    <i></i>
                                    			</label>
                                    		</div>
                	        			</td>
                	        			<td class="center-align">
                	        			    <div class="i-checks" data-cclass="icheckbox_square-blue">
                                    			<label>
                                                    <?php echo Form::checkbox("txtListaActivo[{$lis->getCargoDto()->getId_cargo()}]", $activoC, ($lis->getYn_activo() == $activoC), ['id' => "txtListaActivo{$lis->getCargoDto()->getId_cargo()}"]); ?> 
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
                                                'class' => "ladda-button btn btn-primary {$object->getPermisoDto()->getIconEdit()}",
                                                'id' => 'btnEditAsociarCargo'
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
        $('.icheck-cargo').on('ifChecked', function(event){
        	var contenedorPadre = $(this).parents('tr').find('input');
			$(contenedorPadre).iCheck('check');
  		});
        $('.icheck-cargo').on('ifUnchecked', function(event){
        	var contenedorPadre = $(this).parents('tr').find('input');
			$(contenedorPadre).iCheck('uncheck');
  		});
        $('button#btnEditAsociarCargo').click(function () {
    		BUTTON_CLICK = this;
    	});
        $('#btnEditAsociarCargo').click(function () {
        	Framework.setConfirmar({
				contenido: 'Está a punto de asociar los cargos al representante: <b><?php echo Persistir::getParam('txtNombre'); ?></b> ¿Desea Continuar?',
				aceptar: function() {
					var l = Ladda.create(BUTTON_CLICK);
    	            l.start();
					Framework.setLoadData({
		                id_contenedor_body: false,
		                pagina: '<?php echo site_url('cargo/save_asociar'); ?>',
		                data: $('#frmAsociarCargo').serialize(),
		                success: function(data) {
		                	if (data.contenido == 0) {
                		    	Framework.setWarning('<?php echo lang('general.process_message_fail'); ?>');
                		    } else if (data.contenido) {
                		    	Framework.setSuccess('<?php echo lang('general.process_message'); ?>');
		                		Framework.setLoadData({
		                    		pagina: '<?php echo site_url('cargo/asociar'); ?>',
		                        	data: {
		                            	txtId_representante: null,
		                            	txtNombre: null 
		                            }
		                        });
                		    } else {
                		    	Framework.setError('<?php echo lang('general.operation_message'); ?>');
                		    }
                		    l.stop();
		                }
		            });
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
    function setDesactivarGrillaCargo(valor) {
    	$("#vistaAsociarCargo").css('display', 'none');
    }
    /**
	 * @tutorial Metodo Descripcion: activa la grilla para asociar cargos
	 * @author Rodolfo Perez ~~ pipo6280@gmail.com 
	 * @since 2015/06/09
	 * @param valor
	 */
	function setActivarGrillaCargo(valor) {
		Framework.setLoadData({
			pagina: '<?php echo site_url('cargo/asociar'); ?>',
            data: {
            	txtId_representante: valor.id,
            	txtNombre: valor.label
            }
        });
	}
</script>
