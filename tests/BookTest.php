<?php



    require_once 'src/Book.php';

    class BookTest extends PHPUnit_Framework_TestCase
    {

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



//
?>
