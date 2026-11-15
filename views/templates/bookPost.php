<div class="fil-ariane">
    <a href="index.php?page=myAccount">← retour</a>
</div>
<h1>Publier un nouveau livre</h1>
<?php if (!empty($formErrors)): ?>
    <div class="errors">
        <?php foreach ($formErrors as $formError): ?>
            <p><?= htmlspecialchars($formError) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<div class="create-book">
    <form action="index.php?page=createBook" method="POST" enctype="multipart/form-data">
        <div>
            <label for="title">Titre</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($author ?? '') ?>" required>
        </div>
        <div>
            <label for="author">Auteur</label>
            <input type="text" id="author" name="author" value="<?= htmlspecialchars($title ?? '') ?>" required>
        </div>
        <div>
            <label for="description">Commentaires</label>
            <textarea id="description" name="description" rows="10" cols= "64" required><?= htmlspecialchars($description ?? '') ?></textarea>
        </div>
        <div>
            <label for="availability">Disponibilité</label>
            <select id="availability" name="availability">
                <option value="1" <?= ($availability ?? '') === '1' ? 'selected' : '' ?>>Disponible</option>
                <option value="0" <?= ($availability ?? '') === '0' ? 'selected' : '' ?>>Indisponible</option>
            </select>
        </div>     
        <div>
            <label for="cover">Choisir une photo de couverture</label>
            <input type="file" id="cover" name="cover" accept="image/*">
        </div>    
        <button type="submit">Publier</button>
    </form>
</div>
