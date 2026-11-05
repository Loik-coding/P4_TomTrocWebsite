<h1>Modifier les informations</h1>

<div class="layout-row">
    <div class="create-book">
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
                <textarea id="description" name="description" rows="10" cols= "64" required></textarea>
            </div>
            <div>
                <label for="availability">Disponibilité</label>
                <select id="availability" name="availability">
                    <option value="true">Disponible</option>
                    <option value="false">Indisponible</option>
                </select>
            </div>     
            <div>
                <label for="cover">Choisir une photo de couverture</label>
                <input type="file" id="cover" name="cover" accept="image/*" required onchange="this.form.submit()">
            </div>    
            <button type="submit">Publier</button>
        </form>
    </div>  
</div>
