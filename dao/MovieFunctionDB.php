<?php

namespace Dao;

use Dao\AbstractDB as AbstractDB;
use model\MovieFunction as MovieFunction;
use Dao\MovieDB as MovieDB;

class MovieFunctionDB extends AbstractDB
{
    public function GetAll()
    {
        $sql = "SELECT * FROM MovieFunctions";

        return $this->Execute($sql);
    }

    //MOVIES ES EL TITULO DE LA PELICULA, CINEMA ES EL ID DEL CINEMA (ESTAS SERIAN LAS FK DE LA TABLA MOVIE FUNCTIONS)
    public function Add($moviefunction)
    {

        $sql = "INSERT INTO MovieFunctions(date,hour,idRoom,idMovie) VALUES (:dayFunction,:hourFunction,:room,:movies)";
        $values['dayFunction']  = $moviefunction->getDay();
        $values['hourFunction'] = $moviefunction->getHour();
        $movie = $moviefunction->getMovie();
        $room = $moviefunction->getRoom();
        $values['room']     = $room->getId();
        $values['movies']      = $movie->getId();

        return $this->ExecuteNonQuery($sql, $values);
    }


    public function RetrieveById($id)
    {
        $sql = "SELECT * FROM MovieFunctions WHERE MovieFunctions.idFunction=:id";
        $values['id'] = $id;

        return $this->Execute($sql, $values);
    }

    public function Modify($moviefunction)
    {
        $sql = "UPDATE MovieFunctions SET MovieFunctions.date=:date , MovieFunctions.hour=:hour , MovieFunctions.idMovie=:movies , MovieFunctions.idRoom=:cinema WHERE MovieFunctions.idFunction=:idFunction";
        $values['date']   = $moviefunction->getDay();
        $values['hour']  = $moviefunction->getHour();
        $movie = $moviefunction->getMovie();
        $room = $moviefunction->getRoom();
        $values['idRoom']     = $room->getId();
        $values['movies']      = $movie->getId();
        $values['idFunction'] = $moviefunction->getId();

        return $this->ExecuteNonQuery($sql, $values);
    }

    public function Delete($moviefunction)
    {
        $sql = "DELETE FROM MovieFunctions WHERE MovieFunctions.idFunction=:idFunction";
        $values['idFunction'] = $moviefunction->getId();

        return $this->ExecuteNonQuery($sql, $values);
    }

    public function RetrieveByDate($date)
    {
        $sql = "SELECT * FROM MovieFunctions WHERE MovieFunctions.date=:date";
        $values['date'] = $date;

        return $this->Execute($sql, $values);
    }


    //Levanta la cartelera apartir de hoy a 7 dias 
    public function RetrieveBillboard()
    {
        $sql = "SELECT * FROM MovieFunctions WHERE MovieFunctions.date BETWEEN CURDATE() AND CURDATE() +INTERVAL 7 DAY";

        return $this->Execute($sql);
    }

    public function RetrieveBillboardMovies()
    {
        $functions = $this->RetrieveBillboard();

        $functions = $this->TransformToArray($functions);
        $moviesAtBillboard = array();

        foreach ($functions as $function) {
            $movie = $function->getMovie();
            $moviesAtBillboard[$movie->getId()] = $movie;
        }

        return $moviesAtBillboard;
    }


    private function TransformToArray($value)
    {
        if ($value == false) {
            $value = array();
        }

        if (!is_array($value)) {
            $value = array($value);
        }

        return $value;
    }

    protected function Map($value)
    {
        $value = is_array($value) ? $value : [];

        $resp = array_map(function ($m) {
            $movieDB = new MovieDB();
            $roomDB = new RoomDB();
            return new MovieFunction($m["idFunction"], $m['date'], $m['hour'], $roomDB->RetrieveById($m['idRoom']), $movieDB->RetrieveById($m['idMovie']));
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }
}
