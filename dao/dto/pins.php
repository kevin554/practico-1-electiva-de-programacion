<?php

class pins {

    public $id;
    public $title;
    public $image;
    public $url;
    public $boardFk;

    function getId() {
        return $this->id;
    }

    function getTitle() {
        return $this->title;
    }

    function getImage() {
        return $this->image;
    }

    function getUrl() {
        return $this->url;
    }

    function getBoardFk() {
        return $this->boardFk;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setImage($image) {
        $this->image = $image;
    }

    function setUrl($url) {
        $this->url = $url;
    }

    function setBoardFk($boardFk) {
        $this->boardFk = $boardFk;
    }

}
