<?php

namespace Dao;


use Dao\AbstractDB as AbstractDB;
use model\Movie as Movie;
use Dao\GenreDB as GenreDB;
use Dao\GenresPerMovieDB as GenresPerMovieDB;

class MovieDB extends AbstractDB
{
    public function GetAll()
    {
        $sql = "SELECT * FROM Movies";

        return $this->Execute($sql);
    }


    public function Add($movie)
    {
        $sql = "INSERT INTO Movies (idMovie,tittle,language,overview,releaseDate,poster) VALUES (:idMovie,:tittle,:language,:overview,:releaseDate,:poster)";

        $values['idMovie']     = $movie->getId();
        $values['tittle']      = $movie->getTitle();
        $values['language']    = $movie->getLanguage();
        $values['overview']    = $movie->getOverview();
        $values['releaseDate'] = $movie->getReleaseDate();
        $values['poster']      = explode('https://image.tmdb.org/t/p/w200', $movie->getPoster())[1];

        $genrePerMovie = $movie->getGenres();

        $this->ExecuteNonQuery($sql, $values);

        $genrePerMovieDB = new GenresPerMovieDB();

        foreach ($genrePerMovie as $genreMovie) {
            $genrePerMovieDB->Add($movie->getId(), $genreMovie);
        }
    }
    public function Modify($Movie)
    {
        $sql = "UPDATE Movies SET Movies.tittle=:tittle,Movies.Language=:Language,Movies.overview=:overview,
        Movies.ReleaseDate=:ReleaseDate,Movies.Poster=:Poster
        WHERE Movies.idMovie = :idMovie";

        $values['tittle'] = $Movie->getTitle();
        $values['Language'] = $Movie->getLanguage();
        $values['overview'] = $Movie->getOverview();
        $values['ReleaseDate'] = $Movie->getReleaseDate();
        $values['Poster'] = $Movie->getPoster();
    }

    public function RetrieveById($idMovie)
    {
        $sql = "SELECT * FROM Movies WHERE Movies.idMovie=:idMovie";
        $values['idMovie'] = $idMovie;

        return $this->Execute($sql, $values);
    }

    public function RetrieveByGenre($genreId)
    {
        $sql = "SELECT * FROM Movies INNER JOIN GenresPerMovie ON Movies.idMovie = GenresPerMovie.idMovie INNER JOIN Genres ON GenresPerMovie.idGenre = Genres.idGenre WHERE Genres.idGenre = :idGenre";
        $values['idGenre'] = $genreId;

        return $this->Execute($sql, $values);
    }

    public function RetrieveByTitle($title)
    {
        $sql = "SELECT * FROM Movies WHERE Movies.tittle=:title";
        $values['title'] = $title;

        return $this->Execute($sql, $values);
    }

    public function RetrieveByReleaseDate($releaseDate)
    {
        $sql = "SELECT * FROM Movies WHERE Movies.releaseDate=:releaseDate";
        $values['releaseDate'] = $releaseDate;

        return $this->Execute($sql, $values);
    }

    public function Delete($movie)
    {
        $sql = "DELETE FROM Movies WHERE Movies.tittle=:title";
        $values['tittle'] = $movie->getTitle();

        return $this->ExecuteNonQuery($sql, $values);
    }



    /* Esta funcion tiene por finalidad recuperar TODOS los ids de genreos qe tenga asociada la pelicula con id que se reciba por parametro*/
    public function GetGenresIdsForMovie($idMovie)
    {
        $sql = "SELECT idGenre FROM GenresPerMovie WHERE GenresPerMovie.idMovie = :idMovie";
        $values["idMovie"] = $idMovie;

        $result = $this->connection->Execute($sql, $values);
      
        $genresIDs = [];
        foreach ($result as $genreArray) {
            $genresIDs[] = $genreArray["idGenre"];
        }

        return $genresIDs;
    }

    public function GetGenresForMovie($idMovie)
    {
        $genresIds = $this->GetGenresIdsForMovie($idMovie);
        return $this->GetObjectGenresForMovie($genresIds);
    }

    public function GetObjectGenresForMovie($genreIdsForTheMovie)
    {
        $genreDB = new GenreDB();
        $genresForMovie = array();
        foreach ($genreIdsForTheMovie as $genreId) {
            $genre = $genreDB->ExtractGenrebyId($genreId);
            array_push($genresForMovie, $genre);
        }
        return $genresForMovie;
    }

    protected function Map($value)
    {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($m) {
            return new Movie($m['idMovie'], $m['tittle'], $m['language'], $m['overview'], $m['releaseDate'], $m['poster'], $this->GetGenresForMovie($m['idMovie']));
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }
}
