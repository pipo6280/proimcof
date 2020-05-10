<?php
    use system\Helpers\Lang;
    use app\dtos\ReporteDto;
    use app\dtos\ClienteDto;
    use system\Helpers\Form;
    use system\Support\Arr;
    use system\Support\Util;
use system\Core\Persistir;
    
    $object = $object instanceof ReporteDto ? $object : new ReporteDto();
?>
<div class="main-box clearfix">
    <div class="main-box-body clearfix">
        <div class="row">
            <div class="col-md-12">
                <div class="BUTTON_ADD">
                    <?php echo Lang::text('reporte_text_ortodoncia'); ?>
                </div>
                <hr>
                <?php echo Form::open(array('id' => 'frmOrtodoncias')); ?>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <?php 
                                echo Form::token();
                                echo Form::label(Lang::text('reporte_cliente_cita'), 'txtNombre_cliente');
                                echo Form::text('txtNombre_cliente', $object->getNombre_cliente(), array(
                                    'id' => 'txtNombre_cliente',
                                    'class' => 'form-control autocompletado notnull',
                                    'placeholder' => Lang::text('reporte_search_cliente'),
                                    'data-control' => 'auto_cliente',
                                    'data-on_search' => 'javascript:setDesactivarGrillaCliente',
                                    'data-on_select' => 'javascript:setActivarGrillaCliente',
                                    'data-input_hidden_id' => 'txtId_cliente',
                                    'data-input_hidden_name' => 'txtId_cliente',
                                    'data-input_hidden_value' => $object->getId_cliente()
                                ));
                            ?>
                        </div>
                        <div class="form-group col-md-3">
                            <?php echo Form::label(Lang::text('reporte_control_ortodoncia'), 'txtControlB'); ?>
                            <div class="input-group">
                                <span class="input-group-addon blue"><i class="fa fa-dot-circle-o"></i></span>
                                <?php echo Form::selectEnum('txtControlB', $object->getControlB(), $object->getListControles()); ?>
                            </div> 
                        </div>
                        <div class="form-group col-md-5"><br>
                            <?php echo Form::button(Lang::text('general_search_button'), 'btnBuscar'); ?>  
                        </div>    
                    </div>
                <?php echo Form::close(); ?>
                <br>
                <?php if (! Util::isVacio($object->getList())) { ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel-group accordion" id="accordion2">
                                <?php foreach ($object->getList() as $lis) { ?>
                                    <?php if ($lis instanceof ClienteDto) { ?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle collapsed" data-toggle="collapse" href="#collapseOne<?php echo $lis->getId_cliente(); ?>">
                                                        <?php echo $lis->getPersonaDto()->getNombreCompleto(); ?>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseOne<?php echo $lis->getId_cliente(); ?>" class="panel-collapse collapse" style="height: 1px;">
                                                <div class="panel-body">
                                                    <ul class="widget-todo">
                                                        <?php 
                                                            $arrayCitas = $lis->getList();
                                                        ?>
                                                        <?php foreach ($lis->getListControles() as $control) {
                                                            for ($i = 1; $i <= $control->getNumero(); $i++) {
                                                                $idControl = $control->getId_control() . ($control->getNumero() > 1 ? '-' . $i : '');
                                                                $nombreControl = $control->getNombre() . ($control->getNumero() > 1 ? ' - ' . $i : ''); ?>
                                                                <li class="clearfix" style="background-color: <?php echo Arr::isNullArray($idControl, $arrayCitas) ? 'normal;' : '#f6f6f6;;'; ?>">
                                                                    <div>
                                                                        <span class="pull-left"><?php echo $nombreControl; ?></span>
                                                                        <span class="pull-right">
                                                                            <div class="checkbox-nice">
                                                                                <?php
                                                                                    echo Form::checkbox("txtId_control{$idControl}", '', ! Arr::isNullArray($idControl, $arrayCitas), array('disabled' => 'disabled'));
                                                                                    echo Form::label('', "txtId_control{$idControl}");
                                                                                ?>
                                                                            </div>
                                                                        </span>
                                                                    </div>
                                                                </li>
                                                            <?php } ?>        
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>    
                            </div>
                        </div>
                    </div>
                <?php } elseif (! Util::isVacio(Persistir::getParam('_token'))){ ?>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="alert alert-info fade in">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <i class="fa fa-info-circle fa-fw fa-lg"></i>
                                <?php echo Lang::text('reporte_ortodoncia_no_datos'); ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
    	$('#btnBuscar').click(function () {
    	    recargarPage();
        });
    });
	function setDesactivarGrillaCliente(valor) {
		$('textarea').val(null);
        $(".vistaCita").css('display', 'none');
    }
	/**
	* @tutorial activa la grilla
	* @author Rodolfo Perez
	* @since 28/01/2016
	*/
	function setActivarGrillaCliente(valor) {
		$('#txtId_cliente').val(valor.id);
		$('#txtNombre_cliente').val(valor.label);
	}
	/**
	* @tutorial recarga la pagina
	* @author Rodolfo Perez
	* @since 28/01/2016
	*/	
	function recargarPage() {
  		Framework .LoadData({
			pagina : '<?php echo site_url('reporte/ortodoncia'); ?>',
			data : $('#frmOrtodoncias').serialize()
	  	});
    }
</script>