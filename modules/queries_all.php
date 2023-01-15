<?php
require_once "database/conexion.php";
require_once "modules/functions_util.php";
require_once "modules/response.php";

class Queries_All extends Connection
{


    //Todo en la url (nombre de tabla, parametro, valor del parametro)
    function  queryGet($table, $parameterName, $parameterValue)
    {
        try {
            $query = "SELECT * FROM $table WHERE $parameterName=:$parameterName";

            $stmt = $this->conn_db->prepare($query);
            $stmt->bindParam(":$parameterName", $parameterValue);
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

    //Recibe array asociativo y tabla
    function queryPost($array, $table)
    {
        try {
            $arrayAssociative = splitAsociativeArray($array);
            $keysLength = sizeof($arrayAssociative["keys"]);
            $counter = 1;
            $fields = "(";
            $values = "values (";

            foreach ($arrayAssociative["keys"] as $key) {
                if ($counter < $keysLength) {
                    $fields .= "$key, ";
                    $values .= ":$key, ";
                } else {
                    $fields .= "$key)";
                    $values .= ":$key)";
                }
                $counter++;
            }

            $query = "INSERT INTO $table $fields $values";
            $stmt = $this->conn_db->prepare($query);

            foreach ($array as $key => &$value) {
                $stmt->bindParam(":$key", $value);
            }

            $sucess = $stmt->execute();
            Response::sucessResponse($sucess, $stmt->rowCount());
        } catch (\Throwable $th) {
            Response::$resp["message"] = $th->getMessage();
            Response::response_500();
        } finally {
            $this->conn_db = null;
        }
    }

    //Recibe array asociativo, tabla, parametro, valor de parametro
    function queryPut($array, $table, $parameterName, $parameterValue)
    {
        try {
            $arrayAssociative = splitAsociativeArray($array);
            $keysLength = sizeof($arrayAssociative["keys"]);
            $counter = 1;
            $fields = "";

            foreach ($array as $key => $value) {
                if ($counter < $keysLength) {
                    $fields .= "$key=:$key, ";
                } else {
                    $fields .= "$key=:$key";
                }
                $counter++;
            }

            $query = "UPDATE $table SET $fields WHERE $parameterName=:$parameterName";

            $stmt = $this->conn_db->prepare($query);
            foreach ($array as $key => &$value) {
                $stmt->bindParam(":$key", $value);
            }
            $stmt->bindParam(":$parameterName", $parameterValue);
           // echo $query;
            $sucess = $stmt->execute();
            Response::sucessResponse($sucess, $stmt->rowCount());
        } catch (\Throwable $th) {
            Response::$resp["message"] = $th->getMessage();
            Response::response_500();
        } finally {
            $this->conn_db = null;
        }
    }

    function queryDelete($table, $parameterName, $parameterValue)
    {
        try {
            $query = "DELETE FROM $table WHERE $parameterName=:$parameterName";
            $stmt = $this->conn_db->prepare($query);
            $stmt->bindParam(":$parameterName", $parameterValue);
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
    //delete
    // "DELETE from trabajad_cruzado where COD_TRABAJ= " . ":codigo"



}
