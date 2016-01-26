<?php

/**
 * Short Description:
 * 
 * Class to serve as bridge between the controller and the template files.
 * This will receive the request controller and action as well and based on it, 
 * this will load the view file with the same name. This receive controller 
 * parameters to pass it to the template when necessary. 
 * 
 * The rendering is done on destruct to clean at same time the garbadge.
 * 
 *
 * @package      App
 * @category     Views
 * @author       José Gomes <zx.gomes@gmail.com>
 */

namespace App\Views;

class ViewClass {

    public $arr = array();

    function show() {
        extract($this->arr);
        include_once APP_PATH . "views"
                . DIRECTORY_SEPARATOR . filter_input(INPUT_GET, 'controller')
                . DIRECTORY_SEPARATOR . "index.html.php";
    }

    function assign($name, $value) {
        $this->arr[$name] = $value;
    }

    public function __destruct() {
        $this->show();
    }

}
