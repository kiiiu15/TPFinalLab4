<?php
include(PARTIALS . "/header.php");
include(VIEWS . "/adminNav.php");
include_once(COMPONENTS . "/utils/renderAlert.php");
?>

<main class="p-2 p-lg-5">
    <div class="container-fluid container-lg">

        <?php render_alert_util($successMje, $errorMje); ?>

        <div class="d-flex flex-column align-items-stretch flex-lg-row  justify-content-lg-around bg-light p-3 rounded">
            <form action="<?= FRONT_ROOT . "/Buy/getTotalByDate" ?>" method="POST">
                <p class="h5">Check totals purchases by date / cinema / movie</p>
                <div class="form-group">
                    <div class="d-flex flex-column align-items-stretch flex-lg-row  justify-content-lg-around">
                        <div class="form-group">
                            <label> From date</label>
                            <input id="from" type="date" required name="fromDate" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>To date</label>
                            <input id="to" type="date" disabled required name="toDate" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Cinemas</label>
                        <select name="cinema" class="form-control ">
                            <option value="">Any</option>
                            <?php foreach ($cinemaList as $cinema) { ?>
                                <option value="<?= $cinema->getIdCinema() ?>"><?= $cinema->getName() ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Movies</label>
                        <select name="movie" class="form-control ">
                            <option value="">Any</option>
                            <?php foreach ($movieList as $movie) { ?>
                                <option value="<?= $movie->getId(); ?>"><?= $movie->getTitle(); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Get Total</button>
                </div>
                <div class="form-group justify-content-between">
                    <label>TOTAL BUY</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="text" class="form-control" disabled value="<?= $totalSold; ?>" aria-label="Amount (to the nearest dollar)">
                        <div class="input-group-append">
                            <span class="input-group-text">.00</span>
                        </div>
                    </div>
                </div>

            </form>
            <form action="<?= FRONT_ROOT . "/Buy/getTotalTicketsSold" ?>" method="POST">

                <p class="h5">Check total of tickets by date / cinema / movie</p>
                <div class="form-group ">
                    <div class="d-flex flex-column align-items-stretch flex-lg-row  justify-content-lg-around">
                        <div class="form-group">
                            <label>From date</label>
                            <input type="date" id="from2" required name="fromDate" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>To date</label>
                            <input type="date" id="to2" required disabled name="toDate" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Cinemas</label>
                        <select name="cinema" class="form-control">
                            <option value="">Any</option>
                            <?php foreach ($cinemaList as $cinema) { ?>
                                <option value="<?= $cinema->getIdCinema() ?>"><?= $cinema->getName() ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Movies</label>
                        <select name="movie" class="form-control ">
                            <option value="">Any</option>
                            <?php
                            foreach ($movieList as $movie) {
                            ?>
                                <option value="<?= $movie->getId(); ?>"><?= $movie->getTitle(); ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Get Total</button>
                </div>
                <div class="form-group justify-content-between">
                    <label>TOTAL TICKETS</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">#</span>
                        </div>
                        <input type="text" class="form-control" disabled value="<?= $totalTicketsSold; ?>" aria-label="Amount (to the nearest dollar)">
                        <div class="input-group-append">
                            <span class="input-group-text">.00</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
<?php include(PARTIALS . "/footer.php"); ?>

<script>
    const $fromDateInput = document.querySelector("#from");
    const $toDateInput = document.querySelector("#to");
    const $fromDateInput2 = document.querySelector("#from2");
    const $toDateInput2 = document.querySelector("#to2");


    $fromDateInput.addEventListener("change", function(e) {
        const selectedValue = e.target.value;

        $toDateInput.min = selectedValue;
        $toDateInput.disabled = false;
    });

    $fromDateInput2.addEventListener("change", function(e) {
        const selectedValue = e.target.value;

        $toDateInput2.min = selectedValue;
        $toDateInput2.disabled = false;
    });
</script>