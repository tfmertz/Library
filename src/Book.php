<?php

    class Book
    {
        private $title;
        private $id;

        function __construct($new_title, $new_id = null)
        {
            $this->title = $new_title;
            $this->id = $new_id;

        }

        function getTitle()
        {
            return $this->title;
        }

        function setTitle($newTitle)
        {
            $this->title = $newTitle;
        }

        function getId()
        {
            return $this->id;
        }

        function setId($newId)
        {
            $this->id = $newId;
        }

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO books (title) VALUES ('{$this->getTitle()}') RETURNING id;");
            $id_array = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($id_array['id']);
        }

        function update($new_title)
        {
            $GLOBALS['DB']->exec("UPDATE books SET title = '{$new_title}' WHERE id = {$this->getId()};");
            $this->setTitle($new_title);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM books * WHERE id = {$this->getId()};");
        }

        function addAuthor($author)
        {
            $GLOBALS['DB']->exec("INSERT INTO books_authors (book_id, author_id) VALUES ({$this->getId()}, {$author->getId()});");
        }

        function getAuthors()
        {
            //STUDY THIS JOIN STATEMENT DAVID!!!!
            $statement = $GLOBALS['DB']->query("SELECT authors.* FROM books
            JOIN books_authors ON (books.id = books_authors.book_id)
            JOIN authors ON (authors.id = books_authors.author_id) WHERE books.id = {$this->getId()};");

            $author_array = $statement->fetchAll(PDO::FETCH_ASSOC);

            $authors = array();
            foreach($author_array as $author)
            {
                $id = $author['id'];
                $name = $author['name'];
                $new_author = new Author($name, $id);
                array_push($authors, $new_author);
            }
            return $authors;
        }

        static function getAll()
        {
            $statement = $GLOBALS['DB']->query("SELECT * FROM books;");
            $book_array = $statement->fetchAll(PDO::FETCH_ASSOC);

            $books = array();
            foreach($book_array as $book)
            {
                $id = $book['id'];
                $title = $book['title'];
                $new_book = new Book($title, $id);
                array_push($books, $new_book);
            }

            return $books;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM books *;");
        }

        static function findById($find_id)
        {
            $statement = $GLOBALS['DB']->query("SELECT * FROM books WHERE id = {$find_id};");
            $book_rows = $statement->fetchAll(PDO::FETCH_ASSOC);

            $new_book = null;
            foreach($book_rows as $row)
            {
                $id = $row['id'];
                $title = $row['title'];
                $new_book = new Book($title, $id);
            }
            return $new_book;
        }

        static function findByTitle($find_title)
        {
            $statement = $GLOBALS['DB']->query("SELECT * FROM books WHERE title LIKE '%{$find_title}%';");
            $book_rows = $statement->fetchAll(PDO::FETCH_ASSOC);

            $new_books = [];
            foreach($book_rows as $row)
            {
                $title = $row['title'];
                $id = $row['id'];
                $new_book = new Book($title, $id);
                array_push($new_books, $new_book);
            }
            return $new_books;
        }

    }


?>
