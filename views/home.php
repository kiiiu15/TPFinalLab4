<?php

use repository\MovieRepository as MovieRepository;

$repo = new MovieRepository();
$list = $repo->GetAll();

?>


<?php include(VIEWS."/header.php");?>
<div class="window-margin">
	<div class="window">
		<aside class="sidebar">
			<div class="top-bar">
				<p class="logo">MoviePass</p>
			</div>

			<div class="search-box">
				<input type="text" placeholder="Search..."/>
				<p class="fa fa-search"></p>
			</div>

			<menu class="menu">
				<p class="menu-name">Movie trailers</p>
				<ul>
					<li class="active">
						<a href="#">Action / Adventure</a>
						<ul>
							<li><a href="#">Latest</a></li>
							<li class="active"><a href="#">Popular</a></li>
							<li><a href="#">Coming soon</a></li>
							<li><a href="#">Staff picks</a></li>
						</ul>
					</li>
					<li><a href="#">Animation</a></li>
					<li><a href="#">Comedy</a></li>
					<li><a href="#">Documentaries</a></li>
					<li><a href="#">Drama</a></li>
					<li><a href="#">Horror</a></li>
					<li><a href="#">Sci-Fi  / Fantasy</a></li>
					<li><a href="#">List A-Z</a></li>
				</ul>

				<div class="separator"></div>

				<ul class="no-bullets">
					<li><a href="#">Latest news</a></li>
					<li><a href="#">Critic reviews</a></li>
					<li><a href="#">Box office</a></li>
					<li><a href="#">Top 250</a></li>
				</ul>

				<div class="separator"></div>
			</menu>
		</aside>


		<div class="main" role="main">

			<div class="top-bar">

				<ul class="top-menu">
					<li class="menu-icon trigger-sidebar-toggle">
						<div class="line"></div>
						<div class="line"></div>
						<div class="line"></div>
					</li>
					<li><a href="#">Ver Listado Peliculas</a></li>
					<li><a href="Cinema/getAll">Ver Listado Cines</a></li>
					<li class="active"><a href="#">Movies & Films</a></li>
					<li><a href="#">Television</a></li>
				</ul>

				<div class="profile-box">
					<div class="circle"></div>
					<span class="arrow fa fa-angle-down"></span>
				</div>

			</div>

			<div class="movie-list">
				<div class="title-bar">
					<div class="left">
						<p class="bold">Popular Trailers</p>
						<p class="grey">Action / Adventure</p>
					</div> <!-- left -->
					<div class="right">
						<a class="blue" href="#">Rating <i class="fa fa-angle-down"></i></a>
						<a href="#">Newest</a>
						<a href="#">Oldest</a>
					</div> <!-- right -->
                </div> <!-- title-bar -->
                

                <!-- si despues los ordenamos tendria que ser order list --->
                <ul class="list">
                    <?php

                    //yo se q eseto esta mal, despues lo muevo a donde corresponde
  /*                  $repo = new MovieRepository();
                    $list = $repo->GetAll();
*/
                    foreach ($list as $movie) {
                        //var_dump($movie);
                    ?>
                    <li>
                        <img src="<?php echo $movie->getPoster(); ?>" alt="" class="cover" />
						<?php 
						
						/*

						POR ALGUNA RAZON A VECES EN LUGAR DE MOSTRAR LA RUTA DEL POSTERT
						MUESTRA LA FECHA



						*/
						
						?>
                        <p class="title"> <?= $movie->getTitle(); ?></p>
                    </li>
                    <?php
                    }
                    ?>
                </ul>
<!--
				<ul class="list">
					<li>
						<img src="https://res.cloudinary.com/dddcqqk0g/image/upload/v1394283880/2014-03-08_140248_fmufrz.png" alt="" class="cover" />
						<p class="title">Divergent</p>
						<p class="genre">Action, Sci-Fi</p>
					</li>
				</ul>

				<a href="#" class="load-more">Show more movies <span class="fa fa-plus"></span></a>
-->
			</div> <!-- movie list -->


		</div> <!-- main -->

	</div> <!-- window -->
</div> <!-- window margin -->
<script src='//production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script>
<script >jQuery(document).ready(function($) {

	$('a').on('click', function(e) {
		e.preventDefault();
	});

	$('.trigger-sidebar-toggle').on('click', function() {
		$('body').toggleClass('sidebar-is-open');
	});

});
//# sourceURL=pen.js
</script>
<?php include(VIEWS."/header.php");?>