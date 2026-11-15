<?php

class Message
{
    private $id;
    private $senderId;
    private $receiverId;
    private $date;
    private $content;
    private $hide;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->senderId = $data['sender_id'];
        $this->receiverId = $data['receiver_id'];
        $this->date = $data['date'];
        $this->content = $data['content'];
        $this->hide = $data['hide'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSenderId()
    {
        return $this->senderId;
    }

    public function getReceiverId()
    {
        return $this->receiverId;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getHide()
    {
        return $this->hide;
    }

}