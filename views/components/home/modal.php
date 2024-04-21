<div class="modal fade" id="show-movie" tabindex="-1" role="dialog" aria-labelledby="sign-up" aria-hidden="true">
    <div class="modal-dialog" role="document">

        <form class="modal-content" action="<?= FRONT_ROOT ?>/Buy/ReciveBuy" method="POST">

            <div class="modal-header">
                <p id="title" class="modal-title h5"></p>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">


                <div class="form-group">
                    <label>Cinemas</label>
                    <select required id="options" name="" class="form-control">
                        <option value="" disabled selected>Select a Cinema</option>

                    </select>
                </div>


                <div class="form-group">
                    <label>Functions</label>
                    <select id="choices" required name="idFunction" class="form-control">
                    </select>
                </div>

                <div class="form-group">
                    <label>Number Of Tickets</label>
                    <input class="form-control" name="quantity" min='1' type="number" required>
                </div>


            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-dark">Buy</button>
            </div>
        </form>

    </div>
</div>