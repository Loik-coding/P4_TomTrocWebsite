<?php

class MessageManager extends AbstractEntityManager
{
    public function getMessageToId(int $id): ?message
    {
        //on prépare la requete SQL
        $sql = "SELECT messages.*, users.pseudo, users.profile_picture FROM messages INNER JOIN users ON messages.to_user_id = users.id WHERE users.id = :id";
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

    
}