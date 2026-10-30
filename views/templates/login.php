
<?php if (isset($_SESSION['success'])) : ?>

    <p>
        <?= htmlspecialchars($_SESSION['success']) ?>
    </p>

    <?php unset($_SESSION['success']); ?>

<?php endif; ?>
<?php if (!empty($errors)) : ?>
    <div class="errors">
        <?php foreach ($errors as $error) : ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<h1>Se connecter</h1>

<form action="index.php?page=loginForm" method="POST">

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

    <button type="submit">Se connecter</button>

</form>

<p>
    Pas encore de compte ?
    <a href="index.php?page=register">Créer un compte</a>
</p>
