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
            Book::deleteAll();
        }

        function test_delete_getBooks()
        {
            //Arrange

            $test_author = new Author("Timmy");
            $test_author->save();

            $title="2002";
            $test_book = new Book($title);
            $test_book->save();
            $test_author->addBook($test_book);

            //Act
            $test_author->delete();
            $test_vacant = $test_author->getBooks();

            //Assert
            $this->assertEquals([], $test_vacant);
        }

        function test_getBooks()
        {
            //arrange
            $test_author = new Author("Jim bob");
            $test_author->save();

            $test_book = new Book("Ware and Peese");
            $test_book->save();
            $test_book2 = new Book("Adventure Time");
            $test_book2->save();

            $test_author->addBook($test_book);
            $test_author->addBook($test_book2);

            //act
            $result = $test_author->getBooks();

            //assert
            $this->assertEquals([$test_book, $test_book2], $result);
        }

        function test_addBook()
        {
            //Arrange
            $test_author = new Author("Tom");
            $test_author->save();
            $new_book = new Book("2001");
            $new_book->save();

            //Act
            $test_author->addBook($new_book);
            $test_added_book = $test_author->getBooks();
            //Assert
            $this->assertEquals([$new_book], $test_added_book);
        }

        function test_findByNameNull()
        {
            //arrange

            //act
            $search_name = "Bob";
            $result = Author::findByName($search_name);

            //assert
            $this->assertEquals([], $result);
        }

        function test_findByNameMultiple()
        {
            //arrange
            $test_author = new Author("Larry A");
            $test_author->save();
            $test_author2 = new Author("Larry B");
            $test_author2->save();
            $test_author3 = new Author("Larry C");
            $test_author3->save();
            $test_author4 = new Author("Margaret");
            $test_author4->save();

            //act
            $search_name = "Larry";
            $result = Author::findByName($search_name);

            //assert
            $this->assertEquals([$test_author, $test_author2, $test_author3], $result);
        }

        function test_findByName()
        {
            //arrange
            $test_author = new Author("Larry Truman");
            $test_author->save();

            //act
            $search_name = $test_author->getName();
            $result = Author::findByName($search_name);

            //assert
            $this->assertEquals([$test_author], $result);
        }

        function test_findByIdNull()
        {
            //arrange

            //act
            $search_id = -1;
            $result = Author::findById($search_id);

            //assert
            $this->assertEquals(null, $result);
        }

        function test_findById()
        {
            //arrange
            $test_author = new Author("Mary Jane");
            $test_author->save();

            //act
            $search_id = $test_author->getId();
            $result = Author::findById($search_id);

            //assert
            $this->assertEquals($test_author, $result);
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
