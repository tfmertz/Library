<?php

    require_once 'src/Book.php';

    /**
        @backupGlobals disabled
        @backupStaticAttribute disabled
    */


    $DB = new PDO("pgsql:host=localhost;dbname=library_test;");

    class BookTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Book::deleteAll();
            Author::deleteAll();
        }

        function test_delete_getBooks()
        {
            //arrange
            $test_book = new Book("The Great Gatsby");
            $test_book->save();

            $test_author = new Author("Jim");
            $test_author2 = new Author("TK");
            $test_author->save();
            $test_author2->save();

            $test_book->addAuthor($test_author);
            $test_book->addAuthor($test_author2);

            //act
            $test_book->delete();
            $result = $test_author->getBooks();

            //assert
            $this->assertEquals([], $result);
        }

        function test_delete_getAuthors()
        {
            //arrange
            $test_book = new Book("The Great Gatsby");
            $test_book->save();

            $test_author = new Author("Jim");
            $test_author2 = new Author("TK");
            $test_author->save();
            $test_author2->save();

            $test_book->addAuthor($test_author);
            $test_book->addAuthor($test_author2);

            //act
            $test_book->delete();
            $result = $test_book->getAuthors();

            //assert
            $this->assertEquals([], $result);
        }

        function test_getAuthors()
        {
            //arrange
            $test_book = new Book("2001");
            $test_author = new Author("Jim Shatner");
            $test_author2 = new Author("William Shatner");

            $test_book->save();
            $test_author->save();
            $test_author2->save();

            //assert
            $test_book->addAuthor($test_author);
            $test_book->addAuthor($test_author2);
            $result = $test_book->getAuthors();
            //Act
            $this->assertEquals([$test_author, $test_author2], $result);
        }

        function test_addAuthor()
        {
            //arrange
            $test_book = new Book("2001");
            $test_author = new Author("Jim Shatner");

            $test_book->save();
            $test_author->save();

            //assert
            $test_book->addAuthor($test_author);
            $result = $test_book->getAuthors();
            //Act
            $this->assertEquals([$test_author], $result);
        }

        function test_delete()
        {
            //Arrange
            $test_book = new Book ("Deleted");
            $test_book->save();

            //Act
            $test_book->delete();
            $result = Book::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_findByTitleNull()
        {
            //arrange
            $test_book = new Book("Hunger Games");
            $test_book->save();

            //act
            $test_book_title = "The Hunt for Red October";
            $result = Book::findByTitle($test_book_title);

            //assert
            $this->assertEquals([], $result);
        }

        function test_findByTitlePartial()
        {
            //arrange
            $test_book = new Book("Hunger Games");
            $test_book->save();

            //act
            $test_book_title = "ung";
            $result = Book::findByTitle($test_book_title);

            //assert
            $this->assertEquals([$test_book], $result);
        }

        function test_findByTitleMultiple()
        {
            //arrange
            $test_book = new Book("Hunger Games");
            $test_book2 = new Book("Hunger Names");
            $test_book3 = new Book("Hunger Frames");

            $test_book->save();
            $test_book2->save();
            $test_book3->save();


            //act
            $test_book_title = "unger";
            $result = Book::findByTitle($test_book_title);

            //assert
            $this->assertEquals([$test_book, $test_book2, $test_book3], $result);
        }

        function test_findByTitle()
        {
            //arrange
            $test_book = new Book("Hunger Games");
            $test_book->save();

            //act
            $test_book_title = $test_book->getTitle();
            $result = Book::findByTitle($test_book_title);

            //assert
            $this->assertEquals([$test_book], $result);
        }

        function test_findByIdNull()
        {
            //arrange

            //act
            $result = Book::findById(-1);

            //assert
            $this->assertEquals(null, $result);
        }

        function test_findById()
        {
            //arrange
            $test_book = new Book("Divergent");
            $test_book->save();

            //act
            $test_book_id = $test_book->getId();
            $result = Book::findById($test_book_id);

            //assert
            $this->assertEquals($test_book, $result);
        }

        function test_update()
        {
            //arrange
            $test_book = new Book("The Grt Gatsby");
            $test_book->save();

            //act
            $test_book->update("The Great Gatsby");
            $result = Book::getAll();

            //assert
            $this->assertEquals("The Great Gatsby", $result[0]->getTitle());
        }

        function test_updateObject()
        {
            //arrange
            $test_book = new Book("The Grt Gatsby");
            $test_book->save();

            //act
            $test_book->update("The Great Gatsby");
            $result = Book::getAll();

            //assert
            $this->assertEquals("The Great Gatsby", $test_book->getTitle());
        }

        function test_deleteAll()
        {
            //Assert
            $test_book = new Book("Huckaberry");
            $test_book->save();
            //Act
            Book::deleteAll();
            $all_books = Book::getAll();

            //Assert
            $this->assertEquals([], $all_books);
        }

        function test_getAll()
        {
            //Arrange
            $test_book = new Book("hello there!");
            $test_book->save();

            //Act
            $all_books = Book::getAll();

            //Assert
            $this->assertEquals([$test_book], $all_books);
        }

        function test_save()
        {
            //Arrange
            $test_book = new Book("2001", 2);

            //Act
            $test_book->save();
            $result = Book::getAll();
            //Assert
            $this->assertEquals($test_book, $result[0]);
        }

        function test_getTitle()
        {
            // Arrange
            $test_title = "2001";
            $test_book = new Book($test_title);

            //Act
            $result = $test_book->getTitle();

            //Assert
            $this->assertEquals("2001", $result);
        }

        function test_setTitle()
        {
            // Arrange
            $test_title = "The Goblet of Fire";
            $test_book = new Book($test_title);

            // Act
            $test_book->setTitle("The Odyssey");
            $result = $test_book->getTitle();

            // Assert
            $this->assertEquals("The Odyssey", $result);
        }

        function test_getId()
        {
            //arrange
            $test_book = new Book("The Sorcerers Stone", 1);

            //act
            $result = $test_book->getId();

            //assert
            $this->assertEquals(1, $result);
        }

        function test_setId()
        {
            //arrange
            $test_book = new Book("The Beginning", 1);

            //act
            $test_book->setId(5);
            $result = $test_book->getId();

            //assert
            $this->assertEquals(5, $result);
        }

    }

?>
