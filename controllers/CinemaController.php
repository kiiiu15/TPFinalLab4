<?php 
namespace controllers;

use Controllers\IControllers as IControllers;
use Model\Cinema as Cinema;
use Dao\CinemaDB as CinemaDB;


class CinemaController implements IControllers{

    public function Add ($cinemaName, $adress, $capacity, $entranceValue) {
        
        $cinemaDB= new CinemaDB();
        $cinema=new Cinema(100,$cinemaName,$adress,$capacity,$entranceValue,true);

        $cinemaDB->Add($cinema);

        $this->index();
    }

    public function GetAll(){
        $cinemaDB = new CinemaDB();
        return $cinemaDB->RetrieveByActive(true);
    }

    public function Deactivate($idCinema = 0){
        
        $cinemaDB=new CinemaDB();
        if (is_array($idCinema)){
            foreach($idCinema as $id){
                $cinemaDB->DeactivateByID($id);
            }
        }else {
            $cinemaDB->DeactivateByID($idCinema);
        }
        
        $this->index();
    }

    public function RetrieveByActive($active){
        $cinemaDB=new CinemaDB();
        return $cinemaDB->RetrieveByActive($active);
    }

    public function Reactivate($idCinema = 0){
        
        $cinemaDB=new CinemaDB();
        if (is_array($idCinema)){
            foreach($idCinema as $id){
                $cinemaDB->ReactivateByID($id);
            }
        }else {
            $cinemaDB->ReactivateByID($idCinema);
        }
        
        $this->index(); 
    }

    public function ChangeCinemaState ($newState, $ids = array()){
        if ($newState == 0){
            $this->Deactivate($ids);
        } else{
            $this->Reactivate($ids);
        }

    }
    public function Modify($idCinemaToModify,$changedName,$changedAddress,$changedCapacity,$changedPrice){

        $cinemaDB= new CinemaDB();
        $cinemaDB->Modify( new  Cinema($idCinemaToModify , $changedName , $changedAddress , $changedCapacity , $changedPrice, true));
        $this->index();
    }

    public function index(){
        
        $cinemaList = $this->GetAll();
        include(VIEWS . "/cinemaList.php");
    }

}

?>