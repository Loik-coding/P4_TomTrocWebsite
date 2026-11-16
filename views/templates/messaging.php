<section class="messaging-page">

    <div class="messaging-container">
        <!-- Colonne des contacts -->

        <div class="messaging-list">
            <h1>Messagerie</h1>

            <?php foreach ($contacts as $contactId => $contact) : ?>

                <?php
                $messageDate = strtotime($contact['date']);
                $isToday = (time() - $messageDate) < 86400;
                ?>

                <a class="messaging-card <?= (int) Utils::request('contactId', -1) === (int) $contactId ? 'active' : '' ?>"
                    href="index.php?page=messaging&contactId=<?= $contactId ?>">

                    <!-- Photo de profil -->
                    <img
                        class="messaging-card-picture"
                        src="<?= htmlspecialchars($contact['profilePicture']) ?>"
                        alt="Photo de <?= htmlspecialchars($contact['pseudo']) ?>"
                    >

                    <!-- Informations du contact -->
                    <div class="messaging-card-info">

                        <!-- Première ligne : pseudo et date -->
                        <div class="messaging-card-header">

                            <span class="messaging-contact">
                                <?= htmlspecialchars($contact['pseudo']) ?>
                            </span>

                            <span class="messaging-date">
                                <?= $isToday
                                    ? date('H:i', $messageDate)
                                    : date('d/m', $messageDate)
                                ?>
                            </span>

                        </div>

                        <!-- Deuxième ligne : aperçu du message -->
                        <div class="messaging-content">
                            <?= htmlspecialchars($contact['content']) ?>
                        </div>

                    </div>

                </a>

            <?php endforeach; ?>

        </div>


        <!-- Colonne des messages -->
        <div class="messaging-conversation">
            <div class="messages-list">
                <?php if ($contactPseudo !== null) : ?>
                    <div class="messaging-card">
                        <img class="messaging-card-picture" src="<?= htmlspecialchars($contactPicture) ?>" alt="Photo de profil de <?= htmlspecialchars($contactPseudo) ?>">
                        <h3><?= htmlspecialchars($contactPseudo) ?></h3>
                    </div>

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
            <?php if ($contactPseudo !== null) : ?>
                <div class="messaging-form-container">
                    <form method="POST"
                        action="index.php?page=sendMessage&contactId=<?= (int) Utils::request('contactId', -1) ?>"
                        class="messaging-form">
                        <label for="message-content" class="visually-hidden">Votre message</label>
                        <textarea name="content"
                                placeholder="Tapez votre message ici"
                                required></textarea>

                        <button type="submit">Envoyer</button>
                    </form>
                </div>
            <?php endif; ?>
            </div>
        </div>
    </div>
</section>