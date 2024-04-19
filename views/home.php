<?php

include(VIEWS . "/header.php");

if ($isAdmin) {
    include(VIEWS . '/adminNav.php');
} else {
    include(VIEWS . '/nav.php');
}

?>

<main class="p-md-5">
    <div class="container-fluid container-md">
        <h1 class="mb-5">List of Movies</h1>

        <?php if (isset($successMje) || isset($errorMje)) { ?>
            <div class="alert <?php if (isset($successMje)) echo 'alert-success';
                                else echo 'alert-danger'; ?> alert-dismissible fade show mt-3" role="alert">
                <strong><?php if (isset($successMje)) echo $successMje;
                        else echo $errorMje; ?></strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?>

        <div class="d-flex flex-column flex-md-row  mb-3 bg-light p-3 rounded">
            <form class="form-inline mx-2 " action="<?= FRONT_ROOT . '/Home/showMoviesByGenre' ?>" method="POST">
                <div class="form-row">
                    <label class="col-form-label" for="genreId">Genre</label>
                    <select name="genreId" class="form-control">
                        <?php foreach ($genresList as $genre) { ?>
                            <option value="<?= $genre->getId(); ?>"><?= $genre->getName(); ?></option>
                        <?php  } ?>
                    </select>
                    <button type="submit" class="btn btn-dark">Send</button>
                </div>
            </form>
            <form class="form-inline mx-2" action="<?= FRONT_ROOT . '/Home/ShowMovieByDate' ?>" method="POST">
                <div class="form-row">
                    <label class="col-form-label" for="data">Date</label>
                    <input class="form-control" name="date" required type="date" min="<?= date("Y-m-d"); ?>">
                    <button type="submit" class="btn btn-dark">Send</button>
                </div>
            </form>

        </div>



        <table id="idMovie" class="table" class="catsandstar">
            <thead class="thead-dark">
                <tr>

                    <th>POSTER</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Genre</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($movieList as $movie) { ?>
                    <tr>

                        <td>
                            <button class="event" name="asd" value="<?= $movie->getId(); ?>"> <img src="<?php echo $movie->getPoster(); ?>" alt="" class="cover" /></button>
                        </td>
                        <td> <?php echo $movie->getTitle(); ?> </td>
                        <td> <?php echo $movie->getOverview(); ?> </td>
                        <td> <?php foreach ($movie->getGenres() as $genre) {
                                    echo $genre->getName() . '<br>';
                                } ?>
                        </td>



                    </tr>
                <?php } ?>
            </tbody>
        </table>



    </div>
</main>




<div class="modal fade" id="show-movie" tabindex="-1" role="dialog" aria-labelledby="sign-up" aria-hidden="true">
    <div class="modal-dialog" role="document">

        <form class="modal-content" action="<?= FRONT_ROOT ?>/Buy/ReciveBuy" method="POST">

            <div class="modal-header">

                <h5 id="title" class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">


                <div class="form-group">
                    <label style="color:black;">Cinemas</label>
                    <select required id="options" name="" class="form-control ml-3">
                        <option value="" disabled selected>Select a Cinema</option>

                    </select>
                </div>


                <div class="form-group">
                    <label style="color:black;">Functions</label>
                    <select id="choices" required name="idFunction" class="form-control ml-3">
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

<?php include(VIEWS . '/footer.php');  ?>


<script type="text/javascript">
    window.onload = function() {


    };





    $('#idMovie .event').on('click', function() {


        var selectValue = $(this).val();

        $.ajax({
            method: 'POST',
            url: '/TPFinalLab4/Movie/prueba',
            dataType: 'JSON',
            data: {
                selectValue
            },
            beforeSend: function() {
                // Esto ocurre al iniciar la peticion
            },
            error: function() {
                // Esto ocurre si falla
            },
            success: function(dato) {
                // Esto ocurre si la peticion al servidor se ejecuto correctamente
                var jsonContent = JSON.stringify(dato);

                var peli = JSON.parse(jsonContent);

                $('#title').text(peli.title);

            }
        });

        $.ajax({
            method: 'POST',
            url: '/TPFinalLab4/MovieFunction/prueba',
            dataType: 'JSON',
            data: {
                selectValue
            },
            beforeSend: function() {
                // Esto ocurre al iniciar la peticion
            },
            error: function() {
                // Esto ocurre si falla
            },
            success: function(dato) {
                // Esto ocurre si la peticion al servidor se ejecuto correctamente



                var jsonContent = JSON.stringify(dato);

                var array = JSON.parse(jsonContent);


                var cinemas = [];

                var cinemasId = [];

                var options = {};

                var optionsId = {};



                $.each(array, function(k, v) {
                    cinemasId.push(k);

                    cinemas.push(v[0].room.cinema.name);

                    var aux = [];
                    var ids = [];


                    $.each(v, function(k2, v2) {


                        ids.push(v2.id);
                        aux.push("Fecha: " + v2.day + " Sala: " + v2.room.name + " Horario: " + v2.hour);

                    })


                    optionsId[k] = ids;

                    options[k] = aux;


                })

                $('#options').empty();

                $('#options').append("<option value='' disabled selected>Select a Cinema</option>");

                for (i = 0; i < cinemas.length; i++) {


                    $('#options').append("<option value='" + cinemasId[i] + "'>" + cinemas[i] + "</option>");

                }

                $('#options').on('change', function() {


                    var selectValue = $(this).val();

                    $('#choices').empty();

                    // For each chocie in the selected option
                    for (i = 0; i < options[selectValue].length; i++) {

                        // Output choice in the target field
                        $('#choices').append("<option value='" + optionsId[selectValue][i] + "'>" + options[selectValue][i] + "</option>");

                    }

                });

            }
        });
        $('#show-movie').modal('show');
    });
</script>