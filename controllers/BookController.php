<?php

class BookController
{
//-------------------------------------------------------------------------------//
//    01 - CONTROLES & REDIRECTIONS                                              //
//-------------------------------------------------------------------------------//
    
    // Redirige si l'utilisateur N'EST PAS connecté.
    private function redirectIfNotConnected() : void
    {
        if (!isset($_SESSION['user'])) {
            Utils::redirect("login");
        }
    }

    // Redirige si l'utilisateur N'EST PAS le propriétaire du livre.
    private function checkBooksOwner(int $bookId, string $redirect) : void
    {
        $bookManager = new BookManager();
        $book = $bookManager->getBookById($bookId);

        $bookOwner = $book->getUserId();

        if (($_SESSION['user']['id']) != $bookOwner) {
            Utils::redirect($redirect);
        }
    }

//-------------------------------------------------------------------------------//
//    02 - CONTROLES D'IMAGES, NOMMAGE, ENREGISTREMENT                           //
//-------------------------------------------------------------------------------//

    private function checkImageUpload(int $bookId): array
    {
        // Vérifie que le fichier a été envoyé sinon redirige.
        if (!isset($_FILES['cover']) ||
            $_FILES['cover']['error'] !== UPLOAD_ERR_OK) {
            header('Location: index.php?page=bookModifier&id=' . $bookId);
            exit;
        }  
        // Retourne le fichier.
        return $_FILES['cover'];
    }

    private function checkImageSize(array $file, int $bookId): void
    {
        // Variable de taille de fichier max (3Mo).
        $maxSize = 3 * 1024 * 1024;
        // Contrôle la taille de l'image et redirige si nécessaire.
        if ($file['size'] > $maxSize) {
            header('Location: index.php?page=bookModifier&id=' . $bookId);
            exit;
        }
    }

    private function checkImageMimeType(array $file, int $bookId): string
    {
        // Vérifier le véritable type MIME du fichier
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);

        $allowedTypes = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp'
        ];

        // Redirige si le type du fichier n'est pas autorisé
        if (!array_key_exists($mimeType, $allowedTypes)) {
            header('Location: index.php?page=bookModifier&id=' . $bookId);
            exit;
        }

        // Vérifier qu'il s'agit bien d'une image
        if (getimagesize($file['tmp_name']) === false) {
            header('Location: index.php?page=bookModifier&id=' . $bookId);
            exit;
        }

        // Retourne les extensions autorisées.
        return $allowedTypes[$mimeType];
    }

    private function setFileName(int $bookId, string $extension): string
    {
        // Créer un nom de fichier unique
        $fileName = 'book_' . $bookId . '_' . bin2hex(random_bytes(8)) . '.' . $extension;

        return $fileName;
    }    


    private function setFileDirectory(array $file, string $fileName, int $bookId): string
    {
        // Définir le dossier de destination
        $uploadDirectory = dirname(__DIR__) . '/images/books/';

        // Déplacer le fichier dans le dossier
        if (!move_uploaded_file($file['tmp_name'], $uploadDirectory . $fileName)) {
            header('Location: index.php?page=bookModifier&id=' . $bookId);
            exit;
        }

        // Chemin à enregistrer dans la BDD
        $coverPath = 'images/books/' . $fileName;
        return $coverPath;
    }


//-------------------------------------------------------------------------------//
//    03 - CREATION & SUPPRESSION DE LIVRES                                      //
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
            } else $cover = "";
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
//    04 - MODIFICATION DE LIVRES                                                //
//-------------------------------------------------------------------------------//

    // Met à jour les informations d'un livre à partir d'un formulaire.
    public function updateBook()
    {
        // Récupère l'id du livre concerné
        $bookId = Utils::request("id", -1);

        // Redirige si l'utilisateur n'est pas connecté
        $this->redirectIfNotConnected();
        // Vérifie que le livre appartient à l'utilisateur connecté.
        $this->checkBooksOwner($bookId, "home");

        // Vérifie que le formulaire a été soumis.
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupérer les données individuellement
            $title = trim($_POST['title']);
            $author = trim($_POST['author']);
            $description = trim($_POST['description']);
            $availability = trim($_POST['availability']);         
        }

        
        $bookManager = new BookManager();
        $bookManager->updateBook($bookId,$title,$author,$description,$availability);
        
        header('Location: index.php?page=myAccount');
        exit;

    }

    public function updateBookCover()
    {
        // Récupère l'id du livre concerné.
        $bookId = Utils::request("id", -1);

        // Redirige si l'utilisateur n'est pas connecté.
        $this->redirectIfNotConnected();

        // Vérifie que le livre appartient à l'utilisateur connecté.
        $this->checkBooksOwner($bookId, "home");

        // Récupère le fichier.
        $file = $this->checkImageUpload($bookId);

        // Vérifie sa taille.
        $this->checkImageSize($file,$bookId);

        // Récupère son extension.
        $extension = $this->checkImageMimeType($file,$bookId);

        // Créé un nouveau nom de fichier.
        $fileName = $this->setFileName($bookId, $extension);

        // Déplace le fichier dans un dossier du server.
        $coverPath = $this->setFileDirectory($file, $fileName, $bookId);

        // Mettre à jour la photo dans la BDD
        $bookManager = new BookManager();
        $bookManager->updateBookCover($bookId, $coverPath);

        // Retourner sur le compte utilisateur
        header('Location: index.php?page=bookModifier&id=' . $bookId);
        exit;
    }
}
