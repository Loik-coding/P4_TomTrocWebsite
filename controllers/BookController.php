<?php
class BookController
{
    /**
     * Affiche la page d'accueil.
     * @return void
     */
    public function showHome() : void
    {
        $bookManager = new BookManager();
        $books = $bookManager->getAllbooks();

        $view = new View("Accueil");
        $view->render("home", ['articles' => $articles]);
    }

    /**
     * Affiche un tableau avec tous les livres disponibles
     * @return void
     */
    public function showListing()
    {
        $bookManager = new BookManager();
        $books = $bookManager->getAllBooksAvaliable();

        require 'views/books.php';

    }
}