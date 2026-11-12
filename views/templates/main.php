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
            <a href="index.php?page=home"
            class="<?= ($_GET['page'] ?? '') === 'home' ? 'active' : '' ?>">
                Accueil
            </a>
            <a href="index.php?page=booksListing"
            class="<?= ($_GET['page'] ?? '') === 'booksListing' ? 'active' : '' ?>">
                Nos livres à l'échange
            </a>
        </nav>
        <nav class="nav-right">
  
            <?php if (Utils::isUserConnected()) : ?>
                <a href="index.php?page=messaging"
                class="<?= ($_GET['page'] ?? '') === 'messaging' ? 'active' : '' ?>">
                    <span class="icon-message"></span>
                    Messagerie
                </a>

                <a href="index.php?page=myAccount"
                    class="nav-svg <?= ($_GET['page'] ?? '') === 'myAccount' ? 'active' : '' ?>">
                    <span class="icon-account"></span>
                    Mon compte
                </a>
                <a href="index.php?page=logout">Déconnexion</a>                
            <?php else : ?>
                <a href="index.php?page=login"                
                    class="nav-svg <?= ($_GET['page'] ?? '') === 'login' ? 'active' : '' ?>">
                    Connexion
                </a>
                <a href="index.php?page=register"
                    class="<?= ($_GET['page'] ?? '') === 'register' ? 'active' : '' ?>">
                    Inscription
                </a>
            <?php endif ?>
        </nav>
    </header>

    <main>
        <?= $content ?>
    </main>

    <footer>
        <a href="index.php?page=booksListing">Politique de confidentialité</a>
        <a href="index.php?page=booksListing">Mentions légales</a>
        <p>Tom Troc©</p>
        <img src="images/logo/logo-TT.svg" width=22px>
    </footer>

</body>
</html>