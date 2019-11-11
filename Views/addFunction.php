<?php
    /*ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);*/


    //CAMBIAR ESE 2
    include(VIEWS."/header2.php");
    include(VIEWS.'/adminNav.php');

    
    if ($movieFunctionList == false){
        $movieFunctionList = array();
    }

    if (! is_array($movieFunctionList)){
        $movieFunctionList = array($movieFunctionList);
    }

    if ($activeRooms == false){
        $activeRooms = array();
    }

    if (!is_array($activeRooms)){
        $activeRooms = array($activeRooms);
    }

    if ($movies == false){
        $movies = array();
    }

    if (!is_array($movies)){
        $movies = array($movies);
    }

        
    

?>

    <main class="p-5">
        <div class="container">

            <h1 class="mb-5">Listado de Funciones</h1>

            <button type="button" class="btn btn-dark ml-3" data-toggle="modal" data-target="#add-function">
                Agregar Funcion
            </button> 

<!--ACA PODRIAMOS PONER UN SELECT PARA QUE ELIJA EL CINE DEL QUE QUIERE VER QUE FUNCIONES HAY
            <form class="form-inline" action="" method="GET">
                <div class="form-group mb-4">
                    <label for="">Activo/Inactivo</label>
                    <select name="active" class="form-control ml-3">
                        <option value="true">Activo</option>
                        <option value="false">Inactivo</option>
                    </select>
                    <button type="submit" class="btn btn-dark ml-3">Enviar</button>
                    
                </div>
            </form>   

            <button type="button" class="btn btn-dark ml-3" data-toggle="modal" data-target="#add-cinema">
                Agregar Cine
            </button> 
-->                
            <form class="form-inline" action="<?= FRONT_ROOT?>/MovieFunction/Delete" method="POST">
                <button type="submit" class="btn btn-dark ml-3"  >Borrar Selecion</button> 
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Id Funcion</th>
                            <th>Cine</th>
                            <th>Sala</th>
                            <th>Fecha</th>
                            <th>Horario</th>
                            <th>Pelicula</th>
                        </tr>
                    </thead>
                    <tbody>
                    <!-- 
                        ACA TENEMOS UN PROBLEMA,
                        SI POR ALGUNA RAZON SOLO RECIVE UN UNICO CINE, SE ROMPE EL FOREACH Y NO SE VE NADA 
                     -->
                        <?php foreach($movieFunctionList as $movieFunction) { ?>
                            <tr>
                                <td><input type="checkbox" name="postschecked[]" value="<?php echo $movieFunction->getId();?>"></td>
                                <td> <?php echo $movieFunction->getId();?></td>
                                <td> <?php echo $movieFunction->getRoom()->getCinema()->getName();?>    </td>
                                <td> <?php echo $movieFunction->getRoom()->getName();?>                  </td>
                                <td> <?php echo $movieFunction->getDay();?>                  </td>
                                <td> <?php echo $movieFunction->getHour();?>                 </td>
                                <td> <?php echo $movieFunction->getMovie()->getTitle();?>    </td>
                                
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


    <div class="modal fade" id="add-function" tabindex="-1" role="dialog" aria-labelledby="sign-up" aria-hidden="true">
        <div class="modal-dialog" role="document">

<!-- 
    QUIZAS TENGA MAS SENTIDO QUE SE HAGA POR GET PERO NO FUNCIONA BIEN ASI, EL GET SI SE CARGA
    PERO AL METODO LE LLEGAN LOS PARAMETROS VACIOS
 -->
            <form class="modal-content" action="<?= FRONT_ROOT . '/MovieFunction/Add' ?>" method="POST">

                <div class="modal-header">
                    <h5 class="modal-title">Agregar Funcion</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span> 
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                    <!-- 
                        mas tarde le agrego la capacidad de que sea por nombre o apretando el chek de 
                        la lista de movie
                     -->
                        <label>Pelicula</label>
                        <select required name="idMovie" id="">
                        <?php foreach ($movies as $movie){ ?>
                            <option value="<?= $movie->getId();?>"><?= $movie->getTitle();?></option>
                        <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                    <!-- 
                        mas tarde la agrego el que puedas meter el nombre
                     -->
                        <label>Room</label>
                        <select required  name="idCienma" >
                            <?php foreach ($activeRooms as $activeRoom) {?>
                            <option value="<?= $activeRoom->getId();?>"><?php echo $activeRoom->getName() . " - " . $activeRoom->getCinema()->getName();?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Fecha</label>
                        <input required name="date" type="date">
                    </div>
                    <div class="form-group">
                        <label>Horario</label>
                        <input required name="hour" type="time">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark">Crear</button>
                </div>
            </form>

        </div>   
    </div>                               

<?php include(VIEWS.'/footer.php');  ?>