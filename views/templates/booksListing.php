<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos livres</title>
</head>
<body>
    <h1>Nos livres</h1>

    <?php foreach ($books as $book): ?>
        <article>
            <h2><?= htmlspecialchars($book->getTitle()) ?></h2>
            <p><?= htmlspecialchars($book->getAuthor()) ?></p>
        </article>
    <?php endforeach; ?>
</body>
</html>