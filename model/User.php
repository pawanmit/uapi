<?php

require_once 'mysql/Model.php';

class User extends Model{


    public $id;
    public $login;
    public $firstName;
    public $lastName;
    public $password;

    function __construct() {
        $this->tableName = 'user';
    }
}