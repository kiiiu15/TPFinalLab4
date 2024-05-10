<?php

namespace Dao;

use Dao\AbstractDB as AbstractDB;
use model\Cinema as Cinema;

class CinemaDB extends AbstractDB
{

    public function GetAll()
    {
        $sql = "SELECT * FROM Cinemas";
        return $this->Execute($sql);
    }

    public function Add($cinema)
    {
        $sql = "INSERT INTO Cinemas (nameCinema,adressCinema,active) VALUES (:nameCinema,:address,:active)";

        $values['nameCinema'] = $cinema->getName();
        $values['address']    = $cinema->getAddress();
        $values['active']     = $cinema->getActive();

        return $this->ExecuteNonQuery($sql, $values);
    }

    public function DeactivateByID($idCinema)
    {
        $sql = "UPDATE Cinemas set Cinemas.active=:false WHERE Cinemas.idCinema=:idCinema";
        $values['false'] = false;
        $values['idCinema'] = $idCinema;

        return $this->ExecuteNonQuery($sql, $values);
    }

    public function ReactivateByID($idCinema)
    {
        $sql = "UPDATE Cinemas set Cinemas.active=:false WHERE Cinemas.idCinema=:idCinema";
        $values['false'] = true;
        $values['idCinema'] = $idCinema;

        return $this->ExecuteNonQuery($sql, $values);
    }

    public function Deactivate($cinema)
    {
        $sql = "UPDATE Cinemas set Cinemas.active= :false WHERE Cinemas.idCinema=:idCinema";
        $values['false'] = false;
        $values['idCinema'] = $cinema->getIdCinema();

        return $this->ExecuteNonQuery($sql, $values);
    }



    public function ChangeAddress($cinema)
    {
        $sql = "UPDATE Cinemas set Cinemas.adressCinema=:address WHERE Cinemas.idCinema=:idCinema";
        $values['address'] = $cinema->getAddress();

        return $this->ExecuteNonQuery($sql, $values);
    }

    public function Delete($cinema)
    {
        $sql = "DELETE FROM Cinemas WHERE Cinemas.idCinema=:idCinema";
        $values['idCinema'] = $cinema->getIdCinema();

        return $this->ExecuteNonQuery($sql, $values);
    }



    public function RetrieveByAddress($address)
    {
        $sql = "SELECT * FROM Cinemas WHERE Cinemas.adressCinema=:address";
        $values['address'] = $address;

        return $this->Execute($sql, $values);
    }

    //puede ser activado o desactivado
    public function RetrieveByActive($active)
    {
        $sql = "SELECT * FROM Cinemas WHERE Cinemas.active=:active";
        $values['active'] = $active;

        return $this->Execute($sql, $values);
    }

    public function RetrieveById($id)
    {
        $sql = "SELECT * FROM Cinemas WHERE Cinemas.idCinema=:id";
        $values['id'] = $id;

        return $this->Execute($sql, $values);
    }

    public function RetrieveByName($nameCinema)
    {
        $sql = "SELECT * FROM Cinemas WHERE Cinemas.nameCinema=:nameCinema";
        $values['nameCinema'] = $nameCinema;

        return $this->Execute($sql, $values);
    }

    public function Modify($cinema)
    {

        $sql = "UPDATE  Cinemas SET Cinemas.nameCinema=:nameCinema,Cinemas.adressCinema=:address WHERE Cinemas.idCinema=:idCinema";

        $values['nameCinema']     = $cinema->getName();
        $values['address']  = $cinema->getAddress();
        $values['idCinema'] = $cinema->getIdCinema();

        return  $this->ExecuteNonQuery($sql, $values);
    }


    public function GetIDCinemaActiva()
    {
        $cinemas = $this->RetrieveByActive(true);
        $ids = array();
        foreach ($cinemas as $cinema) {
            array_push($ids, $cinema->getIdCinema());
        }
        return $ids;
    }

    protected function Map($value)
    {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($c) {
            return new Cinema($c['idCinema'], $c['nameCinema'], $c['adressCinema'], (($c['active'] == 1) ? true : false));
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }
}
