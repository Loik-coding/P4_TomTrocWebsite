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

    public function getUserById(int $id): ?User
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute([
            'id' => $id
        ]);
        $userData = $query->fetch();

        if (!$userData) {
            return null;
        }

        return new User($userData);
    }

    public function updateProfilePicture(int $userId, string $profilePicturePath): bool
    {
        $sql = "UPDATE users SET profile_picture = :profile_picture WHERE id = :id";
        $query = $this->db->prepare($sql);
        return $query-> execute([
            'profile_picture' => $profilePicturePath,
            'id' => $userId
        ]);
    }

    public function updateUser(int $userId, string $pseudo, string $email, string $password): bool {
        $sql = "UPDATE users SET pseudo = :pseudo, email = :email, password = :password WHERE id = :id";
        $query = $this->db->prepare($sql);
        return $query-> execute([
            'id' => $userId,
            'pseudo' => $pseudo,
            'email' => $email,
            'password' => $password,
        ]);
    }
}