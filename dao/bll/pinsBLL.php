<?php

class pinsBLL {

    private $tableName = "pins";

    public function insert($id, $title, $image, $url, $boardFk) {
        $objConexion = new Connection();
        $objConexion->queryWithParams("insert into $this->tableName (id, title, image, url,  boardFk) values (:id, :title, :image, :url, :boardFk)", array(":id" => $id,":title" => $title,":image" => $image,":url" => $url,": boardFk" => $boardFk));
    }

    public function update($id, $title, $image, $url, $boardFk) {
        $objConexion = new Connection();
        $objConexion->queryWithParams("update $this->tableName set id = :id, title = :title, image = :image, url = :url, boardFk = :boardFk where id = :id", array(":title" => $title,":image" => $image,":url" => $url,":boardFk" => $boardFk, ":id" => $id));
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
