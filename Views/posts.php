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

    if ($movieList == false){
        $movieList = array();
        
    }

    if (!is_array($movieList )){
        $movieList = array($movieList);
    }


    //var_dump($selectedMovieFunctions);
    
    /* echo "<pre>";
        print_r($selectedMovieFunctions);
     echo "<pre>";*/
    ?>



    <main class="p-5">
        <div class="container">

            <h1 class="mb-5">Listado de Peliculas</h1>

            <?php
                if(isset($alertCapacity)){
                    echo $alertCapacity;          
                }
            ?>
            


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


            <form class="form-inline" action="<?= FRONT_ROOT . '/Home/showMoviesByGenre'?>" method="POST"> 
                <div class="form-group mb-4">
                    <label for="">Genero</label>
                    <select name="genreId" class="form-control ml-3">
                        <?php foreach ($genresList as $genre) {?>
                        <option value="<?= $genre->getId();?>"><?= $genre->getName();?></option>
                        <?php  } ?>
                    </select>
                    <button type="submit" class="btn btn-dark ml-3">Enviar</button>
                </div>
            </form> 
            <form class="form-inline" action="<?= FRONT_ROOT . '/Home/ShowMovieByDate'?>" method="POST">     
                <div>
                    <label for="">Fecha</label>
                    <input name="date" type="date">
                    <button type="submit" class="btn btn-dark ml-3">Enviar</button>
                </div>
            </form>    
                
            <form class="form-inline" action="<?= FRONT_ROOT?>/Home/showMovie" method="POST"> 

                <table class="table" class="catsandstar">
                    <thead class="thead-dark">
                        <tr>
                            
                            <th>POSTER</th>
                            <th>Título</th>
                            <th>Descripcion</th>
                            <th>Genero</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($movieList as $movie) { ?>
                            <tr>
                                
                                <td>
                                        <button type = "sumbit"  name = "asd" value= "<?= $movie->getId();?>"> <img  src="<?php echo $movie->getPoster();?>" alt="" class="cover" /></button>
                                </td>
                                <td> <?php echo $movie->getTitle();?> </td>
                                <td> <?php echo $movie->getOverview();?> </td>
                                <td> <?php foreach($movie->getGenres() as $genre){
                                                echo $genre->getName().'<br>'; 
                                            }?>
                                </td>
                                

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
    LOS CINES DONDE SE PUEDEN VER Y BASICAMENTE ES EL FORMULARIO DE COMPR
 -->
 <?php 
                        foreach ($selectedMovieFunctions as $selectedMovieFunction){
                            foreach($selectedMovieFunction as $function){
                                $nameMovie = $function->getMovie()->getTitle();
                                break;
                            }
                        } 
                    ?>
 
    <div class="modal fade" id="show-movie" tabindex="-1" role="dialog" aria-labelledby="sign-up" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <form class="modal-content" action="" method="GET">

                <div class="modal-header">
                
                    <h5 class="modal-title"><?php echo $nameMovie;?></h5>
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
                        <select id="options" name="" class="form-control ml-3">
                        <option value="" disabled selected>Seleccione un Cine</option>
                        <?php 
                            foreach($selectedMovieFunctions as $cinemaId =>  $selectedMovieFunction) { 
                                foreach($selectedMovieFunction as  $function){?>
                                    <option value="<?= $cinemaId;?>"> <?php echo $function->getRoom()->getCinema()->getName();?> </option>
                        
                            <?php  }
                            }
                        ?>

                        </select>
                    </div>

                <!-- 
                    Y EN ESTE SE MOSTRARIAN LAS FUNCIONES QUE HAY PARA ESE CINE....
                    ACA NO SE SI ESTO VA A FUNCIONAR, YA Q NO SE SI AL SELECCIONAR UN CINE DETERMINADO
                    LA LISTA SE VA A ACTUALIZAR
                 -->
                    
                    <div class="form-group">
                        <label>FUNCIONES</label>
                        <select id="choices" name="" class="form-control ml-3">
                        <?php// foreach() { ?>
                           
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

    <?php if ($selectedMovieFunctions != null) {  ?>
    <script type="text/javascript"> 
        
        window.onload = function() {
            
            $('#show-movie').modal('show');
            

            $('#options').on('change', function() {
                
                // Set selected option as variable
                var selectValue = $(this).val();
                
                // Empty the target field
                $('#choices').empty();
                
                // For each chocie in the selected option
                for (i = 0; i < lookup[selectValue].length; i++) {
                    
                    // Output choice in the target field
                    $('#choices').append("<option value=''>" + lookup[selectValue][i] + "</option>");
                    
                }
            });


            
        };  



        var lookup = {
            <?php foreach ($selectedMovieFunctions as $cinemaId => $selectedMovieFunction){ ?>
            '<?= $cinemaId;?>'  : 
            
                [
                    <?php foreach($selectedMovieFunction as $function) {?>
                    '<?php echo "Fecha: " . $function->getDay() . " Sala: " . $function->getRoom()->getName() . " Horario: " . $function->getHour()?>' <?php if (count($selectedMovieFunction) > 1) {echo ",";} ?>
                    <?php } ?>
                ] <?php if (count($selectedMovieFunction) > 1) {echo ",";} ?>
            <?php }?>
        };

        // When an option is changed, search the above for matching choices



        

    </script>
<?php } ?>