<?php
include_once ("config/autoload.php");
use config\autoload as autoload;
autoload::Start();

//header("location: views/home.php");

use repository\MovieRepository as MovieRepository;

$repo = new MovieRepository();
$list = $repo->GetAll();
//$repo->updateJson();
?>

<html>

<body>
    <form action="deleteCinema.php" method="post">
        <p>Elija el Id del cine a eliminar</p>
        <input type="text" value="id" name="id">
        
        <button type="submit">enviar</button>
    
    </form>
</body>

</html>

