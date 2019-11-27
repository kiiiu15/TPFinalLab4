<?php
    /*ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);*/


    //CAMBIAR ESE 2
    include(VIEWS."/header2.php");
    include(VIEWS.'/adminNav.php');
    if ($cinemaList == false){
        $cinemaList = array();
    }
    if (!is_array($cinemaList)){
        $cinemaList = array($cinemaList);
    }

?>

<style>
body {
	background-image: url("http://www.kabu-load.net/data/out/103/IMG_1086101.jpg");
    background-size:cover;
    background-size:100%;
} 

h1 {
    color:white;
}
label{
    color:white;
}
td{
    color:white;
} 
</style>

<main class="p-5">
        <div class="container">

            <h1 class="mb-5">List of Cinemas</h1>

            <?php if(isset($successMje) || isset($errorMje)) { ?>
                <div class="alert <?php if(isset($successMje)) echo 'alert-success'; else echo 'alert-danger'; ?> alert-dismissible fade show mt-3" role="alert">
                    <strong><?php if(isset($successMje)) echo $successMje; else echo $errorMje; ?></strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php } ?>
            


                <!-- LES DEJO ESTO DEL MULTI ACTION POR SI SE LES OCURRE QUE LES PUEDE SERVIR MAS ADELANTE -->
                <!-- <div class="form-group mb-4"> -->
                    <!-- <button type="button" class="btn btn-light mr-4" data-toggle="modal" data-target="#create-post"> -->
                        <!-- <object type="image/svg+xml" data="<?php //ICONS."/plus.svg"?>" width="16" height="16"></object> -->
                    <!-- </button> -->

                    <!-- <label for="">Accion múltiple</label> -->
                    <!-- <select name="action" class="form-control ml-3"> -->
                        <!-- <option value="trash">Eliminar</option> -->
                        <!-- <option value="enable">Publicar</option> -->
                        <!-- <option value="disable">Despublicar</option> -->
                    <!-- </select> -->
                    <!-- <button type="submit" class="btn btn-dark ml-3">Enviar</button> -->
                <!-- </div> -->



                                      <!-- LOS GET NO ESTAN FUNCIONANDO -->
            <form class="form-inline" action="<?= FRONT_ROOT ?>/Cinema/ChangeCinemaState" method="POST">
                <div class="form-group mb-4">
                    <label for="">Active/Inactive</label>
                    <select name="active" class="form-control ml-3">
                        <option value="<?= true; ?>">Active</option>
                        <option value="<?= false; ?>">Inactive</option>
                    </select>
                    <button type="submit" class="btn btn-dark ml-3">Send</button>

                    <!-- 
                        en realidad este button no tiene nada que ver con el form este, pero si lo ponia afuera quedava re feo :)
                     -->
                    <button type="button" class="btn btn-dark ml-3" data-toggle="modal" data-target="#add-cinema">
                        Add a Cinema
                    </button>
                </div>

                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Id Cinema</th>
                            <th>Name</th>
                            <th>Adress</th>
                            <th>State</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    <!-- 
                        ACA TENEMOS UN PROBLEMA,
                        SI POR ALGUNA RAZON SOLO RECIVE UN UNICO CINE, SE ROMPE EL FOREACH Y NO SE VE NADA 
                     -->
                        <?php foreach($cinemaList as $cinema) { ?>
                            <tr>
                                <td><input type="checkbox" name="postschecked[]" value="<?php echo $cinema->getIdCinema();?>"></td>
                                <td> <?php echo $cinema->getIdCinema();?>    </td>
                                <td> <?php echo $cinema->getName();?>    </td>
                                <td> <?php echo $cinema->getAddress();?> </td>
                                <td><?php echo ($cinema->getActive()) ? "Active" : "Inactive";?></td>
                             
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </form>

            <!-- Esto como si no existiera -->
            <?php if(isset($successMje) || isset($errorMje)) { ?>
                <div class="alert <?php if(isset($successMje)) echo 'alert-success'; else echo 'alert-danger'; ?> alert-dismissible fade show mt-3" role="alert">
                    <strong><?php if(isset($successMje)) echo $successMje; else echo $errorMje; ?></strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php } ?>
        </div>
    </main>


    <div class="modal fade" id="add-cinema" tabindex="-1" role="dialog" aria-labelledby="sign-up" aria-hidden="true">
        <div class="modal-dialog" role="document">

<!-- 
    QUIZAS TENGA MAS SENTIDO QUE SE HAGA POR GET PERO NO FUNCIONA BIEN ASI, EL GET SI SE CARGA
    PERO AL METODO LE LLEGAN LOS PARAMETROS VACIOS
 -->
            <form class="modal-content" action="<?= FRONT_ROOT . '/Cinema/Add' ?>" method="POST">

                <div class="modal-header">
                    <h5 class="modal-title">Add Cinema</h5>
                    <button type="button" class="close" data-dismiss="modal" >
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label style="color:black;">Name</label>
                        <input style="color:black;" required name="cinemaName" type="text" maxlength="50">
                    </div>
                    <div class="form-group">
                        <label style="color:black;">Adress</label>
                        <input style="color:black;" required name="adress" type="text" maxlength="100">
                    </div>
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-dark">Add</button>
                </div>
            </form>

        </div>   
    </div>           
    
    


    <?php include(VIEWS.'/footer.php');  ?>