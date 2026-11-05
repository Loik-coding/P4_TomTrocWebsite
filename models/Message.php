<?php

class Message
{
    private $id;
    private $fromUserId;
    private $toUserId;
    private $date;
    private $content;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->fromUserId = $data['from_user_id'];
        $this->toUserId = $data['to_user_id'];
        $this->date = $data['date'];
        $this->content = $data['content'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFromUserId()
    {
        return $this->fromUserId;
    }

    public function getToUserId()
    {
        return $this->toUserId;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getContent()
    {
        return $this->content;
    }

}