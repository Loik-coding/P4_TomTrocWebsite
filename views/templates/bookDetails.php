
<div class="book-details">
    <div class="book-cover">
        <img src="<?= htmlspecialchars($book->getCover()) ?>" alt="Couverture de <?= htmlspecialchars($book->getTitle()) ?>">
    </div>
    <div class="book-info">
        <h1><?=htmlspecialchars($book->getTitle())?></h1>
        <h2>par <?=htmlspecialchars($book->getAuthor())?></h2>
        <img src="images/logo/line.svg">
        <span>DESCRIPTION</span>
        <p><?=htmlspecialchars($book->getDescription())?></p>
        <span>PROPRIÉTAIRE</span>
        <div class="owner-info">
            <img src="<?= htmlspecialchars($book->getUserCover()) ?>">
            <p><?=htmlspecialchars($book->getUserPseudo())?></p>
        </div>
        <a href="index.php?page=booksListing" class="cta-button">Envoyer un message</a>
    </div>
</div>
