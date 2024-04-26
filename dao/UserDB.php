<?php

namespace Dao;

use Dao\AbstractDB as AbstractDB;
use model\User as User;
use model\Profile as Profile;
use model\Role as Role;
use Dao\CreditCardDB as CreditCardDB;

class UserDB extends AbstractDB
{

    public function GetAll()
    {

        $sql =  "SELECT us.email,us.pass,us.roleName,p.UserName,p.UserLastName,p.Dni,p.TelephoneNumber
                    FROM
                        Users AS us
                    INNER JOIN
                        UserProfiles AS p
                    ON us.usersProfileId = p.idProfile";

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


    public function Add($user, $profileId)
    {
        //se tiene que llamar pass en lugar de password, por que sino tira error, parece que es una palabra reservada
        $sql = "INSERT INTO Users (email,pass,roleName,usersProfileId) VALUES (:email,:pass,:roleName,:usersProfileId)";

        $values["email"]           = $user->GetEmail();
        $values["pass"]            = $user->GetPass();
        $values["roleName"]        = $user->GetRole()->GetRoleName();
        $values["usersProfileId"]  = $profileId;

        try {

            return $this->connection->ExecuteNonQuery($sql, $values);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function Modify($oldEmail, $user)
    {
        $sql = "UPDATE Users SET Users.email=:email,Users.pass=:pass,Users.roleName=:roleName,Users.usersProfileId=:usersProfileId
        WHERE Users.email=:oldEmail";

        $values['email']          = $user->GetEmail();
        $values['pass']           = $user->GetPass();
        $values['roleName']       = $user->GetRole()->GetRoleName;
        $values['usersProfileId'] = $user->GetProfile()->getId();
        $values['oldEmail']       = $oldEmail;
    }
    public function DeleteByEmail($email)
    {
        $sql = "DELETE FROM Users WHERE Users.email = :email";
        $values['email'] = $email;

        try {

            $this->connection->ExecuteNonQuery($sql, $values);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    /*public function GetById($idUser){
        $sql = "SELECT * FROM Users WHERE Users.idUser = :idUser";
        $values['idUser'] = $idUser;

        try{

            return $this->connection->Execute($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }*/

    public function GetByEmail($email)
    {
        $sql = "SELECT * FROM Users WHERE Users.email = :email";
        $values['email'] = $email;

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
        $resp = array_map(function ($u) {

            $ccDB = new CreditCardDB();
            $list = $ccDB->RetrieveByEmail($u['email']);
            $profileDB = new ProfileDB();
            $profile = $profileDB->GetProfileById($u['usersProfileId']);
            $role = new Role($u['roleName']);
            return new User($u['email'], $u['pass'], $role, $profile, $list);
        }, $value);

        return count($resp) > 1 ? $resp : $resp['0'];
    }
}
