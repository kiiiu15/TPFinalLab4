<?php
namespace repository;
use repository\IRepository as IRepository;
use model\Cinema as Cinema;

class CinemaRepository implements IRepository{
    private $CinemaList = array();
    
    public function GetAll(){
        $this->RetrieveData();
        return $this->CinemaList;
    }

    public function Add($Cinema){
        $this->RetrieveData();
        array_push($this->CinemaList,$Cinema);
        $this->SaveData();
    }

    //Busca por el id del Cinema y lo elimina
    public function Delete($IdCinema){
        $this->RetrieveData();
        foreach($this->CinemaList as $key =>$Cinema){
            if($Cinema->getIdCinema() == $IdCinema){
                unset($this->CinemaList[$key]);
                break;
            }
        }
        $this->SaveData();
    }

    public function SaveData(){
        $arrayToEncode =array();

        foreach($this->CinemaList as $Cinema){
            $valuesArray["idCinema"]    =  $Cinema->getIdCinema();
            $valuesArray["Name"]        =  $Cinema->getName();
            $valuesArray["Address"]     =  $Cinema->getAddress();
            $valuesArray["Capacity"]    =  $Cinema->getCapacity();
            $valuesArray["Price"]       =  $Cinema->getPrice();
            array_push($arrayToEncode,$valuesArray);
        }
        $jsonContent =json_encode($arrayToEncode,JSON_PRETTY_PRINT);
        file_put_contents(dirname(__DIR__) . '/data/Cinema.json',$jsonContent);
    }

    public function RetrieveData(){
        $this->CinemaList = array();
        if(file_exists(dirname(__DIR__) ."/data/Cinema.json")){
            $jsonContent = file_get_contents(dirname(__DIR__) . "/data/Cinema.json");
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent,true) : array();

            foreach($arrayToDecode as $valuesArray)
            {
                $Cinema = new Cinema($valuesArray["idCinema"], $valuesArray["Name"], $valuesArray["Address"], $valuesArray["Capacity"], $valuesArray["Price"]);
                array_push($this->CinemaList, $Cinema);
            }
        }   
    }

    public function cinemaExist($idToSearch){
        $exist = false;
        $list = $this->GetAll();
        foreach ($list as $cinema) {
            if($cinema->getIdCinema() == $idToSearch){
                $exist = true;
            }
        }
        return $exist;
    }
}

?>