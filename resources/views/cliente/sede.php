<?php

use system\Helpers\Form;
use app\dtos\ClienteDto;
use system\Support\Util;
use app\dtos\ClienteSedeDto;
use system\Support\Arr;

$object = $object instanceof ClienteDto ? $object : new ClienteDto();  ?>
<?php echo Form::open(['action' => 'Cliente@registrar_pago', 'id' => 'frmPago', 'class' => 'col s12']); ?>
    <div class="ibox float-e-margins">
        <div class="ibox-content">
            <div class="row">
        		<div class="form-group col-md-4 col-lg-4">
                    <?php echo Form::label(lang('cliente.cliente'), 'txtDto-txtNombre_cliente'); ?>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                        <?php 
                        echo Form::text('txtDto-txtNombre_empresa',  $object->getDto()->getNombre_empresa(),[
                            'class' => 'form-control autocompletado notnull', 
                    		'placeholder' => lang('cliente.cliente'), 
                    		'data-control' => 'auto_cliente',
                    	    'data-on_search' => 'javascript:setDesactivarGrillaPago',
                    	    'data-on_select' => 'javascript:setActivarGrillaPago',
                            'data-input_hidden_id' => 'txtDto-txtId_cliente',
                    		'data-input_hidden_name' => 'txtDto-txtId_cliente', 
                    		'data-input_hidden_value' => $object->getDto()->getId_cliente()
                        ]);?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php if( !Arr::isEmptyArray($object->getDto()->getList_sedes()) ) { ?>
        <div class="ibox float-e-margins vistaPago" >
            <div class="ibox-content">
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover datatable" >
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th class="text-center ">
                                    <?php echo lang('cliente.nombre'); ?>
                                </th>
                                <th class="text-center ">
                                    <?php echo lang('cliente.telefono'); ?>
                                </th>
                                <th class="text-center ">
                                    <?php echo lang('cliente.equipos'); ?>
                                </th>
                                <th class="text-center nosort">
                                    <?php echo lang('general.edit_button'); ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ( $object->getDto()->getList_sedes() as $k => $lis) { ?>
                            <?php $lis instanceof ClienteSedeDto; ?>
                                <tr class="gradeX">
                                    <td class="text-center ">
                                        <?php echo $k+1; ?>
                                    </td>
                                    <td class="text-center ">
                                        <?php echo $lis->getNombre(); ?>
                                    </td> 
                                    <td class="text-center ">
                                        <?php echo $lis->getTelefono(); ?>
                                    </td>  
                                    <td class="text-center ">
                                        <?php echo $lis->getNum_equipos(); ?>
                                    </td>
                                    <td class="text-center" >
                                       <a href="javascript:void(0)" class="editClienteSede <?php echo $object->getPermisoDto()->getIconEdit(); ?>" data-id_sede="<?php echo $lis->getId_cliente_sede(); ?>" data-nombre="<?php echo $lis->getNombre(); ?>" data-toggle="tooltip" title="<?php echo lang('general.title_edit', [$lis->getNombre()]); ?>">
                                            <i class=" <?php echo $object->getPermisoDto()->getClassEdit(); ?> fa-2x"></i>
                                       </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>      
            </div>
        </div>
    <?php } ?>
<?php Form::close(); ?>

<script type="text/javascript">
                    
    function setDesactivarGrillaPago(valor) {
    	$(".vistaPago").css('display', 'none');
    }

    function setActivarGrillaPago(valor) {
    	Framework.setLoadData({
    		pagina : '<?php echo site_url('cliente/consultar_sedes'); ?>',
            data : {
            	'txtId_cliente' : valor.id,
            },
            success: function () { 
                //l.stop(); 
            }
        });
    }

    $('a.editClienteSede').click(function () {
    	var options = jQuery.extend({ id_sede : null, nombre : null }, $(this).data());
    	var l = Ladda.create(this);
        l.start();
    	Framework.setLoadData({
    		pagina: '<?php echo site_url('cliente/get_equipos_sede'); ?>',
    		data: { 
    			txtId_cliente_sede : options.id_sede 
            },
    		success: function (data) { 
        		l.stop();
        	}
    	});
    });
    
                    
</script>