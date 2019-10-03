<?php
namespace repository;
use repository\IRepository as IRepository;
use model\Cine as Cine;

class CineRepository implements IRepository{
    private $cineList=array();
    
    public function GetAll(){
        $this->RetrieveData();
        return $this->cineList;
    }

    public function Add($value){
        $this->RetrieveData();
        array_push($this->cineList,$value);
        $this->SaveData();
    }

    //Busca por el id del cine y lo elimina
    public function Delete($value){
        $this->RetrieveData();
        foreach($this->cineList as $key =>$cine){
            if($cine->getIdCine() == $value){
                unset($this->cineList[$key]);
                break;
            }
        }
        $this->SaveData();
    }

    public function SaveData(){
        $arrayToEncode =array();

        foreach($this->cineList as $cine){
            $valuesArray["idCine"]=$cine->getIdCine();
            $valuesArray["nombre"]=$cine->getNombre();
            $valuesArray["direccion"]=$cine->getDireccion();
            $valuesArray["capacidad"]=$cine->getCapacidad();
            $valuesArray["valor"]=$cine->getValorEntrada();
            array_push($arrayToEncode,$valuesArray);
        }
        $jsonContent =json_encode($arrayToEncode,JSON_PRETTY_PRINT);
        file_put_contents(dirname(__DIR__) . '/data/cine.json',$jsonContent);
    }

    public function RetrieveData(){
        $this->cineList=array();
        if(file_exists(dirname(__DIR__) ."data/cine.json")){
            $jsonContent =file_get_contents(dirname(__DIR__) . "data/cine.json");
            $arrayToDecode=($jsonContent) ? json_decode($jsonContent,true) :array();

            foreach($arrayToDecode as $valuesArray)
            {
                $cine = new Cine($valuesArray["idCine"], $valuesArray["nombre"], $valuesArray["direccion"], $valuesArray["capacidad"], $valuesArray["valor"]);
                array_push($this->cineList, $cine);
            }
        }
        
    }

}

?>