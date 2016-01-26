<?php

/**
 * Short Description:
 * 
 * This class receives controller and action parameters from request and try
 * to load the controller with the same name and the action as well.
 *
 *
 * @package      App
 * @category     Controller
 * @author       José Gomes <zx.gomes@gmail.com>
 */

namespace App\Controllers;

//-- include bridge call for views
include_once APP_PATH . DIRECTORY_SEPARATOR . "views"
        . DIRECTORY_SEPARATOR . "viewClass.php";

class AppController {

    public function __construct() {

        //-- load controller class according URL param:
        $controller = filter_input(INPUT_GET, 'controller') . "Controller";
        include $controller . ".php";

        $controller = "App\Controllers\\" . ucfirst($controller);

        //-- check if controller exists:
        if (!class_exists($controller)) {
            header("HTTP/1.1 404 Not Found");
        }

        //-- create class instance:
        $obj = new $controller;

        //-- get action from request:
        $action = filter_input(INPUT_GET, 'action');

        //-- check if method exists:
        if (!method_exists($controller, $action)) {
            header("HTTP/1.1 404 Not Found");
        }

        //-- call class function according URL param:
        $obj->$action();
    }

}
