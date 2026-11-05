<h1>Modifier les informations</h1>

<div class="layout-row">
    <div class="update-book">
        <img src="<?= htmlspecialchars($cover) ?>" alt="Photo de couverture de <?= htmlspecialchars($title) ?>">
        <form class="update-book-link" action="index.php?page=updateBookCover&id=<?= $book->getId() ?>" method="POST" enctype="multipart/form-data">
            <label for="cover">Modifier la photo</label>
            <input type="file" id="cover" name="cover" accept="image/*" value= "" required onchange="this.form.submit()">
        </form>
    </div>

    <div class="create-book">
        <form action="index.php?page=updateBook&id=<?= $book->getId() ?>" method="POST">
            <div>
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($title) ?>" required>
            </div>
            <div>
                <label for="author">Auteur</label>
                <input type="text" id="author" name="author" value="<?= htmlspecialchars($author) ?>" required>
            </div>
            <div>
                <label for="description">Commentaires</label>
                <textarea id="description" name="description" rows="10" cols= "64" required><?= htmlspecialchars($description) ?></textarea>
            </div>
            <div>
                <label for="availability">Disponibilité</label>
                <select id="availability" name="availability">
                    <option value="1" <?= $book->getAvailability() == 1 ? 'selected' : '' ?>>Disponible</option>
                    <option value="0" <?= $book->getAvailability() == 0 ? 'selected' : '' ?>>Indisponible</option>
                </select>
            </div>     
            <button type="submit">Publier</button>
        </form>
    </div>  
</div>
