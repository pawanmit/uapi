<?php

class ControllerFactory {

    public static function createController($requestPath) {
        global $DEPLOYMENT_DIRECTORY;
        $resource = self::getResource($requestPath);
        switch ($resource) {
            case 'user':
                $controllerClassName =  ucfirst($resource) . "Controller";
                $controllerClassPath =  $DEPLOYMENT_DIRECTORY . "/controller/" . $controllerClassName . ".php";
                require_once $controllerClassPath;
                $controller =  new $controllerClassName;
                return $controller;
                break;
            default:
                ControllerFactory::handleException("UserException:Resource url " . $requestPath . " not found");
                break;
        }
    }

    private static function handleException($errorMessage) {
        error_log($errorMessage);
        throw new Exception($errorMessage);
    }

    private static function getResource($requestPath) {
        echo $requestPath . "<BR>";
        $requestPathArray = explode("/", $requestPath);
        print_r($requestPathArray);
        if (count($requestPathArray) < 2) {
            $errorMessage = "UserException:Incorrect resource url";
            ControllerFactory::handleException($errorMessage);
        }
        $version = $requestPathArray[1];
        $resource = strtolower($requestPathArray[2]);
        return $resource;
    }
}