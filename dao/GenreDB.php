<?php

namespace Dao;


use Dao\AbstractDB as AbstractDB;
use model\Genre as Genre;

class GenreDB extends AbstractDB
{

    public function GetAll()
    {
        $sql = "SELECT * FROM Genres";

        return $this->Execute($sql);
    }

    public function ExtractGenrebyId($Id)
    {
        $sql = "SELECT *FROM Genres WHERE Genres.idGenre = :idGenre";
        $values['idGenre'] = $Id;

        return $this->Execute($sql, $values);
    }

    public function GenreExist($nameToSearch)
    {
        $sql = "SELECT  IFNULL(COUNT(Genres.nameGenre), 0 ) as Cantidad FROM Genres WHERE Genres.nameGenre = :nameGenre GROUP BY Genres.nameGenre";
        $values['nameGenre'] = $nameToSearch;

        $result = $this->Execute($sql, $values);

        if (isset($result) && !empty($result) && $result[0]["Cantidad"] > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function Add($genre)
    {
        $sql = "INSERT INTO Genres (idGenre , nameGenre) VALUES (:idGenre , :nameGenre)";
        $values['idGenre'] = $genre->getId();
        $values['nameGenre'] = $genre->getName();

        return $this->ExecuteNonQuery($sql, $values);
    }

    public function Delete($id)
    {
        $sql = "DELETE FROM Genres WHERE Genres.idGenre = :idGenre";
        $values['idGenre'] = $id;

        return $this->ExecuteNonQuery($sql, $values);
    }

    public function Modify($genre)
    {
        $sql = "UPDATE Genres SET Genres.nameGenre = :nameGenre WHERE Genres.idGenre = :idGenre";

        $values['idGenre'] = $genre->getId();
        $values['nameGenre'] = $genre->getName();

        return $this->ExecuteNonQuery($sql, $values);
    }

    protected function Map($value)
    {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($g) {
            return new Genre($g['idGenre'], $g['nameGenre']);
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }
}
