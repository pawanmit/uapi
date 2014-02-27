<?php

require_once '../model/User.php';

class UserController {

    public function create() {
        $user = new User();
        $user->lastName = 'mittal';
        $user->firstName = 'pawan';
        $user->login = "pmittal";
        $user->inputFields('lastName', 'firstName', 'login');
        $user->create();
    }
}


$this->create();