<?php
include(VIEWS . "/header.php");
include(VIEWS . '/adminNav.php');

//$rooms = array();
//$activeCinemas = array();
?>

<main class="p-md-5">
    <div class="container-fluid container-md">

        <h1 class="mb-5">List of Rooms</h1>

        <form action="<?= FRONT_ROOT . '/Room/delete' ?>" method="POST">

            <div class="bg-light p-3 rounded form-inline flex-column-reverse align-items-stretch flex-sm-row justify-content-sm-between">
                <div class="form-group">
                    <button type="submit" class="btn btn-dark btn-block">Deactivate</button>
                </div>
                <div class="form-group mx-sm-1">
                    <button type="button" class="btn btn-dark btn-block" data-toggle="modal" data-target="#add-room">
                        Add a Room
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-light table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Id Room</th>
                            <th>Name</th>
                            <th>Cinema</th>
                            <th>Capacity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rooms as $room) { ?>
                            <tr>
                                <td><input type="checkbox" name="postschecked[]" value="<?php echo $room->getId(); ?>"></td>
                                <td> <?php echo $room->getId(); ?> </td>
                                <td> <?php echo $room->getName(); ?> </td>
                                <td> <?php echo $room->getCinema()->getName(); ?> </td>
                                <td> <?php echo $room->getCapacity(); ?></td>
                                <td> <?php echo $room->getPrice(); ?> </td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </form>

        <?php if (isset($successMje) || isset($errorMje)) {
            require_once(VIEWS . "/components/room/alert.php");
        } ?>
    </div>
</main>

<?php include(VIEWS . '/components/room/modal.php');  ?>

<?php include(VIEWS . '/footer.php');  ?>