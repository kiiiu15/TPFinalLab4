<?php
include(VIEWS."/header2.php");
include(VIEWS."/adminNav.php");
?>




<main class="p-5">
    <div class="container">

        <label class="mb-5" style="color:white;">TOTAL BUY: </label> 
        <label style="color:white;"><?=$totalSold;?></label> <br>
        <label class="mb-5" style="color:white;">TOTAL TICKETS:</label>
        <label style="color:white;"><?=$totalTicketsSold;?></label> <br>

        <?php if(isset($successMje) || isset($errorMje)) { ?>
                <div class="alert <?php if(isset($successMje)) echo 'alert-success'; else echo 'alert-danger'; ?> alert-dismissible fade show mt-3" role="alert">
                    <strong><?php if(isset($successMje)) echo $successMje; else echo $errorMje; ?></strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php } ?>

        <form  action="<?= FRONT_ROOT . "/Buy/getTotalByDate" ?>" method="post" style="color:white;">
            <div class="form-group mb-4">
                <h5 class="modal-title" style="color:white;">check totals by date / cinema / movie</h5> <br>
                <div class="form-group">
                    <label style="color:white;"> From date</label>
                    <input style="color:black;" type="date" required name="fromDate"><br>
                </div>
                <div class="form-group">
                    <label style="color:white;">To date</label>
                    <input style="color:black;" type="date" required name="toDate"><br>
                </div>
                <div class="form-group">
                    <label style="color:white;">Cinemas</label>
                    <select style="color:black;" name="cinema" class="form-control ml-3">
                        <option value="">Any</option>
                    <?php 
                    foreach ($cinemaList as $cinema) {
                    ?>    
                        <option value="<?= $cinema->getIdCinema() ?>"><?= $cinema->getName() ?></option>
                    <?php
                    }
                    ?>
                </div>
                <div class="form-group">
                    </select>
                    <label style="color:white;" >Movies</label>
                    <select style="color:black;"  name="movie" class="form-control ml-3">
                        <option value="">Any</option>
                    <?php 
                        foreach ($movieList as $movie) {
                    ?>
                        <option value="<?=$movie->getId();?>"><?=$movie->getTitle();?></option>
                    <?php
                        }
                    ?>
                    </select>
                </div>
                <button type="submit">Get Total</button>
            </div>
        </form>
                
                
        <form action="<?= FRONT_ROOT . "/Buy/getTotalTicketsSold" ?>" method="post">
            <div class="form-group mb-4">
                <h5 class="modal-title" style="color:white;" >check total of tickets by date / cinema / movie</h5> <br>
                <div class="form-group">   
                    <label style="color:white;" >From date</label>
                    <input type="date" required name="fromDate"> <br>
                </div>
                <div class="form-group">
                    <label style="color:white;" >To date</label>
                    <input type="date" required name="toDate"> <br>
                </div>
                <div class="form-group">
                    <label style="color:white;" >Cinemas</label>
                    <select name="cinema" class="form-control ml-3" >
                        <option value="" >Any</option>
                    <?php 
                    foreach ($cinemaList as $cinema) {
                    ?>    
                        <option value="<?= $cinema->getIdCinema() ?>"><?= $cinema->getName() ?></option>
                    <?php
                    }
                    ?>
                    </select>
                </div>
                <div class="form-group">
                    <label style="color:white;" >Movies</label>
                    <select  name="movie" class="form-control ml-3">
                        <option value="">Any</option>
                    <?php 
                        foreach ($movieList as $movie) {
                    ?>
                        <option value="<?=$movie->getId();?>"><?=$movie->getTitle();?></option>
                    <?php
                        }
                    ?>
                    </select>
                </div>
                <button type="submit">Get Total</button>
            </div>
        </form>

    </div>
</main>
<style>
body {
	background-image: url("https://www.pixelstalk.net/wp-content/uploads/images1/1920x1080-movie-theatre-wallpaper.jpg");
    background-size:cover;
    background-size:100%;
} 
</style>

<?php
include(VIEWS."/footer.php");
?>