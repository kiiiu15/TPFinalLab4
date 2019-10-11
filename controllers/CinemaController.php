<?php 
namespace controllers;
include_once("config/autoload.php");

use config\autoload as autoload;
use controllers\Icontrollers as Icontrollers;
use repository\CinemaRepository as CinemaRepository;
use repository\IRepository as IRepository;
use model\Cinema as Cinema;

autoload::Start();

class CinemaController implements Icontrollers{

        $cinemaList=array();

    public function add($value){
        if(!isset($_POST)){
            $repositoryCinema=new CinemaRepository();

            $cinemaList=$repositoryCinema->GetAll();

            $newCinema= new Cinema($_POST["id"],$_POST["name"],$_POST["address"],$_POST["capacity"],$_POST["value"]);
            
            if(!$repositoryCinema->cinemaExist($_POST["id"])){
                $repositoryCinema->Add($newCinema);
            }else{
                echo "No se guardo el Cine"; //Sacar ! 
            }
        }
    }

    public function delete($value){
        if(!isset($_POST)){
            $repositoryCinema=new CinemaRepository();

            $cinemaList=$repositoryCinema->GetAll();

            $idCinema=$_POST["id"];

            $flag=false;
            
            foreach ($cinemaList as $value) {
                if($idCinema == $value->getIdCinema()){
                    $value->setActive($aux);
                    echo "Se elimino"; //Sacar ! 
                    break;
                }
            }
        }
    }

    public function getAll(){

    }

    public function edit(){

    }

    public function index(){
        include(VIEWS. "/home.php");
    }

}

?>