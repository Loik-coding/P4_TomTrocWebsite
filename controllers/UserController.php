<?php

class UserController
{
    
    public function login()
    {
        if (Utils::isUserConnected()) {
            header('Location: index.php?page=booksListing');
            exit;
        }

        ob_start();
        require TEMPLATE_VIEW_PATH . 'login.php';
        $content = ob_get_clean();

        require TEMPLATE_VIEW_PATH . 'main.php';
    }

    public function register()
    {
        if (Utils::isUserConnected()) {
            header('Location: index.php?page=booksListing');
            exit;
        }

        ob_start();
        require TEMPLATE_VIEW_PATH . 'register.php';
        $content = ob_get_clean();

        require TEMPLATE_VIEW_PATH . 'main.php';
    }

    public function registerForm()
    {
        // On empêche un utilisateur connecté de créer un autre compte.
        if (Utils::isUserConnected()) {
            header('Location: index.php?page=booksListing');
            exit;
        }

        // On récupère les données du formulaire.
        $pseudo = trim($_POST['pseudo'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $errors = [];

        // Vérification du pseudo.
        if (empty($pseudo)) {
            $errors[] = "Le pseudo est obligatoire.";
        }

        // Vérification de l'email.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "L'adresse email n'est pas valide.";
        }

        // Vérification du mot de passe.
        if (strlen($password) < 8) {
            $errors[] = "Le mot de passe doit contenir au moins 8 caractères.";
        }

        // On instancie le manager.
        $userManager = new UserManager();

        // On vérifie si l'email existe déjà.
        if (empty($errors) && $userManager->getUserByEmail($email) !== null) {
            $errors[] = "Cette adresse email est déjà utilisée.";
        }

        // Si aucune erreur n'a été détectée.
        if (empty($errors)) {

            // On chiffre le mot de passe.
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // On enregistre le nouvel utilisateur.
            $userManager->createUser($pseudo, $email, $hashedPassword);

            // On prépare un message de confirmation.
            $_SESSION['success'] = "Votre compte a bien été créé. Vous pouvez vous connecter.";

            // On redirige vers la connexion.
            header('Location: index.php?page=login');
            exit;
        }

        // En cas d'erreur, on réaffiche le formulaire.
        ob_start();
        require TEMPLATE_VIEW_PATH . 'register.php';
        $content = ob_get_clean();

        require TEMPLATE_VIEW_PATH . 'main.php';      
    }

    public function loginForm()
    {
        // On empêche un utilisateur connecté de créer un autre compte.
        if (Utils::isUserConnected()) {
            header('Location: index.php?page=booksListing');
            exit;
        }

        // On récupère les données du formulaire.
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $errors = [];

        // Vérification des champs.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($password)) {
            $errors[] = "Email ou mot de passe incorrect.";
        }

        // On recherche l'utilisateur par son email.
        if (empty($errors)) {

            $userManager = new UserManager();
            $user = $userManager->getUserByEmail($email);

            // On vérifie que l'utilisateur existe et que le mot de passe correspond.
            if ($user === null || !password_verify($password, $user->getPassword())) {
                $errors[] = "Email ou mot de passe incorrect.";
            }
        }

        // Si aucune erreur n'a été détectée.
        if (empty($errors)) {

            // On renouvelle l'identifiant de session pour la sécurité.
            session_regenerate_id(true);

            // On enregistre les informations utiles de l'utilisateur en session.
            $_SESSION['user'] = [
                'id' => $user->getId(),
                'pseudo' => $user->getPseudo(),
                'email' => $user->getEmail()
            ];

            // On redirige vers l'accueil du site'.
            header('Location: index.php?page=myAccount');
            exit;
        }

        // En cas d'erreur, on réaffiche le formulaire.
        ob_start();
        require TEMPLATE_VIEW_PATH . 'login.php';
        $content = ob_get_clean();

        require TEMPLATE_VIEW_PATH . 'main.php';
    }

    public function logout()
    {
        $_SESSION = [];
        session_destroy();
        header('location: index.php?page=booksListing');
        exit;
    }

    public function myAccount()
    {
        if (!Utils::isUserConnected()) {
            header('Location: index.php?page=home');
            exit;
        }
        //Get user id from session
        $userId = $_SESSION['user']['id'] ?? null;
        //Get user info from database
        $userManager = new UserManager();
        $user = $userManager->getUserById($userId);

        //Get user pseudo
        $userPseudo = $user->getPseudo();
        //Get user email
        $userEmail = $user->getEmail();
        //Get user password
        $userPassword = $user->getPassword();
        //Get user profile picture
        $userProfilePicture = $user->getProfilePicture();
        //Get user time since subscription
        $timeSinceSubscription = $user->getTimeSinceSubscription();

        //get the number of books owned by the user
        $bookManager = new BookManager();
        $booksCount = $bookManager->getBooksCountByUserId($userId);

        //Get books owned by the user
        $userBooks = $bookManager->getBooksByUserId($userId);

        ob_start();
        require TEMPLATE_VIEW_PATH . 'myAccount.php';
        $content = ob_get_clean();

        require TEMPLATE_VIEW_PATH . 'main.php';
    }

    public function deleteBookById()
    {
        if (!Utils::isUserConnected()) {
            header('Location: index.php?page=home');
            exit;
        }

        $bookId = Utils::request("id", -1);

        $bookManager = new BookManager();
        $book = $bookManager->getBookById($bookId);

        if ($book === null) {
            echo "Livre introuvable.";
            return;
        }

        $userId = $_SESSION['user']['id'] ?? null;
        if ($book->getUserId() !== $userId) {
            echo "Vous n'avez pas la permission de supprimer ce livre.";
            return;
        }

        $bookManager->deleteBookById($bookId);

        header('Location: index.php?page=myAccount');
        exit;
    }


    public function updateProfilePicture()
    {
        // Vérifier que l'utilisateur est connecté
        if (!Utils::isUserConnected()) {
            header('Location: index.php?page=home');
            exit;
        }

        // Vérifier que le fichier a bien été envoyé
        if (!isset($_FILES['profilePicture']) ||
            $_FILES['profilePicture']['error'] !== UPLOAD_ERR_OK) {
            header('Location: index.php?page=myAccount');
            exit;
        }

        $file = $_FILES['profilePicture'];

        // Vérifier la taille : maximum 3 Mo
        $maxSize = 3 * 1024 * 1024;

        if ($file['size'] > $maxSize) {
            header('Location: index.php?page=myAccount');
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
            header('Location: index.php?page=myAccount');
            exit;
        }

        // Vérifier qu'il s'agit bien d'une image
        if (getimagesize($file['tmp_name']) === false) {
            header('Location: index.php?page=myAccount');
            exit;
        }

        // Créer un nom de fichier unique
        $userId = $_SESSION['user']['id'];
        $extension = $allowedTypes[$mimeType];

        $fileName = 'profile_' . $userId . '_' . bin2hex(random_bytes(8)) . '.' . $extension;

        // Définir le dossier de destination
        $uploadDirectory = dirname(__DIR__) . '/images/users/';

        // Déplacer le fichier dans le dossier
        if (!move_uploaded_file($file['tmp_name'], $uploadDirectory . $fileName)) {
            header('Location: index.php?page=myAccount');
            exit;
        }

        // Chemin à enregistrer dans la BDD
        $profilePicturePath = 'images/users/' . $fileName;

        // Mettre à jour la photo dans la BDD
        $userManager = new UserManager();
        $userManager->updateProfilePicture($userId, $profilePicturePath);

        // Retourner sur le compte utilisateur
        header('Location: index.php?page=myAccount');
        exit;
    }

    public function updateUser()
    {
        if (!Utils::isUserConnected()) {
            header('Location: index.php?page=home');
            exit;
        }

        //Get user id from session
        $userId = $_SESSION['user']['id'] ?? null;

        //Get user info from database
        $userManager = new UserManager();
        $user = $userManager->getUserById($userId);
        //Get user pseudo
        $userPseudo = $user->getPseudo();
        //Get user email
        $userEmail = $user->getEmail();
        //Get user password
        $userPassword = $user->getPassword();
        //Get user profile picture

        // Vérifier si le formulaire a été soumis
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupérer les données individuellement
            $newPseudo = trim($_POST['pseudo']);
            $newEmail = trim($_POST['email']);
            $newPassword = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
        }
        if ($newPseudo !== ""){
            $userPseudo = $newPseudo;
        }
        if ($newEmail !== ""){
            $userEmail = $newEmail;
        }
        if ($newPassword !== ""){
            $userPassword = $newPassword;
        }

        $user = $userManager->updateUser($userId, $userPseudo, $userEmail, $userPassword);
        
        // On prépare un message de confirmation.
        $_SESSION['success'] = "Votre compte a bien été modifié.";

        header('Location: index.php?page=myAccount');
        exit;

    }

    public function userProfile()
    {
        $id = Utils::request("id", -1);

        //on instancie le manager
        $userManager = new UserManager();

        $user = $userManager->getUserById($id);
        //Get user pseudo
        $userPseudo = $user->getPseudo();
        //Get user email
        //Get user profile picture
        $userProfilePicture = $user->getProfilePicture();

        //get the number of books owned by the user
        $bookManager = new BookManager();
        $booksCount = $bookManager->getBooksCountByUserId($id);

        //Get books owned by the user
        $userBooks = $bookManager->getBooksByUserId($id);

        //Get user time since subscription
        $timeSinceSubscription = $user->getTimeSinceSubscription();

        //on vérifie que le user existe
        if ($user === null) {
            echo "Utilisateur introuvable.";
            return;
        }

        //on charge la vue avec les données
        ob_start();
        require TEMPLATE_VIEW_PATH . 'userProfile.php';
        $content = ob_get_clean();

        // On affiche le template principal.
        require TEMPLATE_VIEW_PATH . 'main.php';
    }
}