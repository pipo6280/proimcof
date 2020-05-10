<?php
    use system\Helpers\Lang;
    use system\Helpers\Form;
    use app\dtos\AdministracionDto;
    use app\enums\ESiNo;
    use system\Support\Util;
use system\Helpers\Html;
use system\Support\Arr;
    
    $object = $object instanceof AdministracionDto ? $object : new AdministracionDto();
    $yn_activo = Util::isVacio($object->getDto()->getYn_activo()) ? ESiNo::index(ESiNo::SI)->getId() : $object->getDto()->getYn_activo();
    $object->getDto()->setYn_activo($yn_activo);
?>
<div class="row">
    <div class="col-lg-12">
        <div class="main-box clearfix">
            <div class="main-box-body clearfix">
                <?php echo Form::open(['action' => 'Administracion@guardar_servicio', 'id' => 'frmServicio','class' => 'col s12']); ?>
                    <div class="row">
                        <div class="form-group col-xs-12 col-md-6 col-sm-6 col-lg-6">
                            <?php 
                                echo Form::hide('txtId_servicio', $object->getDto()->getId_servicio());
                                echo Form::hide('txtHasCita', $object->getDto()->getHasCita());
                                echo Form::label(Lang::text('administracion_nombre_servicio'), 'txtNombre');
                                echo Form::text('txtNombre', $object->getDto()->getNombre(), ['class' => 'form-control notnull', 'placeholder' => Lang::text('administracion_title_servicio')]);
                            ?>
                        </div>
                        <div class="form-group col-xs-12 col-md-6 col-sm-6 col-lg-3">
                            <?php 
                                echo Form::label(Lang::text('administracion_precio_servicio'), 'txtPrecio_base');
                                echo Form::text('txtPrecio_base', $object->getDto()->getPrecio_base(), ['class' => 'form-control notnull numero', 'placeholder' => Lang::text('administracion_title_precio_servicio')]);
                            ?>
                        </div>
                        <div class="form-group col-xs-12 col-md-6 col-sm-6 col-lg-3">
                            <?php 
                                echo Form::label(Lang::text('administracion_activo_servicio'), 'txtYn_activo');
                                echo Form::selectEnum('txtYn_activo', $object->getDto()->getYn_activo(), ESiNo::data(), ['class' => 'form-control select2-select notnull']);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="checkbox-nice checkbox-inline">
                                <?php
                                    echo Form::checkbox('txtHasControles', ESiNo::index(ESiNo::SI)->getId(), $object->getDto()->getHasControl());
                                    echo Form::label(Lang::text('administracion_tiene_control'), 'txtHasControles');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row divControles" style="display: <?php echo $object->getDto()->getHasControl() ? 'block' : 'none'; ?>;">
                        <?php foreach ($object->getDto()->getListControles() as $key => $lis) { ?>
                            <div class="form-group col-xs-12 col-md-6 col-sm-6 col-lg-6">
                                <?php 
                                    echo Form::hide('txtIdControl[]', $lis->getId_control());
                                    echo Form::label(Lang::text('administracion_control', [($key+1)]), "txtControl{$key}");
                                    echo Form::text('txtNombreControl[]', $lis->getNombre(), ['id' => "txtControl{$key}", 'class' => 'form-control classControlSevices', 'placeholder' => Lang::text('administracion_control_placeholder')]);
                                ?>
                            </div>
                            <div class="form-group col-xs-12 col-md-6 col-sm-6 col-lg-3">
                                <?php 
                                    echo Form::label(Lang::text('administracion_nro_controles'), "txtNumero{$key}");
                                    echo Form::text('txtNumeroControl[]', $lis->getNumero(), array('id' => "txtNumero{$key}", 'class' => 'form-control classControlSevices numero tooltipstered', 'readonly' => $object->getDto()->getHasCita(), 'title' => ($object->getDto()->getHasCita() ? 'Bloqueado por citas programadas' : '')));
                                ?>
                            </div>
                            <?php if (Arr::count($object->getDto()->getListControles()) > 1 && ! $object->getDto()->getHasCita()) { ?>
                                <div class="form-group col-xs-12 col-md-6 col-sm-6 col-lg-3">
                                    <?php echo Html::link('javascript:void(0)', '<i class="fa fa-trash-o fa-2x"></i>', array('class' => 'tooltipstered btnRemoveControl', 'title' => Lang::text('general_title_remove', array(Lang::text('administracion_control', array(($key+1))))), 'data-id_remove' => $key, 'data-remove' => ESiNo::index(ESiNo::SI)->getId())); ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <?php if (! $object->getDto()->getHasCita()) { ?>
                        <div class="row divControles" style="display: <?php echo $object->getDto()->getHasControl() ? 'block' : 'none'; ?>;">
                            <div class="form-group col-sm-12">
                                <?php echo Html::link('javascript:void(0)', '<i class="fa fa-plus-square-o fa-2x"></i>', array('class' => 'tooltipstered', 'title' => Lang::text('general_title_add', array(Lang::text('administracion_control'))), 'data-remove' => ESiNo::index(ESiNo::NO)->getId(), 'id' => 'btnAddControl')); ?>
                            </div>
                        </div>
                    <?php } ?>                    
                <?php echo Form::close(); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
	$('#txtHasControles').click(function () {
		if ($(this).prop('checked')) {
			$('.divControles').show("slow");
			$('.classControlSevices').each(function () {
				$(this).addClass('notnull');
		    });
		} else {
			$('.divControles').hide(1000);
			$('.classControlSevices').each(function () {
				$(this).removeClass('notnull');
		    });
		}
	});
	$('a#btnAddControl').click(function () {
        var valido = Framework.setValidaForm('frmServicio');     	
    	if (valido) {
    		Framework.LoadData({
    			id_contenedor_body : 'Dialog-Form-Servicio',
				pagina : '<?php echo base_url('administracion/add_control/true'); ?>',
				data : $('#frmServicio').serialize()
			});  	       
    	}
    });
    $('a.btnRemoveControl').each(function () {
        $(this).click(function () {
            var options = $(this).data();
    		Framework.LoadData({
    			id_contenedor_body : 'Dialog-Form-Servicio',
				pagina : '<?php echo base_url('administracion/add_control/true'); ?>',
				data : $('#frmServicio').serialize() + '&txtEliminar='+ options.id_remove +'&txtRemove='+ options.remove
			});  	       
        });
    });
});
</script>
