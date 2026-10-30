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
}