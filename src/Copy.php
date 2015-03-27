<?php

class Copy
{
    private $checked_out;
    private $book_id;
    private $id;

    function __construct($book_id, $checked_out = false, $new_id = null)
    {
        $this->book_id = $book_id;
        $this->checked_out = $checked_out;
        $this->id = $new_id;
    }

    function getBookId()
    {
        return $this->book_id;
    }

    function setBookId($new_id)
    {
        $this->book_id = $new_id;
    }

    function getId()
    {
        return $this->id;
    }

    function setId($newId)
    {
        $this->id = $newId;
    }

    function getCheckout()
    {
        return $this->checked_out;
    }

    function setCheckout($new_checkout)
    {
        $this->checked_out = $new_checkout;
    }

    function save()
    {
        $statement = $GLOBALS['DB']->query("INSERT INTO copies (book_id, checked_out) VALUES ({$this->getBookId()}, {$this->getCheckout()}) RETURNING id;");
        $id_array = $statement->fetch(PDO::FETCH_ASSOC);
        $this->setId($id_array['id']);
    }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM copies * WHERE id = {$this->getId()};");
    }

    function getCopies()
    {
        $statement = $GLOBALS['DB']->query("SELECT * FROM copies WHERE book_id = {$this->getBookId()};");
        $book_id_rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        $copies = array();
        foreach($book_id_rows as $row)
        {
            $id = $row['id'];
            $book_id = $row['book_id'];
            $checked_out = (bool) $row['checked_out'];
            $new_copy = new Copy($book_id, $checked_out, $id);
            array_push($copies, $new_copy);
        }
        return $copies;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM copies *;");
    }
}


?>
