<?php
namespace Dao;

use Dao\IDao as IDao;
use model\Genre as Genre;

class GenreDao implements IDao{
    private $GenreList=array();

    //private $id;
    //private $name;
    public function GetAll(){
        $this->RetrieveData();
        return $this->GenreList;
    }

    public function Add($genre){
        $this->RetrieveData();
        array_push($this->GenreList,$genre);
        $this->SaveData();
    }
    
    public function Remove($id){
        $this->RetrieveData();

        foreach($this->GenreList as $key=>$genre){
            if($id == $genre->getid()){
                unset($this->GenreList[$id]);
                break;
            }
        }

    }

    public function GenreExist($nameToSearch){
        $this->RetrieveData();

        $flag=false;
        foreach($this->GenreList as $key=> $genre){
            if($genre->getName() == $nameToSearch){
                $flag=true;
            }
        }
        return $flag;
    }

    public function SaveData(){
        $arrayToEncode=array();

        foreach($this->GenreList as $genre){
            $valuesArray=array();
            $valuesArray["id"]=$genre->getid();
            $valuesArray["name"]=$genre->getName();
            array_push($arrayToEncode,$valuesArray);
        }
        $jsonContent =json_encode($arrayToEncode,JSON_PRETTY_PRINT);
        file_put_contents(dirname(__DIR__) . '/data/genre.json',$jsonContent);
    }

    public function RetrieveApi()
    {
        $apiContent = file_get_contents("https://api.themoviedb.org/3/genre/movie/list?api_key=f78530630a382b20d19bddc505aac95d&language=en-US");
        
        if ($apiContent){
            $arrayToDecode  = json_decode($apiContent,true); 
            foreach ($arrayToDecode['genres'] as $genre){
                $Newgenre = new Genre($genre["id"],$genre["name"]);
                array_push($this->GenreList, $Newgenre);             
            }
            
        }
    }

    public function RetrieveData(){
        $this->GenreList = array();

        if(file_exists(dirname(__DIR__) ."/data/genre.json")){
            
            $jsonContent = file_get_contents(dirname(__DIR__) . "/data/genre.json");
            
            if($jsonContent){
                
                $arrayToDecode = json_decode($jsonContent,true);
                foreach($arrayToDecode as $genre)
                {  
                    $valuesArray = array();

                    $Newgenre = new Genre($genre["id"],$genre["name"]);

                    array_push($this->GenreList, $Newgenre);   
                }
                
            } else {
                $this->RetrieveApi();
            }
            
        }else{
            $this->RetrieveApi();
        }  
    }
}


//Link de los generos de esta semana! 
//https://api.themoviedb.org/3/genre/movie/list?api_key=f78530630a382b20d19bddc505aac95d&language=en-US


?>