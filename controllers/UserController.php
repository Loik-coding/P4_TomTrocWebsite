<?php

class UserController
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

    // Affiche la page de connection SSI le user n'est pas déjà connecté.
    public function login()
    {
        $redirect = "home";
        $this->redirectIfConnected($redirect);

        ob_start();
        require TEMPLATE_VIEW_PATH . 'login.php';
        $content = ob_get_clean();

        require TEMPLATE_VIEW_PATH . 'main.php';
    }

    // Affiche la page d'inscription SSI le user n'est pas déjà connecté.
    public function register()
    {
        $redirect = "home";
        $this->redirectIfConnected($redirect);

        ob_start();
        require TEMPLATE_VIEW_PATH . 'register.php';
        $content = ob_get_clean();

        require TEMPLATE_VIEW_PATH . 'main.php';
    }

    // Récupère les informations de l'utilisateur connecté et affiche la page mon Compte.
    public function myAccount()
    {
        // Redirige un utilisateur non connecté sur la page login.
        $this->redirectIfNotConnected();

        // Récupère l'id de l'utilisateur connecté
        $userId = $_SESSION['user']['id'] ?? null;

        // Récupère les infos de l'utilisateur par son id sous forme d'objet.
        $userManager = new UserManager();
        $user = $userManager->getUserById($userId);

        // Récupère le nombre de livres mis en ligne par l'utilisateur dans la variable $booksCount.
        $bookManager = new BookManager();
        $booksCount = $bookManager->getBooksCountByUserId($userId);

        // Récupère la liste des livres de l'utilisateur.
        $userBooks = $bookManager->getBooksByUserId($userId);

        // Charge la page.
        ob_start();
        require TEMPLATE_VIEW_PATH . 'myAccount.php';
        $content = ob_get_clean();
        require TEMPLATE_VIEW_PATH . 'main.php';
    }

//-------------------------------------------------------------------------------//
//    03 - CREATION DE COMPTE & CONNEXION/DECONNEXION                            //
//-------------------------------------------------------------------------------//

    public function registerForm()
    {
        // On empêche un utilisateur connecté de créer un autre compte.
        $redirect = "myAccount";
        $this->redirectIfConnected($redirect);

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
        $redirect = "myAccount";
        $this->redirectIfConnected($redirect);

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


    // Déconnecte l'utilisateur et redirige vers la page d'accueil
    public function logout()
    {
        $_SESSION = [];
        session_destroy();
        header('location: index.php?page=home');
        exit;
    }





    public function updateProfilePicture()
    {
        // Redirige un utilisateur non connecté sur la page login
        $this->redirectIfNotConnected();

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

    public function bookPost()
    {
        if (!Utils::isUserConnected()) {
            header('Location: index.php?page=home');
            exit;
        }

        //on charge la vue avec les données
        ob_start();
        require TEMPLATE_VIEW_PATH . 'bookPost.php';
        $content = ob_get_clean();

        // On affiche le template principal.
        require TEMPLATE_VIEW_PATH . 'main.php';
    }

    public function bookModifier()
    {
        if (!Utils::isUserConnected()) {
            header('Location: index.php?page=home');
            exit;
        }

        $bookId = Utils::request("id", -1);

        $bookManager = new BookManager;
        $book = $bookManager->getBookById($bookId);

        //Get book title
        $title = $book->getTitle();
        //Get book author
        $author = $book->getAuthor();
        //Get book descrption
        $description = $book->getDescription();
        //Get book availability
        $availability = $book->getAvailability();
        //Get book cover
        $cover = $book->getCover();

        //on charge la vue avec les données
        ob_start();
        require TEMPLATE_VIEW_PATH . 'bookModifier.php';
        $content = ob_get_clean();

        // On affiche le template principal.
        require TEMPLATE_VIEW_PATH . 'main.php';

    }
}