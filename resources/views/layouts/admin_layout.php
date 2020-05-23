<?php 
use system\Helpers\Html;
use system\Support\Util;
use app\dtos\SessionDto;
use system\Core\Message;
use app\dtos\ClienteDto;
use system\Support\Arr;

$sessionDto = Util::userSessionDto();
$sessionDto = $sessionDto instanceof SessionDto ? $sessionDto : new SessionDto(); ?>
<!DOCTYPE html>
<html>
    <head>
        <?php
            echo Html::charset();
            echo Html::meta('viewport','width=device-width, initial-scale=1.0');
            echo Html::meta('viewport','IE=edge', ['http-equiv' => 'http-equiv']);
            echo Html::title(lang('general.title'));
            echo Html::favicon();
    		
            echo Html::meta('description', lang('general.description'));
    		echo Html::meta('keywords', lang('general.keywords'));
    		echo Html::meta('author', lang('general.company_name'));
    		
    		echo Html::style('css/bootstrap.min.css');
    		echo Html::style('font-awesome/css/font-awesome.css');    		
    		echo Html::style('css/plugins/sweetalert/sweetalert.css');
    		
    		echo Html::style('js/plugins/iCheck/skins/all.css');
    		echo Html::style('js/plugins/fullcalendar/fullcalendar.min.css');
    		echo Html::style('css/plugins/chosen/bootstrap-chosen.css');
    		
    		echo Html::style('css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css');
    		echo Html::style('css/plugins/colorpicker/bootstrap-colorpicker.min.css');
    		echo Html::style('css/plugins/cropper/cropper.min.css');
    		echo Html::style('css/plugins/switchery/switchery.css');
    		echo Html::style('css/plugins/jasny/jasny-bootstrap.min.css');
    		echo Html::style('css/plugins/nouslider/jquery.nouislider.css');
    		echo Html::style('css/plugins/datapicker/datepicker3.css');
    		
    		echo Html::style('css/plugins/ionRangeSlider/ion.rangeSlider.css');
    		echo Html::style('css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css');
    		
    		echo Html::style('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css');
    		echo Html::style('css/plugins/clockpicker/clockpicker.css');
    		echo Html::style('css/plugins/daterangepicker/daterangepicker-bs3.css');
    		echo Html::style('css/plugins/select2/select2.min.css');
    		echo Html::style('css/plugins/touchspin/jquery.bootstrap-touchspin.min.css');
    		echo Html::style('css/plugins/dualListbox/bootstrap-duallistbox.min.css');
    		
    		echo Html::style('css/plugins/sky-mega-menu/sky-mega-menu.css');
    		echo Html::style('css/plugins/sky-mega-menu/sky-mega-menu-blue.css');
    		echo Html::style('css/plugins/toastr/toastr.min.css');
    		
    		echo Html::style('css/plugins/jquery-ui/jquery-ui.min.css');
    		echo Html::style('css/plugins/dataTables/datatables.min.css');
    		
    		// Steps
    		echo Html::style('css/plugins/steps/jquery.steps.css');
    		
    		// Ladda style
    		echo Html::style('css/plugins/ladda/ladda-themeless.min.css');
    		
    		echo Html::style('css/animate.css');
    		echo Html::style('css/style.css');
    		echo Html::style('css/custom.css'); 
            
    		echo Html::script('js/jquery-2.1.1.js');
    	?>
    	<script type="text/javascript">
            var SITE_URL = '<?php echo site_url(); ?>';
            var BUTTON_CLICK = '';
            var ACCION = '';
    	</script>
    </head>
    <body class="<?php echo $sessionDto->getClassBody(); ?>">
        <div id="wrapper">
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <?php echo $sessionDto->getUserMenu(); ?>
                </div>
            </nav>
            <div id="page-wrapper" class="gray-bg dashbard-1">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2 btn light-blue darken-3 " href="#"><i class="fa fa-arrows-h white"></i> </a>
                        </div>
                        <ul class="nav navbar-top-links navbar-right">
                            <li>
                                <span class="m-r-sm text-muted welcome-message">
                                    <?php echo lang('general.welcome_to_app', lang('general.company_name')); ?>
                                </span>
                            </li>
                            
                            <li>
                                <a href="<?php echo site_url('login/close'); ?>">
                                    <i class="fa fa-sign-out"></i> <?php echo lang('general.log_out'); ?>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <?php if (isset($menu)) { ?>
                    <div class="row wrapper border-bottom white-bg page-heading">
                        <?php echo $menu['contentHeader']; ?>
                    </div>
                <?php }?>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <?php if (isset($menu)) { ?>
                        <div class="row horizontal_menu">
                			<div class="col-sm-12">
                                <?php echo $menu["menuHorizontal"]; ?>
                            </div>
                        </div>
                        <hr class="m-b-sm m-t-sm">
                    <?php } ?>
                    <div class="row">
                        <div class="col-sm-12" id="<?php echo isset($menu['contentDefault']) ? $menu['contentDefault'] : 'main_content'; ?>">
                            <?php echo $content; ?>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <div>
                        <strong>
                            <?php 
                                echo lang('general.copyright_copyright', [
                                    Util::year()
                                ]); 
                            ?>
                        </strong>
                        <?php echo lang('general.company_name'); ?> by 
                        <?php 
                            echo Html::link(lang('general.copyright_url_page'), lang('general.copyright_company'), [
                                'target' => '_blank'
                            ]); 
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mainly scripts -->
        <?php 
            echo Html::script('js/plugins/framework/livequery.min.js');
            echo Html::script('js/plugins/framework/framework.js');
            
            echo Html::script('js/bootstrap.min.js');
            
            echo Html::script('js/plugins/metisMenu/jquery.metisMenu.js');
            echo Html::script('js/plugins/slimscroll/jquery.slimscroll.min.js');
            echo Html::script('js/plugins/toastr/toastr.min.js');            
            echo Html::script('js/plugins/chosen/chosen.jquery.js');
            echo Html::script('js/plugins/jsKnob/jquery.knob.js');
            echo Html::script('js/plugins/jasny/jasny-bootstrap.min.js');
            echo Html::script('js/plugins/datapicker/bootstrap-datepicker.js');
            echo Html::script('js/plugins/datapicker/bootstrap-datepicker.es.js');
            echo Html::script('js/plugins/nouslider/jquery.nouislider.min.js');
            echo Html::script('js/plugins/nouslider/jquery.nouislider.min.js');
            echo Html::script('js/plugins/switchery/switchery.js');
            echo Html::script('js/plugins/ionRangeSlider/ion.rangeSlider.min.js');
            echo Html::script('js/plugins/iCheck/icheck.min.js');
            
            echo Html::script('js/plugins/colorpicker/bootstrap-colorpicker.min.js');
            echo Html::script('js/plugins/clockpicker/clockpicker.js');
            echo Html::script('js/plugins/cropper/cropper.min.js');
            echo Html::script('js/plugins/fullcalendar/moment.min.js');
            echo Html::script('js/plugins/daterangepicker/daterangepicker.js');
            echo Html::script('js/plugins/select2/select2.full.min.js');
            echo Html::script('js/plugins/fullcalendar/fullcalendar.min.js');
            echo Html::script('js/plugins/fullcalendar/scheduler.min.js');
            echo Html::script('js/plugins/fullcalendar/locale/es-do.js');
            echo Html::script('js/plugins/touchspin/jquery.bootstrap-touchspin.min.js');
            echo Html::script('js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js');
            
            // Autosize
            echo Html::script('js/plugins/bootstrap-autosize/bootstrap-autosize.js');
            echo Html::script('js/plugins/touchspin/jquery.bootstrap-touchspin.min.js');
            
            echo Html::script('js/plugins/jquery-ui/jquery-ui.min.js');
            echo Html::script('js/plugins/dataTables/datatables.min.js');
            echo Html::script('js/plugins/iCheck/icheck.min.js');
            echo Html::script('js/jquery.validate.js');
            
            // Ladda
            echo Html::script('js/plugins/ladda/spin.min.js');
            echo Html::script('js/plugins/ladda/ladda.min.js');
            echo Html::script('js/plugins/ladda/ladda.jquery.min.js');
            
            echo Html::script('js/inspinia.js');            
            echo Html::script('js/plugins/pace/pace.min.js');
            // Steps
            echo Html::script('js/plugins/staps/jquery.steps.min.js');
            echo Html::script('js/plugins/sweetalert/sweetalert.min.js');
            echo Html::script('js/plugins/framework/plugins.js');
            echo Html::script('js/plugins/chartJs/Chart.min.js');
        ?>
        <script src="https://kit.fontawesome.com/9798ee6817.js" crossorigin="anonymous"></script>
        <script>
            <?php echo Message::viewMessages(); ?>
        </script>
    </body>
</html>