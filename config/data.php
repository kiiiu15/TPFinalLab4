<?php

/* DATABASE */
if (1 === 1) {
    /* FRONT */
    define('FRONT_ROOT', 'http://localhost/TPFinalLab4');

    /* BACK */
    define('ROOT', dirname(__DIR__));

    define('DB_HOST', 'localhost');
    define('DB_NAME', 'moviepass');
    define('DB_USER', 'root');
    define('DB_PASS', '');
} else {
    /* FRONT */
    define('FRONT_ROOT', 'http://localhost/TPFinalLab4');

    /* BACK */
    define('ROOT', dirname(__DIR__));

    define('DB_HOST', 'localhost');
    define('DB_NAME', 'moviepass');
    define('DB_USER', 'root');
    define('DB_PASS', '');
}



/* BACK */
define('VIEWS', ROOT . '/views');
define('COMPONENTS', VIEWS . '/components');
define('PARTIALS', VIEWS . '/partials');
define('PAGES', VIEWS . '/pages');
define('ADMIN_ROLE', 'admin');
//define('ADMIN_VIEWS', ROOT . '/views/admin'); todabia no quedo claro como va a quedar esto
//define('IMG_UPLOADS', ROOT . '/asset/uploads/img');


/* FRONT */
define('STYLE', FRONT_ROOT . '/public/css');
define('JS', FRONT_ROOT . '/public/js');
define('ICONS', VIEWS . '/icons');
define('MOVIE_POSTER_URL_PREFIX', 'https://image.tmdb.org/t/p/w200');

date_default_timezone_set('America/Argentina/Buenos_Aires');
//define('ADMIN_FRONT_ROOT', FRONT_ROOT . '/admin');
//define('CSS_PATH', FRONT_ROOT . '/asset/css');
//define('IMG_PATH', FRONT_ROOT . '/asset/img');

//define('IMG_UPLOADS_PATH', FRONT_ROOT . '/asset/uploads/img');
//define('MOV_UPLOADS_PATH', FRONT_ROOT . '/asset/uploads/movies');
