<?php
use system\Helpers\Form;
use system\Helpers\Html;
use system\Support\Util; 
use system\Core\Persistir;

echo Form::open(['action' => 'Login@login', 'id' =>  'frmChangePassword', 'role' => 'role', 'class' => 'login-form']); ?>
    <div class="col s12 z-depth-4 card-panel">
        <div class="row">
            <div class="input-field col s12 center">
                <?php echo Html::image('login-logo.png', '', ['class' => ' responsive-img valign']) ?>
                <p class="center login-form-text">
                    <?php
                        //echo lang('general.company_name');
                    ?>
                </p>
            </div>
        </div>
        <div class="row margin">
            <div class="input-field col s12" id="label-error-loggin">
                <i class="mdi-action-lock-outline prefix"></i>
                <?php echo Form::hide('txtId_usuario', Persistir::getParam('txtId_usuario'));?>
                <?php echo Form::password('txtPassword_new', NULL,  ['class' => 'notnull']); ?>
                <?php echo Form::label(lang('login.password_new'), 'txtPassword_new'); ?>
            </div>
        </div>
        <div class="row margin">
            <div class="input-field col s12" id="label-error-password">
                <i class="mdi-action-lock-outline prefix"></i>
                <?php echo Form::password('txtPassword_new_review', NULL, ['class' => 'notnull']); ?>
                <?php echo Form::label(lang('login.password_review'), 'txtPassword_new_review'); ?>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <?php 
                    echo Form::button(lang('login.login') . '<i class="mdi-action-lock-open right"></i>', [
                        'class' => 'btn indigo darken-2 waves-effect waves-blue right',
                        'id' => 'btnLogin',
                        'type' => 'submit'
                    ]); 
                ?>
            </div>
        </div>
    </div>
<?php echo Form::close(); ?>
<script>
    $(function(){
    	if($("#frmChangePassword").length>0) {
    		$("#frmChangePassword").validate({
        		alert : false,
    			ignore: ":hidden:not(select)",
    			submitHandler: function(form) {
    				Framework.setConfirmar({
    					contenido : '<?php echo lang('login.confirm_sent'); ?>',
    					aceptar : function() {
    						Framework.setLoadData({
    							id_contenedor_body : false,
    							pagina : '<?php echo site_url('representante/save_password'); ?>',
    							data : $('#frmChangePassword').serialize(),
    							success : function(data) {
    								if (data.contenido) {
    									window.location.href = '<?php echo site_url('welcome'); ?>';
    									Framework.setAlerta('<?php echo lang('login.save_password_ok'); ?>');							
    								} else {
    									Framework.setAlerta('<?php echo lang('login.save_password_error'); ?>');
    								}							
    							}
    						});
    					}
    				});
    			},
    			rules: {
    				txtPassword_new : "required",
    				txtPassword_new_review : "required"
    			},
    			errorPlacement: function(error, element) {
			        error.insertAfter(element.parents('.input-field'));
    			}
    		});
    	};
    });
</script>