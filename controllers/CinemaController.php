<?php 
namespace controllers;
use \PDO as PDO;
use \Exception as Exception;
use Controllers\IControllers as IControllers;
use Model\Cinema as Cinema;
use Dao\CinemaDB as CinemaDB;


class CinemaController implements IControllers{

    public function Add ($cinemaName, $adress) {
        
        $cinemaDB= new CinemaDB();
        $cinema=new Cinema(100,$cinemaName,$adress,true);
        try{
            $cinemaDB->Add($cinema);
        }catch(\PDOException $ex){
            $this->index('There was an erro whit the connection, please try again');
        }
        $this->index();
    }

    public function GetAll(){
        $cinemaDB = new CinemaDB();
        try{
            return $cinemaDB->GetAll();
        }catch(\PDOException $ex){
            $this->index('There was an erro whit the connection, please try again');
        }
    }

    public function Deactivate($idCinema = 0){
        
        $cinemaDB=new CinemaDB();
        try{
                $idCinema = $this->TransformToArray($idCinema);
                foreach($idCinema as $id){
                    $cinemaDB->DeactivateByID($id);
                }
        }catch(\PDOException $ex){
            $this->index('There was an erro whit the connection, please try again');
        }
        $this->index();
    }

    public function RetrieveByActive($active){
        $cinemaDB=new CinemaDB();
        try{
            return $cinemaDB->RetrieveByActive($active);
        }catch(\PDOException $ex){
            $this->index('There was an erro whit the connection, please try again');
        }
    }

    public function RetrieveById($id){
        $cinemaDB=new CinemaDB();
        try{
            return $cinemaDB->RetrieveById($id);
        }catch(\PDOException $ex){
            $this->index('There was an erro whit the connection, please try again');
        }
    }


    public function Reactivate($idCinema = 0){
        
        $cinemaDB=new CinemaDB();

        $idCinema = $this->TransformToArray($idCinema);
        try{
           
                foreach($idCinema as $id){
                    $cinemaDB->ReactivateByID($id);
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
            $this->index('There was an erro whit the connection, please try again');
        }
    }
    public function Modify($idCinemaToModify,$changedName,$changedAddress){

        $cinemaDB= new CinemaDB();
        try{
            $cinemaDB->Modify( new  Cinema($idCinemaToModify , $changedName , $changedAddress , true));
        }catch(\PDOException $ex){
            $this->index('There was an erro whit the connection, please try again');
        }
        
        $this->index();
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

    public function index($msg = null){
        $errorMje = $msg;
        $cinemaList = $this->GetAll();
        include(VIEWS . "/cinema.php");
    }

}

?>