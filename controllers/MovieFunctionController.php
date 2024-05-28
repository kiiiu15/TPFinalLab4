<?php

namespace controllers;

use controllers\IControllers as IControllers;
use model\MovieFunction as MovieFunction;
use dao\RoomDB as RoomDB;
use dao\MovieDB as MovieDB;
use dao\MovieFunctionDB as MovieFunctionDB;

class MovieFunctionController implements IControllers
{
    private $movieFunctionDB;
    private $movieDB;
    private $roomDB;

    public function __construct()
    {
        $this->movieFunctionDB = new MovieFunctionDB();
        $this->movieDB = new MovieDB();
        $this->roomDB = new RoomDB();
    }

    public function Add($idMovie = 0, $idRoom = 1, $date = "", $hour = "")
    {
        $movie = $this->movieDB->RetrieveById($idMovie);
        $room = $this->roomDB->RetrieveById($idRoom);

        $movieFunction = new MovieFunction(0, $date, $hour, $room, $movie);
        $answer = $this->CheckMovieFunction($movieFunction);
        if ($answer === '') {
            $this->movieFunctionDB->Add($movieFunction);
            $this->index();
        } else {
            $this->index($answer);
        }
    }

    public function CheckMovieFunction($movieFunction)
    {
        $answer = '';

        try {
            $functions = $this->movieFunctionDB->RetrieveByDate($movieFunction->getDay());
            $functions = $this->TransformToArray($functions);

            if (count($functions) > 0) {
                $answer = $this->CheckByRoom($movieFunction, $functions);
                if ($answer === '') {
                    $answer = $this->CheckByFunctionsInRoom($movieFunction, $functions);
                }
            }

            return $answer;
        } catch (\Throwable $th) {
            return 'Connection error';
        }
    }

    private function CheckByFunctionsInRoom($movieFunction, $functions)
    {
        $answer = '';
        $room = $movieFunction->getRoom();
        $cinema = $room->getCinema();

        $functionsPerCinema = $this->GroupFunctionsByCinema($functions);
        $functionsForTheDay = array();

        if (isset($functionsPerCinema[$cinema->getIdCinema()])) {
            $functionsForTheDay = $functionsPerCinema[$cinema->getIdCinema()];
            $functionsGroupedByRoom = $this->GroupFunctionsRoom($functionsForTheDay);

            if (isset($functionsGroupedByRoom[$room->getId()])) {
                $functionsAtRoom = $functionsGroupedByRoom[$room->getId()];

                $roomForTheDay = $functionsAtRoom[0]->getRoom();

                if ($roomForTheDay->getId() == $room->getId()) {
                    $answer = $this->CheckTime($movieFunction, $functionsAtRoom);
                } else {
                    $answer = "A movie can be watch just on one specific room of an specific cinema per day";
                }
            }
        }
        return $answer;
    }

    private function CheckByRoom($movieFunction, $functions)
    {
        $answer = '';
        $movie = $movieFunction->getMovie();
        $room = $movieFunction->getRoom();
        $functionsGroupedByMovie = $this->GroupFunctionsByMovie($functions);

        if (isset($functionsGroupedByMovie[$movie->getId()])) {
            $movieFunctions = $functionsGroupedByMovie[$movie->getId()];

            if (count($movieFunctions) > 0) {
                $roomOfMovieForTheDay = $movieFunctions[0]->getRoom();

                if ($roomOfMovieForTheDay->getId() != $room->getId()) {
                    $answer = "A movie can only be played in one room per day. Change date or choose the same room.";
                }
            }
        }
        return $answer;
    }

    private function CheckTime($movieFunction, $functions)
    {
        $answer = '';
        foreach ($functions as $function) {
            $minTime = $this->AddTime($function->getHour(), -135);
            $maxTime = $this->AddTime($function->getHour(), 135);

            if ($movieFunction->getHour() > $function->getHour()) {
                if ($movieFunction->getHour() < $maxTime) {
                    $answer = "The time is set with another function in the same Cinema room, please change the time or the room";
                    break;
                }
            } else {
                if ($minTime < $movieFunction->getHour()) {
                    $answer = "The time is set with another function in the same Cinema room, please change the time or the room";
                    break;
                }
            }

            if ($movieFunction->getHour() < '02:15:00') {
                if ($function->getHour() < '02:15:00') {
                    $answer = "The time is set with another function in the same Cinema room, please change the time or the room";
                    break;
                }
            } elseif ($movieFunction->getHour() > '21:45:00') {
                if ($function->getHour() > '21:45:00') {
                    $answer = "The time is set with another function in the same Cinema room, please change the time or the room";
                    break;
                }
            }
        }

        return $answer;
    }

    private function TransformToArray($value)
    {
        if ($value == false) {
            $value = array();
        }

        if (!is_array($value)) {
            $value = array($value);
        }

        return $value;
    }

    private function AddTime($hora, $minutos_sumar)
    {
        $minutoAnadir = $minutos_sumar;
        $segundos_horaInicial = strtotime($hora);
        $segundos_minutoAnadir = $minutoAnadir * 60;
        $nuevaHora = date("H:i:s", $segundos_horaInicial + $segundos_minutoAnadir);
        return $nuevaHora;
    }

    public function GroupFunctionsRoom($functions)
    {
        $array = array();
        $functions = $this->TransformToArray($functions);
        foreach ($functions as $function) {
            $room = $function->getRoom();
            $array[$room->getId()][] = $function;
        }

        return $array;
    }

    public function GroupFunctionsByMovie($functions)
    {
        $array = array();
        $functions = $this->TransformToArray($functions);
        foreach ($functions as $function) {
            $movie = $function->getMovie();
            $array[$movie->getId()][] = $function;
        }

        return $array;
    }

    public function GroupFunctionsByCinema($functions)
    {
        $array = array();
        $functions = $this->TransformToArray($functions);
        foreach ($functions as $function) {
            $cinema = $function->getRoom()->getCinema();
            $array[$cinema->getIdCinema()][] = $function;
        }

        return $array;
    }

    public function GetMovieByDate($date)
    {
        try {
            $functions = $this->movieFunctionDB->RetrieveByDate($date);
            $movies = array();
            $functions = $this->TransformToArray($functions);

            foreach ($functions as $function) {
                $movie = $function->getMovie();
                $movies[$movie->getId()] = $movie;
            }
            return $movies;
        } catch (\Throwable $th) {
            return array();
        }
    }

    public function GetAll()
    {
        try {
            return $this->movieFunctionDB->GetAll();
        } catch (\Throwable $th) {
            return array();
        }
    }

    public function GetBillboard()
    {
        try {
            return $this->movieFunctionDB->RetrieveBillboard();
        } catch (\Throwable $th) {
            return array();
        }
    }

    public function GetBillboardMovies()
    {
        $functions = $this->GetBillboard();
        $functions = $this->TransformToArray($functions);
        $movies = array();
        foreach ($functions as $function) {
            $movie = $function->getMovie();
            $movies[$movie->getId()] = $movie;
        }
        return $movies;
    }

    public function GetById($idToSearch)
    {
        try {
            return $this->movieFunctionDB->RetrieveById($idToSearch);
        } catch (\Throwable $th) {
            return array();
        }
    }

    public function Delete($idFunction = 0)
    {
        try {
            $idFunction = $this->TransformToArray($idFunction);
            foreach ($idFunction as $id) {
                $function = $this->movieFunctionDB->RetrieveById($id);
                $this->movieFunctionDB->Delete($function);
            }
            $this->index();
        } catch (\Throwable $th) {
            $this->index("DB Connection Error");
        }
    }

    public function GetShowMovieInfo($idMovie)
    {
        $functions = $this->GetBillboard();
        $functions = $this->TransformToArray($functions);

        $groupedFunctions = $this->GroupFunctionsByMovie($functions);

        if (isset($groupedFunctions[$idMovie])) {
            $movieFunctions = $groupedFunctions[$idMovie];
            $info = $this->GroupFunctionsByCinema($movieFunctions);
        } else {
            $info = array();
        }

        return $info;
    }

    public function prueba($param)
    {
        $a = $this->GetShowMovieInfo($param);
        $json = json_encode($a, JSON_PRETTY_PRINT);
        echo $json;
    }

    public function fetchAndUpdateFromApi()
    {
        try {
            $genreController = new GenreController();
            $genreController->RetrieveAPI();

            $movieController = new MovieController();
            $movieController->RetrieveAPI();

            $response = json_encode(["ok" => true], JSON_PRETTY_PRINT);
            echo $response;
        } catch (\Throwable $th) {
            $response = json_encode(["ok" => false], JSON_PRETTY_PRINT);
            echo $response;
        }
    }

    public function index($mensaje = null)
    {
        $errorMje = $mensaje;
        $roomC = new RoomController();
        $movieC = new MovieController();
        $movies = $movieC->GetAll();
        $activeRooms = $roomC->RetrieveByActive(true);
        $movieFunctionList = $this->GetBillboard();

        include(PAGES . '/function.php');
    }
}