<?php include(VIEWS."/header2.php"); ?>
<body>
    <main class="d-flex align-items-center justify-content-center height-100">
        <div class="content">
            <form action="<?= FRONT_ROOT . '/' ?>User/LogIn" method="POST" class="login-form bg-dark-alpha p-5 text-white">
                <div class="form-group">
                    <label for="">Usuario</label>
                    <input type="text" name="email" class="form-control form-control-lg" placeholder="Ingresar usuario">
                </div>
                <div class="form-group">
                    <label for="">Contraseña</label>
                    <input type="text" name="password" class="form-control form-control-lg" placeholder="Ingresar constraseña">
                </div>
                <button class="btn btn-dark btn-block btn-lg" type="submit">Iniciar Sesión</button>
            </form>
                
            <button type="button" class="btn btn-dark btn-block btn-lg" data-toggle="modal" data-target="#register">
                Registrarse
            </button>
            <?php if(isset($successMje) || isset($errorMje)) { ?>
            <div class="alert <?php if(isset($successMje)) echo 'alert-success'; else echo 'alert-danger'; ?> alert-dismissible fade show mt-3" role="alert">
                <strong><?php if(isset($successMje)) echo $successMje; else echo $errorMje; ?></strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php } ?>
            <div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="sign-up" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form class="modal-content" action="<?= FRONT_ROOT . '/User/SignUp' ?>" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title">Registrar usuario</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Email</label>
                                <input required type="text" class="form-control" name="email" />
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input required type="text" class="form-control" name="pass" />
                            </div>
                            <div class="form-group">
                                <label>Name</label>
                                <input required type="text" class="form-control" name="UserName" />
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input required type="text" class="form-control" name="LastName" />
                            </div>
                            <div class="form-group">
                                <label>DNI</label>
                                <input required type="text" class="form-control" name="Dni" />
                            </div>
                            <div class="form-group">
                                <label>Telephone Number</label>
                                <input required type="text" class="form-control" name="TelephoneNumber" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-dark">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

<?php include(VIEWS."/footer.php"); ?>