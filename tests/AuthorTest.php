<?php

    /**
        @backupGlobals disabled
        @backupStaticAttributes disabled
    */

    require_once 'src/Author.php';

    class AuthorTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Author::deleteAll();
        }

        function test_save()
        {
            
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
