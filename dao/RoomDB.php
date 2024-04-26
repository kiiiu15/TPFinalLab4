<?php

namespace Dao;

use Dao\AbstractDB as AbstractDB;
use model\Room as Room;
use model\Cinema as Cinema;


class RoomDB extends AbstractDB
{

    public function GetAll()
    {
        $sql = "SELECT * FROM Rooms";
        try {

            $result = $this->connection->Execute($sql);
        } catch (\PDOException $ex) {
            throw $ex;
        }
        if (!empty($result)) {
            return $this->Map($result);
        } else {
            return false;
        }
    }

    /**
     * no se si le corresponde a roomBd pero por ahora lo dejo aca
     */
    public function GetTotalTicketsByFunction($idFunction)
    {
        $sql = "SELECT SUM(Buy.numberOfTickets) as total FROM Buy WHERE buy.idMovieFunction = :idMovieFunction AND Buy.buyState = true";
        $values["idMovieFunction"] = $idFunction;
        try {

            $reuslt = $this->connection->Execute($sql, $values)[0]['total'];


            if ($reuslt == null) {
                return 0;
            } else {
                return $reuslt;
            }
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function RetrieveByIdFunction($idFunction)
    {
        $sql = "SELECT * FROM Rooms WHERE Rooms.idFunction = :idFunction";

        $values['idFunction'] = $idFunction;

        try {

            $result = $this->connection->Execute($sql, $values);
        } catch (\PDOException $ex) {
            throw $ex;
        }
        if (!empty($result)) {
            return $this->Map($result);
        } else {
            return false;
        }
    }

    public function Add($room)
    {
        $sql = "INSERT INTO Rooms(name,price,capacity,idCinema) VALUES(:name,:price,:capacity,:idCinema)";
        $values['name'] = $room->getName();
        $values['price'] = $room->getPrice();
        $values['capacity'] = $room->getCapacity();
        $cinema = new Cinema();
        $cinema =  $room->getCinema();
        $values['idCinema'] = $cinema->getIdCinema();

        try {

            return $this->connection->ExecuteNonQuery($sql, $values);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function RetrieveByID($idRoom)
    {
        $sql = "SELECT * FROM Rooms WHERE Rooms.id=:id";
        $values['id'] = $idRoom;
        try {

            $result = $this->connection->Execute($sql, $values);
        } catch (\PDOException $ex) {
            throw $ex;
        }
        if (!empty($result)) {
            return $this->Map($result);
        } else {
            return false;
        }
    }

    //Trae todas las salas de un mismo cine :D, pronto le daremos un uso
    public function RetrieveByIdCinema($idCinema)
    {
        $sql = "SELECT * FROM Rooms WHERE Rooms.idCinema=:idCinema";
        $values['idCinema'] = $idCinema;
        try {

            $result = $this->connection->Execute($sql);
        } catch (\PDOException $ex) {
            throw $ex;
        }
        if (!empty($result)) {
            return $this->Map($result);
        } else {
            return false;
        }
    }

    public function Delete($room)
    {
        $sql = "DELETE FROM Rooms WHERE Rooms.id=:id";
        $values['id'] = $room->getId();

        try {

            $this->connection->connect();
            return $this->connection->ExecuteNonQuery($sql, $values);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function Modify($room)
    {
        $sql = "UPDATE  Rooms SET Rooms.name=:name,Rooms.price=:price,Rooms.capacity = :capacity,Rooms.idCinema=:idCinema WHERE Rooms.id=:id";
        $values['id']       = $room->getId();
        $values['name']     = $room->getName();
        $values['price']    = $room->getPrice();
        $values['capacity'] = $room->getCapacity();
        $values['idCinema'] = $room->getIdCinema();

        try {

            return  $this->connection->ExecuteNonQuery($sql, $values);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    protected function Map($value)
    {

        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($c) {
            $cinemaDB = new CinemaDB();
            return new Room($c['id'], $c['name'], $c['price'], $c['capacity'], $cinemaDB->RetrieveById($c['idCinema']));
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }

    public function RetrieveByActive($active)
    {
        $sql = "SELECT * FROM Rooms INNER JOIN Cinemas ON Rooms.idCinema = Cinemas.idCinema WHERE Cinemas.active=:active";
        $values['active'] = $active;
        try {

            $this->connection->connect();
            $result = $this->connection->Execute($sql, $values);
        } catch (\PDOException $ex) {
            throw $ex;
        }
        if (!empty($result)) {
            return $this->Map($result);
        } else {
            return false;
        }
    }
}
