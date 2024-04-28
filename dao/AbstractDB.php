<?php

namespace Dao;

abstract class AbstractDB
{
    protected Connection $connection;

    public function __construct()
    {
        $this->connection = Connection::getInstance();
        $this->connection->connect();
    }


    public function Execute($query, $parameters = array(), $queryType = QueryType::Query)
    {

        try {
            $this->connection->Execute($query, $parameters, $queryType);
            if (empty($result)) {
                return false;
            }
            return $this->Map($result);
        } catch (\PDOException $ex) {
            return false;
        }
    }

    public function ExecuteNonQuery($query, $parameters = array(), $queryType = QueryType::Query)
    {
        try {
            $this->connection->ExecuteNonQuery($query, $parameters, $queryType);
            if (empty($result)) {
                return false;
            }
            return $this->Map($result);
        } catch (\PDOException $ex) {
            return false;
        }
    }

    protected abstract function Map($value);
}
