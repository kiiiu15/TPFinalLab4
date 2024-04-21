<div class="modal fade" id="add-cinema" tabindex="-1" role="dialog" aria-labelledby="sign-up" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content" action="<?= FRONT_ROOT . '/Cinema/Add' ?>" method="POST">

            <div class="modal-header">
                <h5 class="modal-title">New Cinema</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="cinemaName">Name</label>
                    <input required name="cinemaName" type="text" maxlength="50" class="form-control">
                </div>
                <div class="form-group">
                    <label for="adress">Adress</label>
                    <input required name="adress" type="text" maxlength="100" class="form-control">
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-dark">Add</button>
            </div>
        </form>

    </div>
</div>