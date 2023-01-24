<?php
require_once "database/conexion.php";

class Invoices extends Connection
{



    function queryInvoicesUserNow($table, $field1_name, $field1_value, $field2_name, $field2_value)
    {

        try {
            $query = "SELECT * from $table WHERE $field1_name=:$field1_name AND $field2_name >=:$field2_name";
            $stmt = $this->conn_db->prepare($query);
            $stmt->bindParam(":$field1_name", $field1_value);
            $stmt->bindParam(":$field2_name", $field2_value);
            
            $sucess = $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

            Response::$resp["result"] = $stmt->fetchAll();
            Response::sucessResponse($sucess, $stmt->rowCount());

        } catch (\Throwable $th) {
            Response::$resp["message"] = $th->getMessage();
            Response::response_500();
        } finally {
            $this->conn_db = null;
        }
    }

    function queryInvoicesBetweenDates($table,  $field1_value, $field2_value, $field3_value){
        try {
            $query = "SELECT * from $table WHERE invoice_user_id= ? AND invoice_date >= ? AND invoice_date <= ?";
            $stmt = $this->conn_db->prepare($query);
            $stmt->bindParam(1, $field1_value);
            $stmt->bindParam(2, $field2_value);
            $stmt->bindParam(3, $field3_value);
            
            $sucess = $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

            Response::$resp["result"] = $stmt->fetchAll();
            Response::sucessResponse($sucess, $stmt->rowCount());

        } catch (\Throwable $th) {
            Response::$resp["message"] = $th->getMessage();
            Response::response_500();
        } finally {
            $this->conn_db = null;
        }
    }
}
