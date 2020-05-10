<?php
require __DIR__ . '/bootstrap/autoload.php';

define('ENVIRONMENT', isset($_SERVER['ci_env']) ? $_SERVER['ci_env'] : 'development');
switch (ENVIRONMENT) {
    case 'development':
        error_reporting(- 1);
        ini_set('display_errors', 1);
        break;
    case 'testing':
    case 'production':
        ini_set('display_errors', 0);
        error_reporting(E_ALL & ~ E_NOTICE & ~ E_DEPRECATED & ~ E_STRICT & ~ E_USER_NOTICE & ~ E_USER_DEPRECATED);
        break;
    default:
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'The application environment is not set correctly.';
        exit(1);
}

header("Expires: Thu, 27 Mar 1980 23:59:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$view_folder = 'resources/views';
$application_folder = 'app';
$system_path = 'system';

if (defined('STDIN')) {
    chdir(dirname(__FILE__));
}
if (($_temp = realpath($system_path)) !== FALSE) {
    $system_path = $_temp . '/';
} else {
    $system_path = rtrim($system_path, '/') . '/';
}
if (! is_dir($system_path)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: ' . pathinfo(__FILE__, PATHINFO_BASENAME);
    exit(3);
}

define('EM_BASEPATH', str_replace('\\', '/', pathinfo(__FILE__, PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR));
define('EM_SYSTEMPATH', str_replace('\\', '/', $system_path));
define('RAIZPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

if (is_dir($application_folder)) {
    if (($_temp = realpath($application_folder)) !== FALSE) {
        $application_folder = $_temp;
    }
    define('EM_APPPATH', $application_folder . DIRECTORY_SEPARATOR);
} else {
    if (! is_dir(EM_BASEPATH . $application_folder . DIRECTORY_SEPARATOR)) {
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: ' . SELF;
        exit(3);
    }
    define('EM_APPPATH', EM_BASEPATH . $application_folder . DIRECTORY_SEPARATOR);
}

if (($_temp = realpath($view_folder)) !== FALSE) {
    $view_folder = $_temp . DIRECTORY_SEPARATOR;
} else {
    $view_folder = rtrim($view_folder, '/\\') . DIRECTORY_SEPARATOR;
}
if (! is_dir($view_folder)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your view folder path does not appear to be set correctly. Please open the following file and correct this: ' . SELF;
    exit(3);
}

define('EM_VIEWPATH', $view_folder);
require __DIR__ . '/bootstrap/app.php';