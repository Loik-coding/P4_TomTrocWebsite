
<?php


require_once 'config/autoload.php';

$bookManager = new BookManager();

$books = $bookManager->getAllBooksAvailable();

foreach ($books as $book) {
    echo $book->getTitle() . ' - ';
    echo $book->getAuthor() . '<br>';
}