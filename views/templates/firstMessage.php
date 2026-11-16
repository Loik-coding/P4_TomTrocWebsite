<div class="fil-ariane">
    <a href="index.php?page=myAccount">← retour</a>
</div>
<h1>Envoyer un message à <?= htmlspecialchars($contactPseudo) ?></h1>
<?php if (!empty($formErrors)): ?>
    <div class="errors">
        <?php foreach ($formErrors as $formError): ?>
            <p><?= htmlspecialchars($formError) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<div class="create-book">
    <?php var_dump($contactId); ?>
    <form action="index.php?page=sendFirstMessage" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="contactId" value="<?= (int) $contactId ?>">
        <div>
            <label for="content">Message</label>
            <textarea id="content" name="content" rows="5" cols= "32" required><?= $message ?></textarea>
        </div>  
        <button type="submit">Envoyer</button>
    </form>
</div>
