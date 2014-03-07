<?php

require_once '../model/User.php';

class UserController {

    public $errors = array();
    private $model;

    function __construct() {
        $this->model = new User();
    }

    public function post() {
        $model = new User();
        $model->last_name['value'] = 'carson';
        $model->first_name['value'] = 'timmy';
        $model->login['value'] = "tcarson";
        $model->inputFields = array('last_name', 'first_name', 'login');
        $model->create();
    }


    public function get() {
        $this->updateModelFromUserInput();
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

    private function updateModelFromUserInput() {

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

        //Parse query string to get the filter fields
        //parse fields to make sure that they are valid model fields.
        //Parse message body to make sure that it is valid json.
        //Parse json to get field values.
        //parse fields to make sure that they are valid model fields.
    }

    private function isValidQueryString() {

    }

}
