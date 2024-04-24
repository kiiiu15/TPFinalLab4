<?php
include(VIEWS . "/header.php");
include(VIEWS . "/adminNav.php");
?>

<main class="p-5">
    <div class="container">


        <?php if (isset($successMje) || isset($errorMje)) {
            require_once(VIEWS . "components/stats/alert.php");
        } ?>

        <div class="d-flex justify-content-around bg-light p-3 rounded">
            <form action="<?= FRONT_ROOT . "/Buy/getTotalByDate" ?>" method="POST">
                <p class="h5">Check totals by date / cinema / movie</p>
                <div class="form-group">
                    <div class="d-flex">
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
                    <button type="submit" class="btn btn-success">Get Total</button>
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
                    <div class="d-flex">
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
                    <button type="submit" class="btn btn-success">Get Total</button>
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
<?php include(VIEWS . "/footer.php"); ?>

<script>
    $('#from').on('change', function() {
        var selectValue = $(this).val();

        $('#to').attr('min', selectValue);
        $('#to').prop('disabled', false);

    });

    $('#from2').on('change', function() {
        var selectValue = $(this).val();

        $('#to2').attr('min', selectValue);
        $('#to2').prop('disabled', false);
    });
</script>