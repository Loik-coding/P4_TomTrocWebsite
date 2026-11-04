<?php

class User
{
    private $id;
    private $pseudo;
    private $email;
    private $password;
    private $profilePicture;
    private $register_date;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->pseudo = $data['pseudo'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->profilePicture = $data['profile_picture'];
        $this->register_date = $data['register_date'];
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

    public function getRegisterDate()
    {
        return $this->register_date;
    }

    public function getTimeSinceSubscription(): string
    {   
        $registerDate = new DateTime($this->register_date);
        $today = new DateTime();

        $timeSinceSubscription = $registerDate->diff($today);

        if ($timeSinceSubscription->y > 0 && $timeSinceSubscription->y < 2) {
            return $timeSinceSubscription->y . ' an';
        }elseif ($timeSinceSubscription->y >= 2) {
            return $timeSinceSubscription->y . ' ans';
        }

        if ($timeSinceSubscription->m > 0) {
            return $timeSinceSubscription->m . ' mois';
        }

        return $timeSinceSubscription->d . ' jour(s)';
    }

}