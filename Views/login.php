<?php include(VIEWS."/header2.php"); ?>

<style>
body {
	background-image: url("http://www.kabu-load.net/data/out/103/IMG_1086093.jpg");
    background-size:cover;
    background-size:100%;
} 
label{
    color:white;
}
td{
    color:white;
} 
</style>

<body>
    <main class="d-flex align-items-center justify-content-center height-100">
        <div class="content">
            <form action="<?= FRONT_ROOT . '/User/LogIn' ?>" method="POST" class="login-form bg-dark-alpha p-5 text-white">
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" name="email" class="form-control form-control-lg" placeholder="Ingresar usuario" required>
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Ingresar constraseña" required>
                </div>
                <button class="btn btn-dark btn-block btn-lg" type="submit">Log In</button>
                <button type="button" class="btn btn-dark btn-block btn-lg" data-toggle="modal" data-target="#register">
                    Sign Up
                </button>
            </form>
            <?php /*
                require_once (ROOT."/FacebookConfig.php");
                $url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
                echo "<br><a href=" . htmlspecialchars($loginUrl) . ">LOGIN FACEBOOOK</a>";*/
            ?>
                
            
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
                                <label style="color:black;">Email</label>
                                <input required type="text" class="form-control" name="email" />
                            </div>
                            <div class="form-group">
                                <label style="color:black;">Password</label>
                                <input required type="text" class="form-control" name="pass" />
                            </div>
                            <div class="form-group">
                                <label style="color:black;">Name</label>
                                <input required type="text" class="form-control" name="UserName" />
                            </div>
                            <div class="form-group">
                                <label style="color:black;">Last Name</label>
                                <input required type="text" class="form-control" name="LastName" />
                            </div>
                            <div class="form-group">
                                <label style="color:black;">DNI</label>
                                <input required type="text" class="form-control" name="Dni" />
                            </div>
                            <div class="form-group">
                                <label style="color:black;">Telephone Number</label>
                                <input required type="text" class="form-control" name="TelephoneNumber" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button  type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                            <button  type="submit" class="btn btn-link" >Sign Up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

<?php include(VIEWS."/footer.php"); ?>