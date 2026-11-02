
<h1>Mon compte</h1>
<div class="horizontal-container">
    <div>
        <img class="profile-picture"src="<?= htmlspecialchars($userProfilePicture) ?>" alt="Photo de profil de <?= htmlspecialchars($userPseudo) ?>">
        <a href="index.php?page=UpdateProfilePicture" class="underlined">modifier</a>
        <h2><?= htmlspecialchars($userPseudo) ?></h2>
        <p>Membre depuis <?= $timeSinceSubscription ?> </p>
        <p>BIBLIOTHEQUE</p>
        <p><?= htmlspecialchars($booksCount) ?> livres</p>
    </div>
    <div>
        <h2>Vos informations personnelles</h2>
        <form action="index.php?page=update" method="POST">
            <div>
                <label for="pseudo">Pseudo</label>
                <input type="text" id="pseudo" name="pseudo" value="<?= htmlspecialchars($userPseudo) ?>" required>
            </div>
            <div>
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($userEmail) ?>" required>
            </div>
            <div>
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" value="<?= htmlspecialchars($userPassword) ?>" required>         
            </div>
            <button type="submit">Enregistrer</button>
        </form>
    </div>
</div>
<table class="books-array">
    <thead>
        <tr>
            <th>PHOTO</th>
            <th>TITRE</th>
            <th>AUTEUR</th>
            <th>DESCRIPTION</th>
            <th>DISPONIBILITÉ</th>
            <th>ACTION</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($userBooks as $userBook) : ?>
            <tr>
                <td>
                    <img src="<?= htmlspecialchars($userBook->getCover()) ?>"
                         alt="Couverture de <?= htmlspecialchars($userBook->getTitle()) ?>">
                </td>
                <td><?= htmlspecialchars($userBook->getTitle()) ?></td>
                <td><?= htmlspecialchars($userBook->getAuthor()) ?></td>
                <td><?= htmlspecialchars($userBook->getDescription()) ?></td>
                <td>
                    <?= $userBook->getAvailability() ? 'Disponible' : 'Indisponible' ?>
                </td>
                <td class="actions">
                    <a href="index.php?page=updateBook&id=<?= $userBook->getId() ?>">Éditer</a>
                    <a href="index.php?page=deleteBook&id=<?= $userBook->getId() ?>" 
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer : <?= htmlspecialchars($userBook->getTitle()) ?> de <?= htmlspecialchars($userBook->getAuthor()) ?>?');">
                        Supprimer
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>