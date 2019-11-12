<?php

?>

<form action="<?= FRONT_ROOT . "/Buy/getTotalByDate" ?>" method="post">


    <label>fecha desde</label>
    <input type="date" name="fromDate">
    <label>fecha hasta</label>
    <input type="date" name="toDate">

<button type="submit">enviar</button>
</form>