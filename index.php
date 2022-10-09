<?php

class Reviews {
    public $product;
    public $user;
    public $text;
    public $photo;
    public $rating;
    private $email;

    public function __construct($product, $user, $text, $photo, $rating, $email)
    {
        $this->product = $product;
        $this->user = $user;
        $this->text = $text;
        $this->photo = $photo;
        $this->rating = $rating;
        $this->email = $email;
    }

    public function writeReview()
    {
        return;
    }

    public function putRating()
    {
        return;
    }
}

class Answer extends Reviews{

    public function getFeedback()
    {
        return;
    }
}