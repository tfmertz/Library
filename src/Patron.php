<?php

    class Patron
    {

        private $id;
        private $name;

        function __construct($name, $id = null) {
            $this->id = $id;
            $this->name = $name;
        }

        function setId($id){
            $this->id = $id;
        }

        function getId(){
            return $this->id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($name)
        {
            $this->name = $name;
        }

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO patrons (name) VALUES ('{$this->getName()}') RETURNING id;");
            $id_array = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($id_array['id']);
        }


        // DOUBLE CHECK TOM UPDATE:
        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE patrons SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM patrons * WHERE id = {$this->getId()};");
        }

        function checkout()
        {
            
        }

        static function find($id)
        {
            $statement = $GLOBALS['DB']->query("SELECT * FROM patrons WHERE id = $id;");
            $patron_rows = $statement->fetchAll(PDO::FETCH_ASSOC);
            $patron_array = [];

            foreach ($patron_rows as $patron)
            {
                $id = $patron['id'];
                $name = $patron['name'];
                $new_patron = new Patron($name,$id);
                array_push($patron_array, $new_patron);
            }
            return $patron_array;
        }

        static function getAll()
        {
            $statement = $GLOBALS['DB']->query("SELECT * FROM patrons;");
            $patron_rows = $statement->fetchAll(PDO::FETCH_ASSOC);

            $patrons = array();
            foreach($patron_rows as $row)
            {
                $id = $row['id'];
                $name = $row['name'];
                $new_patron = new Patron($name, $id);
                array_push($patrons, $new_patron);
            }
            return $patrons;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM patrons *;");
        }

    }

?>
