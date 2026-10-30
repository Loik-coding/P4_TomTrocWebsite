<?php

class UserManager extends AbstractEntityManager
{
    public function getUserByEmail(string $email): ?User
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $query = $this->db->prepare($sql);
        $query->execute([
            'email' => $email
        ]);
        $userData = $query->fetch();

        if (!$userData) {
            return null;
        }

        return new User($userData);
    }

    public function createUser(
        string $pseudo,
        string $email,
        string $password,
    ): bool {
        $sql = "INSERT INTO users (pseudo, email, password) VALUES (:pseudo, :email, :password)";
        $query = $this->db->prepare($sql);
        return $query->execute([
            'pseudo' => $pseudo,
            'email' => $email,
            'password' => $password
        ]);
    }

}