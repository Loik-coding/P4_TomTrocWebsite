<?php

class BookController
{
//-------------------------------------------------------------------------------//
//    01 - CONTROLE DES CONNEXIONS                                               //
//-------------------------------------------------------------------------------//

    // Vérifie si l'utilisateur EST connecté si non, redirige vers la page de connexion.
    private function redirectIfConnected(string $redirect) : void
    {
        if (isset($_SESSION['user'])) {
            Utils::redirect($redirect);
        }
    }

    // Vérifie si l'utilisateur N'EST PAS connecté.
    private function redirectIfNotConnected() : void
    {
        if (!isset($_SESSION['user'])) {
            Utils::redirect("login");
        }
    }

//-------------------------------------------------------------------------------//
//    02 - AFFICHAGE DES PAGES                                                   //
//-------------------------------------------------------------------------------//

    //Affichage de la page bookListings
    public function booksListing()
    {
        // on instancie le manager
        $bookManager = new BookManager();

        //Récupère les infos de la searchbar
        $search = trim($_GET['q'] ?? '');

        //Lancement de la méthode adaptée en fonction de la recherche
        if ($search !== '') {
            $books = $bookManager->searchBooks($search);
        } else {
            //On défini les paramètres de la méthode.
            $select = "*";
            $where = "availability = 1";
            $orderBy = "ORDER BY id";
            $quantity = "DESC";
            $books = $bookManager->getBooksByParameters($select, $where, $orderBy, $quantity);
        }

        //on charge la vue avec les données
        ob_start();
        require TEMPLATE_VIEW_PATH . 'booksListing.php';
        $content = ob_get_clean();

        // On affiche le template principal.
        require TEMPLATE_VIEW_PATH . 'main.php';
    }


    //Affichage de la page bookDetails
    public function bookDetails()
    {
        //Récupère l'id du livre sur lequel le user à cliqué
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

//-------------------------------------------------------------------------------//
//    03 - Création & Suppression de livre                                       //
//-------------------------------------------------------------------------------//

    // Créé un nouveau livre.
    public function createBook()
    {
        $this->redirectIfNotConnected();

        // Récupère l'id de l'utilisateur connecté.
        $userId = $_SESSION['user']['id'] ?? null;

        // Vérifie si le formulaire a été soumis.
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupérer les données individuellement
            $title = trim($_POST['title']);
            $author = trim($_POST['author']);
            $description = trim($_POST['description']);
            $availability = trim($_POST['availability']);
            if ($_FILES['cover']['error'] === UPLOAD_ERR_OK){
                $cover = "images/books/" . $_FILES['cover']['name'];
                // Déplace l'image dans le dossier du site.
                move_uploaded_file($_FILES['cover']['tmp_name'], $cover);
            }
            
        }
        
        // Instancie le BookManager pour créer le livre dans la BDD.
        $bookManager = new BookManager();
        $bookManager->createBook($title, $author, $description, $availability, $cover, $userId);

        // Redirige vers la page mon compte.
        header('Location: index.php?page=myAccount');
    }

    public function deleteBook()
    {
        // Redirige un utilisateur non connecté sur la page login.
        $this->redirectIfNotConnected();

        // Récupère l'id du livre concerné.
        $bookId = Utils::request("id", -1);

        // Instancie le BookManager pour trouver le livre dans la BDD.
        $bookManager = new BookManager();
        $book = $bookManager->getBookById($bookId);
        if ($book === null) {
            echo "Livre introuvable.";
            return;
        }

        // Vérifie que le user_id appartenant au livre correspond à l'utilisateur connecté.
        $userId = $_SESSION['user']['id'] ?? null;
        if ($book->getUserId() !== $userId) {
            echo "Vous n'avez pas la permission de supprimer ce livre.";
            return;
        }

        // Supprime le livre de la BDD.
        $bookManager->deleteBookById($bookId);

        // Redirige vers la page mon Compte.
        header('Location: index.php?page=myAccount');
        exit;
    }

//-------------------------------------------------------------------------------//
//    04 - Modification de livre                                                 //
//-------------------------------------------------------------------------------//


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
}
