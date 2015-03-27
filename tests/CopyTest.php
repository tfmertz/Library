<?php

    require_once 'src/Copy.php';

    /**
        @backupGlobals disabled
        @backupStaticAttribute disabled
    */


    $DB = new PDO("pgsql:host=localhost;dbname=library_test;");

    class CopyTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            // Book::deleteAll();
            // Author::deleteAll();
            Copy::deleteAll();
        }

        // function test_getBookId()
        // {
        //     // Arrange
        //     $test_title = "2001";
        //     $test_book = new Book($test_title);
        //
        //     //Act
        //     $result = $test_book->getBookId();
        //
        //     //Assert
        //     $this->assertEquals("2001", $result);
        // }
        //
        // function test_setBookId()
        // {
        //     // Arrange
        //     $test_title = "The Goblet of Fire";
        //     $test_book = new Book($test_title);
        //
        //     // Act
        //     $test_book->setBookId("The Odyssey");
        //     $result = $test_book->getBookId();
        //
        //     // Assert
        //     $this->assertEquals("The Odyssey", $result);
        // }

        function test_delete()
        {
            //arrange
            $test_copy = new Copy(5);
            $test_copy->save();
            $test_copy2 = new Copy(3);
            $test_copy2->save();
            $test_copy3 = new Copy(15);
            $test_copy3->save();

            //act
            $test_copy->delete();
            $result = $test_copy->getCopies();

            //assert
            $this->assertEquals([], $result);
        }

        function test_getCopies()
        {
            //arrange
            $test_copy = new Copy(4);
            $test_copy->save();
            $test_copy2 = new Copy(4);
            $test_copy2->save();
            $test_copy3 = new Copy(4);
            $test_copy3->save();
            $test_copy4 = new Copy(4);
            $test_copy4->save();

            //act
            $result = $test_copy->getCopies();

            //assert
            $this->assertEquals([$test_copy, $test_copy2, $test_copy3, $test_copy4], $result);

        }

        function test_save()
        {
            //arrange
            $test_copy = new Copy(2);

            //act
            $test_copy->save();
            $result = $test_copy->getCopies();
            //assert
            $this->assertEquals([$test_copy], $result);
        }

        function test_getId()
        {
            //arrange
            $test_copy = new Copy(1);
            $test_copy->save();

            //act
            $result = $test_copy->getId();

            //assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_setId()
        {
            //arrange
            $test_copy = new Copy(1);
            $test_copy->save();

            //act
            $test_copy->setId(5);
            $result = $test_copy->getId();

            //assert
            $this->assertEquals(5, $result);
        }
    }


?>
