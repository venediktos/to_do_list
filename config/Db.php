<?php

class Db{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "to_do_list";

    public $conn;

    public function connect(){
        $this->conn = null;
        try {
            $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        }catch (Exception $e){
            echo "Connection failed: " . $e->getMessage();
        }

        return $this->conn;
    }
}