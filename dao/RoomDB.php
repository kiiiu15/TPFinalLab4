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

        return $this->Execute($sql);
    }


    public function GetTotalTicketsByFunction($idFunction)
    {
        $sql = "SELECT SUM(Buy.numberOfTickets) as total FROM Buy WHERE buy.idMovieFunction = :idMovieFunction AND Buy.buyState = true";
        $values["idMovieFunction"] = $idFunction;

        $result = $this->Execute($sql, $values, null, false);

        if (!$result) {
            return 0;
        }

        return $result[0]['total'];
    }

    public function RetrieveByIdFunction($idFunction)
    {
        $sql = "SELECT * FROM Rooms WHERE Rooms.idFunction = :idFunction";

        $values['idFunction'] = $idFunction;

        return $this->Execute($sql, $values);
    }

    public function Add($room)
    {
        $sql = "INSERT INTO Rooms(name,price,capacity,idCinema) VALUES(:name,:price,:capacity,:idCinema)";
        $values['name'] = $room->getName();
        $values['price'] = $room->getPrice();
        $values['capacity'] = $room->getCapacity();
        $cinema = $room->getCinema();
        $values['idCinema'] = $cinema->getIdCinema();

        return $this->ExecuteNonQuery($sql, $values);
    }

    public function RetrieveByID($idRoom)
    {
        $sql = "SELECT * FROM Rooms WHERE Rooms.id=:id";
        $values['id'] = $idRoom;

        return $this->Execute($sql, $values);
    }

    public function RetrieveByIdCinema($idCinema)
    {
        $sql = "SELECT * FROM Rooms WHERE Rooms.idCinema=:idCinema";
        $values['idCinema'] = $idCinema;

        return  $this->Execute($sql);
    }

    public function Delete($room)
    {
        $sql = "DELETE FROM Rooms WHERE Rooms.id=:id";
        $values['id'] = $room->getId();

        return $this->ExecuteNonQuery($sql, $values);
    }

    public function Modify($room)
    {
        $sql = "UPDATE  Rooms SET Rooms.name=:name,Rooms.price=:price,Rooms.capacity = :capacity,Rooms.idCinema=:idCinema WHERE Rooms.id=:id";
        $values['id']       = $room->getId();
        $values['name']     = $room->getName();
        $values['price']    = $room->getPrice();
        $values['capacity'] = $room->getCapacity();
        $values['idCinema'] = $room->getIdCinema();

        return $this->ExecuteNonQuery($sql, $values);
    }


    public function RetrieveByActive($active)
    {
        $sql = "SELECT * FROM Rooms INNER JOIN Cinemas ON Rooms.idCinema = Cinemas.idCinema WHERE Cinemas.active=:active";
        $values['active'] = $active;

        return $this->Execute($sql, $values);
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
}
