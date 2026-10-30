<?php
    
    // En fonction des routes utilisées, il est possible d'avoir besoin de la session ; on la démarre dans tous les cas. 
    session_start();

    // Ici on met les constantes utiles, 
    // les données de connexions à la bdd
    // et tout ce qui sert à configurer. 

    define('TEMPLATE_VIEW_PATH', './views/templates/'); // Le chemin vers les templates de vues.

    define('DB_HOST', 'localhost');
    define('DB_NAME', 'tomtroc');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    //Nom de dossier mis à jour
