<?php

class Book
{
    private $id;
    private $title;
    private $author;
    private $description;
    private $availability;
    private $cover;
    private $user_id;
    private $userPseudo;
    private $userCover;
    private $booksCount;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->title = $data['title'];
        $this->author = $data['author'];
        $this->description = $data['description'];
        $this->availability = (bool) $data['availability'];
        $this->cover = $data['cover'];
        $this->user_id = $data['user_id'];
        $this->userPseudo = $data['pseudo'] ?? null;  
        $this->userCover = $data['image'] ?? null;     
        $this->booksCount = $data['booksCount'] ?? 0;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getAvailability()
    {
        return $this->availability;
    }

    public function getCover()
    {
        return $this->cover;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getUserPseudo()
    {
        return $this->userPseudo;
    }

    public function getUserCover()
    {
        return $this->userCover;
    }

        public function getBooksCount()
    {
        return $this->booksCount;
    }
}