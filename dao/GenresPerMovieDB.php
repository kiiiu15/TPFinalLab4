<?php

namespace Dao;


use Dao\AbstractDB as AbstractDB;

class GenresPerMovieDB extends AbstractDB
{

    public function GetAll()
    {
        $sql = "SELECT * FROM GenresPerMovie";

        return $this->Execute($sql);
    }


    public function Add($idMovie, $genre)
    {
        $sql = "INSERT INTO GenresPerMovie (idMovie, idGenre) VALUES (:idMovie,:idGenre)";

        $values['idMovie'] = $idMovie;
        $values['idGenre'] = $genre->getId();

        return $this->ExecuteNonQuery($sql, $values);
    }

    public function Modify($oldIdMovie, $oldIdGenre, $newMovie, $newGenre)
    {
        $sql = "UPDATE GenresPerMovie SET GenresPerMovie.idMovie=:idMovie, GenresPerMovie.idGenre=:idGenre
        WHERE GenresPerMovie.idMovie=:oldIdMovie AND GenresPerMovie.idGenre=:oldIdGenre";

        $values['idMovie'] = $newMovie;
        $values['idGenre'] = $newGenre;
        $values['oldIdMovie'] = $oldIdMovie;
        $values['oldIdGenre'] = $oldIdGenre;

        return $this->ExecuteNonQuery($sql, $values);
    }

    public function Delete($idMovie, $idGenre)
    {
        $sql = "DELETE FROM GenresPerMovie WHERE GenresPerMovie.idMovie = :idMovie AND GenresPerMovie.idGenre = :idGenre";

        $values['idMovie'] = $idMovie;
        $values['idGenre'] = $idGenre;

        return $this->ExecuteNonQuery($sql, $values);
    }

    protected function Map($value)
    {
        /* $db = new GenreDB();
        return $db->Map($value);
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($g) {
            return new Genre($g['idGenre'], $g['nameGenre']);
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];*/
    }
}
