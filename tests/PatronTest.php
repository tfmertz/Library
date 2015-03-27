<?php

    require_once 'src/Patron.php';

    /**
        @backupGlobals disabled
        @backupStaticAttribute disabled
    */


    $DB = new PDO("pgsql:host=localhost;dbname=library_test;");

    class PatronTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            // Book::deleteAll();
            // Author::deleteAll();
            //Copy::deleteAll();
            Patron::deleteAll();
        }

        function test_checkout()
        {
            
        }

        function test_delete()
        {
            //arrange
            $test_patron = new Patron("Zachariah");
            $test_patron->save();

            //act
            $test_patron->delete();
            $result = Patron::getAll();

            //assert
            $this->assertEquals([], $result);
        }

        function test_update()
        {
            //arrange
            $test_patron = new Patron("Roger");
            $test_patron->save();

            //act
            $test_patron->update("Robert");
            $result = Patron::getAll();

            //assert
            $this->assertEquals("Robert", $result[0]->getName());
        }

        function test_find()
        {
            //arrange
            $test_patron = new Patron("Jim");

            $test_patron->save();

            $result = Patron::find($test_patron->getId());
            //assert
            $this->assertEquals([$test_patron], $result);

        }

        function test_save()
        {
            //arrange
            $test_patron = new Patron("Bob");

            //act
            $test_patron->save();
            $result = Patron::getAll();

            //assert
            $this->assertEquals([$test_patron], $result);
        }

        function test_getId()
        {
            //arrange
            $test_patron = new Patron("Rick");
            $test_patron->save();

            //act
            $result = $test_patron->getId();

            //assert
            $this->assertEquals(true, is_numeric($result));
        }

    }



?>
