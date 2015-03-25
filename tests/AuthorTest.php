<?php

    /**
        @backupGlobals disabled
        @backupStaticAttributes disabled
    */

    require_once 'src/Author.php';

    $DB = new PDO("pgsql:host=localhost;dbname=library_test");

    class AuthorTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Author::deleteAll();
        }

        function test_deleteAll()
        {
            //arrange
            $test_author = new Author("Max Brooks");
            $test_author2 = new Author("Dennis Brown");

            $test_author->save();
            $test_author2->save();

            //act
            Author::deleteAll();
            $result = Author::getAll();

            //assert
            $this->assertEquals([], $result);
        }

        function test_getAll()
        {
            //arrange
            $test_author = new Author("Max Brooks");
            $test_author2 = new Author("Dennis Brown");

            $test_author->save();
            $test_author2->save();

            //act
            $result = Author::getAll();

            //assert
            $this->assertEquals([$test_author, $test_author2], $result);
        }

        function test_save()
        {
            //arrange
            $test_author = new Author("J.K. Rowling");

            //act
            $test_author->save();
            $result = Author::getAll();

            //assert
            $this->assertEquals($test_author, $result[0]);
        }

        function test_getId()
        {
            //arrange
            $test_author = new Author("Max Brooks", 1);

            //act
            $result = $test_author->getId();

            //assert
            $this->assertEquals(1, $result);
        }

        function test_setId()
        {
            //arrange
            $test_author = new Author("Max Brooks", 1);

            //act
            $test_author->setId(15);
            $result = $test_author->getId();

            //assert
            $this->assertEquals(15, $result);
        }

        function test_getName()
        {
            //arrange
            $test_author = new Author("Max Brooks");

            //act
            $result = $test_author->getName();

            //assert
            $this->assertEquals("Max Brooks", $result);
        }

        function test_setName()
        {
            //arrange
            $test_author = new Author("Max Brooks");

            //act
            $test_author->setName("James Brooks");
            $result = $test_author->getName();

            //assert
            $this->assertEquals("James Brooks", $result);
        }
    }




 ?>