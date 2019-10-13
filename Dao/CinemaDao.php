<?php
namespace Dao;
use Dao\IDao as IDao;
use Model\Cinema as Cinema;

class CinemaDao implements IDao{
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
                $Cinema->setActive(false);
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
            $valuesArray["active"]      =  $Cinema->getActive();
            array_push($arrayToEncode,$valuesArray);
        }
        $jsonContent =json_encode($arrayToEncode,JSON_PRETTY_PRINT);
        file_put_contents(dirname(__DIR__) . '/Data/Cinema.json',$jsonContent);
    }

    public function RetrieveData(){
        $this->CinemaList = array();
        if(file_exists(dirname(__DIR__) ."/Data/Cinema.json")){
            $jsonContent = file_get_contents(dirname(__DIR__) . "/Data/Cinema.json");
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent,true) : array();

            foreach($arrayToDecode as $valuesArray)
            {
                $Cinema = new Cinema($valuesArray["idCinema"], $valuesArray["Name"], $valuesArray["Address"], $valuesArray["Capacity"], $valuesArray["Price"],$valuesArray["active"]);
                array_push($this->CinemaList, $Cinema);
            }
        }   
    }

    /**
     * busca un cine por su id
     * true si existe
     * false si no
     *  @return boolean
     */
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
 

    public function getCinema($idCinema){
        $aux=null;
        $list = $this->GetAll();
        foreach ($list as $cinema) {
            if($cinema->getIdCinema() == $idCinema){
                $aux=$cinema;
            }
        }
        return $aux;
    }


    public function generateIdCinema()
    {//esta buena pero es peligroso (╯°□°）╯︵ ┻━┻ 
        $id=count($this->CinemaList);
        $id++;
        return $id;
    }
}

?>