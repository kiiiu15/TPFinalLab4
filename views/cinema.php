<?php

include(VIEWS . "/header.php");
include(VIEWS . '/adminNav.php');
if ($cinemaList == false) {
    $cinemaList = array();
}
if (!is_array($cinemaList)) {
    $cinemaList = array($cinemaList);
}

?>

<main class="p-5">
    <div class="container">

        <h1 class="mb-5">List of Cinemas</h1>

        <?php if (isset($successMje) || isset($errorMje)) {
            require_once(VIEWS . "/components/cinema/alert.php");
        } ?>

        <form action="<?= FRONT_ROOT ?>/Cinema/ChangeCinemaState" method="POST">
            <div class="bg-light p-3 rounded d-flex justify-content-between">
                <div class="form-inline">
                    <div class="form-group ">
                        <label for="active">Active/Inactive</label>
                        <select name="active" class="form-control mx-2">
                            <option value="true">Active</option>
                            <option value="false">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-dark">Send</button>
                </div>
                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#add-cinema">
                    Add a Cinema
                </button>
            </div>

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
        </form>
    </div>
</main>

<?php require_once(VIEWS . "/components/cinema/modal.php"); ?>

<?php include(VIEWS . '/footer.php');  ?>