<!DOCTYPE html>

<h1>Nos livres à l'échange</h1>

<div class="book-list">
    <?php foreach ($books as $book) : ?>
        <article class="book-card">
            <h2><?=  htmlspecialchars($book->getTitle()) ?></h2>
            <p><?= htmlspecialchars($book->getAuthor()) ?></p>
            <p>Vendu par : <?= htmlspecialchars($book->getUserId()) ?></p>
        </article>
    <?php endforeach; ?>
</div>