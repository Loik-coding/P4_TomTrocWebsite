<div class="fil-ariane">
    <a href="index.php?page=myAccount">← retour</a>
</div>
<h1>Publier un nouveau livre</h1>

<div class="create-book">
    <form action="index.php?page=createBook" method="POST" enctype="multipart/form-data">
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
            <textarea id="description" name="description" rows="10" cols= "64" required></textarea>
        </div>
        <div>
            <label for="availability">Disponibilité</label>
            <select id="availability" name="availability">
                <option value="1">Disponible</option>
                <option value="0">Indisponible</option>
            </select>
        </div>     
        <div>
            <label for="cover">Choisir une photo de couverture</label>
            <input type="file" id="cover" name="cover" accept="image/*">
        </div>    
        <button type="submit">Publier</button>
    </form>
</div>
