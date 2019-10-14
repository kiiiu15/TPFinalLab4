<?php

use Dao\CinemaDao as CinemaDao;

$repo = new CinemaDao();
$list = $repo->GetAll();

?>


<?php include(VIEWS."/header.php");?>
<div class="window-margin">
	<div class="window">
		<aside class="sidebar">
			<div class="top-bar">
				<a href=<?=FRONT_ROOT?> class="logo">MoviePass</a>
			</div>

			<div class="search-box">
				<input type="text" placeholder="Search..."/>
				<p class="fa fa-search"></p>
			</div>


		</aside>


		<div class="main" role="main">

		<?php // esto es el nav

		include_once(VIEWS.'/nav.php');

		?>

               

                <!-- si despues los ordenamos tendria que ser order list ? --->
                <ul class="list">
                    <?php

                    foreach ($list as $cinema) {
						if($cinema->getActive()){						
                    ?>
                    <li>
						<p> ID: <?= $cinema->getIdCinema() ?></p>
                        <p class="title"> Cine: <?= $cinema->getName(); ?></p>
						<p> Direccion: <?= $cinema->getAddress(); ?> </p>
						<p> Capacidad: <?= $cinema->getCapacity(); ?> </p>
						<p> Precio unico por entrada: <?= $cinema->getPrice(); ?> </p>
                    </li>
                    <?php
						}
                    }
                    ?>
                </ul>

				<div>
					<!-- esto esta mu mal -->
					<form action="Remove" method="get">
					
						<input name = idCinemaToRemove type="number" placeholder = "id del cine que quiere dar de baja">

						<button type = submit> Dar de baja </button>
					
					</form>
				
				</div>

				<div>
					<!-- esto esta mu mal -->
					<form action="modify" method="get">
					
						<input name = idCinemaToModify type="number" placeholder = "id del cine que quiere modificar">
						<input name = nameToModify type="text"      placeholder = Cine>
						<input name = addressToModify type="text"   placeholder = Direccion>
						<input name = capacityToModify type="text"  placeholder = Capacidad>
						<input name = priceToModify type="number"   placeholder = "Precio unico por entrada">

						<button type = submit> Modificar </button>
					
					</form>
				
				</div>


			</div> <!-- movie list -->

		</div> <!-- main -->

	</div> <!-- window -->
</div> <!-- window margin -->

<?php include(VIEWS."/footer.php");?>