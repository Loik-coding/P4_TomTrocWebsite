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

            // On redirige vers la liste des livres.
            header('Location: index.php?page=booksListing');
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

}