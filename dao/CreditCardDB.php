<?php

namespace Dao;

use Dao\AbstractDB as AbstractDB;
use model\CreditCard as CreditCard;

class CreditCardDB extends AbstractDB
{
    public function GetAll()
    {
        $sql = "SELECT * FROM CreditCards";
        try {
            $result = $this->connection->Execute($sql);
        } catch (\PDOException $ex) {
            throw $ex;
        }
        if (!empty($result)) {
            return $this->Map($result);
        } else {
            return false;
        }
    }

    public function Add($creditCard)
    {
        $sql = "INSERT INTO CreditCards (company,`number`,securityCode,expiryMonth,expiryYear) VALUES (:company,:number,:securityCode,:expiryMonth,:expiryYear)";

        $values["company"]      = $creditCard->getCompany();
        $values["number"]       = $creditCard->getNumber();
        $values["securityCode"] = $creditCard->getSecurityCode();
        $values["expiryMonth"]  = $creditCard->getExpiryMonth();
        $values["expiryYear"]   = $creditCard->getExpiryYear();

        try {

            return $this->connection->ExecuteNonQuery($sql, $values);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function Modify($oldNumber, $CreditCard)
    {
        $sql = "UPDATE CreditCards SET CreditCards.company = :company,CreditCards.number = :number,
        CreditCards.securityCode = :securityCode, CreditCards.expiryMonth = :expiryMonth ,CreditCards.expiryYear = :expiryYear
        WHERE CreditCards.number = :oldNumber";

        $values['company']      = $CreditCard->getCompany();
        $values['number']       = $CreditCard->getNumber();
        $values['securityCode'] = $CreditCard->getSecurityCode();
        $values['expiryMonth']  = $CreditCard->getExpiryMonth();
        $values['expiryYear']   = $CreditCard->getExpiryYear();
        $values['oldNumber']    = $oldNumber;


        try {

            return $this->connection->ExecuteNonQuery($sql, $values);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function Delete($number)
    {
        $sql = "DELETE FROM CreditCards WHERE CreditCards.number = :number";

        $values['number'] = $number;

        try {

            return $this->connection->ExecuteNonQuery($sql, $values);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }


    public function RetrieveByEmail($email)
    {
        $sql = "SELECT * 
                FROM 
                    CreditCards AS CC
                INNER JOIN
                     CreditCardPerUser AS CCPU
                ON CC.number = CCPU.CreditCardNumber
                WHERE CCPU.emailUser = :emailUser";
        $values['emailUser'] = $email;

        try {

            $result = $this->connection->Execute($sql, $values);
        } catch (\PDOException $ex) {
            throw $ex;
        }
        if (!empty($result)) {
            return $this->Map($result);
        } else {
            return false;
        }
    }

    public function RetrieveByNumber($number)
    {
        $sql = "SELECT * FROM CreditCards WHERE CreditCards.number = :numberCreditCard";
        $values['numberCreditCard'] = $number;

        try {

            $result = $this->connection->Execute($sql, $values);
        } catch (\PDOException $ex) {
            throw $ex;
        }
        if (!empty($result)) {
            return $this->Map($result);
        } else {
            return false;
        }
    }

    protected function Map($value)
    {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($c) {
            return new CreditCard($c['company'], $c['number'], $c['securityCode'], $c['expiryMonth'], $c['expiryYear']);
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }
}
