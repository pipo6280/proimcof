<!-- view stored in public/views/layouts/login_layout.php -->
<?php 
    use system\Helpers\Html;
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?php             
            echo Html::title(lang('general.title'));
            echo Html::charset(config_item('charset'));
            echo Html::favicon('favicon.ico');
            
            echo Html::meta('viewport','width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no');
            echo Html::meta('','IE=edge', ['http-equiv' => 'X-UA-Compatible']);
            echo Html::meta('author', lang('general.author'));
            echo Html::meta('description', lang('general.description'));
            echo Html::meta('keywords', lang('general.keywords'));            
            
            echo Html::style('js/plugins/materialize/css/materialize.min.css', ['media' => "screen,projection"]);
            echo Html::style('css/plugins/jquery-ui/jquery-ui.css');
            echo Html::style('js/plugins/materialize/css/style.css', ['media' => "screen,projection"]);
            echo Html::style('js/plugins/materialize/css/page-center.css', ['media' => 'screen,projection']);
            echo Html::style('js/plugins/materialize/css/prism.css', ['media' => 'screen,projection']);
            echo Html::style('css/plugins/toastr/toastr.min.css');
            
            echo Html::script('js/jquery-2.1.1.js');
            echo Html::script('js/plugins/framework/livequery.min.js');
            echo Html::script('js/plugins/framework/framework.js');
        ?>
        <script>var SITE_URL = '<?php echo site_url(); ?>'; </script>
    </head>
    
    <body>
        <div id="login-page" class="row">
            <?php echo isset($content) ? $content : NULL; ?>
        </div>
        <!-- ===== Scripts ===== -->
        <?php
            echo Html::script('js/plugins/jquery-ui/jquery-ui.min.js');
            echo Html::script('js/plugins/materialize/js/materialize.min.js');
            echo Html::script('js/plugins/framework/plugins.js');
            echo Html::script('js/plugins/toastr/toastr.min.js');
            echo Html::script('js/jquery.validate.js');
        ?>
    </body>
</html>