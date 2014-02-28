<?php

global $DEPLOYMENT_DIRECTORY;
require_once $DEPLOYMENT_DIRECTORY . '/app/config/Database.php';

class Connection {

    public static function getDatabaseConnection() {
            $dbCondig = Database::getDatabaseConfig();
            $host = $dbCondig['host'];
            $username = $dbCondig['username'];
            $password = $dbCondig['password'];
            $database = $dbCondig['database'];
            $dbConnection = @mysql_connect($host, $username, $password);

        if(!$dbConnection) {
            throw new Exception("Error connection to database host with username and password");
        }

        if (!$dbConnection || !mysql_select_db($database,$dbConnection)) {
            throw new Exception("Error connection to database " . $database);
        }

        return $dbConnection;
    }

}
