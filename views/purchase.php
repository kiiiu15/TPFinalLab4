<?php
include(VIEWS . "/header.php");
include(VIEWS . '/nav.php');
include_once(COMPONENTS . "/utils/renderAlert.php");
?>

<main class="p-md-5">
    <div class="container-fluid container-md">

        <h1 class="mb-5">List of Buys</h1>

        <?php render_alert_util($successMje, $errorMje); ?>

        <div class="table-responsive">
            <table class="table table-light table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Cinema</th>
                        <th>Room</th>
                        <th>Movie</th>
                        <th>Date</th>
                        <th>Number of Tickets </th>
                        <th>QR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ticketsPurchased as $ticket) { ?>
                        <?php if ($ticket->getBuy()->getState() == true) { ?>
                            <tr>
                                <td> <?php echo $ticket->getBuy()->getMovieFunction()->getRoom()->getCinema()->getName(); ?> </td>
                                <td> <?php echo $ticket->getBuy()->getMovieFunction()->getRoom()->getName(); ?> </td>
                                <td> <?php echo $ticket->getBuy()->getMovieFunction()->getMovie()->getTitle(); ?> </td>
                                <td> <?php echo $ticket->getBuy()->getDate(); ?></td>
                                <td> <?php echo $ticket->getBuy()->getNumberOfTickets(); ?></td>
                                <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#qrModal" data-qr="<?= FRONT_ROOT . "/QRS/" . $ticket->getQR() . ".png"; ?>">View QR</button></td>
                            </tr>
                    <?php }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include(VIEWS . '/components/purchase/modal.php');  ?>
<?php include(VIEWS . '/footer.php');  ?>
<?php include(VIEWS . '/components/purchase/modalScript.php');  ?>
