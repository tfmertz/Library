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

        static function getAll()
        {
            $book_array = $GLOBALS['DB']->query("SELECT * FROM books;");
            $book_array = $book_array->fetchAll(PDO::FETCH_ASSOC);

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

    }


?>
