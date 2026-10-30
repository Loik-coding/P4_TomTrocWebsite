<!DOCTYPE html>

<h1>Nos livres à l'échange</h1>

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