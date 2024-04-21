<?php include(VIEWS . "/header.php"); ?>

<main class="h-100 container d-flex flex-column justify-content-center align-items-lg-center">

    <h1 class="text-white">MoviePass</h1>
    <form action="<?= FRONT_ROOT . '/User/LogIn' ?>" method="POST" class="bg-secondary rounded p-4 text-white">
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input type="text" name="email" class="form-control form-control-lg" placeholder="Email" required>
        </div>
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
        </div>
        <button class="btn btn-dark btn-block btn-lg" type="submit">Log In</button>
        <button type="button" class="btn btn-dark btn-block btn-lg" data-toggle="modal" data-target="#register">
            Sign Up
        </button>
        <?php
        require_once(ROOT . "/FacebookConfig.php");
        $url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $str = "<a href=" . htmlspecialchars($loginUrl) . ">Facebook LogIn</a>";
        ?>
        <button class="btn btn-dark btn-block btn-lg" type="button"><?= $str ?></button>
    </form>

    <?php
    if (isset($successMje) || isset($errorMje)) {
        require_once(VIEWS . "/components/login/loginOperationResultAlert.php");
    }
    ?>

    <?php require_once(VIEWS . "/components/login/registerFormModal.php"); ?>

</main>

<?php include(VIEWS . "/footer.php"); ?>