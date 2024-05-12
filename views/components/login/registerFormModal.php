<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="sign-up" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <form class="modal-content" action="<?= FRONT_ROOT . '/User/SignUp' ?>" method="POST">
            <div class="modal-header">
                <p class="modal-title h5">Registrar usuario</p>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group text-dark">
                    <label class="form-label" for="email">Email</label>
                    <input required type="email" class="form-control" name="email" />
                </div>
                <div class="form-group">
                    <label class="form-label" for="pass">Password</label>
                    <input required type="password" class="form-control" name="pass" />
                </div>
                <div class="form-group">
                    <label class="form-label" for="UserName">Name</label>
                    <input required type="text" class="form-control" name="UserName" />
                </div>
                <div class="form-group">
                    <label class="form-label" for="LastName">Last Name</label>
                    <input required type="text" class="form-control" name="LastName" />
                </div>
                <div class="form-group">
                    <label class="form-label" for="Dni">DNI</label>
                    <input required type="text" class="form-control" name="Dni" />
                </div>
                <div class="form-group">
                    <label class="form-label" for="TelephoneNumber">Telephone Number</label>
                    <input required type="tel" class="form-control" name="TelephoneNumber" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</<a>
                    <button type="submit" class="btn btn-primary">Sign Up</button>
            </div>
        </form>
    </div>
</div>