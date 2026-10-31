<?php

class HomeController
{
    public function home()
    {
        $bookManager = new BookManager();
        $last4Books = $bookManager->getLast4Books();

        //on charge la vue avec les données
        ob_start();
        require TEMPLATE_VIEW_PATH . 'home.php';
        $content = ob_get_clean();

        // On affiche le template principal.
        require TEMPLATE_VIEW_PATH . 'main.php';
    }
}