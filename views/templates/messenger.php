<div>
    <h1>Messagerie</h1>
    <?php foreach ($messages as $message) : ?>
        <div class="row">
            <img src="<?= htmlspecialchars($message->getUserFromProfilPicture()) ?>">
            <div class="column">
                <div class="row">
                    <p><?=htmlspecialchars($message->getUserFromPseudo())?></p>
                    <p>heure</p>
                </div>
                <p>début du message...</p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div>
    <div>
        <img src="<?= htmlspecialchars($message->getUserFromProfilPicture()) ?>">
        <p><?=htmlspecialchars($message->getUserFromPseudo())?></p>
    </div>
    <?php foreach ($messages as $message) : ?>
        <p><?=htmlspecialchars($message->getUserFromPseudo())?></p>
    <?php endforeach; ?>
    <form action="index.php?page=sendMessage" method="POST">
        <label for="message" hidden></label>
        <input type="text" id="message" name="message" placeholder="Tapez votre message ici" required>
        <button type="submit">Envoyer</button>
    </form>
</div>