<?php

require_once '../model/User.php';

class UserController {

    public $error = "";
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
        //print_r($this->model->filterFields);
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
                $this->model->$field['value'] = '$value';
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
