<?php

class MessageManager extends AbstractEntityManager
{
    public function getMessageToId(int $id): ?message
    {
        //on prépare la requete SQL
        $sql = "SELECT messenger.*, users.pseudo, users.profile_picture FROM messenger INNER JOIN users ON messenger.to_user_id = users.id WHERE users.id = :id";
        $query = $this->db->prepare($sql);

        //on associe la valeur de $id au paramètre :id
        $query->execute([
            'id' => $id
        ]);

        //on récupère le résultat
        $messageData = $query->fetch();
        if (!$messageData) {
            return null;
        }
        return new Message($messageData);
    }

    public function getLastMessagesByContact(int $userId): array
    {
        // On prépare la requête SQL.
        $sql = "SELECT * FROM messenger WHERE from_user_id = :userId OR to_user_id = :userId ORDER BY date DESC";
        $query = $this->db->prepare($sql);
        $query->execute(['userId' => $userId]);

        $messages = $query->fetchAll(PDO::FETCH_ASSOC);

        $contacts = [];

        foreach ($messages as $message) {

            if ($message['from_user_id'] == $userId) {
                $contactId = $message['to_user_id'];
            } else {
                $contactId = $message['from_user_id'];
            }

            if (!isset($contacts[$contactId])) {
                $contacts[$contactId] = $message;
            }
        }

        return $contacts;
    }

}