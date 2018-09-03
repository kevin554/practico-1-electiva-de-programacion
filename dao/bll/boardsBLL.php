<?php

class boardsBLL {

    private $tableName = "boards";

    public function insert($name) {
        $objConexion = new Connection();
        $objConexion->queryWithParams("insert into $this->tableName (name) values (:name)", array(":name" => $name));
    }

    public function update($id, $name) {
        $objConexion = new Connection();
        $objConexion->queryWithParams("update $this->tableName set name = :name where id = :id", array(":name" => $name, ":id" => $id));
    }

    public function delete($id) {
        $objConexion = new Connection();
        $objConexion->queryWithParams("delete from $this->tableName where id = :id", array(":id" => $id));
    }

    public function select($id) {
        $objConexion = new Connection();
        $res = $objConexion->queryWithParams("select id, name from $this->tableName where id = :id", array(":id" => $id));

        if ($res->rowCount() == 0) {
            return null;
        }

        $row = $res->fetch(PDO::FETCH_ASSOC);
        $obj = $this->rowToDto($row);

        return $obj;
    }

    public function selectAll() {
        $objConexion = new Connection();
        $res = $objConexion->query("select id, name from $this->tableName");
        $boardList = array();

        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $obj = $this->rowToDto($row);
            $boardList[] = $obj;
        }

        return $boardList;
    }

    public function rowToDto($row) {
        $obj = new boards();
        $obj->setId($row["id"]);
        $obj->setName($row["name"]);

        return $obj;
    }

}
