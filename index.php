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
    <form action="deleteCinema.php" method="post">
        <p>Elija el Id del cine a eliminar</p>
        <input type="text" value="id" name="id">
        
        <button type="submit">enviar</button>
    
    </form>
</body>

</html>

-->