<?php

include(VIEWS . "/header.php");

if ($isAdmin) {
    include(VIEWS . '/adminNav.php');
} else {
    include(VIEWS . '/nav.php');
}

include_once(COMPONENTS . "/utils/renderAlert.php");

?>

<main class="p-md-5">
    <div class="container-fluid container-md">
        <h1 class="mb-5">List of Movies</h1>

        <?php render_alert_util($successMje, $errorMje); ?>

        <div class="d-flex flex-column align-items-stretch flex-sm-row justify-content-between mb-3 bg-light py-3 px-2 px-md-3 rounded">
            <form class="form-inline flex-column align-items-stretch flex-sm-row" action="<?= FRONT_ROOT . '/Home/showMoviesByGenre' ?>" method="POST">
                <div class="form-group">
                    <label class="mb-0" for="genreId">Genre</label>
                    <select name="genreId" class="form-control mx-sm-1">
                        <?php foreach ($genresList as $genre) { ?>
                            <option value="<?= $genre->getId(); ?>"><?= $genre->getName(); ?></option>
                        <?php  } ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-dark btn-block">Send</button>
                </div>
            </form>
            <form class="form-inline flex-column align-items-stretch flex-sm-row" action="<?= FRONT_ROOT . '/Home/ShowMovieByDate' ?>" method="POST">
                <div class="form-group">
                    <label class="mb-0" for="data">Date</label>
                    <input class="form-control mx-sm-1 " name="date" required type="date" min="<?= date("Y-m-d"); ?>">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-dark btn-block">Send</button>
                </div>
            </form>

        </div>

        <table id="idMovie" class="table table-striped table-light" class="catsandstar">
            <thead class="thead-dark">
                <tr>

                    <th>POSTER</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Genre</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($movieList as $movie) { ?>
                    <tr>

                        <td>
                            <img src="<?php echo $movie->getPoster(); ?>" alt="" class="img-fluid cover" />
                        </td>
                        <td> <?php echo $movie->getTitle(); ?> </td>
                        <td> <?php echo $movie->getOverview(); ?> </td>
                        <td> <?php foreach ($movie->getGenres() as $genre) {
                                    echo $genre->getName() . '<br>';
                                } ?>
                        </td>
                        <td>
                            <button class="event btn btn-success" value="<?= $movie->getId(); ?>">Buy</button>
                        </td>



                    </tr>
                <?php } ?>
            </tbody>
        </table>



    </div>
</main>


<?php require_once(VIEWS . "/components/home/modal.php"); ?>


<?php include(VIEWS . '/footer.php');  ?>

<?php require_once(VIEWS . "/components/home/modalScript.php"); ?>