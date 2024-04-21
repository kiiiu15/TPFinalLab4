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

        <?php if (isset($successMje) || isset($errorMje)) {
            require_once(VIEWS . "/components/home/alert.php");
        } ?>

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

        <table id="idMovie" class="table table-striped table-light" class="catsandstar">
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
                            <button class="event btn" name="asd" value="<?= $movie->getId(); ?>"> <img src="<?php echo $movie->getPoster(); ?>" alt="" class=" cover" /></button>
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


<?php require_once(VIEWS . "/components/home/modal.php"); ?>


<?php include(VIEWS . '/footer.php');  ?>

<?php require_once(VIEWS . "/components/home/modalScript.php"); ?>
