<?php

namespace controllers;

use Controllers\IControllers as IControllers;
use Model\Room as Room;
use Dao\RoomDB as RoomDB;
use Controllers\CinemaController as CinemaController;

class RoomController implements IControllers
{
    private $roomDB;
    private $cinemaController;

    public function __construct()
    {
        $this->roomDB = new RoomDB();
        $this->cinemaController = new CinemaController();
    }

    public function Add($idCinema, $name, $capacity, $price)
    {
        $room = new Room(0, $name, $price, $capacity, $this->cinemaController->RetrieveById($idCinema));
        try {
            $this->roomDB->Add($room);
            $this->index();
        } catch (\PDOException $ex) {
            $this->index("Error connection DB");
        }
    }

    public function GetAll()
    {
        try {
            $roomList = $this->roomDB->GetAll();
            return $roomList;
        } catch (\PDOException $ex) {
            return array();
        }
    }

    public function RetrieveById($idRoom)
    {
        try {
            $room = $this->roomDB->RetrieveById($idRoom);
            return $room;
        } catch (\PDOException $ex) {
            return null;
        }
    }

    public function RetrieveByIdCinema($idCinema)
    {
        try {
            $room = $this->roomDB->RetrieveByIdCinema($idCinema);
            return $room;
        } catch (\PDOException $ex) {
            return array();
        }
    }

    public function Delete($idRoom)
    {
        $idRoom = $this->TransformToArray($idRoom);
        try {
            foreach ($idRoom as $id) {
                $this->roomDB->Delete($this->RetrieveById($id));
                $this->index();
            }
        } catch (\PDOException $ex) {
            $this->index("Error DB connection");
        }
    }

    /** 
     * no se si es responsabilidad de room pero por ahora la dejo aca
     */
    public function GetRemainingCapacity($idFunction, $numberOfTickets)
    {
        try {
            $movieFunctionController = new MovieFunctionController();
            $function = $movieFunctionController->GetById($idFunction);
            $room = $function->getRoom();
            $TotalTicketsByFunction = $this->roomDB->GetTotalTicketsByFunction($idFunction);

            $RemainingCapacity = $room->getCapacity() - ($TotalTicketsByFunction + $numberOfTickets);

            return $RemainingCapacity;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public function GetRoomByIdFunction($idFunction)
    {
        try {
            return $this->roomDB->RetrieveByIdFunction($idFunction);
        } catch (\PDOException $ex) {
            return null;
        }
    }

    public function RetrieveByActive($active)
    {
        try {
            return $this->roomDB->RetrieveByActive($active);
        } catch (\PDOException $ex) {
            return null;
        }
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

    public function index($message = null)
    {
        $errorMje = $message;
        $roomList = $this->GetAll();
        $CinemaList = $this->cinemaController->RetrieveByActive(true);

        $rooms = $this->TransformToArray($roomList);
        $activeCinemas = $this->TransformToArray($CinemaList);

        include(PAGES . "/rooms.php");
    }
}
