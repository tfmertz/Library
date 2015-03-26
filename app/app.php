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

    $app->get('/books', function() use ($app) {

        return $app['twig']->render('all_books.twig', array('book_array' => Book::getAll()));
    });

    $app->post('/books', function() use ($app) {
        $new_book = new Book($_POST['title']);
        $new_book->save();

        return $app['twig']->render('all_books.twig', array('book_array' => Book::getAll()));
    });

    $app->post('/authors', function() use ($app){
        $new_author = new Author($_POST['author_add']);
        $new_author->save();
        return $app['twig']->render('all_authors.twig', array('author_array' => Author::getAll()));
    });

    $app->get('/authors', function() use ($app){
        return $app['twig']->render('all_authors.twig', array('author_array' => Author::getAll()));
    });


    return $app;

?>
