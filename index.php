<?php
require(__dir__."/config/data.php");
include_once (ROOT."/config/autoload.php");
use config\autoload as autoload;
autoload::Start();

use config\request as Request;
use config\router as Router;

/**Mas les vale que me limpien todo este index hijos de puta!! */
//header("location: views/home.php");
/*
use repository\MovieRepository as MovieRepository;

$repo = new MovieRepository();
$list = $repo->GetAll();
//$repo->updateJson();

*/

$objectRequest = new Request(); /* This as the first time we came to the website should direct us to the login (home view for now..)*/

$objectRouter = new Router ();

$objectRouter::route($objectRequest);

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