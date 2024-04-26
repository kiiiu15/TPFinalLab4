<?php

namespace Dao;

class AbstractDB
{
    protected Connection $connection;

    public function __construct()
    {
        $this->connection = Connection::getInstance();
        $this->connection->connect();
    }
}
