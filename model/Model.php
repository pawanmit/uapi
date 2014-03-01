<?php

require_once 'MySqliHelper.php';

class Model {

    const SINGLE_QUOTE = "'";

    public $tableName;

    //List of fields for SELECT clause
    public $selectFields = array();

    //List of fields with values for INSERT and UPDATE
    public $inputFields = array();

    //List of fields for WHERE clause
    public $filterFields = array();

    private static $dbConnection;

    private static $mySqliHelper;

    function __construct() {
        self::$mySqliHelper = new MySqliHelper();
    }

    //Saves the model object
    public function create() {
        self::$mySqliHelper->insert($this);
    }

    //Updates the model object based on $filterFields and sets the value to $inputFields
    public function update() {
        self::$mySqliHelper->update($this);
    }

    //Finds the model object and returns an array of std objects
    public function find() {
        //
    }

    //Deletes the model from database table
    public function delete() {

    }

} //class
