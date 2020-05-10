<?php
    use system\Helpers\Lang;
    use app\dtos\ReporteDto;
    use system\Helpers\Form;
    use system\Support\Util;
    use system\Helpers\Html;
use app\dtos\ClienteCitaDto;
use app\enums\EDateFormat;
use app\enums\EEstadosCita;
    
    $object = $object instanceof ReporteDto ? $object : new ReporteDto();
    echo Html::style('css/libs/timeline.css');
?>
<div class="main-box clearfix">
    <div class="main-box-body clearfix">
        <div class="row">
            <div class="col-md-12">
                <div class="BUTTON_ADD">
                    <?php echo Lang::text('reporte_text_citas_clientes'); ?>
                </div>
                <br>
                <?php echo Form::open(array('id' => 'frmCitaCliente')); ?>
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
                            <?php echo Form::label(Lang::text('reporte_fecha_inicio'), 'txtFecha_inicio'); ?>
                            <div class="input-group">
                                <span class="input-group-addon blue"><i class="fa fa-calendar"></i></span>
                                <?php echo Form::text('txtFecha_inicio', (Util::isVacio($object->getFecha_inicio()) ? Util::restarFecha(Util::fechaActual(true), array('A' => 1)) : $object->getFecha_inicio()), array('class' => 'form-control datepicker notnull')); ?>
                            </div> 
                        </div>
                        <div class="form-group col-md-2">
                            <?php echo Form::label(Lang::text('reporte_fecha_fin'), 'txtFecha_fin'); ?>
                            <div class="input-group">
                                <span class="input-group-addon blue"><i class="fa fa-calendar"></i></span>
                                <?php echo Form::text('txtFecha_fin', (Util::isVacio($object->getFecha_fin()) ? Util::fechaActual() : $object->getFecha_fin()), array('class' => 'form-control datepicker notnull')); ?>
                            </div>  
                        </div>
                        <div class="form-group col-md-4"><br>
                            <?php echo Form::button(Lang::text('general_search_button'), 'btnBuscar'); ?>  
                        </div>    
                    </div>
                <?php echo Form::close(); ?>
            </div>
        </div>
    </div>
</div>
<?php if (! Util::isVacio($object->getList())) { ?>
    <div class="row">
        <div class="form-group">
            <section id="cd-timeline" class="cd-container">
                <?php foreach ($object->getList() as $fecha => $lis) { ?>
                    <?php $entra = true; ?>
                    <div class="cd-timeline-block">
                        <div class="cd-timeline-img cd-picture">
                            <i class="fa fa-clock-o fa-2x"></i>
                        </div>
                        <div class="cd-timeline-content">
                            <?php foreach ($lis as $l) { ?>
                                <?php if ($l instanceof ClienteCitaDto) { ?>
                                    <?php 
                                        $l->setHora_inicio($l->getFecha_cita() . ' ' . $l->getHora_inicio());
                                        $l->setHora_fin($l->getFecha_cita() . ' ' . $l->getHora_fin());
                                    ?>
                                    <h3>
                                        Hora Cita: <strong><?php echo Util::fecha(Util::fechaNumero($l->getHora_inicio()), 'h:i a'); ?> - <?php echo Util::fecha(Util::fechaNumero($l->getHora_fin()), 'h:i a'); ?></strong>   
                                    </h3>
                                    <div class="col-lg-12">
                                        <table>
                                            <tr>
                                                <td nowrap="nowrap" width="40%">
                                                    <?php echo Lang::text('reporte_representante'); ?>:            
                                                </td>
                                                <th>
                                                  <?php echo $l->getRepresentanteDto()->getPersonaDto()->getNombreCompleto(); ?>  
                                                </th>
                                            </tr>
                                            <tr>
                                                <td nowrap="nowrap">
                                                    <?php echo Lang::text('reporte_tipo_cita'); ?>:            
                                                </td>
                                                <th>
                                                  <?php echo $l->getServicioDto()->getNombre(); ?>  
                                                </th>
                                            </tr>
                                            <tr>
                                                <td nowrap="nowrap">
                                                    <?php echo Lang::text('reporte_estado_cita'); ?>:            
                                                </td>
                                                <th>
                                                  <?php echo EEstadosCita::result($l->getEstado())->getDescription(); ?>  
                                                </th>
                                            </tr>
                                            <tr>
                                                <td nowrap="nowrap">
                                                    <?php echo Lang::text('reporte_observaciones_cita'); ?>:            
                                                </td>
                                                <th>
                                                  <?php echo $l->getObservaciones(); ?>  
                                                </th>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="clearfix"></div>
                                <?php } ?>
                            <?php } ?>
                            <?php if ($entra) { ?>
                                <span class="cd-date"><?php echo Util::formatDate($fecha, 11); //EDateFormat::index(EDateFormat::DIA_MES_ANO_LETTER)->getId()?></span>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </section>
        </div>
    </div>
<?php } ?>
<?php echo Html::script('js/timeline.js'); ?>
<script>
    $(document).ready(function () {
    	$('#btnBuscar').click(function () {
        	var valido = Framework.setValidaForm('frmCitaCliente');
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
			pagina : '<?php echo site_url('reporte/citas_cliente'); ?>',
			data : $('#frmCitaCliente').serialize()
	  	});
    }
</script>