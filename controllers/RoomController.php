<?php namespace controllers;

use \PDO as PDO;
use \Exception as Exception;
use Controllers\IControllers as IControllers;
use Model\Room as Room;
use Model\Cinema as Cinema;
use Dao\RoomDB as RoomDB;
use Controllers\CinemaController as CinemaController;

class RoomController implements IControllers{

    public function __construct(){}
    
    public function Add($idCinema, $name, $capacity, $price){
        $roomDB = new RoomDB();
        $cinemaController = new CinemaController();
        $room = new Room(0, $name, $price, $capacity,$cinemaController->RetrieveById($idCinema));
        try{
            $roomDB->Add($room);
        }catch(\PDOException $ex){
            throw $ex;
        }

        $this->index();
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

    public function Delete($idRoom){
        $roomDB = new RoomDB();
        $idRoom = $this->TransformToArray($idRoom);
        try{
            foreach($idRoom as $id){
                $roomDB->Delete($this->RetrieveById($id));
            }
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

    /** 
     * no se si es responsabilidad de room pero por ahora la dejo aca
     */
    public function GetRemainingCapacity($idFunction,$numberOfTickets){
        $db = new RoomDB();
                                //va a buscar todas las buy que tengan esa idFunction y devolver sumar su number of tikets
        $RemainingCapacity = $db->GetTotalTicketsByFunction($idFunction);

        return $RemainingCapacity - $numberOfTickets;
    }

    public function RetrieveByActive($active){
        $roomDB = new RoomDB();
        try{
           return $roomDB->RetrieveByActive($active);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    private function TransformToArray($value){
        if ($value == false){
            $value = array();
        }

        if (!is_array($value)){
            $value = array($value);
        }

        return $value;

    }

    public function index(){
        $rooms = $this->GetAll();
        $CinemaController = new CinemaController();

        $activeCinemas = $CinemaController->RetrieveByActive(true);
        include(VIEWS . "/listRooms.php");
    }


}