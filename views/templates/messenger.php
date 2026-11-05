

<section class="messaging">

    <h1>Messagerie</h1>

    <?php if (empty($messages)) : ?>

        <p>Vous n'avez pas encore de conversation.</p>

    <?php else : ?>

        <div class="messaging-list">

            <?php foreach ($messages as $message) : ?>

                <article class="messaging-card">

                    <div class="messaging-contact">
                        Contact #<?= htmlspecialchars($message['contact_id']) ?>
                    </div>

                    <div class="messaging-content">
                        <?= htmlspecialchars($message['content']) ?>
                    </div>

                    <div class="messaging-date">
                        <?= date('d/m/Y à H:i', strtotime($message['date'])) ?>
                    </div>

                </article>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</section>
