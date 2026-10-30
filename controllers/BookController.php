<?php

class BookController
{
    public function booksListing()
    {
        // on instancie le manager
        $bookManager = new BookManager();

        // on récupère les livres disponibles
        $books = $bookManager->getAllBooksAvailable();

        //on charge la vue avec les données
        ob_start();
        require TEMPLATE_VIEW_PATH . 'booksListing.php';
        $content = ob_get_clean();

        // On affiche le template principal.
        require TEMPLATE_VIEW_PATH . 'main.php';
    }

    public function bookDetails()
    {
        $id = Utils::request("id", -1);

        //on instancie le manager
        $bookManager = new BookManager();
        //on récupère le livre
        $book = $bookManager->getBookById($id);

        //on vérifie que le livre existe
        if ($book === null) {
            echo "Livre introuvable.";
            return;
        }

        //on charge la vue avec les données
        ob_start();
        require TEMPLATE_VIEW_PATH . 'bookDetails.php';
        $content = ob_get_clean();

        // On affiche le template principal.
        require TEMPLATE_VIEW_PATH . 'main.php';

    }
}