<?php 
namespace controllers;

use controllers\Icontrollers as Icontrollers;
use model\Cinema as Cinema;
use repository\CinemaRepository as CinemaRepository;


class CinemaController implements Icontrollers{

    public function add ($cinemaName = "" , $capacity = 0 , $adress = "" , $entranceValue = 0 ) {
        
        $cinemaRepo=new CinemaRepository();
        $id=$cinemaRepo->generateIdCinema();        
        $cinema=new Cinema($id,$cinemaName,$adress,$capacity,$entranceValue,true);
        $cinemaRepo->Add($cinema);
    }

    public function delete($idCinema){
        $cinemaRepo=new CinemaRepostory();
        $cinemaRepo->Delete($idCinema);
        //include(VIEWS."/"); le ponemos listar sin el cine eliminado
    }

    public function modify($idCinema){
        $cinemaRepo=new CinemaRepostory();
        $cinema=$cinemaRepo->toCinema($idCinema);
        

    }





    public function index(){
        include(VIEWS. "/home.php");
    }

}

?>