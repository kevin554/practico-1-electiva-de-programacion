<?php

class pinsBLL {

    private $tableName = "pins";

    public function insert($title, $image, $url, $boardFk) {
        $objConexion = new Connection();
        $objConexion->queryWithParams("insert into $this->tableName (title, image, url, boardFk) values (:title, :image, :url, :boardFk)", array(":title" => $title, ":image" => $image, ":url" => $url, ":boardFk" => $boardFk));

        $stmt = $objConexion->query("select max(id) from pins");

        $lastId = $stmt->fetchColumn();
        return $lastId;
    }

    public function update($id, $title, $image, $url, $boardFk) {
        $objConexion = new Connection();
        $objConexion->queryWithParams("update $this->tableName set title = :title, image = :image, url = :url, boardFk = :boardFk where id = :id", array(":title" => $title, ":image" => $image, ":url" => $url, ":boardFk" => $boardFk, ":id" => $id));
    }

    public function delete($id) {
        $objConexion = new Connection();
        $objConexion->queryWithParams("delete from $this->tableName where id = :id", array(":id" => $id));
    }

    public function select($id) {
        $objConexion = new Connection();
        $res = $objConexion->queryWithParams("select id, title, image, url, boardFk from $this->tableName where id = :id", array(":id" => $id));

        if ($res->rowCount() == 0) {
            return null;
        }

        $row = $res->fetch(PDO::FETCH_ASSOC);
        $obj = $this->rowToDto($row);

        return $obj;
    }

    public function selectAll() {
        $objConexion = new Connection();
        $res = $objConexion->query("select id, title, image, url, boardFk from $this->tableName");
        $pinList = array();

        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $obj = $this->rowToDto($row);
            $pinList[] = $obj;
        }

        return $pinList;
    }

    public function selectOfBoard($boardFk) {
        $objConexion = new Connection();
        $res = $objConexion->queryWithParams("select id, title, image, url, boardFk from $this->tableName where boardFk = :boardFk", array(":boardFk" => $boardFk));
        $pinList = array();

        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $obj = $this->rowToDto($row);
            $pinList[] = $obj;
        }

        return $pinList;
    }

    public function rowToDto($row) {
        $obj = new pins();
        $obj->setId($row["id"]);
        $obj->setTitle($row["title"]);
        $obj->setImage($row["image"]);
        $obj->setUrl($row["url"]);
        $obj->setBoardFk($row["boardFk"]);

        return $obj;
    }

}
