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

    public function select($model){
        $bindParameter = self::getBindParameter($model);
        $bindParameter->setSql(self::getSelectQuery($model));
        $result = self::$dbConnection->query($bindParameter);
        return $result;
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
            $columnsCsv .= $inputField . ",";
            $valuesCsv .=  "?" . ",";
        }
        $columnsCsv = rtrim(trim($columnsCsv, ','));
        $valuesCsv =  rtrim($valuesCsv, ',');
        $insertSql .= "(" . $columnsCsv . ")" . " VALUES " . "(" . $valuesCsv . ")";
        return $insertSql;
    }

    private static function getUpdateQuery($model) {
        $updateSql = "UPDATE " . $model->tableName . ' SET ';
        if ( isset ($model->inputFields) && count($model->inputFields) > 0) {
            foreach($model->inputFields as $inputField) {
                $updateSql .= $inputField . '=?,';
            }
        }
        $updateSql = rtrim($updateSql, ",");

        if ( isset ($model->filterFields) && count($model->filterFields) > 0) {
            $updateSql .= " WHERE ";
            foreach($model->filterFields as $filterField) {
                $updateSql .= $filterField . '=?,';
            }
        }
        $updateSql = rtrim($updateSql, ",");
        echo $updateSql;
        return $updateSql;
    }

    private static function getSelectQuery($model) {
        $selectSql = "SELECT ";
        if ( isset ($model->selectFields) && count($model->selectFields) > 0) {
            foreach($model->selectFields as $selectField) {
                $selectSql .=  $selectField . ",";
            }
        } else {
            $selectSql .= '* ';
        }
        $selectSql = rtrim($selectSql, ",");
        $selectSql .= " FROM " . $model->tableName;
        if ( isset ($model->filterFields) && count($model->filterFields) > 0) {
            $selectSql .= " WHERE ";
            foreach($model->filterFields as $filterField) {
                $selectSql .= " " . $filterField . "=? AND";
            }
        }
        $selectSql = rtrim($selectSql, "AND");
        return $selectSql;
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

}