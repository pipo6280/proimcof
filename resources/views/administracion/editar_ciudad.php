<?php
    use system\Helpers\Lang;
    use system\Helpers\Form;
    use app\dtos\AdministracionDto;
    
    $object = $object instanceof AdministracionDto ? $object : new AdministracionDto();
?>
<div class="row">
    <div class="col-lg-12">
        <div class="main-box clearfix">
            <div class="main-box-body clearfix">
                <?php echo Form::open(['action' => 'Administracion@guardar_ciudad', 'id' => 'frmCiudad','class' => 'col s12']); ?>
                    <div class="row">
                        <div class="form-group">
                            <?php 
                                echo Form::hide('txtId_ciudad', $object->getDto()->getId_ciudad());
                                echo Form::label(Lang::text('administracion_nombre_ciudad'), 'txtNombre');
                                echo Form::text('txtNombre', $object->getDto()->getNombre(), ['class' => 'form-control notnull', 'placeholder' => Lang::text('administracion_placeholder_ciudad')]);
                            ?>
                        </div>
                    </div>
                <?php echo Form::close(); ?>
            </div>
        </div>
    </div>
</div>