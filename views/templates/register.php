
<?php if (!empty($errors)) : ?>
    <div class="errors">
        <?php foreach ($errors as $error) : ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<!DOCTYPE html>
<h1>Créer un compte</h1>

<form action="index.php?page=registerForm" method="POST">

    <div>
        <label for="pseudo">Pseudo</label>
        <input
            type="text"
            id="pseudo"
            name="pseudo"
            required
        >
    </div>

    <div>
        <label for="email">Adresse email</label>
        <input
            type="email"
            id="email"
            name="email"
            required
        >
    </div>

    <div>
        <label for="password">Mot de passe</label>
        <input
            type="password"
            id="password"
            name="password"
            required
        >
    </div>

    <button type="submit">Créer mon compte</button>

<p>
    Déjà inscrit ?
    <a href="index.php?page=login">Se connecter</a>
</p>

</form>
