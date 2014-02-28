<?php

global $DEPLOYMENT_DIRECTORY;
require_once $DEPLOYMENT_DIRECTORY . '/app/config/Database.php';

class MySqlConnection {

    private static $mysqli = null;

    function __construct() {
        //if ( self::$mysqli != null ) {
                self::createMySqlConnection();
        //}
        //echo self::$mysqli->host_info . "\n";
    }//construct

    private static function createMySqlConnection() {
            $dbCondig = Database::getDatabaseConfig();
            $host = $dbCondig['host'];
            $username = $dbCondig['username'];
            $password = $dbCondig['password'];
            $database = $dbCondig['database'];
            $mysqli = new mysqli($host, $username, $password, $database);

        if ($mysqli->connect_errno) {
            error_log($mysqli->connect_error);
            throw new Exception("Error connection to database host with username and password");
        }
        self::$mysqli = $mysqli;
    }

    public function prepare($sql) {
        $preparedStatement = null;
        if (!($preparedStatement = self::$mysqli->prepare($sql))) {
            error_log("Prepare failed: (" . self::$mysqli->errno . ") " . self::$mysqli->error);
            throw new Exception("Invalid sql." . $sql);
        }
    }
}
