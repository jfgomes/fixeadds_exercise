<?php

/**
 * Short Description:
 * 
 * This Model class handles the user model.
 * Connects with user table; validate user fields; treat user values to avoid 
 * things like injection; generate user passwords (see function comments) 
 * with a 30 chars salt; save new users.
 * 
 *
 * @package      App
 * @category     Models
 * @author       José Gomes <zx.gomes@gmail.com>
 */

namespace App\Models;

//-- include database class:
include_once BASE_PATH . "config"
        . DIRECTORY_SEPARATOR . "database.php";

use App\Config;

class UserModel {

    private $_table = "users";
    private $_fillable_columns = "email, password, first_name, last_name, " .
            "address, zip_code, zone, country, vat, phone, salt";

    /**
     * Server side validations:
     * @return boolean
     */
    public function isValid($post_values) {

        //-- email
        if (!isset($post_values['email']) || trim($post_values['email']) == "") {
            return "Email obrigat&oacute;rio.";
        }

        //-- email structure:
        if (!filter_var($post_values['email'], FILTER_VALIDATE_EMAIL)) {
            return "Email Inválido.";
        }

        //-- email match:
        if ($post_values['email'] != $post_values['confirm_email']) {
            return "Emails n&atilde;o coincidem.";
        }

        //-- 'password' 
        if (!isset($post_values['password']) || trim($post_values['password']) == "") {
            return "Password obrigat&oacute;ria.";
        }

        //-- password min char lenght:
        if (strlen(trim($post_values['password'])) < 6) {
            return "Password tem de ter no minimo 6 caracteres.";
        }

        //-- password match:
        if (trim($post_values['password']) != trim($post_values['confirm_password'])) {
            return "Passwords n&atilde;o coincidem.";
        }

        //-- 'first_name'
        if (!isset($post_values['first_name']) || trim($post_values['first_name']) == "") {
            return "Primeiro nome obrigat&oacute;rio.";
        }

        //-- first_name max char lenght:
        if (strlen(trim($post_values['first_name'])) > 20) {
            return "Primeiro nome tem de ter no m&aacute;ximo 20 caracteres.";
        }

        //-- 'last_name'
        if (!isset($post_values['last_name']) || trim($post_values['last_name']) == "") {
            return "Ultimo nome obrigat&oacute;rio.";
        }

        //-- last_name max char lenght:
        if (strlen(trim($post_values['last_name'])) > 20) {
            return "Ultimo nome tem de ter no m&aacute;ximo 20 caracteres.";
        }

        //-- 'address'
        if (isset($post_values['address'])) {

            //-- address max char lenght:
            if (strlen(trim($post_values['address'])) > 80) {
                return "Endere&ccedil;o tem de ter no m&aacute;ximo 80 caracteres.";
            }
        }
        //-- 'zipcode' 
        if (isset($post_values['zipcode']) && trim($post_values['zipcode'] != "")) {

            if (!preg_match('/^[0-9]{4,4}([- ]?[0-9]{3,3})?$/', trim($post_values['zipcode']))) {
                return "C. Postal inv&aacute;lido.";
            }
        }

        //-- 'country' 
        if (isset($post_values['country'])) {

            //-- country list hardcoded:
            $country_list = array('PT', 'BR', 'ES', 'FR');
            if (!in_array($post_values['country'], $country_list)) {
                return "Pa&iacute;s inv&aacute;lido.";
            }
        }

        //-- 'vat' 
        if (isset($post_values['vat']) && trim($post_values['vat'] != "")) {

            //-- vat max char lenght:
            if (strlen(trim($post_values['vat'])) != 9 || !is_numeric($post_values['vat'])) {
                return "NIF tem de ter 9 digitos num&eacute;ricos";
            }
        }

        //-- 'phone' 
        if (isset($post_values['phone']) && trim($post_values['phone'] != "")) {

            //-- users selected Portugal?
            if ($post_values['country'] == "PT") {
                
                //-- Portuguese phone numbers max char lenght:
                if (strlen(trim($post_values['vat'])) != 9 || !is_numeric($post_values['vat'])) {
                    return "N. Telefone tem de ter 9 d&iacute;gitos num&eacute;ricos";
                }
            }
        }


        return true;
    }

    public function save($post_values) {

        try {

            //-- get singleton instance:
            $db_instance = Config\DatabaseClass::getInstance();

            //-- treat values to before insert:
            $insert_values = $this->handleValues($post_values, $db_instance->getConnection());

            //-- insert query string:
            $query = "INSERT INTO $this->_table ($this->_fillable_columns)"
                    . " VALUES ($insert_values)";

            //-- do query:
            if (!mysqli_query($db_instance->getConnection(), $query)) {

                //-- check if email address crash on duplicate:
                if (mysqli_errno($db_instance->getConnection()) == 1062) {
                    throw new \Exception("O email j&aacute; existe na BD.");
                }

                throw new \Exception("Erro! Contacte Administrador.");
            }

            return true;
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    private function unique_salt() {
        return substr(sha1(mt_rand()), 0, 30);
    }

    /**
     * @tutorial - password is setted with a plain text string created by user on
     * password form field and a salt hash string generated based on a full 
     * random 30 characters. 
     * 
     * To hash the final value I used the sha256 algorithm to hide the password, 
     * storing the salt on database near the final hash message.
     * 
     * 
     * @return string with all values scaped, ready to insert on db
     */
    private function handleValues($post_values, $connection) {

        //-- unset unecessary values:
        unset($post_values["confirm_email"], $post_values["confirm_password"]);

        //-- handle password:
        $post_values["salt"] = $this->unique_salt();
        $post_values["password"] = hash('sha256', $post_values["salt"] . $post_values["password"]);

        //-- create new array to receive each treated value:
        $values = array();

        //-- clear all possible dirty values to avoid injection:
        foreach ($post_values as $key => $value) {
            $values[$key] = trim(utf8_decode(mysqli_real_escape_string($connection, $value)));
        }

        //-- convert to string to include on query:
        $values = "'" . implode("','", $values) . "'";
        return trim($values);
    }

}
