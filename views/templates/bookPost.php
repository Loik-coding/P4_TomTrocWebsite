
<h1>Publier un nouveau livre</h1>

<div class="layout-row">
    <div>
        <img class="post-book"src="<?= htmlspecialchars($cover) ?>">
        <form class="link-form" action="index.php?page=UpdateBookCover" method="POST" enctype="multipart/form-data">
            <label for="profilePicture">Modifier la photo</label>
            <input type="file" id="cover" name="profilePicture" accept="image/*" required onchange="this.form.submit()">
        </form>
    </div>
    <div class="profile-layout">
        <form action="index.php?page=createBook" method="POST">
            <div>
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div>
                <label for="author">Auteur</label>
                <input type="text" id="author" name="author" required>
            </div>
            <div>
                <label for="description">Commentaires</label>
                <input type="text" id="description" name="description" required>
            </div>
            <div>
                <label for="aivailability">Disponibilité</label>
                <select id="availability" name="availability">
                    <option value="true">Disponible</option>
                    <option value="false">Indisponible</option>
                    <option value="be">Belgique</option>
                </select>
            </div>
            <div>
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div>
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" required>
            </div>
            

            <button type="submit">Publier</button>
        </form>
    </div>
    </div>