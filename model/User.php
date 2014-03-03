<?php

require_once 'Model.php';

class User extends Model{


    public $id = array('value'=>'', 'type'=>'string', 'length'=> 25);
    public $login = array('value'=>'', 'type'=>'string', 'length'=> 25);
    public $first_name = array('value'=>'', 'type'=>'string', 'length'=> 25);
    public $last_name  = array('value'=>'', 'type'=>'string', 'length'=> 25);
    public $password = array('value'=>'', 'type'=>'string', 'length'=> 25);

    function __construct() {
        parent::__construct();
        $this->tableName = 'user';
    }
}