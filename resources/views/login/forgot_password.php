<?php 
    use system\Helpers\Form;
    use system\Helpers\Html;
echo Form::open(['action' => 'Login@login', 'id' =>  'frmForgotPassword', 'role' => 'role', 'class' => 'login-form']); ?>
    <div class="col s12 z-depth-2 card-panel">
        <div class="row">
            <div class="input-field col s12 center">
                <?php echo Html::image('login-logo.png', '', ['class' => 'responsive-img valign']) ?>
                <p class="center login-form-text">
                    <?php
                        //echo lang('general.company_name');
                    ?>
                </p>
            </div>
        </div>
        <div class="row margin">
            <div class="input-field col s12" id="label-error-email">
                <i class="mdi-action-lock-outline prefix"></i>
                <?php 
                    echo Form::label(lang('login.email_username'), 'txtEmail');
                    echo Form::text('txtEmail', NULL, ['class' => 'form-control notnull']);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <?php 
                    echo Form::button(lang('login.continue_button', '<i class="mdi-action-lock-open right"></i>'), [
                        'class' => 'btn blue darken-4 waves-effect waves-blue right',
                        'id' => 'btnLogin',
                        'type' => 'submit'
                    ]); 
                ?>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 right">
                <p class="margin right-align medium-small">
                    <?php echo Html::linkAction(site_url('login'), lang('login.login', []), '', ['id' => 'login-forget-link']); ?>
                </p>
            </div>          
        </div>
    </div>
<?php echo Form::close() ?>
<script>
    $(function(){
    	if($("#frmForgotPassword").length>0) {
    		$("#frmForgotPassword").validate({
        		alert : false,
    			ignore: ":hidden:not(select)",
    			submitHandler: function(form) {
    				Framework.setConfirmar({
    					contenido : '<?php echo lang('login.confirm_sent'); ?>',
    					aceptar : function() {
    						Framework.setLoadData({
    							id_contenedor_body : false,
    							pagina : '<?php echo site_url('login/send_email'); ?>',
    							data : $('#frmForgotPassword').serialize(),
    							success : function(data) {
    								if (data.contenido) {
    									Framework.setLoadData({
    										id_contenedor_body : 'login-page',
    										pagina : '<?php echo site_url('login/index'); ?>',
    										data : {
    											txtLogin : null,
    											txtPassword : null
    										}
    									});
    									Framework.setAlerta(data.contenido);
    								}							
    							}
    						});
    					}
    				});
    			},
    			rules: {
    				txtEmail : "required"
    			},
    			errorPlacement: function(error, element) {
    				if (element.attr("name").indexOf('txtEmail') != -1) {
    			        error.insertAfter("#label-error-email");
    			    } else {
    			        error.insertAfter(element);
    			    }
    			}
    		});
    	};
    });
</script>
