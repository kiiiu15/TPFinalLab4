<?php
namespace Dao;
use \PDO as PDO;
use \Exception as Exception;
use Dao\QueryType as QueryType;
use model\CreditCard as CreditCard;

class CreditCardDB{
    private $connection;

    public function __construct(){
        
    }

    public function GetAll(){
       
    }

    public function Add($creditCard){
        $sql = "INSERT INTO CreditCards (company,`number`,securityCode,expiryMonth,expiryYear) VALUES (:company,:number,:securityCode,:expiryMonth,:expiryYear)";      
        
        $values["company"]      = $creditCard->getCompany();
        $values["number"]       = $creditCard->getNumber();
        $values["securityCode"] = $creditCard->getSecurityCode();
        $values["expiryMonth"]  = $creditCard->getExpiryMonth();
        $values["expiryYear"]   = $creditCard->getExpiryYear();

        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }
    }

    public function RetrieveByEmail($email){
        $sql = "SELECT * 
                FROM 
                    CreditCards AS CC
                INNER JOIN
                     CreditCardPerUser AS CCPU
                ON CC.number = CCPU.CreditCardNumber
                WHERE CCPU.emailUser = :emailUser";
        $values['emailUser'] = $email;

        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            $result = $this->connection->Execute($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }

    public function RetrieveByNumber($number){
        $sql = "SELECT * FROM CreditCards WHERE CreditCards.number = :numberCreditCard";
        $values['numberCreditCard'] = $number;

        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            $result = $this->connection->Execute($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }
    
    protected function Map($value) {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($c) {
        return new CreditCard( $c['company'], $c['number'], $c['securityCode'], $c['expiryMonth'], $c['expiryYear'] );
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }



}

?>