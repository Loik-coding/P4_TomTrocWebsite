
<?php

require_once 'config/autoload.php';
require_once 'config/config.php';

// On récupère la page demandée dans l'URL.
// Par défaut, on affiche la liste des livres.
$page = $_GET['page'] ?? 'home';

// On choisit le contrôleur selon la page demandée.
switch ($page) {

    //display home page
    case 'home':
        $controller = new HomeController();
        $controller->home();
        break;

    //display bookslisting page
    case 'booksListing':
        $controller = new HomeController();
        $controller->booksListing();
        break;

    //display bookDetails page
    case 'bookDetails':
        $controller = new HomeController();
        $controller->bookDetails();
        break;

    //display register page
    case 'register':
        $controller = new UserController();
        $controller->register();
        break;

    //lauch register method
    case 'registerForm':
        $controller = new UserController();
        $controller->registerForm();
        break;

    //display login page
    case 'login':
        $controller = new UserController();
        $controller->login();
        break;

    //lauch login method
    case 'loginForm' :
        $controller = new UserController();
        $controller->loginForm();
        break;
    
    //Disconnect the user and display Home page
    case 'logout' :
        $controller = new UserController();
        $controller->logout();
        break;
    
    //display myAccount page
    case 'myAccount' :
        $controller = new UserController();
        $controller->myAccount();
        break;    
    
    //Launch deleteBook method
    case 'deleteBook' :
        $controller = new BookController();
        $controller->deleteBook();
        break;

    //Launch method to change user profile picture
    case 'UpdateProfilePicture' :
        $controller = new UserController();
        $controller->UpdateProfilePicture();
        break;

    //Launch method to modify user's informations (email, pseudo, password)    
    case 'updateUser' :
        $controller = new UserController();
        $controller->updateUser();
        break;

    //Display user profile page for external consulting
    case 'userProfile' :
        $controller = new HomeController();
        $controller->userProfile();
        break;
    
    //Display bookPost page to publish a new book
    case 'bookPost' :
        $controller = new UserController();
        $controller->bookPost();
        break;
    
    //Launch method to create a new book
    case 'createBook' :
        $controller = new BookController();
        $controller->createBook();
        break;

    //Display bookModifier page
    case 'bookModifier' :
        $controller = new UserController();
        $controller->bookModifier();
        break;

    //Launch method to change the cover picture of the book
    case 'updateBookCover' :
        $controller = new BookController();
        $controller->updateBookCover();
        break;

    //Launch method to update book's datas
    case 'updateBook' :
        $controller = new BookController();
        $controller->updateBook();
        break;

    case 'showMessenger' :
        $controller = new MessageController();
        $controller->showMessenger();
        break;

    case 'sendMessage' :
        $controller = new MessageController();
        $controller->sendMessage();
        break;

    default:
        echo "Page introuvable.";
        break;
}
