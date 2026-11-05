<div class="layout-row layout-row--userProfile">
    <div class="profile-layout">
        <img class="profile-picture"src="<?= htmlspecialchars($userProfilePicture) ?>" alt="Photo de profil de <?= htmlspecialchars($userPseudo) ?>">
        <h2><?= htmlspecialchars($userPseudo) ?></h2>
        <p>Membre depuis <?= $timeSinceSubscription ?> </p>
        <p>BIBLIOTHEQUE</p>
        <p><?= htmlspecialchars($booksCount) ?> livres</p>
        <a href="index.php?page=showMessenger&id=<?= htmlspecialchars($id) ?>" class="cta-button">Écrire un message</a>
    </div>
    <div class="profile-layout ">
        <table class="books-array">
            <thead>
                <tr>
                    <th>PHOTO</th>
                    <th>TITRE</th>
                    <th>AUTEUR</th>
                    <th>DESCRIPTION</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($userBooks as $userBook) : ?>
                    <tr>
                        <td>
                            <img src="<?= htmlspecialchars($userBook->getCover()) ?>"
                            alt="Couverture de <?= htmlspecialchars($userBook->getTitle()) ?>">
                        </td>
                        <td class = "book-title">
                            <a href = "index.php?page=bookDetails&id=<?= $userBook->getId() ?>">
                                <?= htmlspecialchars($userBook->getTitle()) ?>
                            </a>
                        </td>
                        <td>
                            <?= htmlspecialchars($userBook->getAuthor()) ?>
                        </td>
                        <td>
                            <span class="book-description">
                                <?= htmlspecialchars($userBook->getDescription()) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

