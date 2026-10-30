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
        <h1>TomTroc</h1>

        <nav>
            <a href="index.php?page=booksListing">Nos livres à l'échange</a>
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