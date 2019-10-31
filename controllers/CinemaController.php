<?php 
namespace Controllers;

use Controllers\IControllers as IControllers;
use Model\Cinema as Cinema;
use Dao\CinemaDB as CinemaDB;


class CinemaController implements IControllers{

    public function add ($cinemaName = "" , $adress = "" , $capacity = 0 , $entranceValue = 0 ) {
        
        var_dump($cinemaName);

        $cinemaDB= new CinemaDB();
        $cinema=new Cinema(100,$cinemaName,$adress,$capacity,$entranceValue,true);

        $cinemaDB->Add($cinema);

        /*$cinemaRepo=new CinemaDao();
        $id=$cinemaRepo->generateIdCinema();        
        $cinema=new Cinema($id,$cinemaName,$adress,$capacity,$entranceValue,true);
        $cinemaRepo->Add($cinema);*/
        include(VIEWS."/cinemaHome.php"); 
    }

    public function getAll(){
        $cinemaDB=new CinemaDB();
        $list=$cinemaDB->RetrieveByActive();
        include(VIEWS."/cinemaHome.php");
    }

    public function Deactivate($idCinema = 0){
        
        /*$cinemaRepo = new CinemaDao();
        $cinemaRepo->Deactivate($idCinema);
        */
        include(VIEWS."/cinemaHome.php"); 
    }

    public function modify($idCinemaToModify,$changedName,$changedAddress,$changedCapacity,$changedPrice){

        $cinemaDao = new CinemaDao();
        $cinemaDao->modify($idCinemaToModify,$changedName,$changedAddress,$changedCapacity,$changedPrice);
        
        include(VIEWS."/cinemaHome.php"); 
    }

    public function index(){
        include(VIEWS . "/cinemaHome.php");
    }

}

?>