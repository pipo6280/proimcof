<?php 
use system\Helpers\Form;
use system\Helpers\Html;
use app\enums\ESiNo;

echo Form::open(['action' => 'Login@login', 'id' =>  'frmLogin', 'role' => 'role', 'class' => 'login-form']); ?>
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
                <i class="mdi-social-person-outline prefix"></i>
                <?php echo Form::text('txtLogin', NULL,  ['class' => 'notnull']); ?>
                <?php echo Form::label(lang('login.user'), 'txtLogin'); ?>
            </div>
        </div>
        <div class="row margin">
            <div class="input-field col s12" id="label-error-password">
                <i class="mdi-action-lock-outline prefix"></i>
                <?php echo Form::password('txtPassword', NULL, ['class' => 'notnull']); ?>
                <?php echo Form::label(lang('login.password'), 'txtPassword'); ?>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <?php 
                    echo Form::button(lang('login.login') . '<i class="mdi-action-lock-open right"></i>', [
                        'class' => 'btn indigo darken-4 waves-effect waves-blue right',
                        'id' => 'btnLogin',
                        'type' => 'submit'
                    ]); 
                ?>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 right">
                <p class="margin right-align medium-small">
                    <?php echo Html::linkAction('Login@forgot_password', lang('login.forgot_password'), '', ['id' => 'login-forget-link']); ?>
                </p>
            </div>          
        </div>
    </div>
<?php echo Form::close() ?>
<script>
    $(function(){
    	if($("#frmLogin").length>0) {
    		$("#frmLogin").validate({
        		alert : false,
    			ignore: ":hidden:not(select)",
    			submitHandler: function(form) {
    				Framework.setLoadData({
                        pagina : '<?php echo site_url('login/login'); ?>',
                        data : $('#frmLogin').serialize(),
                        id_contenedor_body 	: false,
                        success : function(data) {
                        	var message = $.trim(data.contenido);
                            if (Number(message) == <?php echo ESiNo::index(ESiNo::SI)->getId(); ?>) {
                                location.href='<?php echo site_url('login/change_password'); ?>/'+$('#txtLogin').val();
                            } else if (Number(message) == <?php echo ESiNo::index(ESiNo::NO)->getId(); ?>) {
                                location.href='<?php echo site_url(); ?>';
                            } else {Framework.setAlerta(data.contenido);}        	
                        }
                    });
    			},
    			rules: {
    				txtLogin : "required",
    				txtPassword : "required",
    			},
    			errorPlacement: function(error, element) {
    				if (element.attr("name").indexOf('txtLogin') != -1) {
    			        error.insertAfter("#label-error-loggin");
    			    } else if (element.attr("name").indexOf('txtPassword') != -1) {
    			    	error.insertAfter("#label-error-password");
    			    } else {
    			        error.insertAfter(element);
    			    }
    			}
    		});
    	};
    });
</script>