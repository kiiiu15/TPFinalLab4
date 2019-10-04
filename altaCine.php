<?php
include_once("config/autoload.php");
use config\autoload as autoload;
use model\Cine as Cine;
use repository\CineRepository as CineRepository;
use repository\IRepository as IRepository;
autoload::Start();

if($_POST && isset($_POST)){
    $idCine=$_POST["id"];
    $nombre=$_POST["nombre"];
    $direccion=$_POST["direccion"];
    $capacidad=$_POST["capacidad"];
    $valorEntrada=$_POST["valor"];

    $cine= new Cine($idCine,$nombre,$direccion,$capacidad,$valorEntrada);

    $cineRepo= new CineRepository();

    $cineList= $cineRepo->GetAll();

    $cineExiste=false;

    foreach ($cineList as $key => $value) {
        if($value->getIdCine() == $cine->getIdCine()){
            $cineExiste=true;
            break;
        }
    }

    if(!$cineExiste){
        $cineRepo->Add($cine);
        echo "el cine fue creado exitosamente";
    }else{
        $Error='El Cine ya existe';
        echo "el cine ya fue creado anteriormente";
    }

}

?>