
<?php

require_once 'config/autoload.php';
require_once 'config/config.php';

// On récupère la page demandée dans l'URL.
// Par défaut, on affiche la liste des livres.
$page = $_GET['page'] ?? 'home';

// On choisit le contrôleur selon la page demandée.
switch ($page) {

    case 'home':
        $controller = new HomeController();
        $controller->home();
        break;

    case 'booksListing':
        $controller = new BookController();
        $controller->booksListing();
        break;

    case 'bookDetails':
        $controller = new BookController();
        $controller->bookDetails();
        break;

    case 'register':
        $controller = new UserController();
        $controller->register();
        break;

    case 'registerForm':
        $controller = new UserController();
        $controller->registerForm();
        break;

    case 'login':
        $controller = new UserController();
        $controller->login();
        break;

    case 'loginForm' :
        $controller = new UserController();
        $controller->loginForm();
        break;
      
    case 'logout' :
        $controller = new UserController();
        $controller->logout();
        break;
      
    case 'myAccount' :
        $controller = new UserController();
        $controller->myAccount();
        break;    
        
    case 'deleteBook' :
        $controller = new UserController();
        $controller->deleteBookById();
        break;

    case 'UpdateProfilePicture' :
        $controller = new UserController();
        $controller->UpdateProfilePicture();
        break;
    
    case 'updateUser' :
        $controller = new UserController();
        $controller->updateUser();
        break;

    case 'userProfile' :
        $controller = new UserController();
        $controller->userProfile();
        break;
    
    case 'bookPost' :
        $controller = new UserController();
        $controller->bookPost();
        break;
    
    case 'createBook' :
        $controller = new BookController();
        $controller->createBook();
        break;

    default:
        echo "Page introuvable.";
        break;
}
