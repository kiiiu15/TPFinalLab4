<?php

use Dao\CinemaDao as CinemaDao;

$repo = new CinemaDao();
$list = $repo->GetAll();

$ids = $repo->getIDCinemaActiva ();

?>


<?php include(VIEWS."/header.php");?>
<div class="window-margin">
	<div class="window">
		<aside class="sidebar">
			<div class="top-bar">
				<a href="<?= FRONT_ROOT ?>/Home" class="logo">MoviePass</a>
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

               

                <div class="float">
					<table  >
						<thead>
						<td>ID</td>
						<td>Cine</td>
						<td>Direccion</td>
						<td>Capacidad</td>
						<td>Precio </td>
						</thead>
						<tbody>
						<tr>
						<?php
						foreach ($list as $cinema) {
							if($cinema->getActive()){						
						?>
						
							<td>  <?= $cinema->getIdCinema(); ?></td>
							<td >  <?= $cinema->getName(); ?></td>
							<td>  <?= $cinema->getAddress(); ?> </td>
							<td>  <?= $cinema->getCapacity(); ?> </td>
							<td>  <?= $cinema->getPrice(); ?> </td>
						
						<?php
							} ?>
							</tr>
						<?php	
						}
						
						?>
						</tbody>
					</table>
				</div>

				<div class="float">

					<div class="form-cinemaHome">
						<label for="" class="label"><button >Agregar Cine</button> </label>
						
						<form action="<?php echo FRONT_ROOT ?>/Cinema/add" method="post"  id="add"	>
						
							<input name = nameToModify type="text"      placeholder = Cine  class="form-cinemaHome-input">
							<input name = addressToModify type="text"   placeholder = Direccion class="form-cinemaHome-input">
							<input name = capacityToModify type="text"  placeholder = Capacidad class="form-cinemaHome-input">
							<input name = priceToModify type="number"   placeholder = "Precio unico por entrada" class="form-cinemaHome-input">

							<button type = submit class="form-cinemaHome-input"> Grabar </button>
						
						</form>
					
					</div>



					<div class="form-cinemaHome" >

						<label  for = "" class="label"> <button >Borrar Cine</button></label>	
						<form action="<?php echo FRONT_ROOT ?>/Cinema/Deactivate" method="post"  id="del" >
						
							<label  for = "idToDelete" class="form-cinemaHome-input">id del cine que quiere dar de baja </label>

							<select name="idToDelete" id="" class="form-cinemaHome-input">
								<?php foreach ($ids as $id) {?>
								<option value="<?= $id?>"> <?php echo $id;?></option>
								<?php }?>
							
							</select>

							<button type = submit class="form-cinemaHome-input"> Dar de baja </button>
						
						</form>
					
					</div>



					<div class="form-cinemaHome">
						<label for="" class="label"><button >Modificar Cine</button></label>
						<form action="<?php echo FRONT_ROOT ?>/Cinema/modify" method="post"  id="mod" >
						
							<label for="idToEdit" class="form-cinemaHome-input">id del cine que quiere modificar</label>  

							<select name="idToEdit" id="" class="form-cinemaHome-input">
								<?php foreach ($ids as $id) {?>
								<option value="<?= $id?>"> <?php echo $id;?></option>
								<?php }?>
							
							</select>
							<input name = nameToModify type="text"      placeholder = Cine  class="form-cinemaHome-input">
							<input name = addressToModify type="text"   placeholder = Direccion class="form-cinemaHome-input">
							<input name = capacityToModify type="text"  placeholder = Capacidad class="form-cinemaHome-input">
							<input name = priceToModify type="number"   placeholder = "Precio unico por entrada" class="form-cinemaHome-input">

							<button type = submit class="form-cinemaHome-input"> Modificar </button>
						
						</form>
					
					</div>

				</div>




			</div> <!-- movie list -->

		</div> <!-- main -->

	</div> <!-- window -->
</div> <!-- window margin -->


<style>

.float {
	float:left;
}
table  {
	margin : 2px;
}


td {
		border: solid 3px black;
}

.form-cinemaHome{
	display : block;
	margin : 2px;
	width : 308px;
	border : solid 2px black;
}

.label {
	display : block;
	margin : 2px;
	width : 300px;
	border : solid 2px black;
}
.form-cinemaHome-input {
	display : block;
	margin : 2px;
	width : 300px;
	border : solid 2px black;
}
</style>

<?php include(VIEWS."/footer.php");?>