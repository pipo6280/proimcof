<?php
use system\Support\Util;
use app\dtos\SessionDto;
use system\Helpers\Html;
use system\Helpers\Form;
use app\enums\ETipoDocumento;
use app\enums\EEstadoCivil;

$sessionDto = Util::userSessionDto();
$sessionDto = $sessionDto instanceof SessionDto ? $sessionDto : new SessionDto();
?>
<div class="col-lg-12" id="main_content">
    <div class="row">
        <div class="col-lg-12">
            <br><h1><?php echo lang('representante.info_profile'); ?></h1>
		</div>
	</div>
	<div class="row" id="user-profile">
		<div class="col-lg-3 col-md-4 col-sm-4">
			<div class="main-box clearfix">
				<header class="main-box-header clearfix">
					<h2><?php echo $sessionDto->getFirstLastName(); ?></h2>
				</header>
				<div class="main-box-body clearfix">
					<div class="profile-status">
						<i class="fa fa-circle"></i> Online
					</div>
					<div class="profile-label">
                        <?php 
//                             echo Util::loadInputFile(array(
//                                 'classInputFile' => 'tooltipstered',
//                                 'title' => lang('representante.change_photo'),
//                                 'idDivFoto' => 'divFotoPerfil',
//                                 'urlFoto' => $sessionDto->getPhotoProfile(),
//                                 'urlFolder' => Lang::text('em_imgpath', array(Lang::text('em_photopath', array(NULL)))),
//                                 'classDel' => false
//                             ));
                        ?>
                        
					</div>
                    <div class="profile-details">
                        <div class="profile-label">
    						<span class="label label-success"><?php echo lang('representante.profiles'); ?></span>
    					</div>
						<ul class="fa-ul">
                            <?php foreach ($sessionDto->getListProfiles() as $lis) { ?>
                                <li><i class="fa-li fa fa-user"></i><?php echo $lis->getNombre(); ?></li>
                            <?php } ?>
						</ul>
						
						<div class="profile-label">
    						<span class="label label-primary"><?php echo lang('representante.login'); ?></span>
    					</div>
						<ul class="fa-ul">
                            <li><i class="fa-li fa fa-key"></i><?php echo $sessionDto->getLoggin(); ?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-9 col-md-8 col-sm-8">
			<div class="main-box clearfix">
				<div class="tabs-wrapper profile-tabs">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-datos" data-toggle="tab"><?php echo lang('representante.datos'); ?></a></li>
						<li class=""><a href="#tab-cuenta" data-toggle="tab"><?php echo lang('representante.cuenta'); ?></a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane fade active in" id="tab-datos">
							<div id="newsfeed">
                                <?php echo Form::open(['action' => site_url('representante/save_datos'), 'id' => 'frmDatosRepresentante']); ?>
								    <div class="story">
    									<div class="story-user">
                                            <?php echo Html::link('javascript:void(0)', Html::image('icons/personal-information.png')); ; ?>
    									</div>
    									<div class="story-content">
    										<header class="story-header">
    											<div class="story-author">
    												<h4><?php echo lang('representante.info_basica'); ?></h4>
    											</div>
    										</header>
    										<div class="story-inner-content">
                                                <div class="row">
                                                    <div class="form-group col-lg-6">
                                                        <?php
                                                            echo Form::hide('txtDto-txtPersonaDto-txtId_persona', $sessionDto->getPersonaDto()->getId_persona());
                                                            echo Form::label(lang('representante.primer_nombre'), 'txtDto-txtPersonaDto-txtPrimer_nombre');
                                                            echo Form::text('txtDto-txtPersonaDto-txtPrimer_nombre', $sessionDto->getPersonaDto()->getPrimer_nombre(), array('class' => 'form-control notnull'));
                                                        ?>
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <?php
                                                            echo Form::label(lang('representante.segundo_nombre'), 'txtDto-txtPersonaDto-txtSegundo_nombre');
                                                            echo Form::text('txtDto-txtPersonaDto-txtSegundo_nombre', $sessionDto->getPersonaDto()->getSegundo_nombre(), array('class' => 'form-control'));
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-6">
                                                        <?php
                                                            echo Form::label(lang('representante.primer_apellido'), 'txtDto-txtPersonaDto-txtPrimer_apellido');
                                                            echo Form::text('txtDto-txtPersonaDto-txtPrimer_apellido', $sessionDto->getPersonaDto()->getPrimer_apellido(), array('class' => 'form-control notnull'));
                                                        ?>
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <?php
                                                            echo Form::label(lang('representante.segundo_apellido'), 'txtDto-txtPersonaDto-txtSegundo_apellido');
                                                            echo Form::text('txtDto-txtPersonaDto-txtSegundo_apellido', $sessionDto->getPersonaDto()->getSegundo_apellido(), array('class' => 'form-control'));
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-6">
                                                        <?php
                                                            echo Form::hide('txtDto-txtPersonaDto-txtTipo_identificacion', $sessionDto->getPersonaDto()->getTipo_identificacion());
                                                            echo Form::label(lang('representante.tipo_documento'), 'txtDto-txtPersonaDto-txtTipo_identificacion');
                                                            echo Form::selectEnum('txtDto-txtPersonaDto-txtTipo_identificacion', $sessionDto->getPersonaDto()->getTipo_identificacion(), ETipoDocumento::data(), ['class' => 'form-control select2-select notnull', 'disabled' => 'disabled']);
                                                        ?>
                                                	</div>
                                                	<div class="form-group col-lg-6">
                                                       <?php  
                                                            echo Form::label(lang('representante.numero_documento'), 'txtDto-txtPersonaDto-txtNumero_identificacion');
                                                            echo Form::text('txtDto-txtPersonaDto-txtNumero_identificacion', $sessionDto->getPersonaDto()->getNumero_identificacion(), ['class' => 'form-control  notnull numero', 'length' => 15, 'readonly' => 'readonly']);
                                                       ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-6">
                            	                        <?php
                                                            echo Form::label(lang('representante.ciudad_expedicion'), 'txtDto-txtPersonaDto-txtId_ciudad_documento');
                                                            //echo Form::text('txtDto-txtPersonaDto-txtCiudadDto-txtNombre', $sessionDto->getPersonaDto()->getCiudadDto()->getNombre(), ['id' => 'txtId_ciudad_documento', 'class' => 'form-control autocompletado', 'data-control' => 'auto_ciudades', 'data-input_hidden_name' => 'txtDto-txtPersonaDto-txtId_ciudad_documento', 'data-input_hidden_value' => $sessionDto->getPersonaDto()->getId_ciudad_documento()]);
                                                        ?>
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <?php echo Form::label(lang('representante.fecha_nacimiento'), 'txtDto-txtPersonaDto-txtFecha_nacimiento'); ?>
                                                        <div class="input-group">
                                                            <span class="input-group-addon blue"><i class="fa fa-calendar"></i></span>
                                                            <?php echo Form::text('txtDto-txtPersonaDto-txtFecha_nacimiento', $sessionDto->getPersonaDto()->getFecha_nacimiento(), ['class' => 'form-control datepicker']); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
    									</div>
    								</div>
    								<div class="story">
    									<div class="story-user">
                                            <?php echo Html::link('javascript:void(0)', Html::image('icons/preferences-contact.png')); ; ?>
    									</div>
    									<div class="story-content">
    										<header class="story-header">
    											<div class="story-author">
    												<h4><?php echo lang('representante.info_contacto'); ?></h4>
    											</div>
    										</header>
    										<div class="story-inner-content">
                                                <div class="row">
                                                    <div class="form-group col-lg-6">
                                                        <?php echo Form::label(lang('representante.direccion'), 'txtDto-txtPersonaDto-txtDireccion'); ?>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                                      		<?php echo Form::text('txtDto-txtPersonaDto-txtDireccion', $sessionDto->getPersonaDto()->getDireccion(), array('class' => 'form-control notnull')); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <?php echo Form::label(lang('representante.barrio'), 'txtDto-txtPersonaDto-txtBarrio'); ?>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
                                                      		<?php echo Form::text('txtDto-txtPersonaDto-txtBarrio', $sessionDto->getPersonaDto()->getBarrio(), array('class' => 'form-control notnull')); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-6">
                                                        <?php echo Form::label(lang('representante.numero_fijo'), 'txtDto-txtPersonaDto-txtTelefono'); ?>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                      		<?php echo Form::text('txtDto-txtPersonaDto-txtTelefono', $sessionDto->getPersonaDto()->getTelefono(), ['class' => 'form-control  numero', 'length' => 10]); ?>
                                                      	</div>	
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <?php echo Form::label(lang('representante.movil'), 'txtDto-txtPersonaDto-txtMovil'); ?>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-mobile-phone"></i></span>
                                                       		<?php echo Form::text('txtDto-txtPersonaDto-txtMovil', $sessionDto->getPersonaDto()->getMovil(), ['class' => 'form-control notnull numero', 'length' => 10]); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
    										<footer class="story-footer">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <?php echo Form::button(lang('representante.save_changes'), 'btnSaveDatos'); ?>
                                                    </div>
                                                </div>
    										</footer>
    									</div>
    								</div>
    							</div>
                            <?php echo Form::close(); ?>
						</div>
						<div class="tab-pane fade" id="tab-cuenta">
                            <div id="newsfeed">
                                <?php echo Form::open(['action' => site_url('representante/save_cuenta'), 'id' => 'frmCuenta']); ?>
								    <div class="story">
    									<div class="story-user">
                                            <?php echo Html::link('javascript:void(0)', Html::image('icons/cuenta-user.png')); ; ?>
    									</div>
    									<div class="story-content">
    										<header class="story-header">
    											<div class="story-author">
    												<h4><?php echo lang('representante.info_cuenta'); ?></h4>
    											</div>
    										</header>
    										<div class="story-inner-content">
                                                <div class="row">
                                                    <div class="form-group col-lg-6">
                                                        <?php
                                                            echo Form::hide('txtId_usuario', $sessionDto->getIdUsuario());
                                                            echo Form::hide('txtId_persona', $sessionDto->getPersonaDto()->getId_persona());
                                                            echo Form::label(lang('representante.login'), 'txtUsuario');
                                                            echo Form::text('txtUsuario', $sessionDto->getLoggin(), array('readonly' => 'readonly'));
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-6">
                                                        <?php
                                                            echo Form::label(lang('representante.password_actual'), 'txtPassword_actual');
                                                            echo Form::password('txtPassword_actual', NULL, array('class' => 'form-control notnull'));
                                                        ?>
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <?php
                                                            echo Form::label(lang('representante.password_new'), 'txtPassword_new');
                                                            echo Form::password('txtPassword_new', NULL, array('class' => 'form-control notnull'));
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-6">
                                                        <?php
                                                            echo Form::label(lang('representante.password_review'), 'txtPassword_new_review');
                                                            echo Form::password('txtPassword_new_review', NULL, array('class' => 'form-control notnull'));
                                                        ?>
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <br>
                                                        <?php echo Form::button(lang('representante.save_changes'), 'btnSavePassword'); ?>
                                                    </div>
                                                </div>
                                           </div>
                                        </div>
                                    </div>
                                <?php echo Form::close(); ?>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function () {
	$('#btnSaveDatos').click(function () {
		var valido = Framework.setValidaForm('frmDatosRepresentante'); 
		if (valido) {
			Framework.Confirmar({
				contenido : 'Está a punto de guardar los datos de información personal ¿Desea Continuar?',
				aceptar : function() {
					Framework.LoadData({
						id_contenedor_body : false,
						pagina : '<?php echo site_url('representante/save_datos'); ?>',
						data : $('#frmDatosRepresentante').serialize(),
						success : function(data) {
							if (data.contenido) {
								Framework.Alerta('<?php echo lang('representante.save_ok'); ?>');
								Framework.LoadData({
	    							pagina : '<?php echo site_url('representante/user_profile'); ?>',
									data : {}
								});
							} else {
								Framework.Alerta('<?php echo Lang::text('general_operation_message'); ?>');
							}							
						}
					});
				}
			});
		}
	});
	$('#txtPassword_new').keyup(function () {
	    if ($(this).val() != $('#txtPassword_new_review').val()) {
		    $(this).parent('div').addClass('has-warning');
		    $('#txtPassword_new_review').parent('div').addClass('has-warning');
		} else {
			$(this).parent('div').removeClass('has-warning').addClass();
		    $('#txtPassword_new_review').parent('div').removeClass('has-warning').addClass('has-warning');
		}
	});
	$('#txtPassword_new_review').keyup(function () {
	    if ($(this).val() != $('#txtPassword_new').val()) {
		    $(this).parent('div').addClass('has-warning');
		    $('#txtPassword_new_review').parent('div').addClass('has-warning');
		} else {
			$(this).parent('div').removeClass('has-warning').addClass('has-success');
		    $('#txtPassword_new').parent('div').removeClass('has-warning').addClass('has-success');
		}
	});
	$('#txtPassword_actual').keyup(function () {
		if ($(this).val().length > 3) {
			var object = $(this);
    		Framework.LoadData({
    			id_contenedor_body : false,
    			pagina : '<?php echo site_url('representante/validate_password'); ?>',
    			loading : false,
    			data : {
    				txtId_usuario : $('#txtId_usuario').val(),
    				txtPassword : $(this).val()
    			},
    			success : function(data) {
    				$(object).parent('div').attr('class', null);
    				$(object).parent('div').addClass('form-group col-lg-6');
    				$(object).parent('div').addClass((data.contenido ? 'has-success' : 'has-warning'));						
    			}
    		});
		}
	});
	$('#btnSavePassword').click(function () {
		var valido = Framework.setValidaForm('frmCuenta'); 
		if (valido) {
			Framework.Confirmar({
				contenido : 'Está a punto de cambiar la contraseña ¿Desea Continuar?',
				aceptar : function() {
					Framework.LoadData({
						id_contenedor_body : false,
						pagina : '<?php echo site_url('representante/save_password'); ?>',
						data : $('#frmCuenta').serialize(),
						success : function(data) {
							if (data.contenido) {
								Framework.LoadData({
	    							pagina : '<?php echo site_url('representante/user_profile'); ?>',
	    							data : {
	    								id_contenedor_body : false
		    						}
								});
								Framework.Alerta('<?php echo lang('representante.save_password_ok'); ?>');
								
							} else {
								Framework.Alerta('<?php echo lang('representante.save_password_error'); ?>');
							}							
						}
					});
				}
			});
		}
	});
});
</script>