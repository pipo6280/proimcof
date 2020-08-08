<?php 
use app\dtos\WelcomeDto;
use system\Helpers\Html;
use system\Support\Util;
use system\Helpers\Lang;
use system\Support\Str;
use system\Support\Number;
use app\enums\EDateFormat;
use app\dtos\MantenimientoDto;

$object = $object instanceof WelcomeDto ? $object : new WelcomeDto(); ?>
<div class="row">
    <div class="col-lg-12">
        <h1>Clientes <small><?php echo lang('welcome.next_birthday'); ?></small></h1>
    </div>
</div>
<div class="row">
    <?php foreach ($object->getListBirthDay() as  $lis) { ?>
    	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    		<div class="main-box clearfix profile-box-contact">
    			<div class="main-box-body clearfix">
    				<div class="profile-box-header gray-bg clearfix">    					
    					
    				</div>
    				<div class="profile-box-footer clearfix">
    					 
    				</div>
    			</div>
    		</div>
    	</div>
    <?php } ?>
</div>