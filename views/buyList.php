<?php

include(VIEWS . "/header.php");
include(VIEWS . '/nav.php');



?>

<style>
    body {
        background-image: url("http://www.kabu-load.net/data/out/103/IMG_1086101.jpg");
        background-size: cover;
        background-size: 100%;
    }

    h1 {
        color: white;
    }

    label {
        color: white;
    }

    td {
        color: white;
    }
</style>

<main class="p-5">
    <div class="container">

        <h1 class="mb-5">List of Buys</h1>

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



        <table class="table">
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
                            <td> <?php echo  $ticket->getBuy()->getDate(); ?></td>
                            <td> <?php echo  $ticket->getBuy()->getNumberOfTickets(); ?></td>
                            <td> <img src="<?php echo FRONT_ROOT . "/QRS/" . $ticket->getQR() . ".png"; ?>"></td>




                        </tr>
                <?php }
                }
                ?>
            </tbody>
        </table>
        </form>


    </div>
</main>


<?php include(VIEWS . '/footer.php');  ?>