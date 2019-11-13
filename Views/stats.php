<?php

?>

<form action="<?= FRONT_ROOT . "/Buy/getTotalByDate" ?>" method="post">


    <label>fecha desde</label>
    <input type="date" name="fromDate">
    <label>fecha hasta</label>
    <input type="date" name="toDate">
    <select name="cinema">
    <?php 
    foreach ($cinemaList as $cinema) {
    ?>    
        <option value="<?= $cinema->getIdCinema() ?>"><?= $cinema->getName() ?></option>
    <?php
    }
    ?>
    </select>

<button type="submit">enviar</button>
</form>