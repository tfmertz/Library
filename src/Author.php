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

        function addBook($new_book)
        {

        }

        function getBooks()
        {
            
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
        }
    }


 ?>
