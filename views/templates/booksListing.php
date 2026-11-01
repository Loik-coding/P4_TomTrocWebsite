<!DOCTYPE html>

<div class="horizontal_container">
    <div>
        <h1>Nos livres à l'échange</h1>
    </div>
    <div>
        <form class="searchbar" action="index.php" method="GET" role="search">
            <input type="hidden" name="page" value="booksListing">
            <button type="submit"><img src="images/logo/logo-loupe.svg" alt=""></button>
            <input type="search" name="q" placeholder="Rechercher un livre" value="<?= htmlspecialchars($search ?? '') ?>"/>
        </form>
    </div>
</div>

<div class="book-list">
    <?php foreach ($books as $book) : ?>
        <a href="index.php?page=bookDetails&id=<?= $book->getId() ?>">
            <article class="book-card">
                <img src="<?= htmlspecialchars($book->getCover()) ?>" alt="Couverture de <?= htmlspecialchars($book->getTitle()) ?>">
                <h2><?=  htmlspecialchars($book->getTitle()) ?></h2>
                <p><?= htmlspecialchars($book->getAuthor()) ?></p>
                <p>Vendu par : <?= htmlspecialchars($book->getUserId()) ?></p>
            </article>
        </a>
    <?php endforeach; ?>
</div>