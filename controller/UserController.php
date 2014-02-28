<?php

require_once '../app/config/Application.php';
require_once '../model/User.php';

class UserController {

    public function create() {
        $user = new User();
        $user->lastName = 'mittal';
        $user->firstName = 'pawan';
        $user->login = "pmittal";
        $user->inputFields = array('lastName', 'firstName', 'login');
        $user->create();
    }
}


$userController = new UserController();
try {
    $userController->create();
}catch (Exception $e) {
    echo $e->getMessage();
}