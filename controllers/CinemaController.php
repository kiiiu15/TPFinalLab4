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

    public function Remove(){
        
        $idCinema = $_GET["idCinemaToRemove"];

        $cinemaRepo = new CinemaDao();
        $cinemaRepo->Remove($idCinema);
        
        include(VIEWS."/cinemaHome.php"); 
    }

    public function modify($idCinema){
        $cinemaRepo=new CinemaDao();
        $cinema=$cinemaRepo->toCinema($idCinema);
        

    }

    public function index(){
        include(VIEWS . "/cinemaHome.php");
        //header('Location: ../Views/cinemaHome.php');
    }

}

?>