
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



<div class="book-details">
    <div class="login-form">
        <h1>Connexion</h1>
        <form action="index.php?page=loginForm" method="POST">
            <label for="email">Adresse email</label>
            <input
                type="email"
                id="email"
                name="email"
                required
            >
            <label for="password">Mot de passe</label>
            <input
                type="password"
                id="password"
                name="password"
                required
            >
            <button type="submit">Se connecter</button>
        </form>
        <p>
            Pas de compte ?
            <a href="index.php?page=register">Inscrivez-vous</a>
        </p>
    </div>
    <div class="book-cover">
        <img src="images/home/inscription-image.png">
    </div>
</div>

