<?php

/**
 * Short Description:
 * 
 * This controller class handles the actions to register user.
 * Action index is to load form page (GET)
 * Action create cames from form submition and calls the user model 
 * to validate and create a new user. (POST) 
 *
 *
 * @package      App
 * @category     Controller
 * @author       José Gomes <zx.gomes@gmail.com>
 */

namespace App\Controllers;

//-- include user model class:
include_once APP_PATH . "models" . DIRECTORY_SEPARATOR
        . "UserModel.php";

use App\Models\UserModel;
use App\Views\ViewClass;

class RegisterController extends ViewClass {

    private $_params;

    function index() {

        //-- check for flash messages:
        if (isset($_SESSION['FLASH'])) {
            $this->_params = $_SESSION['FLASH'];
        }
        //-- clean flash from session:
        $_SESSION['FLASH'] = null;

        //-- assign template:
        $this->assign("params", $this->_params);
    }

    function create() {

        //-- only POST allowed:
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') != "POST") {

            //-- It is supposed to be (only) POST. If not, kill the request.
            throw new \Exception("Not allowed method for this action!");
        }

        //-- get post values from request:
        $post_values = filter_input_array(INPUT_POST);

        //-- check if user params are present on request:
        if (!isset($post_values['user'])) {
            throw new \Exception("User params missing");
        }

        //-- new User instance:
        $new_register = new UserModel();

        //-- check if post values are valid:
        $is_valid_result = $new_register->isValid($post_values['user']);
 

        //-- is it valid?
        if ($is_valid_result === true) {

            //-- try to save:
            $save_result = $new_register->save($post_values['user']);
            if ($save_result === true) {

                //-- set a simple success message on flash var:
                $_SESSION['FLASH'] = array("success"
                    => "Registo Conclu&iacute;do!");

                //-- redirect to index action:
                header("Location: " . REGISTER_ROUTE);
                exit();
            } else {

                //-- fail message to user with parameters:
                $this->_params = array(
                    "fail" => $save_result,
                    "user" => $post_values['user']);
            }
        } else {

            //-- case invalid, show message to user, with parameters:
            $this->_params = array(
                "fail" => $is_valid_result,
                "user" => $post_values['user']);
        }

        $this->assign("params", $this->_params);
    }

}
