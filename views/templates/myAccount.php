
<h1>Mon compte</h1>
<div class="horizontal-container">
    <div>
        <img class="profile-picture"src="<?= htmlspecialchars($userProfilePicture) ?>" alt="Photo de profil de <?= htmlspecialchars($userPseudo) ?>">
        <h2><?= htmlspecialchars($userPseudo) ?></h2>
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