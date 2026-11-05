<?php

class MessageController
{
    public function showMessenger()
    {
        $id = Utils::request("id", -1);
        //on charge la vue avec les données
        //on instancie le manager
        $messageManager = new MessageManager();
        //on récupère le livre
        $message = $messageManager->getMessageToId($id);

        ob_start();
        require TEMPLATE_VIEW_PATH . 'messenger.php';
        $content = ob_get_clean();

        require TEMPLATE_VIEW_PATH . 'main.php';  

    }
}