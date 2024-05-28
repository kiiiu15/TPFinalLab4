<?php

namespace controllers;

use phpqrcode\QRcode as QRcode;
use controllers\Icontrollers as Icontrollers;
use Dao\TicketDB as TicketDB;

class TicketController implements Icontrollers
{
    private $ticketDB;

    public function __construct()
    {
        $this->ticketDB = new TicketDB();
    }

    public function Add($ticket)
    {
        try {
            $this->ticketDB->Add($ticket);
        } catch (\PDOException $ex) {
            echo "Error connection";
        }
    }

    public function GetAll()
    {
        try {
            $ticketList = $this->ticketDB->GetAll();
            return $ticketList;
        } catch (\PDOException $ex) {
            return array();
        }
    }

    public function Delete($ticket)
    {
        try {
            $this->ticketDB->Delete($ticket);
        } catch (\PDOException $ex) {
            echo "Error Connection";
        }
    }

    public function RetrieveById($idTicket)
    {
        try {
            $ticket = $this->ticketDB->RetrieveById($idTicket);
            return $ticket;
        } catch (\PDOException $ex) {
            return null;
        }
    }

    public function RetrieveByIdBuy($idBuy)
    {
        try {
            $ticket = $this->ticketDB->RetrieveByIdBuy($idBuy);
            return $ticket;
        } catch (\PDOException $ex) {
            return null;
        }
    }

    public function RetrieveByUser($user)
    {
        try {
            return $this->ticketDB->RetrieveByUser($user);
        } catch (\Throwable $th) {
            return array();
        }
    }

    public function GenerateRandomString($length = 4)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function GenerateQR($randomString)
    {
        $dir = 'QRS/';
        if (!file_exists($dir)) {
            mkdir($dir);
        } else {
            $filename = $dir . $randomString . '.png';
            $tamanio = 10;
            $level = 'M';
            $frameSize = 3;
            $content = $randomString;

            QRcode::png($content, $filename, $level, $tamanio, $frameSize);
        }
    }

    public function index()
    {
    }
}
