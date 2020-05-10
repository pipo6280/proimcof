<?php
    use system\Helpers\Lang;
    use app\dtos\ReporteDto;
    use system\Helpers\Form;
    use system\Support\Util;
    use system\Helpers\Html;
use app\dtos\ClienteCitaDto;
use app\enums\EDateFormat;
use app\enums\EEstadosCita;
use app\dtos\ServicioDto;
use app\dtos\ClienteServicioDto;
use system\Support\Number;
    
    $object = $object instanceof ReporteDto ? $object : new ReporteDto();
?>
<div class="main-box clearfix">
    <div class="main-box-body clearfix">
        <div class="row">
            <div class="col-md-12">
                <div class="BUTTON_ADD">
                    <?php echo Lang::text('reporte_text_deudas_cliente'); ?>
                </div>
                <br>
                <?php echo Form::open(array('id' => 'frmDeudasCliente')); ?>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <?php 
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
                        <div class="form-group col-md-2">
                            <?php 
                                echo Form::label(Lang::text('reporte_deuda_tratamiento'), 'txtId_servicio');
                                echo Form::selectEnum('txtId_servicio', $object->getId_servicio(), $object->getList()); 
                            ?>                            
                        </div>
                        <div class="form-group col-md-4"><br>
                            <?php echo Form::button(Lang::text('general_search_button'), 'btnBuscar'); ?>  
                        </div>    
                    </div>
                <?php echo Form::close(); ?>
            </div>
        </div>
        <?php if (! Util::isVacio($object->getListServicios())) { ?>
            <div class="row">
                <div class="form-group">
                    <table id="" class="table table-hover table-striped">
                        <thead>
                            <tr role="row">
                                <th>
                                    <?php echo Lang::text('reporte_deuda_tratamiento'); ?>
                                </th>
                                <th>
                                    <?php echo Lang::text('reporte_deuda_valor_tratamiento'); ?>
                                </th>
                                <th>
                                    <?php echo Lang::text('reporte_deuda_total_abonos'); ?>
                                </th>
                                <th>
                                    <?php echo Lang::text('reporte_deuda_saldo_tratamiento'); ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $totalServicio = 0;
                                $totalAbonos = 0;
                                $totalSaldo = 0;
                            ?>
                            <?php foreach ($object->getListServicios() as $lis) { ?>
                                <tr>
                                    <td rowspan="<?php echo count($lis->getListTratamientos()) + 1; ?>">
                                        <?php echo $lis->getNombre(); ?>
                                    </td>
                                </tr>
                                
                                <?php foreach ($lis->getListTratamientos() as $l) {
                                    if ($l instanceof ClienteServicioDto) { ?>
                                        <tr>   
                                            <td>
                                                <?php 
                                                    echo Number::format(Util::isVacio($l->getValor()) ? 0 : $l->getValor());
                                                    $totalServicio += $l->getValor();
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    echo Number::format(Util::isVacio($l->getTotalAbonos()) ? 0 : $l->getTotalAbonos());
                                                    $totalAbonos += $l->getTotalAbonos();
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    echo Number::format(Util::isVacio($l->getTotalSaldo()) ? 0 : $l->getTotalSaldo());
                                                    $totalSaldo += $l->getTotalSaldo();
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>
                                    <?php echo Lang::text('reporte_deuda_totales');?>
                                </td>
                                <td>
                                    <?php echo Number::format($totalServicio); ?>
                                </td>
                                <td>
                                    <?php echo Number::format($totalAbonos); ?>
                                </td>
                                <td>
                                    <?php echo Number::format($totalSaldo); ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        <?php } else if (! Util::isVacio($object->getId_cliente())){ ?>
        <script type="text/javascript">
            $(document).ready(function () {
                Framework.Alerta('El cliente no tiene deudas por cancelar <?php echo Util::isVacio($object->getId_servicio()) ? 'o tratamientos asignados' : 'para el tratamiento seleccionado'; ?>');
            });
        </script>
        <?php } ?>
    </div>
</div>
<script>
    $(document).ready(function () {
    	$('#btnBuscar').click(function () {
        	var valido = Framework.setValidaForm('frmDeudasCliente');
    		if (valido) {
    			recargarPage();
    		}
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
			pagina : '<?php echo site_url('reporte/deuda_cliente'); ?>',
			data : $('#frmDeudasCliente').serialize()
	  	});
    }
</script>