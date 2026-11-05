<?php

class BookController
{
    public function booksListing()
    {
        // on instancie le manager
        $bookManager = new BookManager();

        $search = trim($_GET['q'] ?? '');

        if ($search !== '') {
            $books = $bookManager->searchBooks($search);
        } else {
            $books = $bookManager->getAllBooksAvailable();
        }

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

    public function createBook()
    {
        if (!Utils::isUserConnected()) {
            header('Location: index.php?page=home');
            exit;
        }
        //Get user id from session
        $userId = $_SESSION['user']['id'] ?? null;
        // Vérifier si le formulaire a été soumis
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupérer les données individuellement
            $title = trim($_POST['title']);
            $author = trim($_POST['author']);
            $description = trim($_POST['description']);
            $availability = trim($_POST['availability']);
                       
        }

        $bookManager = new BookManager();
        $book = $bookManager->createBook($title, $author, $description, $availability, $userId);

        header('Location: index.php?page=myAccount');
    }
}