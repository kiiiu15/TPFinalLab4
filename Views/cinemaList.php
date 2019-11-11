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

<main class="p-5">
        <div class="container">

            <h1 class="mb-5">Listado de Cines</h1>


            


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
                    <label for="">Activo/Inactivo</label>
                    <select name="active" class="form-control ml-3">
                        <option value="<?= true; ?>">Activo</option>
                        <option value="<?= false; ?>">Inactivo</option>
                    </select>
                    <button type="submit" class="btn btn-dark ml-3">Enviar</button>

                    <!-- 
                        en realidad este button no tiene nada que ver con el form este, pero si lo ponia afuera quedava re feo :)
                     -->
                    <button type="button" class="btn btn-dark ml-3" data-toggle="modal" data-target="#add-cinema">
                        Agregar Cine
                    </button>
                </div>

                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Id Cine</th>
                            <th>Nombre</th>
                            <th>Direccion</th>
                            <th>Capacidad</th>
                            <th>Precio</th>
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
                                <td> <?php echo $cinema->getCapacity();?></td>
                                <td> <?php echo $cinema->getPrice();?>   </td>
                                
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
                    <h5 class="modal-title">Crear Cine</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input required name="cinemaName" type="text">
                    </div>
                    <div class="form-group">
                        <label>Direccion</label>
                        <input required name="adress" type="text">
                    </div>
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark">Crear</button>
                </div>
            </form>

        </div>   
    </div>           
    
    
    <form action="" method="post">





                    <select name="" id="">funciones</select>

                    <input type="text"> cantidad

                    button 


                




    </form>

    <?php include(VIEWS.'/footer.php');  ?>