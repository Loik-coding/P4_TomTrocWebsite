
<?php

require_once 'config/autoload.php';
require_once 'config/config.php';

// On récupère la page demandée dans l'URL.
// Par défaut, on affiche la liste des livres.
$page = $_GET['page'] ?? 'booksListing';

// On choisit le contrôleur selon la page demandée.
switch ($page) {

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
      

    default:
        echo "Page introuvable.";
        break;
}
