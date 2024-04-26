<?php

include(PARTIALS . "/header.php");
include(PARTIALS . '/adminNav.php');
include_once(COMPONENTS . "/utils/renderAlert.php");

if ($cinemaList == false) {
    $cinemaList = array();
}
if (!is_array($cinemaList)) {
    $cinemaList = array($cinemaList);
}

?>

<main class="p-2 p-md-5">
    <div class="container-md">

        <h1 class="mb-5">List of Cinemas</h1>

        <?php render_alert_util($successMje, $errorMje); ?>

        <form action="<?= FRONT_ROOT ?>/Cinema/ChangeCinemaState" method="POST">
            <div class="bg-light p-3 rounded d-flex flex-column flex-sm-row justify-content-sm-between">
                <div class="form-inline flex-column align-items-stretch flex-sm-row ">
                    <div class="form-group d-flex flex-column flex-sm-row d-sm-inline-flex align-items-sm-baseline">
                        <label class="mb-0" for="active">Active/Inactive</label>
                        <select name="active" class="form-control mx-sm-2">
                            <option value="true">Active</option>
                            <option value="false">Inactive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-dark btn-block">Send</button>
                    </div>
                </div>
                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#add-cinema">
                    Add a Cinema
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-light table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Id Cinema</th>
                            <th>Name</th>
                            <th>Adress</th>
                            <th>State</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cinemaList as $cinema) { ?>
                            <tr>
                                <td><input type="checkbox" name="postschecked[]" value="<?php echo $cinema->getIdCinema(); ?>"></td>
                                <td> <?php echo $cinema->getIdCinema(); ?> </td>
                                <td> <?php echo $cinema->getName(); ?> </td>
                                <td> <?php echo $cinema->getAddress(); ?> </td>
                                <td> <?php echo ($cinema->getActive()) ? "Active" : "Inactive"; ?></td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</main>

<?php require_once(VIEWS . "/components/cinema/modal.php"); ?>

<?php include(PARTIALS . '/footer.php');  ?>