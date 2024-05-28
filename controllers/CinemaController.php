<?php

namespace controllers;

use Dao\CinemaDB;
use Model\Cinema;

class CinemaController implements IControllers
{
    private $cinemaDB;

    public function __construct()
    {
        $this->cinemaDB = new CinemaDB();
    }

    public function Add($cinemaName, $address)
    {
        $cinema = new Cinema(100, $cinemaName, $address, true);
        
        try {
            $this->cinemaDB->Add($cinema);
        } catch (\PDOException $ex) {
            $this->index('There was an error with the connection, please try again');
        }
        $this->index();
    }

    public function GetAll()
    {
        try {
            return $this->cinemaDB->GetAll();
        } catch (\PDOException $ex) {
            $this->index('There was an error with the connection, please try again');
        }
    }

    public function Deactivate($idCinema = 0)
    {
        try {
            $idCinema = $this->TransformToArray($idCinema);
            foreach ($idCinema as $id) {
                $this->cinemaDB->DeactivateByID($id);
            }
        } catch (\PDOException $ex) {
            $this->index('There was an error with the connection, please try again');
        }
        $this->index();
    }

    public function RetrieveByActive($active)
    {
        try {
            return $this->cinemaDB->RetrieveByActive($active);
        } catch (\PDOException $ex) {
            $this->index('There was an error with the connection, please try again');
        }
    }

    public function RetrieveById($id)
    {
        try {
            return $this->cinemaDB->RetrieveById($id);
        } catch (\PDOException $ex) {
            $this->index('There was an error with the connection, please try again');
        }
    }

    public function Reactivate($idCinema = 0)
    {
        $idCinema = $this->TransformToArray($idCinema);
        try {
            foreach ($idCinema as $id) {
                $this->cinemaDB->ReactivateByID($id);
            }
        } catch (\PDOException $ex) {
            throw $ex;
        }
        $this->index();
    }

    public function ChangeCinemaState($newState, $ids = array())
    {
        try {
            if (filter_var($newState, FILTER_VALIDATE_BOOLEAN)) {
                $this->Reactivate($ids);
            } else {
                $this->Deactivate($ids);
            }
        } catch (\PDOException $ex) {
            $this->index('There was an error with the connection, please try again');
        }
    }

    public function Modify($idCinemaToModify, $changedName, $changedAddress)
    {
        try {
            $this->cinemaDB->Modify(new Cinema($idCinemaToModify, $changedName, $changedAddress, true));
        } catch (\PDOException $ex) {
            $this->index('There was an error with the connection, please try again');
        }

        $this->index();
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
        $cinemaList = $this->GetAll();
        include(PAGES . "/cinema.php");
    }
}

