<?php
    
    include(VIEWS."/header2.php");
    include(VIEWS.'/nav2.php');
    
    //EL ARRAY DE LAS COMPRAS
    if ($listBuy == false){
        $listBuy = array();
    }
    if (!is_array($listBuy)){
        $listBuy = array($listBuy);
    }

?>

<style>
body {
	background-image: url("http://www.kabu-load.net/data/out/103/IMG_1086101.jpg");
    background-size:cover;
    background-size:100%;
} 

h1 {
    color:white;
}
label{
    color:white;
}
td{
    color:white;
} 
</style>

<main class="p-5">
        <div class="container">

            <h1 class="mb-5">List of Buy</h1>

            <?php if(isset($successMje) || isset($errorMje)) { ?>
                <div class="alert <?php if(isset($successMje)) echo 'alert-success'; else echo 'alert-danger'; ?> alert-dismissible fade show mt-3" role="alert">
                    <strong><?php if(isset($successMje)) echo $successMje; else echo $errorMje; ?></strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php } ?>
            
        
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Cinema</th>
                            <th>Room</th>
                            <th>Movie</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Discount</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($listBuy as $buy) { ?>
                            <?php if($buy->getState() == true){?>
                            <tr>
                                <td><input type="checkbox" name="postschecked[]" value=""></td>
                                <td> <?php echo $buy->getMovieFunction()->getRoom()->getCinema()->getName();?>    </td>
                                <td> <?php echo $buy->getMovieFunction()->getRoom()->getName();?>    </td>
                                <td> <?php echo $buy->getMovieFunction()->getMovie()->getTitle();?> </td>
                                <td> <?php echo  $buy->getDate();?></td>
                                <td> <?php echo  $buy->getTotal();?></td>
                                <td> <?php echo  $buy->getDiscount();?></td>
                                <td> <?php echo  $buy->getUser()->GetEmail();?></td>
                             
                            </tr>
                        <?php } 
                        }
                        ?>
                    </tbody>
                </table>
            </form>

            <!-- Esto como si no existiera -->
            <?php if(isset($successMje) || isset($errorMje)) { ?>
                <div class="alert <?php if(isset($successMje)) echo 'alert-success'; else echo 'alert-danger'; ?> alert-dismissible fade show mt-3" role="alert">
                    <strong><?php if(isset($successMje)) echo $successMje; else echo $errorMje; ?></strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php } ?>
        </div>
    </main>


    <?php include(VIEWS.'/footer.php');  ?>