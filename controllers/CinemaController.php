<?php 
namespace controllers;

use Controllers\IControllers as IControllers;
use Model\Cinema as Cinema;
use Dao\CinemaDB as CinemaDB;


class CinemaController implements IControllers{

    public function Add ($cinemaName = "" , $adress = "" , $capacity = 0 , $entranceValue = 0 ) {
        
        $cinemaDB= new CinemaDB();
        $cinema=new Cinema(100,$cinemaName,$adress,$capacity,$entranceValue,true);

        $cinemaDB->Add($cinema);

        include(VIEWS."/cinemaHome.php"); 
    }

    public function GetAll(){
        $cinemaDB = new CinemaDB();
        return $cinemaDB->RetrieveByActive();
    }

    public function Deactivate($idCinema = 0){
        
        $cinemaDB=new CinemaDB();
        $cinemaDB->DeactivateByID($idCinema);
        include(VIEWS."/cinemaHome.php"); 
    }

    public function Modify($idCinemaToModify,$changedName,$changedAddress,$changedCapacity,$changedPrice){

        $cinemaDB= new CinemaDB();
        $cinemaDB->Modify( new  Cinema($idCinemaToModify , $changedName , $changedAddress , $changedCapacity , $changedPrice, true));
        include(VIEWS."/cinemaHome.php"); 
    }

    public function index(){
        
        $cinemaList = $this->GetAll();
        //include(VIEWS . "/cinemaList.php");
    }

}

?>