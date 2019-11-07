<?php namespace controllers;

use \PDO as PDO;
use \Exception as Exception;
use Controllers\IControllers as IControllers;
use Model\Room as Room;
use Model\Cinema as Cinema;
use Dao\RoomDB as RoomDB;
use Dao\CinemaDB as CinemaDB;

class RoomController implements IControllers{

    public function __construct(){}
    
    public function Add($room){
        $roomDB = new RoomDB();

        try{
            $roomDB->Add($room);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function GetAll(){
        $roomDB = new RoomDB();
        $roomList = array();

        try{
            $roomList = $roomDB->GetAll();
        }catch(\PDOException $ex){
            throw $ex;
        }
        return $roomList;
    }

    public function RetrieveById($idRoom){
        $roomDB = new RoomDB();
        $room = new Room();

        try{
            $room = $roomDB->RetrieveById($idRoom);
        }catch(\PDOException $ex){
            throw $ex;
        }
        return $room;
    }
    public function RetrieveByIdCinema($idCinema){
        $roomDB = new RoomDB();
        $room = new Room();

        try{
            $room = $roomDB->RetrieveByIdCinema($idCinema);
        }catch(\PDOException $ex){
            throw $ex;
        }
        return $room;
    }

    public function Delete($room){
        $roomDB = new RoomDB();
        try{
            $roomDB->Delete($room);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function Modify($room){
        $roomDB = new RoomDB();
        try{
            $roomDB->Modify($room);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function index(){
        $roomList = $this->GetAll();
        //include(VIEWS . "/roomList.php");
    }


}
