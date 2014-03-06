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
        }

        if (! method_exists($controller, $method)) {
            $responseObject = new stdClass();
            $responseObject->code = 405;
            $responseObject->message = $method . " not supported by resource:" . $path;
            self::createAndSendHttpResponse($responseObject);
        }

    }

    private static function createAndSendHttpResponse($responseObject) {
        http_send_status($responseObject->code);
        http_send_content_type('text/json');
        http_send_data(json_encode($responseObject));
    }
    private static function isMethodSupported($controller, $method) {

    }
}



//HttpResponse::setCacheControl('public');
$method = $_SERVER['REQUEST_METHOD'];
RequestHandler::handleRequest($_SERVER['REQUEST_URI'], $method);