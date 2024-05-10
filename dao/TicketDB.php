<?php

namespace Dao;

use Dao\AbstractDB as AbstractDB;
use model\Ticket as Ticket;
use model\Buy as Buy;
use Dao\BuyDB as BuyDB;


class TicketDB extends AbstractDB
{


    public function Add($ticket)
    {
        $sql = "INSERT INTO Tickets(qr,idBuy) VALUES(:qr,:idBuy)";
        $values['qr'] = $ticket->getQR();
        $buy = $ticket->getBuy();
        $values['idBuy'] = $buy->getIdBuy();

        return $this->ExecuteNonQuery($sql, $values);
    }
    public function Modify($ticket)
    {
        $sql = "UPDATE Tickets SET Tickets.qr=:qr,Tickets.idBuy=:idBuy WHERE Tickets.id = :id";

        $values['qr'] = $ticket->getQR();
        $values['idBuy'] = $ticket->getBuy()->getIdBuy();
        $values['id'] = $ticket->getIdTicket();

        return $this->ExecuteNonQuery($sql, $values);
    }

    public function GetAll()
    {
        $sql = "SELECT * FROM Tickets";

        return $this->Execute($sql);
    }

    public function RetrieveById($idTicket)
    {
        $sql = "SELECT * FROM Tickets WHERE Tickets.idTicket=:idTicket";
        $values['idTicket'] = $idTicket;

        return $this->Execute($sql, $values);
    }

    public function RetrieveByIdBuy($idBuy)
    {
        $sql = "SELECT * FROM Tickets WHERE Tickets.idBuy=:idBuy";
        $values['idBuy'] = $idBuy;

        return $this->Execute($sql, $values);
    }

    public function RetrieveByUser($user)
    {
        $sql = "SELECT * FROM Tickets INNER JOIN Buy ON Buy.idBuy = Tickets.idBuy WHERE Buy.emailUser = :emailUser";
        $values['emailUser'] = $user;

        return $this->Execute($sql, $values);
    }

    public function Delete($ticket)
    {
        $sql = "DELETE FROM Tickets WHERE Tickets.idTicket=:idTicket";
        $values['idTickets'] = $ticket->getIdTicket();

        return $this->ExecuteNonQuery($sql, $values);
    }

    protected function Map($value)
    {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($b) {
            $buyDB = new BuyDB();
            return new Ticket($b['idTicket'], $b['qr'], $buyDB->RetrieveById($b['idBuy']));
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }
}
