<?php

/**
 *  Bootstrap
 *
 *  PHP Version 5.3
 *
 *  @category Core
 *  @package  Scyth
 *  @author   Alex Lushpai <alex@lushpai.org>
 *  @license  LGPL v.3 http://www.gnu.org/licenses/lgpl.html
 *  @link     http://jtforce.com/scyth/guide/index.html
 *
 */

/**
 * Define global constants
 *
 */

define('DIR_SEP', DIRECTORY_SEPARATOR);
define('SYS_PATH', realpath(dirname(__FILE__)) . DIR_SEP);
define('APP_PATH', SYS_PATH . 'app' . DIR_SEP);
define('LIB_PATH', SYS_PATH . 'core' . DIR_SEP);

/**
* Load common configuration
*
*/
require APP_PATH . 'config' . DIR_SEP . 'common.php';

/**
 * Autoload core classes
 *
 * @return void
 */

function __autoload($class_name)
{
    $file = LIB_PATH . $class_name . '.php';

    if (!file_exists($file)) {
        return false;
    }

    include_once $file;
}

/**
 * Build common enviroment
 *
 */

$app = App::getInstance();

/*
 * Run app
 *
 */

$app->get('router')->setPath('app/controllers');
$app->get('router')->run();
