<?php

require_once '../app/config/Application.php';
require_once 'ControllerFactory.php';
require_once 'ClientRequest.php';

class RequestHandler {

    public static function handleRequest($request) {
        $controller = ControllerFactory::createController($request->path);
        if ($controller == NULL) {
            $responseObject = new stdClass();
            $responseObject->code = 404;
            $responseObject->message = "Resource not found: " . $request->path;
            self::createAndSendHttpResponse($responseObject);
        }

        if (! method_exists($controller, $request->method)) {
            $responseObject = new stdClass();
            $responseObject->code = 405;
            $responseObject->message = $request->method . " not supported by resource:" . $request->path;
            self::createAndSendHttpResponse($responseObject);
        }

        try {
            $output = $controller->{$request->method}();
        } catch (Exception $e) {
            $responseObject = new stdClass();
            $responseObject->code = 500;
            $responseObject->message = $e->getMessage();
            self::createAndSendHttpResponse($responseObject);
        }

        $responseObject = new stdClass();
        $responseObject->code = 200;
        $responseObject->message = $output;
        self::createAndSendHttpResponse($responseObject);
    }

    private static function createAndSendHttpResponse($responseObject) {
        http_send_status($responseObject->code);
        http_send_content_type('text/json');
        http_send_data($responseObject->message);
    }
}

$request = new ClientRequest();
$request->method = $_SERVER['REQUEST_METHOD'];
$request->path = $_SERVER['REQUEST_URI'];
$request->queryString = $_SERVER['QUERY_STRING'];
$request->body = http_get_request_body();

RequestHandler::handleRequest($request);