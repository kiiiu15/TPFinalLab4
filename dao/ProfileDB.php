<?php

namespace Dao;

use Dao\AbstractDB as AbstractDB;
use model\Profile as Profile;

class ProfileDB extends AbstractDB
{

    public function GetAll()
    {
        $sql = "SELECT * FROM UserProfiles";

        return $this->Execute($sql);
    }


    public function Add($profile)
    {
        $sql = "INSERT INTO UserProfiles (UserName,UserlastName,dni,telephoneNumber) VALUES (:UserName,:UserlastName,:dni,:telephoneNumber)";

        $values["UserName"]        = $profile->GetName();
        $values["UserlastName"]    = $profile->GetLastName();
        $values["dni"]             = $profile->GetDni();
        $values["telephoneNumber"] = $profile->GetTelephoneNumber();

        $this->ExecuteNonQuery($sql, $values);

        $profileId = $this->GetLastId();

        return $profileId;
    }

    //supongo que hay una mejor forma de hacerlo....
    public function GetLastId()
    {
        $sql = "SELECT MAX(idProfile) AS idProfile FROM UserProfiles";

        $result = $this->Execute($sql);

        if (!$result) {
            return false;
        }
        return $result[0][0];
    }

    public function GetProfileById($idProfile)
    {

        $sql = "SELECT * FROM UserProfiles up WHERE up.idProfile = :idProfile";
        $values['idProfile'] = $idProfile;

        return $this->Execute($sql, $values);
    }

    public function Modify($profile)
    {
        $sql = "UPDATE UserProfiles SET UserProfiles.UserName=:UserName,UserProfiles.UserLastName=:UserLastName,
        UserProfiles.dni=:Dni,UserProfiles.telephoneNumber=:telephoneNumber
        WHERE UserProfiles.idProfile=:idProfile";

        $values['UserName'] = $profile->getUserName();
        $values['UserLastName'] = $profile->getUserLastName();
        $values['Dni'] = $profile->getDni();
        $values['telephoneNumber'] = $profile->getTelephoneNumber();
        $values['idProfile'] = $profile->getIdProfile();

        return $this->ExecuteNonQuery($sql, $values);
    }

    public function Delete($profileId)
    {
        $sql = "DELETE FROM UserProfiles WHERE UserProfiles.idProfile = :idProfile";

        $values['idProfile'] = $profileId;

        return $this->ExecuteNonQuery($sql, $values);
    }

    protected function Map($value)
    {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($p) {
            return new Profile($p['idProfile'], $p['UserName'], $p['UserlastName'], $p['dni'], $p['telephoneNumber']);
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }
}
