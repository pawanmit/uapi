<?php

class ControllerFactory {

    public static function createController($requestPath) {
        global $DEPLOYMENT_DIRECTORY;
        $controller = NULL;
        $resource = self::getResource($requestPath);
        $controllerClassName =  ucfirst($resource) . "Controller";
        $controllerClassPath =  $DEPLOYMENT_DIRECTORY . "/controller/" . $controllerClassName . ".php";
        if (file_exists($controllerClassPath)) {
            include_once $controllerClassPath;
            $controller =  new $controllerClassName;
         }
        return $controller;
    }

    private static function handleException($errorMessage) {
        error_log($errorMessage);
        throw new Exception($errorMessage);
    }

    private static function getResource($requestPath) {
        $resource = "";
        $requestPathArray = explode("/", $requestPath);
        if (count($requestPathArray) > 2) {
            $version = $requestPathArray[1];
            $resource = strtolower($requestPathArray[2]);        }
        return $resource;
    }
}