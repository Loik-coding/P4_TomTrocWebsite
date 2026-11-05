<?php

class HomeController
{
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
}