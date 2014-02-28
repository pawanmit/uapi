<?php

require_once 'MySqlConnection.php';
require_once 'Model.php';
require 'BindParam.php';

class MySqliHelper {

    private static $dbConnection;

    function __construct() {
        self::$dbConnection = new MySqlConnection();
    }

    public function insert($model) {
        $bindParameter = self::getBindParameter($model);
        self::$dbConnection->execute($bindParameter);
    }

    private static function getBindParameter($model) {
        $insertSql = "INSERT INTO " . $model->tableName;
        $columnsCsv = "";
        $valuesCsv = "";
        $bindParam = new BindParam();
        foreach($model->inputFields as $inputField) {
            $columnsCsv .= self::camelCaseToUnderScore($inputField) . ",";
            $valuesCsv .=  "?" . ",";
            $modelProperty = $model->$inputField;
            $type = self::getParameterType($modelProperty['type']);
            $bindParam->add($type, $modelProperty['value']);
        }
        $columnsCsv = rtrim(trim($columnsCsv, ','));
        $valuesCsv =  rtrim($valuesCsv, ',');
        $insertSql .= "(" . $columnsCsv . ")" . " VALUES " . "(" . $valuesCsv . ")";
        $bindParam->setSql($insertSql);
        return $bindParam;
    }

    private static function getParameterType($fieldType) {
        switch($fieldType) {
            case 'string':
                $parameterType= 's';
                break;
            case 'integer':
                $parameterType = 'i';
                break;
            case 'double':
                $parameterType = 'd';
                break;
            case 'date':
                $parameterType= 's';
                break;
            case 'boolean':
                $parameterType = 'i';
                break;
            default:
                $parameterType = '';
                break;
        }
        return $parameterType;
    }

    private static function camelCaseToUnderScore($input) {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }
}