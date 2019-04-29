<?php

class BaseRepository
{
    protected $connection;

    public function __construct($connection)
    {
        if (empty($connection)) {
            echo "No Connection found with DB";
            die();
        }

        $this->connection = $connection;
    }
}