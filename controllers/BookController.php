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

    public function updateBookCover()
    {
        $bookId = Utils::request("id", -1);

        // Vérifier que l'utilisateur est connecté
        if (!Utils::isUserConnected()) {
            header('Location: index.php?page=bookModifier&id=' . $bookId);
            exit;
        }

        // Vérifier que le fichier a bien été envoyé
        if (!isset($_FILES['cover']) ||
            $_FILES['cover']['error'] !== UPLOAD_ERR_OK) {
            header('Location: index.php?page=bookModifier&id=' . $bookId);
            exit;
        }

        $file = $_FILES['cover'];

        // Vérifier la taille : maximum 3 Mo
        $maxSize = 3 * 1024 * 1024;

        if ($file['size'] > $maxSize) {
            header('Location: index.php?page=bookModifier&id=' . $bookId);
            exit;
        }

        // Vérifier le véritable type MIME du fichier
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);

        $allowedTypes = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp'
        ];

        if (!array_key_exists($mimeType, $allowedTypes)) {
            header('Location: index.php?page=bookModifier&id=' . $bookId);
            exit;
        }

        // Vérifier qu'il s'agit bien d'une image
        if (getimagesize($file['tmp_name']) === false) {
            header('Location: index.php?page=bookModifier&id=' . $bookId);
            exit;
        }

        // Créer un nom de fichier unique
        $extension = $allowedTypes[$mimeType];

        $fileName = 'profile_' . $bookId . '_' . bin2hex(random_bytes(8)) . '.' . $extension;

        // Définir le dossier de destination
        $uploadDirectory = dirname(__DIR__) . '/images/books/';

        // Déplacer le fichier dans le dossier
        if (!move_uploaded_file($file['tmp_name'], $uploadDirectory . $fileName)) {
            header('Location: index.php?page=bookModifier&id=' . $bookId);
            exit;
        }

        // Chemin à enregistrer dans la BDD
        $coverPath = 'images/books/' . $fileName;

        // Mettre à jour la photo dans la BDD
        $bookManager = new BookManager();
        $bookManager->updateBookCover($bookId, $coverPath);

        // Retourner sur le compte utilisateur
        header('Location: index.php?page=bookModifier&id=' . $bookId);
        exit;
    }

    public function updateBook()
    {
        $bookId = Utils::request("id", -1);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupérer les données individuellement
            $title = trim($_POST['title']);
            $author = trim($_POST['author']);
            $description = trim($_POST['description']);
            $availability = trim($_POST['availability']);         
        }

        $bookManager = new BookManager();
        $bookManager->updateBook($bookId,$title,$author,$description,$availability);
        
        header('Location: index.php?page=bookModifier&id=' . $bookId);
        exit;

    }
}