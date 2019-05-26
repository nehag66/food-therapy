<?php

require_once(__DIR__.'/../constants/Constants.php');

class DbConnection
{
    /**
     * Db Connection
     *
     */
    private $connection;

    /**
     * Function to create a new DB connection.
     *
     */
    public static function getNewConnectionObj()
    {
        $obj = new DbConnection();
        $obj->connection = new PDO(
            "mysql:host=".Constants::DB_HOST.
            ";dbname=".Constants::DB_NAME, 
            Constants::DB_USER, 
            Constants::DB_PASS
        );

        return !empty($obj->connection) ? $obj : null;
    }

    /**
     *  Function to close the DB Connection.
     */
    public function closeConnection()
    {
    	$this->connection = null;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}