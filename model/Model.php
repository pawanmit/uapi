<?php

require_once 'MySqlConnection.php';

class Model {

    const SINGLE_QUOTE = "'";

    protected $tableName;

    //List of fields for SELECT clause
    public $selectFields = array();

    //List of fields with values for INSERT and UPDATE
    public $inputFields = array();

    //List of fields for WHERE clause
    public $filterFields = array();

    private static $dbConnection;

    function __construct() {
        self::$dbConnection = new MySqlConnection();
    }

    //Saves the model object
    public function create() {
        $this->getInsertPreparedStatement();
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


    private function getInsertPreparedStatement() {
        $sql = "INSERT INTO " . $this->tableName;
        $columnsCsv = "";
        $valuesCsv = "";
        foreach($this->inputFields as $inputField) {
            $columnsCsv .= $this->camelCaseToUnderScore($inputField) . ",";
            $valuesCsv .=  "?" . ",";
        }
        $columnsCsv = rtrim(trim($columnsCsv, ','));
        $valuesCsv =  rtrim($valuesCsv, ',');
        $sql .= "(" . $columnsCsv . ")" . " VALUES " . "(" . $valuesCsv . ")";
        $preparedStatement = self::$dbConnection->prepare($sql);
        return $preparedStatement;
    }

    private function camelCaseToUnderScore($input) {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }
} //class
