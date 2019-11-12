<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="<?= FRONT_ROOT ?>">MoviePass</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?= FRONT_ROOT ?>">Show List Movies</a>
            </li>
            <li class="nav-item">
                <!-- 
                    corregir esto
                 -->
                <a class="nav-link" href="<?= FRONT_ROOT . '/Payment' ?>">Payment</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= FRONT_ROOT . '/Cinema' ?>">Add Cinema</a>   
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= FRONT_ROOT . '/Room' ?>">Add Rooms</a>   
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= FRONT_ROOT . '/MovieFunction' ?>">Add Function</a>   
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= FRONT_ROOT . '/User/LogOut' ?>">Logout</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= FRONT_ROOT . '/CreditCard' ?>">prueba</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= FRONT_ROOT . '/Buy' ?>">verTotal</a>
            </li>
        </ul>
        <!-- <span class="navbar-text text-white"> -->
            <!-- <strong>(Hola <?php// echo $user->getName(); ?>)</strong> -->
        <!-- </span> -->
    </div>
</nav>