<?php

require_once 'Connection.php';

class Model {

    private static $dbConnection;

    function __construct() {
        $connection = new Connection();
        self::$dbConnection = $connection->getDatabaseConnection();
    }

    protected $tableName;

    //List of fields for SELECT clause
    public $selectFields = array();

    //List of fields with values for INSERT and UPDATE
    public $inputFields = array();

    //List of fields for WHERE clause
    public $filterFields = array();

    //Saves the model object
    public function create() {
        $sql = $this->getCreateRecordSql();
        print_r($sql);
    }

    //Updates the model object based on $filterFields and sets the value to $inputFields
    public function update() {
        //
    }

    //Finds the model object and returns an array of std objects
    public function find() {
        //
    }

    //Deletes the model from database table
    public function delete() {

    }


    private function getCreateRecordSql() {
        $sql = "INSERT INTO " . $this->tableName;
        $columnsCsv = "";
        $valuesCsv = "";
        foreach(self::$inputFields as $inputField) {
            $columnsCsv .= $inputField . ", ";
            $valuesCsv .= $this->$inputField . ", ";
        }
        $columnsCsv = rtrim($columnsCsv, ",");
        $valuesCsv = rtrim($valuesCsv, ",");
        $sql .= "(" . $columnsCsv . ")" . " VALUES " . "(" . $valuesCsv . ")";
        //print_r($sql);
        return $sql;
    }

    private function camelCaseToUnderScore($text) {

    }

} //class
