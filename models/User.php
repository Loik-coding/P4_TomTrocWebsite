<?php

class user
{
    private $id;
    private $pseudo;
    private $email;
    private $password;
    private $profilePicture;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->pseudo = $data['pseudo'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->profilePicture = $data['image'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    } 

    public function getProfilePicture()
    {
        return $this->profilePicture;
    }



}