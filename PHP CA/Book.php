<?php
class Book
{
    public $title;
    public $author;
    public $price;

    function __construct($title, $author, $price)
    {
        $this->title = $title;
        $this->author = $author;
        $this->price = $price;
    }
    function displayBook()
    {   
        echo "title: " . $this->title . "<br>";
        echo "author: " . $this->author . "<br>";
        echo "price: ₹" . $this->price . "<br><br>";
    }
}
$book1 = new Book("BCA", "ABC", 99);
$book2 = new Book("MCA", "XYZ", 250);

echo "<h1>Library</h1>";
$book1->displayBook();
$book2->displayBook();
?>