
<div class="fil-ariane">
    <a href="index.php?page=myAccount">← retour</a>
</div>

<h1>Modifier les informations</h1>

<?php if (!empty($coverErrors)): ?>
    <div class="errors">
        <?php foreach ($coverErrors as $coverError): ?>
            <p><?= htmlspecialchars($coverError) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?php if (!empty($formErrors)): ?>
    <div class="errors">
        <?php foreach ($formErrors as $formError): ?>
            <p><?= htmlspecialchars($formError) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Formulaire commun aux deux colonnes -->
<form id="updateBook"
      action="index.php?page=updateBook&id=<?= htmlspecialchars($book->getId()) ?>"
      method="POST"
      enctype="multipart/form-data">
</form>

<div class="layout-row">

    <div class="update-book">
        <p>Photo</p>
        <img src="<?= htmlspecialchars($book->getCover()) ?>"
             alt="Photo de couverture de <?= htmlspecialchars($book->getTitle()) ?>">

        <label for="cover">Modifier la photo</label>

        <input type="file"
               id="cover"
               name="cover"
               accept="image/*"
               form="updateBook"
               onchange="this.form.requestSubmit()">

    </div>

    <div class="create-book">

        <div>
            <label for="title">Titre</label>
            <input type="text"
                   id="title"
                   name="title"
                   form="updateBook"
                   value="<?= htmlspecialchars($book->getTitle()) ?>"
                   required>
        </div>

        <div>
            <label for="author">Auteur</label>
            <input type="text"
                   id="author"
                   name="author"
                   form="updateBook"
                   value="<?= htmlspecialchars($book->getAuthor()) ?>"
                   required>
        </div>

        <div>
            <label for="description">Commentaires</label>
            <textarea id="description"
                      name="description"
                      form="updateBook"
                      rows="10"
                      cols="64"
                      required><?= htmlspecialchars($book->getDescription()) ?></textarea>
        </div>

        <div>
            <label for="availability">Disponibilité</label>

            <select id="availability"
                    name="availability"
                    form="updateBook">

                <option value="1" <?= $book->getAvailability() == 1 ? 'selected' : '' ?>>
                    Disponible
                </option>

                <option value="0" <?= $book->getAvailability() == 0 ? 'selected' : '' ?>>
                    Indisponible
                </option>

            </select>
        </div>

        <button type="submit" form="updateBook">Publier</button>

    </div>

</div>
