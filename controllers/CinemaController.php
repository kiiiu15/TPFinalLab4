<?php 
namespace Controllers;

use Controllers\IControllers as IControllers;
use Model\Cinema as Cinema;
use Dao\CinemaDao as CinemaDao;


class CinemaController implements IControllers{

    public function add ($cinemaName = "" , $capacity = 0 , $adress = "" , $entranceValue = 0 ) {
        
        $cinemaRepo=new CinemaDao();
        $id=$cinemaRepo->generateIdCinema();        
        $cinema=new Cinema($id,$cinemaName,$adress,$capacity,$entranceValue,true);
        $cinemaRepo->Add($cinema);
    }

    public function Deactivate(){
        
        $idCinema = $_GET["idCinemaToDeactivate"];
        //preguntenme por q hice esto
       // unset($_GET["idCinemaToDeactivate"]);

        $cinemaRepo = new CinemaDao();
        $cinemaRepo->Deactivate($idCinema);
        
        include(VIEWS."/cinemaHome.php"); 
    }

    public function modify(){

        $cinemaDao = new CinemaDao();

        //if($_GET["idCinemaToModify"])
        $cinemaDao->modify();
        
        include(VIEWS."/cinemaHome.php"); 
    }

    public function index(){
        include(VIEWS . "/cinemaHome.php");
        //header('Location: ../Views/cinemaHome.php');
    }

}

?>