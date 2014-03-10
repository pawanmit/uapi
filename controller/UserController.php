<?php

require_once '../model/User.php';

class UserController {

    public $errors = array();
    private $model;

    function __construct() {
        $this->model = new User();
    }

    public function post() {
        $this->updateModeForPost();
        if (count( $this->errors ) > 0) {
            return;
        }
        print_r($this->model);
        //die;
        if ( $this->model->id['value'] )  {
            $this->model->update();
        } else {
            $this->model->create();
        }
    }


    public function get() {
        $this->updateModelForGet();
        if (count( $this->errors ) > 0) {
            return;
        }
        $result = $this->model->find();
        $models = self::normalizeOutput($result);
        return $models;
    }

    private static function normalizeOutput($result) {
        $models = array();
        $output = array();
        foreach($result as $row) {
            $model = array();
            foreach($row as $fieldName => $fieldValue) {
                $model[$fieldName] = $fieldValue;
            }
            $models['user'] = $model;
            array_push($output, $models);
        }
        return $output;
    }

    private function updateModelForGet() {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $urlParts = explode("/", $url);
        if( count($urlParts) > 3 && strlen($urlParts[3] > 0))  {
            $userId = $urlParts[3];
            array_push($this->model->filterFields, 'id');
            $this->model->id['value'] = $userId;
        } else {
            $this->updateModelWithQueryString();
        }
        //Parse query string to get the filter fields
        //parse fields to make sure that they are valid model fields.
        //Parse message body to make sure that it is valid json.
        //Parse json to get field values.
        //parse fields to make sure that they are valid model fields.
    }

    private function updateModelWithQueryString() {
        $query = new HttpQueryString();
        $queries = $query->toArray();
        foreach($queries as $field => $value) {
            if (property_exists( get_class($this->model), $field) ) {
                array_push($this->model->filterFields, $field);
                $filterField = $this->model->$field;
                $filterField['value'] = $value;
                $this->model->$field = $filterField;
            } else {
                array_push($this->errors, $field . " is not valid");
            }
        }
    }

    private function updateModeForPost() {
        $inputFieldMap = $_POST;
        if (count($inputFieldMap) < 1) {
            array_push($this->errors, "No user input found");
            return;
        }
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $urlParts = explode("/", $url);
        if( count($urlParts) > 3 && strlen($urlParts[3] > 0))  {
            $userId = $urlParts[3];
            array_push($this->model->filterFields, 'id');
            $this->model->id['value'] = $userId;
        }
        foreach($inputFieldMap as $field => $value) {
            if (property_exists( get_class($this->model), $field) ) {
                array_push($this->model->inputFields, $field);
                $inputField = $this->model->$field;
                $inputField['value'] = $value;
                $this->model->$field = $inputField;
            } else {
                array_push($this->errors, $field . " is not valid");
            }
        }
    }

}
