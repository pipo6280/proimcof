<?php 
use app\dtos\WelcomeDto;
use system\Helpers\Html;
use system\Support\Util;
use system\Helpers\Lang;
use system\Support\Str;
use system\Support\Number;
use app\enums\EDateFormat;

$object = $object instanceof WelcomeDto ? $object : new WelcomeDto(); ?>
<div class="row">
    <div class="col-lg-12">
        <h1>Clientes <small><?php echo lang('welcome.next_birthday'); ?></small></h1>
    </div>
</div>
<div class="row">
    <?php foreach ($object->getListBirthDay() as $lis) { ?>
    	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    		<div class="main-box clearfix profile-box-contact">
    			<div class="main-box-body clearfix">
    				<div class="profile-box-header gray-bg clearfix">
    					<?php 
        					if (! Util::isVacio($lis->getPersonaDto()->getFoto_perfil()) && Util::fileExists(Lang::text('em_imgpath', array(Lang::text('em_photopath', array($lis->getPersonaDto()->getFoto_perfil())))))) {
        					    echo Html::image(Lang::text('em_photopath', array($lis->getPersonaDto()->getFoto_perfil())), '', array('class' => 'profile-img img-responsive tooltipstered', 'title' => $lis->getPersonaDto()->getNombreCompletoPrimeraMayuscula()));
        					} else {
        					    echo Html::image(Lang::text('em_photopath', array('avatar.png')), '', array('class' => 'profile-img img-responsive tooltipstered', 'title' => $lis->getPersonaDto()->getNombreCompletoPrimeraMayuscula()));
        					}
    					?>
    					<h2><?php echo $lis->getPersonaDto()->getNombrePersonaCita(); ?></h2>
    					<ul class="contact-details">
    					   <li><i class="fa fa-calendar-o"></i> <?php echo Util::formatDate($lis->getPersonaDto()->getFecha_nacimiento(), EDateFormat::index(EDateFormat::DIA_MES)->getId()); ?></li>
    						<li><i class="fa fa-map-marker"></i> <?php echo $lis->getPersonaDto()->getDireccion() . ' ' . $lis->getPersonaDto()->getBarrio(); ?></li>
    						<?php if (! Util::isVacio($lis->getPersonaDto()->getEmail())) { ?>
                                <li><i class="fa fa-envelope"></i> <?php echo Str::lower($lis->getPersonaDto()->getEmail()); ?></li>
                            <?php } ?>
                            <?php if (! Util::isVacio($lis->getPersonaDto()->getTelefono())) { ?>
                                <li><i class="fa fa-phone"></i> (57 - 7) <?php echo $lis->getPersonaDto()->getTelefono(); ?></li>
                            <?php } ?>
                            <?php if (! Util::isVacio($lis->getPersonaDto()->getMovil())) { ?>
                                <li><i class="fa fa-mobile-phone"></i> (57) <?php echo $lis->getPersonaDto()->getMovil(); ?></li>
                            <?php } ?>
    					</ul>
    				</div>
    				<div class="profile-box-footer clearfix">
    					<a href="#" class="pull-left"><span class="value" style="font-size: 16px;"><?php echo $lis->getValor_inicial(); ?></span> <span class="label"><?php echo lang('welcome.services'); ?></span></a>
    					<a href="#" class="pull-right"><span class="value" style="font-size: 16px;">$ <?php echo Number::format($lis->getValor_abono()); ?></span> <span class="label"><?php echo lang('welcome.ventas'); ?></span></a> 
    				</div>
    			</div>
    		</div>
    	</div>
    <?php } ?>
</div>