<?php

use Dao\UserDao as UserDao;

$repo = new UserDao();
$list = $repo->GetAll();

var_dump($list);
if(isset($msg)){
    echo $msg;
}
?>

<html>

<form action="<?= FRONT_ROOT . '/' ?>User/logIn" method="POST">

    <input name = "email" type="text">
    <input type="text" name = "password">

    <button type = "submit">Enviar</button>

</form>


</html>