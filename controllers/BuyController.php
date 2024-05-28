<?php

namespace controllers;

use Dao\BuyDB as BuyDB;
use Model\Buy as Buy;
use controllers\MovieFunctionController as MovieFunctionController;
use controllers\HomeController as HomeController;
use Controllers\SessionManager as SessionManager;

class BuyController implements Icontrollers
{
    private $buyDB;

    public function __construct()
    {
        $this->buyDB = new BuyDB();
    }

    public function ReciveBuy($idFunction = 0, $numberOfTickets = 0)
    {
        $_POST = null;

        if ($idFunction == 0 || $numberOfTickets <= 0) {
            header("location:" . FRONT_ROOT);
        }
        $homeController = new HomeController();
        $sessionManager = SessionManager::getInstance();
        $user = $sessionManager->GetUserLoged();  //obtengo el usuario

        if (!$user) {
            include(PAGES . "/login.php");
        } else {

            $moviefunctionController = new MovieFunctionController();
            $function = $moviefunctionController->GetById($idFunction);  //obtengo la funcion

            $roomController = new RoomController();
            $room = $function->getRoom(); //obtengo la sala

            //validacion sobre la capacidad de la sala
            if ($roomController->GetRemainingCapacity($idFunction, $numberOfTickets) > -1) {
                $date =  date("l");

                $today = date("Y-m-d");
                $id = date("Ymdhms");
                $discount = 0;
                $total = 0;

                //validacion del dia martes y miercoles     

                if ($date == "Tuesday" || $date == "Wednesday") {
                    if ($numberOfTickets >= 2) {
                        $discount = ($room->getPrice() * $numberOfTickets) * 0.25;
                    }
                    $total = ($room->getPrice() * $numberOfTickets) - $discount;
                } else {
                    $total =  $room->getPrice() * $numberOfTickets;
                }


                try {
                    $this->Add($id, $function, $today, $numberOfTickets, $total, $discount, $user, false);
                    $buy = $this->RetrieveById($id);

                    include(PAGES . "/payment.php");
                } catch (\Throwable $th) {
                    $homeController->index('There has been a problem with the buy please try again.');
                }
            } else {
                //Hacer que este mensaje aparezca como alerta 

                $alertCapacity = "We are sorry, there is not enought capacity in the room. Try in another room or function. ";
                $homeController->index($alertCapacity);
            }
        }
    }

    public function GetAll()
    {
        $listBuy = array();
        try {
            $listBuy = $this->buyDB->GetAll();
        } catch (\PDOException $ex) {
            $listBuy = array();
        }
        return $listBuy;
    }

    public function Add($idBuy = "", $movieFunction = null, $date = "", $numberOfTickets = 0, $total = 0, $discount = 0, $user = null, $state = false)
    {
        $buy = new Buy($idBuy, $movieFunction, $date, $numberOfTickets, $total, $discount, $user, $state);
        try {
            $this->buyDB->Add($buy);
        } catch (\PDOException $ex) {
            $this->index('There was an erro whit the connection, please try again');
        }
    }

    public function RetrieveById($idBuy)
    {
        $buy = new Buy();
        try {
            $buy = $this->buyDB->RetrieveById($idBuy);
        } catch (\PDOException $ex) {
            $this->index('There was an erro whit the connection, please try again');
        }
        return $buy;
    }

    public function RetrieveByUser($user)
    {
        $Arraybuy = array();
        try {
            $Arraybuy = $this->buyDB->RetrieveByUser($user);
        } catch (\PDOException $ex) {
            $this->index('There was an erro whit the connection, please try again');
        }
        return $Arraybuy;
    }

    public function ChangeState($idBuy)
    {
        try {
            $this->buyDB->ChangeState($idBuy);
        } catch (\PDOException $ex) {
            $this->index('There was an erro whit the connection, please try again');
        }
    }

    public function getTotalByDate($fromDate, $toDate, $cinema, $movie)
    {
        $homeController = new HomeController();
        //si no especifica cine ni pelicula se muestra el total de todas las ventas
        if ($cinema == "" && $movie == "") {

            try {
                $result = $this->buyDB->getTotalByDate($fromDate, $toDate);
                if ($result == null) {
                    $result = 0;
                }
                $this->Stats($result, -1);
            } catch (\PDOException $ex) {
                $this->Stats(-1, -1);
            }
        } else if ($cinema != "" && $movie == "") { //solo se selecciono un cine pero no pelicula

            try {
                $result = $this->buyDB->getTotalByCinema($fromDate, $toDate, $cinema);
                if ($result == null) {
                    $result = 0;
                }
                $this->Stats($result, -1);
            } catch (\PDOException $ex) {
                $this->Stats(-1, -1);
            }
        } else if ($cinema == "" && $movie != "") {

            try {
                $result = $this->buyDB->getTotalByMovie($fromDate, $toDate, $movie);
                if ($result == null) {
                    $result = 0;
                }
                $this->Stats($result, -1);
            } catch (\PDOException $ex) {
                $this->Stats(-1, -1);
            }
        } else if ($cinema != "" && $movie != "") {
            try {
                $result = $this->buyDB->getTotalByMovieAndCinema($fromDate, $toDate, $movie, $cinema);
                if ($result == null) {
                    $result = 0;
                }
                $this->Stats($result, -1);
            } catch (\PDOException $ex) {
                $this->Stats(-1, -1);
            }
        }
    }

    public function getTotalTicketsSold($fromDate, $toDate, $cinema, $movie)
    {
        $db = new BuyDB();
        //si no especifica cine ni pelicula se muestra el total de todas las ventas
        if ($cinema == "" && $movie == "") {

            try {
                $result = $db->getTotalTicketsSold($fromDate, $toDate);
                if ($result == null) {
                    $result = 0;
                }
                $this->Stats(-1, $result);
            } catch (\PDOException $ex) {
                $this->Stats(-1, -1);
            }
        } else if ($cinema != "" && $movie == "") { //solo se selecciono un cine pero no pelicula

            try {
                $result = $db->getTotalTicketsSoldByCinema($fromDate, $toDate, $cinema);
                if ($result == null) {
                    $result = 0;
                }
                $this->Stats(-1, $result);
            } catch (\PDOException $ex) {
                $this->Stats(-1, -1);
            }
        } else if ($cinema == "" && $movie != "") {

            try {
                $result = $db->getTotalTicketsSoldByMovie($fromDate, $toDate, $movie);
                if ($result == null) {
                    $result = 0;
                }
                $this->Stats(-1, $result);
            } catch (\PDOException $ex) {
                $this->Stats(-1, -1);
            }
        } else if ($cinema != "" && $movie != "") {
            try {
                $result = $db->getTotalTicketsSoldByCinemaAndMovie($fromDate, $toDate, $cinema, $movie);
                if ($result == null) {
                    $result = 0;
                }
                $this->Stats(-1, $result);
            } catch (\PDOException $ex) {
                $this->Stats(-1, -1);
            }
        }
    }

    public function Stats($total = -1, $totalTickets = -1, $mesage = null)
    {
        $totalSold = $total;
        $totalTicketsSold = $totalTickets;
        $errorMje = $mesage;

        if ($totalSold == -1) {
            $totalSold = "complete the form";
        }
        if ($totalTicketsSold == -1) {
            $totalTicketsSold = "complete the form";
        }
        try {
            $cinemaController = new CinemaController();
            $cinemaList = $cinemaController->GetAll();
            $movieController = new MovieController();
            $movieList = $movieController->GetAll();
            include(PAGES . "/stats.php");
        } catch (\PDOException $th) {
            $errorMje = "Problem retriving stats";
            include(PAGES . "/stats.php");
        }
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

    public function index($msg = null)
    {
        $errorMje = $msg;
        $ticketsC = new TicketController();
        $sessionManager = SessionManager::getInstance();
        $user = $sessionManager->GetUserLoged();

        $ticketsPurchased = $ticketsC->RetrieveByUser($user->getEmail());
        $ticketsPurchased = $this->TransformToArray($ticketsPurchased);
        include(PAGES . "/purchase.php");
    }
}
