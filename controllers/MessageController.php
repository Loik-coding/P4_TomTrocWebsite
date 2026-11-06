<?php

class MessageController
{
    public function showMessenger()
    {

        unset($message);

        ob_start();
        require TEMPLATE_VIEW_PATH . 'messenger.php';
        $content = ob_get_clean();

        require TEMPLATE_VIEW_PATH . 'main.php';  


    }

    public function messaging()
{       
    // Récupérer son ID depuis la session.
    // Récupérer ses contacts.
    // Récupérer les messages du contact sélectionné.
    // Charger la vue messaging.php.
    
    // Vérifie que l'utilisateur est connecté.
    if (!Utils::isUserConnected()) {
        header('Location: index.php?route=connexionForm');
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

    // Récupère l'id de la conversation sélectionnée.
    $contactId = Utils::request("id", -1);
    $contact = $userManager->getUserById($contactId);
    $contactPseudo = $contact->getPseudo();
    // Récupère les messages avec le contact.
    $messages = $messageManager->getMessagesWithUser($userId, $contactId);

    // Charge la vue.
    ob_start();
    require TEMPLATE_VIEW_PATH . 'messaging.php';
    $content = ob_get_clean();

    require TEMPLATE_VIEW_PATH . 'main.php';  
    
}

public function sendMessage()
{
    // Vérifier que l'utilisateur est connecté.
    // Récupérer son ID depuis la session.
    // Récupérer le destinataire et le contenu du POST.
    // Enregistrer le message avec MessengerManager.
    // Rediriger vers la conversation.
}
}