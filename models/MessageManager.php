<?php

class MessageManager extends AbstractEntityManager
{
    public function getContacts($userId) : array
    {
        // Requête pour récupérer les messages envoyés et reçus par notre user
        $sql = "SELECT *
            FROM messenger
            WHERE sender_id = :userId
            OR receiver_id = :userId
            ORDER BY date DESC";
        // Prépare et éxécute la requête.
        $query = $this->db->prepare($sql);
        $query->execute(['userId' => $userId]);

        // Récupère les messages.
        $messages = $query->fetchAll(PDO::FETCH_ASSOC);

        // Variable pour stocker les contact et le dernier message.
        $contacts = [];

        // Parcourt les messages.
        foreach ($messages as $message) {

            if ($message['sender_id'] == $userId) {
                $contactId = $message['receiver_id'];
            } else {
                $contactId = $message['sender_id'];
            }

            // Vérifie si le contact est déjà dans la liste
            if (!isset($contacts[$contactId])) {
                $contacts[$contactId] = $message;
            }
        }
        return $contacts;
    }

    // Récupère la conversation entre deux users.
    public function getMessagesWithUser(int $userId,int $contactId)
    {
        // Requête pour récupérer les messages échangés entre 2 users.
        $sql = "SELECT * FROM messenger 
            WHERE (sender_id = :userId AND receiver_id = :contactId)
            OR (sender_id = :contactId2 AND receiver_id = :userId2)ORDER BY date DESC";

        // Préparation de la requête.
        $query = $this->db->prepare($sql);
        
        // Execution de la requête.
        $query->execute([
            'userId' => $userId,
            'contactId' => $contactId,
            'userId2' => $userId,
            'contactId2' => $contactId,
        ]);

        // Tableau qui contiendra les messages.
        $messages = [];

        // On enregistre les messages.
        while ($messageData = $query->fetch()) {
            $messages[] = new Message($messageData);
        }
        
        // Renvoi les messages.
        return $messages;
    }

    public function sendMessage()
    {

    }
}