<?php 
namespace controllers;
use \PDO as PDO;
use \Exception as Exception;
use Controllers\IControllers as IControllers;
use Model\Cinema as Cinema;
use Dao\CinemaDB as CinemaDB;


class CinemaController implements IControllers{

    public function Add ($cinemaName, $adress, $capacity, $entranceValue) {
        
        $cinemaDB= new CinemaDB();
        $cinema=new Cinema(100,$cinemaName,$adress,$capacity,$entranceValue,true);
        try{
            $cinemaDB->Add($cinema);
        }catch(\PDOException $ex){
            throw $ex;
        }
        $this->index();
    }

    public function GetAll(){
        $cinemaDB = new CinemaDB();
        try{
            return $cinemaDB->RetrieveByActive(true);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function Deactivate($idCinema = 0){
        
        $cinemaDB=new CinemaDB();
        try{
            if (is_array($idCinema)){
                foreach($idCinema as $id){
                    $cinemaDB->DeactivateByID($id);
                }
            }else {
                $cinemaDB->DeactivateByID($idCinema);
            }
        }catch(\PDOException $ex){
            throw $ex;
        }
        $this->index();
    }

    public function RetrieveByActive($active){
        $cinemaDB=new CinemaDB();
        try{
            return $cinemaDB->RetrieveByActive($active);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function Reactivate($idCinema = 0){
        
        $cinemaDB=new CinemaDB();
        try{
            if (is_array($idCinema)){
                foreach($idCinema as $id){
                    $cinemaDB->ReactivateByID($id);
                }
            }else {
                $cinemaDB->ReactivateByID($idCinema);
            }
        }catch(\PDOException $ex){
            throw $ex;
        }
        $this->index(); 
    }

    public function ChangeCinemaState ($newState, $ids = array()){
        try{
            if ($newState == 0){
                $this->Deactivate($ids);
            } else{
                $this->Reactivate($ids);
            }
        }catch(\PDOException $ex){
            throw $ex;
        }
    }
    public function Modify($idCinemaToModify,$changedName,$changedAddress,$changedCapacity,$changedPrice){

        $cinemaDB= new CinemaDB();
        try{
            $cinemaDB->Modify( new  Cinema($idCinemaToModify , $changedName , $changedAddress , $changedCapacity , $changedPrice, true));
        }catch(\PDOException $ex){
            throw $ex;
        }
        
        $this->index();
    }

    public function index(){
        
        $cinemaList = $this->GetAll();
        include(VIEWS . "/cinemaList.php");
    }

}

?>