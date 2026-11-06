<?php

class HomeController
{

//-------------------------------------------------------------------------------//
//    01 - AFFICHAGE DES PAGES                                                   //
//-------------------------------------------------------------------------------//

    // Affichage de la page d'accueil.
    //Fonction qui récupère les 4 derniers livres et les transmet à la page d'accueil.
    public function home()
    {
        $bookManager = new BookManager();
        $select = "*";
        $where = "availability = 1";
        $orderBy = "ORDER BY id";
        $quantity = "DESC LIMIT 4";
        $last4Books = $bookManager->getBooksByParameters($select, $where, $orderBy, $quantity);

        //on charge la vue avec les données
        ob_start();
        require TEMPLATE_VIEW_PATH . 'home.php';
        $content = ob_get_clean();

        // On affiche le template principal.
        require TEMPLATE_VIEW_PATH . 'main.php';
    }

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
}