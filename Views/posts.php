<?php
    
    include(VIEWS."/header2.php");
    
    if($isAdmin){
        include(VIEWS.'/adminNav.php');
    }else{
        include(VIEWS.'/nav2.php'); 
    }

    ?>

<style>
body {
	background-image: url("https://d2v9y0dukr6mq2.cloudfront.net/video/thumbnail/V7QIfdTcgikqxmxok/cinema-background_vzw7c2tqe__F0000.png");
    /*background-repeat:no-repeat;*/
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

            <h1 class="mb-5">List of Movies</h1>

            <?php
                if(isset($alertCapacity)){
                    echo $alertCapacity;          
                }
            ?>

                    <?php if(isset($successMje) || isset($errorMje)) { ?>
                <div class="alert <?php if(isset($successMje)) echo 'alert-success'; else echo 'alert-danger'; ?> alert-dismissible fade show mt-3" role="alert">
                    <strong><?php if(isset($successMje)) echo $successMje; else echo $errorMje; ?></strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php } ?>


            <form class="form-inline" action="<?= FRONT_ROOT . '/Home/showMoviesByGenre'?>" method="POST"> 
                <div class="form-group mb-4">
                    <label for="">Genre</label>
                    <select name="genreId" class="form-control ml-3">
                        <?php foreach ($genresList as $genre) {?>
                        <option value="<?= $genre->getId();?>"><?= $genre->getName();?></option>
                        <?php  } ?>
                    </select>
                    <button type="submit" class="btn btn-dark ml-3">Send</button>
                </div>
            </form> 
            <form class="form-inline" action="<?= FRONT_ROOT . '/Home/ShowMovieByDate'?>" method="POST">     
                <div class="form-group mb-4">
                    <label for="">Date</label>
                    <input name="date" type="date" min="<?php echo date("Y-m-d");?>">
                    <button type="submit" class="btn btn-dark ml-3">Send</button>
                </div>
            </form>    
                
            <form class="form-inline" action="<?= FRONT_ROOT?>/Home/showMovie" method="POST"> 

                <table class="table" class="catsandstar">
                    <thead class="thead-dark">
                        <tr>
                            
                            <th>POSTER</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Genre</th>
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
                                


                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </form>

            
        </div>
    </main>


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

            <form class="modal-content" action="<?= FRONT_ROOT?>/Buy/ReciveBuy" method="POST">

                <div class="modal-header">
                
                    <h5 class="modal-title"><?php echo $nameMovie;?></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

               
                    <div class="form-group">
                        <label style="color:black;">Cinemas</label>
                        <select id="options" name="" class="form-control ml-3">
                        <option value="" disabled selected>Select a Cinema</option>
                        <?php 
                            foreach($selectedMovieFunctions as $cinemaId =>  $selectedMovieFunction) { 
                                foreach($selectedMovieFunction as  $function){?>
                                    <option value="<?= $cinemaId;?>"> <?php echo $function->getRoom()->getCinema()->getName();?> </option>
                        
                            <?php break; }    
                            }
                        ?>

                        </select>
                    </div>


                    <div class="form-group">
                        <label style="color:black;">Functions</label>
                            <select id="choices" name="idFunction" class="form-control ml-3">
                            </select>
                    </div>

                    <div class="form-group">
                        <label style="color:black;">Number Of Tickets</label>
                        <input style="color:black;" name="quantity" min='1' type="number" required onkeypress="return false">
                    </div>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-dark">Buy</button>
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
                
                
                var selectValue = $(this).val();

               /* $.ajax({
                    method : 'POST',
                    url : '/TPFinalLab4/MovieFunction/prueba',
                    dataType : 'JSON',
                    data : { selectValue },
                    beforeSend : function() {
                        // Esto ocurre al iniciar la peticion
                    },
                    error : function() {
                        // Esto ocurre si falla
                    },
                    success : function(dato) {
                        // Esto ocurre si la peticion al servidor se ejecuto correctamente

                        console.log(dato);

                        $.each(array, function(v, k) {

                        })
                        // JSON.Parse(dato);
                    }
                }); */
                
                // Empty the target field
                $('#choices').empty();
                
                // For each chocie in the selected option
                for (i = 0; i < lookup[selectValue].length; i++) {
                    
                    // Output choice in the target field
                    $('#choices').append("<option value='" + values[selectValue][i] + "'>" + lookup[selectValue][i] + "</option>");
                    
                }
            });


            
        };  

        var values = {
            <?php foreach ($selectedMovieFunctions as $cinemaId => $selectedMovieFunction){ ?>
                '<?= $cinemaId;?>'   : 
            
            [
                <?php foreach($selectedMovieFunction as $function) {?>
                '<?php echo $function->getId();?>' <?php if (count($selectedMovieFunction) > 1) {echo ",";} ?>
                <?php } ?>
            ] <?php if (count($selectedMovieFunction) > 1) {echo ",";} ?>
        <?php }?>
        };

        var lookup = {
            
            <?php foreach ($selectedMovieFunctions as $cinemaId => $selectedMovieFunction){ ?>
            '<?= $cinemaId;?>'   : 
            
                [
                    <?php foreach($selectedMovieFunction as $function) {?>
                    
                    '<?php echo "Fecha: " . $function->getDay() . " Sala: " . $function->getRoom()->getName() . " Horario: " . $function->getHour()?>' <?php if (count($selectedMovieFunction) > 1) {echo ",";} ?>
                    <?php } ?>
                ] <?php if (count($selectedMovieFunction) > 1) {echo ",";} ?>
            <?php }?>
        };




        

    </script>
<?php } ?>