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
        $userManager = new userManager();

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
        $contactId = (int) Utils::request('id', -1);

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

        // Vérifie que le contact appartient bien aux conversations de l'utilisateur.
        $messageManager = new MessageManager();
        $contacts = $messageManager->getContacts($userId);

        if (!isset($contacts[$contactId])) {
            header('Location: index.php?page=messaging');
            exit;
        }

        // Envoie le message.
        $messageManager->sendMessage($userId, $contactId, $content);

        // Recharge la page.
        header('Location: index.php?page=messaging&id=' . $contactId);
        exit;
    }


    // Enregistrer le message avec MessengerManager.
    // Rediriger vers la conversation.
}
