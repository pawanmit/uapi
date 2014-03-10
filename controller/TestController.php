<?php

require_once 'Controller.php';

class TestController extends  Controller {

    public function get() {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://localhost/v1/user/11');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, "first_name=test1");
        $output = curl_exec($curl);
        curl_close($curl);
        echo $output;
        die;
    }
}