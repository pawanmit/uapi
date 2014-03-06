<?php

require_once '../model/User.php';

class UserController {

    public function post() {
        $user = new User();
        $user->last_name['value'] = 'carson';
        $user->first_name['value'] = 'timmy';
        $user->login['value'] = "tcarson";
        $user->inputFields = array('last_name', 'first_name', 'login');
        $user->create();
    }

    public function put() {
        $user = new User();
        $user->last_name['value'] = 'Mittal';
        $user->first_name['value'] = 'timmy';
        //$user->login['value'] = "anamikaa";
        $user->inputFields = array('last_name');
        $user->filterFields = array('first_name');
        $user->update();
    }

    public function get() {
        $user = new User();
        $user->selectFields = array('last_name', 'login');
        $user->first_name['value'] = 'timmy';
        $user->filterFields = array('first_name');
        $result = $user->find();
        print_r($result);
    }

}
