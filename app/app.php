<?php

    require_once __DIR__.'/../vendor/autoload.php';
    require_once __DIR__.'/../src/Author.php';
    require_once __DIR__.'/../src/Book.php';


    //twig
    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(),array('twig.path' => __DIR__.'/../views'));

    //db
    $DB = new PDO('pgsql:host=localhost;dbname=library');

    //paths
    $app->get('/', function() use ($app) {

        return $app['twig']->render('homepage.twig');
    });


    return $app;

?>
