<?php

?>

<form action="<?= FRONT_ROOT . "/Buy/getTotalByDate" ?>" method="post">
    <h5>check totals by date / cinema / movie</h5>

    <label>fecha desde</label>
    <input type="date" required name="fromDate">
    <label>fecha hasta</label>
    <input type="date" required name="toDate">
    <label>Cinemas</label>
    <select name="cinema">
        <option value="">Any</option>
    <?php 
    foreach ($cinemaList as $cinema) {
    ?>    
        <option value="<?= $cinema->getIdCinema() ?>"><?= $cinema->getName() ?></option>
    <?php
    }
    ?>
    </select>
    <label>Movies</label>
    <select name="movie">
        <option value="">Any</option>
    <?php 
        foreach ($movieList as $movie) {
    ?>
        <option value="<?=$movie->getId();?>"><?=$movie->getTitle();?></option>
    <?php
        }
    ?>
    </select>

<button type="submit">enviar</button>
</form>