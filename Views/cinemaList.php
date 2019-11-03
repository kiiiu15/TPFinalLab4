<?php
    /*ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);*/


    //CAMBIAR ESE 2
    include(VIEWS."/header2.php");
    include(VIEWS.'/adminNav.php');

?>

    <main class="p-5">
        <div class="container">

            <h1 class="mb-5">Listado de Cines</h1>

            <div class="form-group mb-4">
                <button type="button" class="btn btn-light mr-4" data-toggle="modal" data-target="#add-cinema">
                    AGREGAR CINE
                </button>
            </div>
            
<!-- 
    dejo este form que es del boton ese de abajo por si mas adelante le damos funcionalidad
    al checkbox que tiene el primer td
 -->
            <form class="form-inline" action="" method="POST">  
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Nombre</th>
                            <th>Direccion</th>
                            <th>Capacidad</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($cinemaList as $cinema) { ?>
                            <tr>
                                <td><input type="checkbox" name="postschecked[]" value="<?php echo $cinema->getIdCinema();?>"></td>
                                <td> <?php echo $cinema->getName();?> </td>
                                <td> <?php echo $cinema->getAddress();?> </td>
                                <td> <?php echo $cinema->getCapacity();?> </td>
                                <td> <?php echo $cinema->getPrice();?> </td>
                                
                                <!-- BOTON PARA BORRAR -->
                                    <!-- <a href="Process/delete_post.php?delete=<?php //echo $post->getID(); ?>" class="btn btn-light"> -->
                                        <!-- <object type="image/svg+xml" data="<?php//ICONS."/trash-2.svg"?>" width="16" height="16"> -->
                                            <!-- Your browser does not support SVG -->
                                        <!-- </object> -->
                                    <!-- </a> -->
                                <!-- </td> -->
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

            <form class="modal-content" action="<?= FRONT_ROOT . '/Cinema/Add' ?>" method="GET">

                <div class="modal-header">
                    <h5 class="modal-title">Crear Cine</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input name="cinemaName" type="text">
                    </div>
                    <div class="form-group">
                        <label>Direccion</label>
                        <input name="adress" type="text">
                    </div>
                    <div class="form-group">
                        <label>Capacidad</label>
                        <input name="capacity" type="text">
                    </div>
                    <div class="form-group">
                        <label>Precio por entrada</label>
                        <input name="entranceValue" type="text">
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