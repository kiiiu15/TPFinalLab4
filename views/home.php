<?php

use Dao\MovieDao as MovieDao;

$repo = new MovieDao();
$list = $repo->GetAll();

?>


<?php include(VIEWS."/header.php");?>
<div class="window-margin">
	<div class="window">
		<aside class="sidebar">
			<div class="top-bar">
				<a href=<?=FRONT_ROOT?>  class="logo">MoviePass</a>
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

		<?php // esto es el nav

		include_once(VIEWS.'/nav.php');

		?>


			<div class="movie-list">
				<div class="title-bar">
					<div class="left">
						<p class="bold">Popular Trailers</p>
						<p class="grey">Action / Adventure</p>
					</div> <!-- left -->
					<div class="right">
						<a class="blue" href="#">Rating <i class="fa fa-angle-down"></i></a>
						<a href="#">Newest</a> <!-- esto nos mandaria a la controladora y reordenaria $list segun fecha -->
						<a href="#">Oldest</a>
					</div> <!-- right -->
                </div> <!-- title-bar -->
                

                <!-- si despues los ordenamos tendria que ser order list ? --->
                <ul class="list">
                    <?php

                    foreach ($list as $movie) {
                      
                    ?>
                    <li>
                        <img src="<?php echo $movie->getPoster(); ?>" alt="" class="cover" />
						
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
</div> <!-- window margin -->  <!--
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
</script>-->
<?php include(VIEWS."/header.php");?>