<?php

global $DEPLOYMENT_DIRECTORY;
require_once $DEPLOYMENT_DIRECTORY . '/app/config/Database.php';

//define("MYSQL_CONN_ERROR", "Unable to connect to database.");

mysqli_report(MYSQLI_REPORT_STRICT);

class MySqlConnection {

    private static $mysqli = NULL;

    function __construct() {
        //if ( self::$mysqli != null ) {
                self::createMySqlConnection();
        //}
        //echo self::$mysqli->host_info . "\n";
    }//construct

    public function execute($bindParam) {
        $statement = self::prepareStatement($bindParam->getSql());
        self::bindAndExecute($statement, $bindParam);
        $statement->close();
    }

    public function query($bindParam) {
        $statement = self::prepareStatement($bindParam->getSql());
        self::bindAndExecute($statement, $bindParam);
        $results = self::getResults($statement);
        $statement->close();
        return $results;
    }

    private static function getResults($statement) {
        $meta = $statement->result_metadata();
        while ($field = $meta->fetch_field()) {
            $params[] = &$row[$field->name];
        }
        call_user_func_array(array($statement, 'bind_result'), $params);
        while ($statement->fetch()) {
            foreach($row as $key => $val)
            {
                $c[$key] = $val;
            }
            $result[] = $c;
        }
        return $result;
    }

    private static function createMySqlConnection() {
        if (self::$mysqli == NULL ) {
                $dbCondig = Database::getDatabaseConfig();
                $host = $dbCondig['host'];
                $username = $dbCondig['username'];
                $password = $dbCondig['password'];
                $database = $dbCondig['database'];
                $mysqli = new mysqli($host, $username, $password, $database);

            if ($mysqli->connect_errno) {
                self::handleException("Database Exception" . $mysqli->connect_error);
                error_log($mysqli->connect_error);
            }
            self::$mysqli = $mysqli;
        }
    }

    /**
     * Creates a Mysql Prepared Statement
     * @param $sql
     * @throws Exception
     */

    private static function prepareStatement($sql) {
        $preparedStatement = null;
        if (!($preparedStatement = self::$mysqli->prepare($sql))) {
            error_log("Prepare failed: (" . self::$mysqli->errno . ") " . self::$mysqli->error);
            throw new Exception("Invalid sql." . $sql);
        }
        return $preparedStatement;
    }

    private static function bindAndExecute($statement, $bindParam) {
        try {
            call_user_func_array( array($statement, 'bind_param'), $bindParam->getParameters());
        }catch (Exception $e) {
            $errorMessage = "Binding failed: (" . $statement->errno . ") " . $statement->error;
            self::handleException($errorMessage);
        }
        if (!$statement->execute()) {
            $errorMessage = "Execute failed: (" . $statement->errno . ") " . $statement->error;
            self::handleException($errorMessage);
        }
    }

    private static function handleException($errorMessage) {
        error_log($errorMessage);
        throw new Exception($errorMessage);
    }

}
