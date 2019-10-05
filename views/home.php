<?php

include_once "config/autoload.php";
use config\autoload as autoload;
autoload::Start();

?>


<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->


<!DOCTYPE html><html class=''>
<head><script src='//production-assets.codepen.io/assets/editor/live/console_runner-079c09a0e3b9ff743e39ee2d5637b9216b3545af0de366d4b9aad9dc87e26bfd.js'></script><script src='//production-assets.codepen.io/assets/editor/live/events_runner-73716630c22bbc8cff4bd0f07b135f00a0bdc5d14629260c3ec49e5606f98fdd.js'></script><script src='//production-assets.codepen.io/assets/editor/live/css_live_reload_init-2c0dc5167d60a5af3ee189d570b1835129687ea2a61bee3513dee3a50c115a77.js'></script><meta charset='UTF-8'><meta name="robots" content="noindex"><link rel="shortcut icon" type="image/x-icon" href="//production-assets.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico" /><link rel="mask-icon" type="" href="//production-assets.codepen.io/assets/favicon/logo-pin-f2d2b6d2c61838f7e76325261b7195c27224080bc099486ddd6dccb469b8e8e6.svg" color="#111" /><link rel="canonical" href="https://codepen.io/AyhanALTINOK/pen/Atlva" />

<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'><script src='https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js'></script>

<link rel="stylesheet" href="style/peliculas.css" class="cp-pen-styles">

</head>
<body>
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
					<li><a href="#">Articles</a></li>
					<li class="active"><a href="#">Movies & Films</a></li>
					<li><a href="#">Television</a></li>
					<li><a href="#">Music</a></li>
					<li><a href="#">Celebrities</a></li>
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
                    use repository\PeliRepository as PeliRepository;
                    $repo = new PeliRepository();
                    $list = $repo->GetAll();

                    foreach ($list as $peli) {
                        
                    ?>
                    <li>
                        <img src="<?php echo $peli->getPoster(); ?>" alt="" class="cover" />
                        <p class="title"> <?= $peli->getNombre(); ?></p>
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
</body></html>