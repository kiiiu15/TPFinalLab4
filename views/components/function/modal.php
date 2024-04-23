<div class="modal fade" id="add-function" tabindex="-1" role="dialog" aria-labelledby="sign-up" aria-hidden="true">
    <div class="modal-dialog" role="document">

        <form class="modal-content" action="<?= FRONT_ROOT . '/MovieFunction/Add' ?>" method="POST">

            <div class="modal-header">
                <h5 class="modal-title">Add a Function</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Movie</label>
                    <select required name="idMovie" id="idMovie" class="form-control">
                        <?php foreach ($movies as $movie) { ?>
                            <option value="<?= $movie->getId(); ?>"><?= $movie->getTitle(); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Room</label>
                    <select required name="idCienma" class="form-control">
                        <?php foreach ($activeRooms as $activeRoom) { ?>
                            <option value="<?= $activeRoom->getId(); ?>"><?php echo $activeRoom->getName() . " - " . $activeRoom->getCinema()->getName(); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Date</label>
                    <input required name="date" type="date" min="<?php echo date("Y-m-d"); ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label>Hour</label>
                    <input required name="hour" type="time" class="form-control">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-dark">Add</button>
            </div>
        </form>

    </div>
</div>