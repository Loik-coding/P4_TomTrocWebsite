<section class="messaging-page">

    <h1>Messagerie</h1>

    <div class="messaging-container">
        <!-- Colonne des contacts -->
        <div class="messaging-list">
            <?php foreach ($contacts as $contactId => $contact) : ?>
                <a class="messaging-card"
                   href="index.php?page=messaging&id=<?= $contactId ?>">
                    <div class="messaging-contact">
                        <?= htmlspecialchars($contact['pseudo']) ?>
                    </div>
                    <div class="messaging-content">
                        <?= htmlspecialchars($contact['content']) ?>
                    </div>
                    <div class="messaging-date">
                        <?= date('d/m/Y à H:i', strtotime($contact['date'])) ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Colonne des messages -->
        <div class="messaging-conversation">
            <div class="messages-list">
                <?php if ($contactPseudo !== null) : ?>

                    <h2>Conversation avec <?= htmlspecialchars($contactPseudo) ?></h2>

                    <?php foreach ($messages as $message) : ?>
                        <?php
                        // Détermine si le message est envoyé ou reçu.
                        $isSent = $message->getSenderId() == $userId;
                        // Détermine le pseudo de l'expéditeur.
                        $senderPseudo = $isSent
                            ? $_SESSION['user']['pseudo']
                            : $contactPseudo;
                        ?>
                        <div class="message-wrapper <?= $isSent ? 'message-sent' : 'message-received' ?>">
                            <div class="message-info">
                                <?= htmlspecialchars($senderPseudo) ?>
                                ·
                                <?= date('d/m/Y à H:i', strtotime($message->getDate())) ?>
                            </div>
                            <div class="message">
                                <?= htmlspecialchars($message->getContent()) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                
                <?php else : ?>
                    <p>Sélectionnez une conversation pour afficher vos messages.</p>
                <?php endif; ?>
            </div>
            <div>
                <?php if ($contactPseudo !== null) : ?>
                    <form method="POST" action="index.php?page=sendMessage&id=<?= (int) Utils::request('id', -1) ?>" class="messaging-form">
                        <textarea
                            name="content"
                            placeholder="Écrire un message..."
                            required
                        ></textarea>
                        <button type="submit">
                            Envoyer
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>