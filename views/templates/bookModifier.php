<div class="fil-ariane">
    <a href="index.php?page=myAccount">← retour</a>
</div>


<h1>Modifier les informations</h1>

<div class="layout-row">
    <div class="update-book">
        <img src="<?= htmlspecialchars($book->getCover()) ?>" alt="Photo de couverture de <?= htmlspecialchars($book->getTitle()) ?>">
        <form class="update-book-link" action="index.php?page=updateBookCover&id=<?= htmlspecialchars($book->getId()) ?>" method="POST" enctype="multipart/form-data">
            <label for="cover">Modifier la photo</label>
            <input type="file" id="cover" name="cover" accept="image/*" value= "" required onchange="this.form.submit()">
        </form>
    </div>

    <div class="create-book">
        <form action="index.php?page=updateBook&id=<?= htmlspecialchars($book->getId()) ?>" method="POST">
            <div>
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($book->getTitle()) ?>" required>
            </div>
            <div>
                <label for="author">Auteur</label>
                <input type="text" id="author" name="author" value="<?= htmlspecialchars($book->getAuthor()) ?>" required>
            </div>
            <div>
                <label for="description">Commentaires</label>
                <textarea id="description" name="description" rows="10" cols= "64" required><?= htmlspecialchars($book->getDescription()) ?></textarea>
            </div>
            <div>
                <label for="availability">Disponibilité</label>
                <select id="availability" name="availability">
                    <option value="1" <?= htmlspecialchars($book->getAvailability()) == 1 ? 'selected' : '' ?>>Disponible</option>
                    <option value="0" <?= htmlspecialchars($book->getAvailability()) == 0 ? 'selected' : '' ?>>Indisponible</option>
                </select>
            </div>     
            <button type="submit">Publier</button>
        </form>
    </div>  
</div>
