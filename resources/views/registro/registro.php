<?php 
use app\dtos\RegistroDto;
use system\Helpers\Form;

$object = $object instanceof RegistroDto ? $object : new RegistroDto();
?>
<?php echo Form::open(['action' => 'registro@save', 'id' => 'frmEdit']); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?php echo lang('registro.form_registro')?></h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <?php echo Form::label(lang('cliente.busqueda'), 'txtNombre_cliente'); ?>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                <?php
                                    echo Form::text( 'txtNombre_cliente', $object->getNombre_cliente(), [
                                        'data-input_hidden_value' => $object->getId_cliente(),
                                        'data-on_search' => 'javascript:setDesactivarGrilla',
                                        'data-on_select' => 'javascript:setActivarGrilla',
                                        'data-input_hidden_name' => 'txtId_cliente',
                                        'data-input_hidden_id' => 'txtId_cliente',
                                        'class' => 'form-control autocompletado',
                                        'data-control' => 'auto_clientes',
                                        'data-click' => false
                                    ]);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php Form::close()?>

<script type="text/javascript">

    /**
     * @tutorial Metodo Descripcion: desactiva la grilla
     * @author Eminson Mendoza ~~ emimaster16@gmail.com 
     * @since 2015/06/09
     * @param valor
     */
    function setDesactivarGrilla(valor) {
    	//$("#VISTA_PAGO").css('display', 'none');
    }
    /**
     * @tutorial Metodo Descripcion: activa la grilla
     * @author Eminson Mendoza ~~ emimaster16@gmail.com 
     * @since 2015/06/09
     * @param valor
     */
    function setActivarGrilla(valor) {
    	Framework.setLoadData({
			id_contenedor_body: false,
    		pagina: '<?php echo base_url('registro/save'); ?>',
    		data: {
        		'txtId_cliente':valor.id
    		},
    		success: function (data) {
        		if (data.contenido) {
        			//l.stop();
        			Framework.setAlerta("<?php echo lang('registro.nombre_cliente')?>"+data.nombre+"<br>"+data.mensaje)
        		} else {
        			//l.stop();
        			Framework.setAlerta("<?php echo lang('registro.nombre_cliente')?>"+data.nombre+"<br>"+data.error);	
        		}
    		}
		});	
    }
</script>