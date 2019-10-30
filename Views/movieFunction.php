<?php

?>

<div class="form-cinemaHome">
<label for="" class="label"><button >Add a Movie Function</button></label>
	<form action="" method="post"  id="mod" >
						
			<label for="idToEdit" class="form-cinemaHome-input">Name of the Cinema</label>  

				<select name="idToEdit" id="" class="form-cinemaHome-input">
					<?php foreach ($cines as $cine) {?>
					<option value="<?= $cine->getName();?>"> <?php echo $cine->getName();?></option>
					<?php }?>
							
				</select>
				<input name = nameCinema type="text"      placeholder = "Name of Cinema"  class="form-cinemaHome-input">
				<input name = movie type="text"           placeholder = "Movie" class="form-cinemaHome-input">
				<input name = date type="date"            placeholder = Date class="form-cinemaHome-input">
				<input name = hour type="number"          placeholder = "hour" class="form-cinemaHome-input">
                <button type = submit class="form-cinemaHome-input"> Send the Function </button>
						
	</form>
					
</div>


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


<!--
<form action="/my-handling-form-page" method="post">
    <div>
        <label for="day">Day From Function</label>
        <input type="date" id="date" name="date_function" />
    </div>
    <div>
        <label for="hour">Hour From Function</label>
        <input type="hour" id="hour" name="hour_function" />
    </div>
    <div>
        <label for="cinema">Cinema From Function</label>
        <input id="cinema" name="cinema">
    </div>
    <div>
        <label for="movie">Movie From Function</label>
        <input id="movie" name="movie">
    </div>

    <div class="button">
        <button type="submit">Send Function</button>
    </div>
</form>

<style>
form {
    /* Sólo para centrar el formulario a la página */
    margin: 0 auto;
    width: 400px;
    /* Para ver el borde del formulario */
    padding: 1em;
    border: 1px solid #CCC;
    border-radius: 1em;
}

form div + div {
    margin-top: 1em;
}
label {
    /* Para asegurarse que todos los labels tienen el mismo tamaño y están alineados correctamente */
    display: inline-block;
    width: 90px;
    text-align: right;
}
input, textarea {
    /* Para asegurarse de que todos los campos de texto tienen las mismas propiedades de fuente
       Por defecto, las areas de texto tienen una fuente con monospace */
    font: 1em sans-serif;

    /* Para darle el mismo tamaño a todos los campos de texto */
    width: 300px;
    -moz-box-sizing: border-box;
    box-sizing: border-box;

    /* Para armonizar el look&feel del borde en los campos de texto */
    border: 1px solid #999;
}

input:focus, textarea:focus {
    /* Para dar un pequeño destaque en elementos activos*/
    border-color: #000;
}

textarea {
    /* Para alinear campos de texto multilínea con sus labels */
    vertical-align: top;

    /* Para dar suficiente espacio para escribir texto */
    height: 5em;

    /* Para permitir a los usuarios cambiar el tamaño de cualquier textarea verticalmente
        No funciona en todos los navegadores */
    resize: vertical;
}

.button {
    /* Para posicionar los botones a la misma posición que los campos de texto */
    padding-left: 90px; /* mismo tamaño a todos los elementos label */
}
.button {
    /* Este margen extra representa aproximadamente el mismo espacio que el espacio
       entre los labels y sus campos de texto */
    margin-left: .5em;
}


</style>
-->