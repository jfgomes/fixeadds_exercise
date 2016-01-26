<?php

/**
 * Short Description:
 *
 * Class to init app based on URL parameters.
 *
 * @package      App
 * @category     Boot
 * @author       José Gomes <zx.gomes@gmail.com>
 */

namespace App;

use App\Controllers\AppController;

//-- simple path defining for root:
define('BASE_PATH', dirname(realpath(__FILE__)) . DIRECTORY_SEPARATOR);

//-- simple path defining for app:
define('APP_PATH', BASE_PATH . 'app' . DIRECTORY_SEPARATOR);

//-- simple path defining for config:
define('CONFIG_PATH', BASE_PATH . 'app' . DIRECTORY_SEPARATOR);

//-- simple route defining for register:
define('REGISTER_ROUTE', DIRECTORY_SEPARATOR . "index.php?controller=register&action=index");

//-- include main controller:
include APP_PATH . 'controllers' . DIRECTORY_SEPARATOR . 'appController.php';

session_start();

//-- instance main controller instance:
new AppController();
