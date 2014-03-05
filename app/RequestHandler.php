<?php

require_once '../app/config/Application.php';
require_once 'ControllerFactory.php';

class RequestHandler {

    public static function handleRequest($path, $method) {
        $controller = ControllerFactory::createController($path);
        if ($controller == NULL) {
            $responseObject = new stdClass();
            $responseObject->code = 404;
            $responseObject->message = "Resource not found: " . $path;
            self::createAndSendHttpResponse($responseObject);
            error_log("Resource not found: " . $path);
        }
        $controller->select();
    }

    private static function createAndSendHttpResponse($responseObject) {
        HttpResponse::status($responseObject->code);
        HttpResponse::setContentType('text/json');
        HttpResponse::setData(json_encode($responseObject));
    }
}

$method = $_SERVER['REQUEST_METHOD'];
RequestHandler::handleRequest($_SERVER['REQUEST_URI'], $method);