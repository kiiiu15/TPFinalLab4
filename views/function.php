<?php
include(VIEWS . "/header.php");
include(VIEWS . '/adminNav.php');
include_once(COMPONENTS . "/utils/renderAlert.php");


if ($movieFunctionList == false) {
    $movieFunctionList = array();
}

if (!is_array($movieFunctionList)) {
    $movieFunctionList = array($movieFunctionList);
}

if ($activeRooms == false) {
    $activeRooms = array();
}

if (!is_array($activeRooms)) {
    $activeRooms = array($activeRooms);
}

if ($movies == false) {
    $movies = array();
}

if (!is_array($movies)) {
    $movies = array($movies);
}
?>
<main class="p-md-5">
    <div class="container-fluid container-md">

        <h1 class="mb-5">List of Functions</h1>

        <?php render_alert_util($successMje, $errorMje); ?>


        <!--ACA PODRIAMOS PONER UN SELECT PARA QUE ELIJA EL CINE DEL QUE QUIERE VER QUE FUNCIONES HAY
            <form class="form-inline" action="" method="GET">
                <div class="form-group mb-4">
                    <label for="">Activo/Inactivo</label>
                    <select name="active" class="form-control ml-3">
                        <option value="true">Activo</option>
                        <option value="false">Inactivo</option>
                    </select>
                    <button type="submit" class="btn btn-dark ml-3">Enviar</button>
                    
                </div>
            </form>   

            <button type="button" class="btn btn-dark ml-3" data-toggle="modal" data-target="#add-cinema">
                Agregar Cine
            </button> 
        -->


        <div class="bg-light p-3 rounded form-inline flex-column-reverse align-items-stretch flex-sm-row justify-content-sm-between">
            <div class="form-group mx-sm-1">
                <button type="submit" class="btn btn-dark btn-block">Delete Selection</button>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-dark btn-block" data-toggle="modal" data-target="#add-function">
                    Add a Function
                </button>
            </div>
        </div>
        <form class="form-inline" action="<?= FRONT_ROOT ?>/MovieFunction/Delete" method="POST">
            <div class="table-responsive">
                <table class="table table-light table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Id Function</th>
                            <th>Cinema</th>
                            <th>Room</th>
                            <th>Date</th>
                            <th>Hour</th>
                            <th>Movie</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($movieFunctionList as $movieFunction) { ?>
                            <tr>
                                <td><input type="checkbox" name="postschecked[]" value="<?php echo $movieFunction->getId(); ?>"></td>
                                <td> <?php echo $movieFunction->getId(); ?></td>
                                <td> <?php echo $movieFunction->getRoom()->getCinema()->getName(); ?> </td>
                                <td> <?php echo $movieFunction->getRoom()->getName(); ?> </td>
                                <td> <?php echo $movieFunction->getDay(); ?> </td>
                                <td> <?php echo $movieFunction->getHour(); ?> </td>
                                <td> <?php echo $movieFunction->getMovie()->getTitle(); ?> </td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</main>

<?php include(VIEWS . '/components/function/modal.php');  ?>
<?php include(VIEWS . '/footer.php');  ?>