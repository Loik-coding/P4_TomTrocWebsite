<?php

class MessageController
{
    public function showMessenger()
    {
        //Get user id from session
        $userId = $_SESSION['user']['id'] ?? null;

        //on instancie le manager
        $messageManager = new MessageManager();
        $messages = $messageManager->getLastMessagesByContact($userId);

        $userManager = new userManager();
        foreach ($messages as &$message) {
            $contact = $userManager->getUserById($message['contact_id']);
            $message['pseudo'] = $contact->getPseudo();
        }
        unset($message);

        ob_start();
        require TEMPLATE_VIEW_PATH . 'messenger.php';
        $content = ob_get_clean();

        require TEMPLATE_VIEW_PATH . 'main.php';  


    }
}