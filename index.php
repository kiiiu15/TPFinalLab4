<?php
include_once ("config/autoload.php");
use config\autoload as autoload;
autoload::Start();

//header("location: views/home.php");

use repository\MovieRepository as MovieRepository;

$repo = new MovieRepository();
//$list = $repo->GetAll();
$repo->updateJson();
?>
<!--
<html>

<body>
    <form action="altaCine.php" method="post">

        <input type="text" value="id" name="id">
        <input type="text" value="nombre" name="nombre">
        <input type="text" value="direccion" name="direccion">
        <input type="text" value="capacidad" name="capacidad">
        <input type="text" value="valor" name="valor">
    

        <button type="submit">enviar</button>
    
    </form>
</body>

</html>

-->