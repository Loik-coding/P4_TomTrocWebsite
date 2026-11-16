<?php

class MessageController
{
    public function messaging()
    {         
        // Vérifie que l'utilisateur est connecté.
        if (!Utils::isUserConnected()) {
            header('Location: index.php?page=login');
            exit;
        }

        // Get l'id du user connecté.
        $userId = $_SESSION['user']['id'] ?? null;

        // On instancie les managers.
        $messageManager = new MessageManager();
        $userManager = new UserManager();

        // Récupère les contacts et leur dernier message.
        $contacts = $messageManager->getContacts($userId);

        // Récupère le pseudo de chaque contact.
        foreach ($contacts as $contactId => $message) {
            $contact = $userManager->getUserById($contactId);
            $contacts[$contactId]['pseudo'] = $contact->getPseudo();
        }

        // Initialise les variables utilisées dans la vue.
        $messages = [];
        $contactPseudo = null;

        // Récupère l'ID du contact sélectionné.
        $contactId = (int) Utils::request('contactId', -1);

        // Vérifie que le contact appartient bien à la liste des contacts.
        if (isset($contacts[$contactId])) {

            // Récupère son pseudo.
            $contactPseudo = $contacts[$contactId]['pseudo'];

            // Récupère les messages échangés.
            $messages = $messageManager->getMessagesWithUser($userId, $contactId);
        }

        // Charge la vue.
        ob_start();
        require TEMPLATE_VIEW_PATH . 'messaging.php';
        $content = ob_get_clean();

        require TEMPLATE_VIEW_PATH . 'main.php';  
    }

    public function sendMessage()
    {
        // Vérifie que l'utilisateur est connecté.
        if (!Utils::isUserConnected()) {
            header('Location: index.php?page=login');
            exit;
        }
        // Get l'id du user connecté.
        $userId = $_SESSION['user']['id'] ?? null;

        // Récupère l'ID du contact sélectionné.
        $contactId = Utils::request('id', -1);

        // Vérifie si le formulaire a été soumis.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=messaging&id=' . $contactId);
            exit;
        }       
        
        // Récupère le contenu du message.
        $content = trim($_POST['content'] ?? '');

        // Vérifie que le message n'est pas vide.
        if ($content === '') {
            header('Location: index.php?page=messaging&id=' . $contactId);
            exit;
        }

        $messageManager = new MessageManager();
        // Envoie le message.
        $messageManager->sendMessage($userId, $contactId, $content);

        // Recharge la page.
        header('Location: index.php?page=messaging&contactId=' . $contactId);
        exit;
    }

    public function firstMessage()
    {
        // Vérifie que l'utilisateur est connecté.
        if (!Utils::isUserConnected()) {
            header('Location: index.php?page=login');
            exit;
        }
        $userId = (int) ($_SESSION['user']['id'] ?? 0);
        $contactId = (int) Utils::request('contactId', -1);
        $bookId = (int) Utils::request('bookId', -1);

        // Redirection vers la page profil si le user=contact
        if ($bookId === -1 && $userId === $contactId) {
            header('Location: index.php?page=userProfile&id=' . $contactId);
            exit;
        }
        // Redirection vers la page du livre si le user=contact
        if ($userId === $contactId) {
            header('Location: index.php?page=bookDetails&id=' . $bookId);
            exit;
        }
        //on instancie le manager
        $userManager = new UserManager();
        $user = $userManager->getUserById($contactId);
        $contactPseudo = $user->getPseudo();

        if ($bookId === -1) {
            $message = "Bonjour " . htmlspecialchars($contactPseudo ?? '') . ",\n\n"
                . "As-tu des livres disponibles ?\n\n"
                . "Merci.";
        } else {
            $bookManager = new BookManager();
            $book = $bookManager->getBookById($bookId);
            $bookTitle = $book->getTitle();
            $message = "Bonjour " . htmlspecialchars($contactPseudo ?? '') . ",\n\n"
                    . "Ton livre " . htmlspecialchars($bookTitle ?? '') . " m'intéresse, est-il toujours disponible ?";
        }
            
        // Charge la vue.
        ob_start();
        require TEMPLATE_VIEW_PATH . 'firstMessage.php';
        $content = ob_get_clean();

        require TEMPLATE_VIEW_PATH . 'main.php';  
    }

    public function sendFirstMessage()
    {
        // Vérifie que l'utilisateur est connecté.
        if (!Utils::isUserConnected()) {
            header('Location: index.php?page=login');
            exit;
        }
        // Get l'id du user connecté.
        $userId = $_SESSION['user']['id'] ?? null;

        // Récupère l'ID du contact sélectionné.
        $contactId = (int) ($_POST['contactId'] ?? -1);

        // Vérifie que l'identifiant est valide.
        if ($contactId <= 0) {
            die('Erreur : identifiant du destinataire invalide.');
        }

        // Vérifie si le formulaire a été soumis.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=firstMessage&id=' . $contactId);
            exit;
        }       
        
        // Récupère le contenu du message.
        $content = trim($_POST['content'] ?? '');

        // Vérifie que le message n'est pas vide.
        if ($content === '') {
            header('Location: index.php?page=firstMessage&id=' . $contactId);
            exit;
        }

        // Redirection vers la page du livre si le user=contact
        if ($userId === $contactId) {
            header('Location: index.php?page=firstMessage&id=' . $contactId);
            exit;
        }

        $messageManager = new MessageManager();
        // Envoie le message.
        $messageManager->sendMessage($userId, $contactId, $content);

        // Recharge la page.
        header('Location: index.php?page=messaging&contactId=' . $contactId);
        exit;
    }


}
