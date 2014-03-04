<?php

require_once '../app/config/Application.php';
require_once 'ControllerFactory.php';

class RequestHandler {

    public static function handleRequest($path, $method) {
           //echo ($path . " : " . $method);
        $controller = ControllerFactory::createController($path);
        $controller->select();

    }
}

$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

RequestHandler::handleRequest($_SERVER['REQUEST_URI'], $method);