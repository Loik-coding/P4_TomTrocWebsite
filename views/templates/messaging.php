

<section class="messaging">

    <h1>Messagerie</h1>

    <?php if (empty($contacts)) : ?>

        <p>Vous n'avez pas encore de conversation.</p>

    <?php else : ?>
        <div class="messaging-list">
            <?php foreach ($contacts as $contactId => $contact) : ?>
                <a href = "index.php?page=messaging&id=<?= $contactId ?>">
                    <article class="messaging-card">
                        <div class="messaging-contact">
                            <?= htmlspecialchars($contact['pseudo']) ?>
                        </div>
                        <div class="messaging-content">
                            <?= htmlspecialchars($contact['content']) ?>
                        </div>
                        <div class="messaging-date">
                            <?= date('d/m/Y à H:i', strtotime($contact['date'])) ?>
                        </div>
                    </article>
                </a>     
            <?php endforeach; ?>  
        </div>
    <?php endif; ?>
</section>


<?php foreach ($messages as $message) : ?>

    <p>
        <?= htmlspecialchars($message->getContent()) ?>
    </p>

<?php endforeach; ?>
