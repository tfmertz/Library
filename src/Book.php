<?php

    class Book
    {
        private $title;
        private $id;

        function __construct($new_title, $new_id)
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

        

    }


?>
