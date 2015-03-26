<?php

    class Author
    {
        private $id;
        private $name;

        function __construct($new_name, $new_id = null)
        {
            $this->name = $new_name;
            $this->id = $new_id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function getId()
        {
            return $this->id;
        }

        function setId($new_id)
        {
            $this->id = $new_id;
        }

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO authors (name) VALUES ('{$this->getName()}') RETURNING id;");
            $id_array = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($id_array['id']);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors * WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM books_authors * WHERE author_id = {$this->getId()};");
        }

        function addBook($new_book)
        {
            $GLOBALS['DB']->exec("INSERT INTO books_authors (book_id,author_id) VALUES ({$new_book->getId()}, {$this->getId()});");
        }

        function getBooks()
        {
            $statement = $GLOBALS['DB']->query("SELECT books.* FROM books
              JOIN books_authors ON(books.id = books_authors.book_id)
              JOIN authors ON(authors.id = books_authors.author_id)
                   WHERE author_id = {$this->getId()};");

                   $book_array = $statement->fetchAll(PDO::FETCH_ASSOC);
                   $hold_books = [];

                   foreach($book_array as $bookrow)
                   {
                       $id = $bookrow['id'];
                       $title = $bookrow['title'];
                       $new_book = new Book($title, $id);
                       array_push($hold_books, $new_book);
                   }
              return $hold_books;
        }

        //STATIC FUNCTIONS BELOW
        static function findByName($search_name)
        {
            $statement = $GLOBALS['DB']->query("SELECT * FROM authors WHERE name LIKE '%{$search_name}%';");
            $author_rows = $statement->fetchAll(PDO::FETCH_ASSOC);

            $authors = array();
            foreach($author_rows as $row)
            {
                $id = $row['id'];
                $name = $row['name'];
                $new_author = new Author($name, $id);
                array_push($authors, $new_author);
            }
            return $authors;
        }

        static function findById($search_id)
        {
            $statement = $GLOBALS['DB']->query("SELECT * FROM authors WHERE id = {$search_id};");
            $author_rows = $statement->fetchAll(PDO::FETCH_ASSOC);

            $author = null;
            foreach($author_rows as $row)
            {
                $id = $row['id'];
                $name = $row['name'];
                $new_author = new Author($name, $id);
                $author = $new_author;
            }
            return $author;
        }

        static function getAll()
        {
            $statement = $GLOBALS['DB']->query("SELECT * FROM authors;");
            $author_rows = $statement->fetchAll(PDO::FETCH_ASSOC);

            $authors = array();
            foreach($author_rows as $row)
            {
                $id = $row['id'];
                $name = $row['name'];
                $new_author = new Author($name, $id);
                array_push($authors, $new_author);
            }
            return $authors;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors *;");
            $GLOBALS['DB']->exec("DELETE FROM books_authors *;");
        }
    }


 ?>
