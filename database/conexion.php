<?php
include_once "config.php";

class Connection
{

    protected $conn_db;


    function __construct()
    {
        try {
            $this->conn_db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
            $this->conn_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //  echo "Conexión exitosa <br>";
            // $this->conn_db->set_cha
        } catch (\Throwable $th) {
            echo "Error en la conexión" . "<br>";
            echo $th->getMessage();
        } 
    }
}
