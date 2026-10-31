<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TomTroc - Échange de livres</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <header>
        <nav class="nav-left">
            <a href="index.php?page=home"><img src="images/logo/header-logo.svg"></a>
            <a href="index.php?page=home">Accueil</a>
            <a href="index.php?page=booksListing">Nos livres à l'échange</a>
        </nav>
        <nav class="nav-right">
  
            <?php if (Utils::isUserConnected()) : ?>
                <a href="index.php?page=myAccount" class="nav-svg">
                    <span class="icon-message"></span>
                    Messagerie
                </a>
                <a href="index.php?page=myAccount" class="nav-svg">
                    <span class="icon-account"></span>
                    Mon compte
                </a>
                <a href="index.php?page=logout">Déconnexion</a>                
            <?php else : ?>
                <a href="index.php?page=login">Connexion</a>
                <a href="index.php?page=register">Inscription</a>
            <?php endif ?>
        </nav>
    </header>

    <main>
        <?= $content ?>
    </main>

    <footer>
        <a href="index.php?page=booksListing">Politique de confidentialité</a>
        <a href="index.php?page=booksListing">Mentions légales</a>
        <p>Tom Troc</p>
    </footer>

</body>
</html>