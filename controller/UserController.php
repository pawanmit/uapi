<?php

require_once '../app/config/Application.php';
require_once '../model/User.php';

class UserController {

    public function create() {
        $user = new User();
        $user->lastName['value'] = 'mittal';
        $user->firstName['value'] = 'pawan';
        $user->login['value'] = "pmittal";
        $user->inputFields = array('lastName', 'firstName', 'login');
        $user->create();
    }

    public function update() {
        $user = new User();
        $user->lastName['value'] = 'Aggarwal1';
        $user->firstName['value'] = 'Pawan1';
        $user->login['value'] = "anamikaa";
        $user->inputFields = array('lastName');
        $user->filterFields = array('firstName');
        $user->update();
    }
}


$userController = new UserController();
try {
    $userController->update();
}catch (Exception $e) {
    echo $e->getMessage();
}