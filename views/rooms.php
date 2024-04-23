<?php
include(VIEWS . "/header.php");
include(VIEWS . '/adminNav.php');

//$rooms = array();
//$activeCinemas = array();
?>

<style>
    body {
        background-image: url("https://d2v9y0dukr6mq2.cloudfront.net/video/thumbnail/V7QIfdTcgikqxmxok/cinema-background_vzw7c2tqe__F0000.png");
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

        <h1 class="mb-5">List of Rooms</h1>





        <!-- LES DEJO ESTO DEL MULTI ACTION POR SI SE LES OCURRE QUE LES PUEDE SERVIR MAS ADELANTE -->
        <!-- <div class="form-group mb-4"> -->
        <!-- <button type="button" class="btn btn-light mr-4" data-toggle="modal" data-target="#create-post"> -->
        <!-- <object type="image/svg+xml" data="<?php //ICONS."/plus.svg"
                                                ?>" width="16" height="16"></object> -->
        <!-- </button> -->

        <!-- <label for="">Accion múltiple</label> -->
        <!-- <select name="action" class="form-control ml-3"> -->
        <!-- <option value="trash">Eliminar</option> -->
        <!-- <option value="enable">Publicar</option> -->
        <!-- <option value="disable">Despublicar</option> -->
        <!-- </select> -->
        <!-- <button type="submit" class="btn btn-dark ml-3">Enviar</button> -->
        <!-- </div> -->



        <!-- LOS GET NO ESTAN FUNCIONANDO -->
        <form class="form-inline" action="<?= FRONT_ROOT . '/Room/delete' ?>" method="POST">
            <div class="form-group mb-4">

                <button type="submit" class="btn btn-dark ml-3">Deactivate</button>

                <!-- 
                        en realidad este button no tiene nada que ver con el form este, pero si lo ponia afuera quedava re feo :)
                     -->
                <button type="button" class="btn btn-dark ml-3" data-toggle="modal" data-target="#add-room">
                    Add a Room
                </button>
            </div>

            <table class="table">
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
                    <!-- 
                        ACA TENEMOS UN PROBLEMA,
                        SI POR ALGUNA RAZON SOLO RECIVE UN UNICO CINE, SE ROMPE EL FOREACH Y NO SE VE NADA 
                     -->
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
        </form>

        <!-- Esto como si no existiera -->
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
    </div>
</main>


<div class="modal fade" id="add-room" tabindex="-1" role="dialog" aria-labelledby="sign-up" aria-hidden="true">
    <div class="modal-dialog" role="document">

        <form class="modal-content" action="<?= FRONT_ROOT . '/Room/Add' ?>" method="POST">

            <div class="modal-header">
                <h5 class="modal-title">Add a Room</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="form-group">
                    <label style="color:black;">Cinema to which it belongs</label>
                    <select required name="cinema" id="">
                        <?php foreach ($activeCinemas as $activeCinema) { ?>
                            <option style="color:black;" value="<?= $activeCinema->getIdCinema(); ?>"> <?php echo $activeCinema->getName(); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label style="color:black;">Name</label>
                    <input style="color:black;" maxlength="50" required name="roomName" type="text">
                </div>

                <div class="form-group">
                    <label style="color:black;">Capacity</label>
                    <input style="color:black;" name='capacity' min='1' max='32767' type="number" required onkeypress="return false">
                </div>

                <div class="form-group">
                    <label style="color:black;">Price</label>
                    <input style="color:black;" name='price' min='1' max='32767' type="number" required onkeypress="return false">
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-dark">Add</button>
            </div>
        </form>

    </div>
</div>




<?php include(VIEWS . '/footer.php');  ?>