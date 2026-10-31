
<div class="horizontal_container"><!-- 1er conteneur de la page  -->
    <div>
        <h2>Rejoignez nos lecteurs passionés</h2>
        <p>Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture. 
        Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres. </p>
        <a href="index.php?page=booksListing" class="cta-button">Découvrir</a>
    </div>
    <div>
        <img src="images/home/image_home.png" alt="Une boutique de livre." width="400" height="300">
    </div>
</div>
<div>
    <h2>Les derniers livres ajoutés</h2>
    <div class="book-list"><!-- les derniers livres ajoutés-->

        <?php foreach ($last4Books as $book) : ?>
            <a href="index.php?page=bookDetails&id=<?= $book->getId() ?>">
                <article class="book-card">
                    <img src="<?= htmlspecialchars($book->getCover()) ?>" alt="Couverture de <?= htmlspecialchars($book->getTitle()) ?>">
                    <h2><?=  htmlspecialchars($book->getTitle()) ?></h2>
                    <p><?= htmlspecialchars($book->getAuthor()) ?></p>
                    <p>Vendu par : <?= htmlspecialchars($book->getUserId()) ?></p>
                </article>
            </a>
        <?php endforeach; ?>
        
    </div>
    <a href="index.php?page=booksListing" class="cta-button">Voir tous les livres</a>
</div>
<div>
    <h2>Comment ça marche ?</h2>
    <p>Échanger des livres avec TomTroc c’est simple et amusant ! Suivez ces étapes pour commencer :</p>
    <div class="book-list">
        <p>Inscrivez-vous gratuitement sur notre plateforme.</p>
        <p>Ajoutez les livres que vous souhaitez échanger à votre profil.</p>
        <p>Parcourez les livres disponibles chez d'autres membres.</p>
        <p>Proposez un échange et discutez avec d'autres passionnés de lecture.</p>
    </div>
    <a href="index.php?page=booksListing" class="cta-button">Voir tous les livres</a>
</div>
<img src="images/home/image_home2.png" alt="Une blibliothèque">
<div>
    <h2>Nos Valeurs</h2>
    <p>
        Chez Tom Troc, nous mettons l'accent sur le partage, la découverte et la communauté. 
        Nos valeurs sont ancrées dans notre passion pour les livres et notre désir de créer des liens entre les lecteurs. 
        Nous croyons en la puissance des histoires pour rassembler les gens et inspirer des conversations enrichissantes.
        Notre association a été fondée avec une conviction profonde : chaque livre mérite d'être lu et partagé. 
        Nous sommes passionnés par la création d'une plateforme conviviale qui permet aux lecteurs de se connecter, 
        de partager leurs découvertes littéraires et d'échanger des livres qui attendent patiemment sur les étagères.
    </p>
    <p><span style="color: #555555; font-size: 12px;">L'équipe Tom Troc</span></p>
</div>