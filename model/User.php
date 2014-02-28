<?php

require_once 'Model.php';

class User extends Model{


    public $id;
    public $login;
    public $firstName;
    public $lastName;
    public $password;

    function __construct() {
        parent::__construct();
        $this->tableName = 'user';
    }
}