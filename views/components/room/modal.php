<div class="modal fade" id="add-room" tabindex="-1" role="dialog" aria-labelledby="sign-up" aria-hidden="true">
    <div class="modal-dialog" role="document">

        <form class="modal-content" action="<?= FRONT_ROOT . '/Room/Add' ?>" method="POST">

            <div class="modal-header">
                <h5 class="modal-title">New Room</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="form-group">
                    <label>Cinema to which it belongs</label>
                    <select required name="cinema" class="form-control" id="">
                        <?php foreach ($activeCinemas as $activeCinema) { ?>
                            <option value="<?= $activeCinema->getIdCinema(); ?>"> <?php echo $activeCinema->getName(); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input maxlength="50" required name="roomName" type="text" class="form-control">
                </div>

                <div class="form-group">
                    <label>Capacity</label>
                    <input name='capacity' min='1' max='32767' type="number" required class="form-control">
                </div>

                <div class="form-group">
                    <label>Price</label>
                    <input name='price' min='1' max='32767' type="number" required class="form-control">
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-dark">Add</button>
            </div>
        </form>

    </div>
</div>