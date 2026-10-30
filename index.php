
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

    default:
        echo "Page introuvable.";
        break;
}
