<?php
use system\Helpers\Html;
use system\Core\Message;
use system\Helpers\Form;
use system\Support\Util;

global $userMenu; ?>
<!DOCTYPE html>
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<head>
        <?php
            echo Html::title(lang('general.company_name'));
            echo Html::favicon();
            echo Html::charset();
            
    		echo Html::meta('viewport','width=device-width, initial-scale=1.0');
    		echo Html::meta('description', lang('general.description'));
    		echo Html::meta('keywords', lang('general.keywords'));
    		echo Html::meta('author', lang('general.company_name'));
    		
    		// Fonts
    		echo Html::style('http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic');
    		echo Html::style('http://fonts.googleapis.com/css?family=Raleway:700,400,300');
    		echo Html::style('http://fonts.googleapis.com/css?family=Pacifico');
    		echo Html::style('http://fonts.googleapis.com/css?family=PT+Serif');
    		
    		// Bootstrap
    		echo Html::style('plugins/bootstrap/css/bootstrap.min.css');
    		echo Html::style('fonts/font-awesome/css/font-awesome.css');
    		echo Html::style('fonts/fontello/css/fontello.css');
    		
    		echo Html::style('plugins/magnific-popup/magnific-popup.css');
    		echo Html::style('plugins/rs-plugin/css/settings.css');
    		echo Html::style('css/animations.css');
    		
    		echo Html::style('plugins/owl-carousel/owl.carousel.css');
    		echo Html::style('plugins/owl-carousel/owl.transitions.css');
    		echo Html::style('plugins/hover/hover-min.css');
    		
    		echo Html::style('plugins/tooltipster/tooltipster.css');
    		echo Html::style('plugins/select2/select2.min.css');
    		echo Html::style('plugins/select2/select2-bootstrap.min.css');
    		echo Html::style('plugins/jquery-ui/jquery-ui.min.css');
    		
    		echo Html::style('css/style.css');
    		echo Html::style('css/skins/light_blue.css');
    		echo Html::style('css/custom.css');
    		
    		echo Html::script('plugins/jquery-1.11.3.min.js');
    		echo Html::script('plugins/framework/livequery.min.js');
    		echo Html::script('plugins/framework/framework.js');
		?>
	</head>
	<body class="no-trans front-page  ">
		<!-- scrollToTop -->
		
		<div class="scrollToTop circle"><i class="icon-up-open-big"></i></div>
		<!-- page wrapper start -->
		
		<div class="page-wrapper">
			<!-- header-container start -->
			<div class="header-container">
				
				<!-- header-top start -->
				<!-- classes:  -->
				<!-- "dark": dark version of header top e.g. class="header-top dark" -->
				<!-- "colored": colored version of header top e.g. class="header-top colored" -->
				<div class="header-top colored">
					<div class="container">
						<div class="row">
							<div class="col-xs-3 col-sm-6 col-md-9">
								<!-- header-top-first start -->
								<div class="header-top-first clearfix">
									<ul class="social-links circle small clearfix hidden-xs">
										<li class="twitter"><a target="_blank" href="http://www.twitter.com"><i class="fa fa-twitter"></i></a></li>
										<li class="facebook"><a target="_blank" href="http://www.facebook.com"><i class="fa fa-facebook"></i></a></li>
										<li class="youtube"><a target="_blank" href="http://www.youtube.com"><i class="fa fa-youtube-play"></i></a></li>
									</ul>
									<div class="social-links hidden-lg hidden-md hidden-sm circle small">
										<div class="btn-group dropdown">
											<button type="button" class="btn dropdown-toggle" data-toggle="dropdown"><i class="fa fa-share-alt"></i></button>
											<ul class="dropdown-menu dropdown-animation">
												<li class="twitter"><a target="_blank" href="http://www.twitter.com"><i class="fa fa-twitter"></i></a></li>
												<li class="facebook"><a target="_blank" href="http://www.facebook.com"><i class="fa fa-facebook"></i></a></li>
												<li class="youtube"><a target="_blank" href="http://www.youtube.com"><i class="fa fa-youtube-play"></i></a></li>
											</ul>
										</div>
									</div>
									<ul class="list-inline hidden-sm hidden-xs">
										<!-- <li><i class="fa fa-map-marker pr-5 pl-10"></i>One Infinity Loop Av, Tk 123456</li> -->
										<li><i class="fa fa-phone pr-5 pl-10"></i><?php echo lang('general.company_phone')?></li>
										<li><i class="fa fa-envelope-o pr-5 pl-10"></i> <?php echo lang('general.company_email'); ?></li>
									</ul>
								</div>
								<!-- header-top-first end -->
							</div>
							<div class="col-xs-9 col-sm-6 col-md-3">
								<!-- header-top-second start -->
								<div id="header-top-second" class="clearfix">
									<!-- header top dropdowns start -->
									<div class="header-top-dropdown text-right">
										<div class="btn-group <?php echo (Util::userSessionDto() != NULL && ! Util::userSessionDto()->getAccess()) ? 'dropdown' : ''; ?>">
										    <?php if (Util::userSessionDto() != NULL && ! Util::userSessionDto()->getAccess()) { ?>
    											<button type="button" class="btn dropdown-toggle btn-default btn-sm " data-toggle="dropdown" aria-expanded="false">
                                                    <?php echo lang('general.sign_in'); ?><i class="fa fa-lock pl-10"></i>
    											</button>
    											<ul class="dropdown-menu dropdown-menu-right dropdown-animation">
    												<li>
    													<form class="login-form margin-clear" id="frmLogin" method="post">
    														<div class="form-group has-feedback">
                                                                <?php 
                                                                    echo Form::label(lang('principal.username'), 'txtLogin', [
                                                                        'class' => 'control-label'
                                                                    ]);
                                                                    echo Form::text('txtLogin', null, [
                                                                        'class' => 'form-control notnull',
                                                                        'autocompletado' => 'off'
                                                                    ]);
                                                                ?>
    															<i class="fa fa-user form-control-feedback"></i>
    														</div>
    														<div class="form-group has-feedback">
    															<?php 
                                                                    echo Form::label(lang('principal.password'), 'txtPassword', [
                                                                        'class' => 'control-label'
                                                                    ]);
                                                                    echo Form::password('txtPassword', null, [
                                                                        'class' => 'form-control notnull'
                                                                    ]);
                                                                ?>
    															<i class="fa fa-lock form-control-feedback"></i>
    														</div>
    														<?php 
                                                                echo Form::button(lang('general.login_in_icon', ['<i class="fa fa-plus-circle"></i>']), [
                                                                    'class' => 'btn btn-group btn-gray btn-sm btn-animated tooltipster',
                                                                    'data-redirect' => site_url('menu'),
                                                                    'data-url' => site_url('login/login'),
                                                                    'id' => 'btnLogin'
                                                                ]);
                                                            ?>
    														<ul style="list-style-type: disc;">
                                                                <li>
                                                                    <a href="<?php echo site_url('login/forgot_password'); ?>">
                                                                        <?php echo lang('principal.forgot_password'); ?>
                                                                    </a>
                                                                </li>
                                                            </ul>
    													</form>
    												</li>
    											</ul>
											<?php } else { ?>
                                                <a class="btn dropdown-toggle btn-default btn-sm" href="<?php echo site_url('menu'); ?>">
                                                    <?php echo lang('general.sign_in'); ?><i class="fa fa-lock pl-10"></i> 
    											</a>
											<?php } ?>
										</div>
									</div>
									<!--  header top dropdowns end -->
								</div>
								<!-- header-top-second end -->
							</div>
						</div>
					</div>
				</div>
				<!-- header-top end -->
				<header class="header fixed clearfix">					
					<div class="container">
						<div class="row">
							<div class="col-md-3">
								<!-- header-left start -->
								<div class="header-left clearfix">
									<!-- logo -->
									<div class="col-sm-3">
            							<a href="<?php echo site_url(); ?>">
                                            <?php echo Html::image('logo.png',"",['width'=>'38']); ?>
                                        </a>
                                   </div>
                                   <div class="col-sm-9">   
                                        <span style="font-size: 13px"><?php echo lang('general.company_name_separate'); ?></span>
    							   </div>
    							   <div class="col-sm-12">
    							     <span style="font-size: 11px"><?php echo lang('general.company_slogan')?></span>
    							   </div>
                                </div>
									<!-- name-and-slogan -->
								<!-- header-left end -->
							</div>
							<div class="col-md-9">
								<!-- header-right start -->
								<div class="header-right clearfix">
								<!-- main-navigation start -->
								<div class="main-navigation  animated with-dropdown-buttons">
									<!-- navbar start -->									
									<nav class="navbar navbar-default" role="navigation">
										<div class="container-fluid">
											<!-- Toggle get grouped for better mobile display -->
											<div class="navbar-header">
												<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
													<span class="sr-only">Toggle navigation</span>
													<span class="icon-bar"></span>
													<span class="icon-bar"></span>
													<span class="icon-bar"></span>
												</button>												
											</div>
											<!-- Collect the nav links, forms, and other content for toggling -->
											<div class="collapse navbar-collapse" id="navbar-collapse-1">
												<!-- main-menu -->
												<?php echo $userMenu; ?>
												<!-- main-menu end -->												
												<div class="header-dropdown-buttons">
													<a href="<?php echo site_url('principal/contacto'); ?>" class="btn btn-sm hidden-xs btn-primary"><?php echo lang('general.menu_contacto'); ?><i class="fa fa-envelope-o pl-5"></i></a>
													<a href="<?php echo site_url('principal/contacto'); ?>" class="btn btn-lg visible-xs btn-block btn-primary"><?php echo lang('general.menu_contacto'); ?> <i class="fa fa-envelope-o pl-5"></i></a>
												</div>
											</div>
										</div>
									</nav>
									<!-- navbar end -->
								</div>
								<!-- main-navigation end -->	
								</div>
								<!-- header-right end -->
							</div>
						</div>
					</div>
				</header>
				<!-- header end -->
			</div>
			<!-- header-container end -->			
			<?php if ($object->getViewSlider()) { ?>
    			<!-- banner start -->
    			<div class="banner clearfix">
    				<!-- slideshow start -->
    				<div class="slideshow">
    					<!-- slider revolution start -->
    					<div class="slider-banner-container">
    						<div class="slider-banner-fullwidth">
    							<ul class="slides">
    								<!-- slide 1 start -->
    								<li style="font-size: 28px;" data-transition="random" data-slotamount="7" data-masterspeed="500" data-saveperformance="on" data-title="<?php echo lang('general.company_name'); ?>">
        								<!-- main image -->
        								<?php 
        								    echo Html::image('slider/slider-1.jpg', 'slidebg1', [
        								        'data-bgposition' => 'center top',
        								        'data-bgrepeat' => 'no-repeat', 
        								        'data-bgfit' => 'cover'
        								    ]);
    								    ?>
        								<!-- Transparent Background -->
        								<div class="tp-caption dark-translucent-bg"
        									data-x="center"
        									data-y="bottom"
        									data-speed="600"
        									data-start="0">
        								</div>
        								<!-- LAYER NR. 1 -->
        								<div class="tp-caption sfb fadeout text-center large_white"
        									data-x="center"
        									data-y="50"
        									data-speed="500"
        									data-start="1000"
        									data-easing="easeOutQuad">
        									<span class=""><?php echo lang('general.company_name_separate'); ?></span><br>
                                            <span style="font-size: 19px;"><?php echo lang('general.company_slogan'); ?></span>
        								</div>	
        								<!-- LAYER NR. 2 -->
        								<div class="tp-caption sfb fadeout text-center large_white tp-resizeme hidden-xs"
        									data-x="center"
        									data-y="150"
        									data-speed="500"
        									data-start="1300"
        									data-easing="easeOutQuad"><div class="separator light"></div>
        								</div>	
        								<!-- LAYER NR. 3 -->
        								<div class="tp-caption sfb fadeout medium_white text-center hidden-xs"
        									data-x="center"
        									data-y="190"
        									data-speed="500"
        									data-start="1300"
        									data-easing="easeOutQuad"
        									data-endspeed="600">
        									<p class="text-center lead" style="line-height: 25px; margin: 0 auto; width: 70% !important; white-space: normal;">
                            				    <?php echo strip_tags(nl2br($object->getDto()->getMensaje_servicio())); ?>
                            				</p>
        								</div>
        								<!-- LAYER NR. 4 -->
        								<div class="tp-caption sfb fadeout small_white text-center"
        									data-x="center"
        									data-y="300"
        									data-speed="500"
        									data-start="1600"
        									data-easing="easeOutQuad"
        									data-endspeed="600">
        									<a href="<?php echo site_url('principal/contenido/2'); ?>" class="btn btn-dark btn-animated"><?php echo lang('general.read_more'); ?> <i class="fa fa-arrow-right"></i></a> 
        									<span class="pl-5 pr-5">or</span> 
        									<a href="<?php echo site_url('principal/contacto'); ?>" class="btn btn-default btn-animated"><?php echo lang('general.menu_contacto'); ?> <i class="fa fa-envelope"></i></a>
        								</div>
    								</li>
    								<!-- slide 1 end -->
    								<?php
    								$secuencia = 1; 
    								$arrayTransitions = [
    								    'fade',
    								    'random',
    								    'slidehorizontal',
    								    'cube',
    								    'random',
    								    'slidehorizontal'
    								];
    								foreach ($object->getListServicios() as $key => $lis) { 
    								    $secuencia ++; ?>
        								<!-- slide <?php echo $secuencia; ?> start -->
        								<li data-transition="<?php echo $arrayTransitions[rand(0, 5)]; ?>" data-slotamount="7" data-masterspeed="500" data-saveperformance="on" data-title="<?php echo $lis->getNombre(); ?>">
            								<!-- main image -->
            								<?php 
            								    echo Html::image("slider/slider-{$secuencia}.jpg", $lis->getNombre(), [
            								        'data-bgposition' => 'center top',
            								        'data-bgrepeat' => 'no-repeat', 
            								        'data-bgfit' => 'cover'
            								    ]);
        								    ?>
        								    <!-- Transparent Background -->
            								<div class="tp-caption dark-translucent-bg"
            									data-x="center"
            									data-y="bottom"
            									data-speed="600"
            									data-start="0">
            								</div>
            								<!-- LAYER NR. 1 -->
            								<div class="tp-caption sfb fadeout text-center large_white"
            									data-x="center"
            									data-y="50"
            									data-speed="500"
            									data-start="1000"
            									data-easing="easeOutQuad">
            									<span class="logo-font" style="font-family: 'Raleway', sans-serif; font-size: 28" ><?php echo title($lis->getNombre()); ?></span>
            								</div>	
            								<!-- LAYER NR. 2 -->
            								<div class="tp-caption sfb fadeout text-center large_white tp-resizeme hidden-xs"
            									data-x="center"
            									data-y="150"
            									data-speed="500"
            									data-start="1300"
            									data-easing="easeOutQuad"><div class="separator light"></div>
            								</div>	
            								<!-- LAYER NR. 3 -->
            								<div class="tp-caption sfb fadeout medium_white text-center hidden-xs"
            									data-x="center"
            									data-y="190"
            									data-speed="500"
            									data-start="1300"
            									data-easing="easeOutQuad"
            									data-endspeed="600">
            									<p class="text-center lead" style="line-height: 25px; margin: 0 auto; width: 80%; white-space: normal;">
                                				    <?php echo substr(strip_tags(nl2br($lis->getDescripcion())), 0, 350); ?> ...
                                				</p>
            								</div>
            								<!-- LAYER NR. 4 -->
            								<div class="tp-caption sfb fadeout small_white text-center"
            									data-x="center"
            									data-y="300"
            									data-speed="500"
            									data-start="1600"
            									data-easing="easeOutQuad"
            									data-endspeed="600">
            									<a href="<?php echo site_url("principal/servicio_detalle/{$lis->getId_servicio()}"); ?>" class="btn btn-dark btn-animated"><?php echo lang('general.read_more'); ?> <i class="fa fa-arrow-right"></i></a> 
            								</div>        
        								</li>
        								<!-- slide <?php echo $secuencia; ?> end -->
    								<?php } ?>
    							</ul>
    							<div class="tp-bannertimer"></div>
    						</div>
    					</div>
    					<!-- slider revolution end -->
    				</div>
    				<!-- slideshow end -->
    
    			</div>
    			<!-- banner end -->
			<?php } ?>
						
			<div class="banner clearfix">
    			<div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="row" id="main_content">
    					<?php echo $content; ?>
    				</div>							
    			</div>
			</div>
			<!-- banner end -->
			
			<!-- footer start (Add "dark" class to #footer in order to enable dark footer) -->
			<footer id="footer" class="clearfix dark">
				<!-- .footer start -->
				<div class="footer">
					<div class="container">
						<div class="footer-inner">
							<div class="row">
								<div class="col-md-6 col-md-offset-3">
									<div class="footer-content text-center padding-ver-clear">
										<div class="text-white" style="color: #fff">
                                            <?php // echo Html::image('logo_light_blue.png',null,array('class' => 'center-block')); ?>
                                            <a href="<?php echo site_url(); ?>" class="" style="font-size: 34px; color: #fff;">
                                                <?php echo lang('general.company_name_separate'); ?>
                                            </a>
										</div>
										<p>
                                            <?php echo lang('general.company_slogan');?>
                                        </p>
										<ul class="list-inline mb-20">
											<!-- <li><i class="text-default fa fa-map-marker pr-5"></i>One infinity loop, 54100</li> -->
											<li><a href="tel:+00 1234567890" class="link-dark"><i class="text-default fa fa-phone pl-10 pr-5"></i>+00 1234567890</a></li>
											<li><a href="mailto:info@theproject.com" class="link-dark"><i class="text-default fa fa-envelope-o pl-10 pr-5"></i>info@theproject.com</a></li>
										</ul>
										<ul class="social-links circle animated-effect-1 margin-clear">
											<li class="twitter"><a target="_blank" href="http://www.twitter.com"><i class="fa fa-twitter"></i></a></li>
											<li class="facebook"><a target="_blank" href="http://www.facebook.com"><i class="fa fa-facebook"></i></a></li>
											<li class="youtube"><a target="_blank" href="http://www.youtube.com"><i class="fa fa-youtube-play"></i></a></li>
										</ul>
										<div class="separator"></div>
										<p class="text-center margin-clear">
                                            <?php echo lang('general.copyright_copyright', [Util::year()]); ?> <a href="<?php echo lang('copyright_url_page') ?>" class="link-light"><?php echo lang('general.company_name_separate'); ?></a> by <a target="_blank" href="<?php echo lang('general.copyright_url_page'); ?>"><?php echo lang('general.copyright_company'); ?></a>. Todos los derechos reservados
                                        </p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- .footer end -->
			</footer>		
		</div><!-- page-wrapper end -->
		
		<!-- JavaScript files placed at the end of the document so the pages load faster -->
		<?php
    		echo Html::script('plugins/bootstrap/js/bootstrap.min.js');    		
    		echo Html::script('plugins/modernizr.js');
    		echo Html::script('plugins/rs-plugin/js/jquery.themepunch.tools.min.js');
    		echo Html::script('plugins/rs-plugin/js/jquery.themepunch.revolution.min.js');
    		echo Html::script('plugins/isotope/isotope.pkgd.min.js');
    		echo Html::script('plugins/magnific-popup/jquery.magnific-popup.min.js');
    		echo Html::script('plugins/waypoints/jquery.waypoints.min.js');
    		echo Html::script('plugins/jquery.countTo.js');
    		echo Html::script('plugins/jquery.parallax-1.1.3.js');
    		echo Html::script('plugins/jquery.validate.js');
    		echo Html::script('plugins/morphext/morphext.min.js');
    		echo Html::script('plugins/vide/jquery.vide.js');
    		echo Html::script('plugins/owl-carousel/owl.carousel.js');
    		echo Html::script('plugins/jquery.browser.js');
    		echo Html::script('plugins/SmoothScroll.js');
    		echo Html::script('js/template.js');
    		echo Html::script('js/custom.js');
    		
    		echo Html::script('plugins/tooltipster/jquery.tooltipster.min.js');
    		echo Html::script('plugins/jquery-ui/jquery-ui.min.js');
    		echo Html::script('plugins/jquery-ui/datepicker-es.js');
    		echo Html::script('plugins/framework/plugins.js');
    		echo Html::script('plugins/framework/shortcut.min.js');
		?>
		<script>
            <?php echo Message::viewMessages(); ?>
			// document.oncontextmenu = function(){return false;};
    		shortcut.add('F12', function() { return false; });
		</script>
	</body>	
</html>