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

    private function checkImageUpload(array &$coverErrors): array
    {
        // Vérifie que le fichier a été envoyé sinon redirige.
        if (!isset($_FILES['cover']) ||
            $_FILES['cover']['error'] !== UPLOAD_ERR_OK) {

            $coverErrors[] = "Une erreur est survenue lors de l'envoi de l'image.";
            return [];
        }
        // Retourne le fichier.
        return $_FILES['cover'];
    }

    private function checkImageSize(array $file, array &$coverErrors): void
    {        
        // Variable de taille de fichier max (3Mo).
        $maxSize = 3 * 1024 * 1024;

        if ($file['size'] > $maxSize) {
            $coverErrors[] = "L'image ne doit pas dépasser 3 Mo.";
        }
    }       

    private function checkImageMimeType(array $file, array &$coverErrors): string
    {
        // Vérifie le véritable type MIME du fichier
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);

        $allowedTypes = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp'
        ];

        // Enregistre l'erreur si le type du fichier n'est pas autorisé
        if (!array_key_exists($mimeType, $allowedTypes)) {
            $coverErrors[] = "Le format de l'image n'est pas autorisé.";
            return '';
        }
        // Vérifie qu'il s'agit bien d'une image
        if (getimagesize($file['tmp_name']) === false) {
            $coverErrors[] = "Le fichier envoyé n'est pas une image valide.";
            return '';
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

    private function setFileDirectory(array $file, string $fileName, array &$coverErrors): string
    {
        // Définir le dossier de destination
        $uploadDirectory = dirname(__DIR__) . '/images/books/';

        // Déplacer le fichier dans le dossier
        if (!move_uploaded_file($file['tmp_name'], $uploadDirectory . $fileName)) {
            $coverErrors[] = "Impossible d'enregistrer l'image.";
            return '';
        }

        // Chemin à enregistrer dans la BDD
        return 'images/books/' . $fileName;
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
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            header('Location: index.php?page=myAccount');
            exit;
        }

        $coverErrors = [];
        $formErrors = [];

        // Récupère les données individuellement.
        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $availability = trim($_POST['availability'] ?? '');

        // Vérification des informations du livre.
        if (empty($title)) {
            $formErrors[] = "Le titre du livre est obligatoire.";
        }

        if (empty($author)) {
            $formErrors[] = "L'auteur du livre est obligatoire.";
        }

        if (mb_strlen($description) < 100) {
            $formErrors[] = "La description doit contenir au minimum 100 caractères.";
        }

        if (!in_array($availability, ['0', '1'], true)) {
            $formErrors[] = "Veuillez sélectionner une disponibilité valide.";
        }

        // Instancie le BookManager.
        $bookManager = new BookManager();

        // MISE A JOUR DE LA COVER.
        $cover = "";

        // Vérifie si une photo a été sélectionnée.
        if (!empty($_FILES['cover']['name'])) {
            // Récupère et vérifie le fichier.
            $file = $this->checkImageUpload($coverErrors);
            if (empty($coverErrors)) {
                // Vérifie sa taille.
                $this->checkImageSize($file, $coverErrors);
            }
            if (empty($coverErrors)) {
                // Récupère son extension.
                $extension = $this->checkImageMimeType($file, $coverErrors);
            }
            if (empty($coverErrors)) {
                // Crée un nom de fichier unique.
                $fileName = 'book_new_' . bin2hex(random_bytes(8)) . '.' . $extension;
                // Déplace le fichier dans le dossier du serveur.
                $cover = $this->setFileDirectory($file, $fileName, $coverErrors);
            }
        }

        // CRÉATION DU LIVRE.
        // Si aucune erreur n'a été détectée.
        if (empty($formErrors) && empty($coverErrors)) {
            $bookManager->createBook(
                $title,
                $author,
                $description,
                $availability,
                $cover,
                $userId
            );

            // Redirige vers la page mon compte.
            header('Location: index.php?page=myAccount');
            exit;
        }

        // En cas d'erreur, on réaffiche le formulaire.
        ob_start();
        require TEMPLATE_VIEW_PATH . 'bookPost.php';
        $content = ob_get_clean();
        require TEMPLATE_VIEW_PATH . 'main.php';
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



    public function updateBook()
    {
        // Vérifie que le formulaire a été soumis.
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            header('Location: index.php?page=myAccount');
            exit;
        }

        // Récupère l'id du livre concerné.
        $bookId = Utils::request("id", -1);

        $coverErrors = [];
        $formErrors = [];

        // Vérifie si l'utilisateur est connecté.
        $this->redirectIfNotConnected();

        // Vérifie que le livre appartient à l'utilisateur connecté.
        $this->checkBooksOwner($bookId, "home");

        // Récupère les informations du formulaire.
        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $availability = trim($_POST['availability'] ?? '');

        // Vérification des informations du livre.
        if (empty($title)) {
            $formErrors[] = "Le titre du livre est obligatoire.";
        }

        if (empty($author)) {
            $formErrors[] = "L'auteur du livre est obligatoire.";
        }

        if (mb_strlen($description) < 100) {
            $formErrors[] = "La description doit contenir au minimum 100 caractères.";
        }

        if (!in_array($availability, ['0', '1'], true)) {
            $formErrors[] = "Veuillez sélectionner une disponibilité valide.";
        }

        $bookManager = new BookManager();

        // MISE A JOUR DE LA COVER.

        // Vérifie si une nouvelle photo a été sélectionnée.
        if (!empty($_FILES['cover']['name'])) {

            // Récupère et vérifie le fichier.
            $file = $this->checkImageUpload($coverErrors);

            if (empty($coverErrors)) {
                // Vérifie sa taille.
                $this->checkImageSize($file, $coverErrors);
            }

            if (empty($coverErrors)) {
                // Récupère son extension.
                $extension = $this->checkImageMimeType($file, $coverErrors);
            }

            if (empty($coverErrors)) {
                // Crée un nouveau nom de fichier.
                $fileName = $this->setFileName($bookId, $extension);

                // Déplace le fichier dans un dossier du serveur.
                $coverPath = $this->setFileDirectory($file, $fileName, $coverErrors);
            }

            if (empty($coverErrors)) {
                // Met à jour la photo dans la BDD.
                $bookManager->updateBookCover($bookId, $coverPath);
            }
        }

        // MISE A JOUR DES INFORMATIONS.

        if (empty($formErrors)) {

            $bookManager->updateBook(
                $bookId,
                $title,
                $author,
                $description,
                $availability
            );
        }

        // Si aucune erreur n'a été détectée.
        if (empty($formErrors) && empty($coverErrors)) {
            header('Location: index.php?page=bookModifier&id=' . $bookId);
            exit;
        }

        // En cas d'erreur, on récupère les informations du livre.
        $book = $bookManager->getBookById($bookId);

        // On réaffiche le formulaire.
        ob_start();
        require TEMPLATE_VIEW_PATH . 'bookModifier.php';
        $content = ob_get_clean();
        require TEMPLATE_VIEW_PATH . 'main.php';
    }
}
