<div class="layout-row">
    <h1>Mon compte</h1>
    <a href="index.php?page=bookPost" class="cta-button-inverted">Ajouter un livre à ma collection</a>
</div>

<div class="layout-row">
    <div class="profile-layout">
        <img class="profile-picture"src="<?= htmlspecialchars($user->getProfilePicture()) ?>" alt="Photo de profil de <?= htmlspecialchars($user->getPseudo()) ?>">
        <form class="link-form" action="index.php?page=UpdateProfilePicture" method="POST" enctype="multipart/form-data">
            <label for="profilePicture">Modifier</label>
            <input type="file" id="profilePicture" name="profilePicture" accept="image/*" required onchange="this.form.submit()">
        </form>
        <h2><?= htmlspecialchars($user->getPseudo()) ?></h2>
        <p>Membre depuis <?= htmlspecialchars($user->getTimeSinceSubscription()) ?> </p>
        <p>BIBLIOTHEQUE</p>
        <p><?= htmlspecialchars($booksCount) ?> livres</p>
    </div>
    <div class="profile-layout">
        <h2>Vos informations personnelles</h2>

        <?php if (isset($_SESSION['success'])) : ?>
            <p>
                <?= htmlspecialchars($_SESSION['success']) ?>
            </p>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <form action="index.php?page=updateUser" method="POST">
            <div>
                <label for="pseudo">Pseudo</label>
                <input type="text" id="pseudo" name="pseudo" value="<?= htmlspecialchars($user->getPseudo()) ?>" required>
            </div>
            <div>
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user->getEmail()) ?>" required>
            </div>
            <div>
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" value="<?= htmlspecialchars($user->getPassword()) ?>" required>         
            </div>
            <button type="submit">Enregistrer</button>
        </form>
    </div>
</div>
<div class="layout-row">
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
                    <td>
                        <span class="book-description">
                            <?= htmlspecialchars($userBook->getDescription()) ?>
                        </span>
                    </td>
                    <td>
                        <?= $userBook->getAvailability() ? 'Disponible' : 'Indisponible' ?>
                    </td>
                    <td class="actions">
                        <a href="index.php?page=bookModifier&id=<?= $userBook->getId() ?>">Éditer</a>
                        <a href="index.php?page=deleteBook&id=<?= $userBook->getId() ?>" 
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer : <?= htmlspecialchars($userBook->getTitle()) ?> de <?= htmlspecialchars($userBook->getAuthor()) ?>?');">
                            Supprimer
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
