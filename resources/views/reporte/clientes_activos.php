<?php
use app\dtos\ReporteDto;
use system\Support\Util;
use app\enums\EDateFormat;
$object = $object instanceof ReporteDto ? $object : new ReporteDto();
?>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>
            <?php echo lang('reporte.clientes_activos'); ?>
        </h5>
    </div>
    <div class="ibox-content">
        <div class="clearfix"></div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover datatable" >
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            <?php echo lang('reporte.nombre'); ?>
                        </th>
                        <th class="text-center">
                            <?php echo lang('reporte.movil'); ?>
                        </th>
                        <th class="text-center">
                            <?php echo lang('reporte.fijo'); ?>
                        </th>
                        <th class="text-center">
                            <?php echo lang('reporte.email'); ?>
                        </th>
                        <th class="text-center">
                            <?php echo lang('reporte.paquete'); ?>
                        </th>
                        <th class="text-center">
                            <?php echo lang('reporte.fecha_pago'); ?>
                        </th>
                        <th class="text-center">
                            <?php echo lang('reporte.usuario'); ?>
                        </th>
                        <th class="text-center nosort">
                            <?php echo lang('general.edit_button'); ?>
                        </th>
                        <th class="text-center nosort">
                            <?php echo lang('reporte.ver_pago'); ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 1;?>
                    <?php foreach ($object->getList() as $key => $lis) { ?>
                        <tr>
                            <td>
                                <?php echo $count;?>
                            </td>
                            <td>
                                <?php echo $lis->getClienteDto()->getPersonaDto()->getNombreCompletoPrimeraMayuscula();?>
                            </td>
                            <td>
                                <?php echo $lis->getClienteDto()->getPersonaDto()->getMovil();?>
                            </td>
                            <td>
                                <?php echo $lis->getClienteDto()->getPersonaDto()->getTelefono() ?>
                            </td>
                            <td>
                                <?php echo $lis->getClienteDto()->getPersonaDto()->getEmail() ?>
                            </td>
                            <td>
                                <?php echo $lis->getSubPaqueteDto()->getNombre()?>
                            </td>
                            <td>
                                <?php echo Util::formatDate($lis->getFecha_pago(), EDateFormat::index(EDateFormat::MES_DIA_ANO)->getId())?>
                            </td>
                            <td>
                                <?php echo $lis->getClienteDto()->getPersonaDto()->getLoggin() ?>
                            </td>
                            <td class="text-center" >
                               <a href="javascript:void(0)" class="editCliente <?php echo $object->getPermisoDto()->getIconEdit(); ?>" data-numero_documento="<?php echo $lis->getClienteDto()->getPersonaDto()->getNumero_identificacion();?>" data-id_cliente="<?php echo $lis->getClienteDto()->getId_cliente() ?>" data-nombre="<?php echo $lis->getClienteDto()->getPersonaDto()->getNombreCompletoPrimeraMayuscula(); ?>" data-toggle="tooltip" title="<?php echo lang('general.title_edit', [$lis->getClienteDto()->getPersonaDto()->getNombreCompletoPrimeraMayuscula()]); ?>">
                                    <i class=" <?php echo $object->getPermisoDto()->getClassEdit(); ?> fa-2x"></i>
                               </a>
                            </td>
                            <td class="text-center" >
                               <a href="javascript:void(0)" class="editPago" data-id_cliente="<?php echo $lis->getClienteDto()->getId_cliente() ?>" data-id_cliente_sub_paquete="<?php echo $lis->getId_cliente_sub_paquete()?>" data-nombre="<?php echo $lis->getClienteDto()->getPersonaDto()->getNombreCompletoPrimeraMayuscula(); ?>" data-toggle="tooltip" title="<?php echo lang('reporte.ver_pago', [$lis->getClienteDto()->getPersonaDto()->getNombreCompletoPrimeraMayuscula()]); ?>">
                                    <i class=" fa fa-dollar fa-2x"></i>
                               </a>
                            </td>
                            <?php $count++;?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
$('a.editCliente').click(function () {
	var options = jQuery.extend({id_cliente : null, nombre : null , numero_documento: null }, $(this).data());
	var l = Ladda.create(this);
    l.start();
	Framework.setLoadData({
		pagina: '<?php echo site_url('cliente/cliente_datos'); ?>',
		data: { 
			txtId_paquete : options.id_cliente,
			"txtDto-txtPersonaDto-txtNumero_identificacion" :  options.numero_documento
		 },
		success: function (data) { l.stop(); }
	});
});

$('a.editPago').click(function () {
	var options = jQuery.extend({id_cliente : null, nombre : null, id_cliente_sub_paquete: null }, $(this).data());
	var l = Ladda.create(this);
    l.start();
    Framework.setLoadData({
    	pagina: '<?php echo site_url('cliente/pago_cliente_plan'); ?>',
        data: {
        	txtId_cliente: options.id_cliente,
        	txtId_cliente_sub_paquete:  options.id_cliente_sub_paquete,
        	txtNombre_cliente: options.nombre
        }            
    });
});
</script>
