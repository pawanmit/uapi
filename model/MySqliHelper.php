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
        $bindParameter->setSql(self::getInsertQuery($model));
        self::$dbConnection->execute($bindParameter);
    }

    public function update($model) {
        $bindParameter = self::getBindParameter($model);
        $bindParameter->setSql(self::getUpdateQuery($model));
        self::$dbConnection->execute($bindParameter);
    }

    private static function getBindParameter($model) {
        $bindParam = new BindParam();
        foreach($model->inputFields as $inputField) {
            $modelProperty = $model->$inputField;
            $type = self::getParameterType($modelProperty['type']);
            $bindParam->add($type, $modelProperty['value']);
        }
        foreach($model->filterFields as $filterField) {
            $modelProperty = $model->$filterField;
            $type = self::getParameterType($modelProperty['type']);
            $bindParam->add($type, $modelProperty['value']);
        }
        return $bindParam;
    }

    private static function getInsertQuery($model) {
        $columnsCsv = "";
        $valuesCsv = "";
        $insertSql = "INSERT INTO " . $model->tableName;
        foreach($model->inputFields as $inputField) {
            $columnsCsv .= self::camelCaseToUnderScore($inputField) . ",";
            $valuesCsv .=  "?" . ",";
        }
        $columnsCsv = rtrim(trim($columnsCsv, ','));
        $valuesCsv =  rtrim($valuesCsv, ',');
        $insertSql .= "(" . $columnsCsv . ")" . " VALUES " . "(" . $valuesCsv . ")";
        return $insertSql;
    }

    private static function getUpdateQuery($model) {
        $updateSql = "UPDATE " . $model->tableName . ' SET ';
        foreach($model->inputFields as $inputField) {
            $updateSql .= self::camelCaseToUnderScore($inputField) . '=?,';
        }
        $updateSql = rtrim($updateSql, ",");

        if ( isset ($model->filterFields) && count($model->filterFields) > 0) {
            $updateSql .= " WHERE ";
            foreach($model->filterFields as $filterField) {
                $updateSql .= self::camelCaseToUnderScore($filterField) . '=?,';
            }
        }
        $updateSql = rtrim($updateSql, ",");
        echo $updateSql;
        return $updateSql;
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