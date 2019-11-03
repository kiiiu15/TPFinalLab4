<?php
    /*ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);*/


    //CAMBIAR ESE 2
    include(VIEWS."/header2.php");
    $isadmin = true;
    if($isadmin){
        include(VIEWS.'/adminNav.php');
    }else{
        include(VIEWS.'/nav2.php'); 
    }

?>

    <main class="p-5">
        <div class="container">

            <h1 class="mb-5">Listado de Peliculas</h1>


            <form class="form-inline" action="" method="POST">


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



                <div class="form-group mb-4">

                    <label for="">Genero</label>
                    <select name="" class="form-control ml-3">
                        <?php foreach ($genres as $genre) {?>
                        <option value="<?= $genre->getId();?>"><?= $genre->getName();?></option>
                        <?php  } ?>
                    </select>

                    <label for="">Fecha</label>
                    <input type="date">
                    <button type="submit" class="btn btn-dark ml-3">Enviar</button>
                </div>
                
                

                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th> POSTER </th>
                            <th>Título</th>
                            <th>Descripcion</th>
                            <th>Genero</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($list as $post) { ?>
                            <tr>
                                <td><input type="checkbox" name="postschecked[]" value="<?php echo $post->getID();?>"></td>
                                <td> <img  src="<?php echo $post->getPoster();?>" alt="" class="cover" data-toggle="modal" data-target="#show-movie"/> </td>
                                <td> <?php echo $post->getTitle();?> </td>
                                <td> <?php echo $post->getOverview();?> </td>
                                <td> 
                                <?php $genres = $post->getGenres();
                                    foreach($genres as $genre) {
                                        echo $genre->getName() ."<br/>";
                                    }
                                ?>
                                 </td>
                                <!-- <td><?php //$post->getID();?></td> -->
                                <!-- <td><?php //$post->getTitle();?></td> -->
                                <!-- <td><?php //$post->getAuthor();?></td> -->
                                <!-- <td><?php //$post->getCategory();?></td> -->
                                <!-- <td><?php //$post->getDate();?></td> -->
                                <!-- <td><?php //$post->getText();?></td> -->
                                <!-- <td> -->

                            

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

<!-- 
    ESTE BOTON SERIA EL QUE DESPLIEGA EL MODAL FADE CON ID= CREATE-POST DE ABAJO 
    CON ESTO PODRIAMOS HACER QUE SE DESPLIEGE LA VISTA CON EL FORMULARIO PARA REALIZAR LA COMPRA DE LA PELICULA ?
    TIPO Q TE MUESTRE UN SELECT CON LOS DISTINTOS CINES Q LA TRANSMITEN, AHI TE APARECE LAS FECHAS QUE ESTEN DISPONIBLES Y VOS ELEGIS ETC
-->
    <!-- <button type="button" class="btn btn-light mr-4" data-toggle="modal" data-target="#create-post"> -->
            <!-- <object type="image/svg+xml" data="<?php //ICONS."/plus.svg"?>" width="16" height="16"></object> -->
    <!-- </button> -->

    
<!-- 
    SI APRETAN LA IMAGEN DEL POSTER DE LA PELICULA SE DESPLIEGA ESTO CON TODA LA INFO DE LA PELICULA,
    LOS CINES DONDE SE PUEDEN VER Y BASICAMENTE ES EL FORMULARIO DE COMPRA
 -->
    <div class="modal fade" id="show-movie" tabindex="-1" role="dialog" aria-labelledby="sign-up" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <form class="modal-content" action="" method="GET">

                <div class="modal-header">
                    <h5 class="modal-title">ACA VA EL TITULO DE LA PELI</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                <!-- 
                    EN ESTE DIV SE MOSTRARIAN LOS DISTINTOS CINES QUE EMITEN ESTA PELICULA
                 -->
                    <div class="form-group">
                        <label>CINES</label>
                        <select name="" class="form-control ml-3">
                        <?php// foreach() { ?>
                            <option value=""> primer cine </option>
                        <?php// } ?>
                        </select>
                    </div>

                <!-- 
                    Y EN ESTE SE MOSTRARIAN LAS FUNCIONES QUE HAY PARA ESE CINE....
                    ACA NO SE SI ESTO VA A FUNCIONAR, YA Q NO SE SI AL SELECCIONAR UN CINE DETERMINADO
                    LA LISTA SE VA A ACTUALIZAR
                 -->
                    
                    <div class="form-group">
                        <label>FUNCIONES</label>
                        <select name="" class="form-control ml-3">
                        <?php// foreach() { ?>
                            <option value=""> primer funcion </option>
                        <?php// } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>CANTIDAD DE ENTRADAS</label>
                        <input name="" type="number">
                    </div>

<!--
                    <div class="form-group">
                        <label>Título</label>
                        <input type="text" class="form-control" name="post[title]" />
                    </div>

                    <div class="form-group">
                        <label>Autor</label>
                        <input type="text" disabled value="<?php //echo $user->getName() ?>" class="form-control">
                        <input type="hidden" name="post[author]" value="<?php// echo $user->getName() ?>" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Categoría</label>
                        <select name="post[category]" class="form-control ml-3">
                        <?php// foreach($categoriesList as $category ) { ?>
                            <option value="<?php// echo $category->getName() ?>"><?php// echo $category->getName() ?></option>
                        <?php// } ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Fecha</label>
                        <input type="date" class="form-control" name="post[date]" />
                    </div>

                    <div class="form-group">
                        <label>Texto</label>
                        <textarea name="post[text]" class="form-control"></textarea>
                    </div>
-->
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark">Comprar</button>
                </div>
            </form>

        </div>   
    </div>                               

    <?php include(VIEWS.'/footer.php');  ?>