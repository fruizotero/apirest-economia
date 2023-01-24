<?php
require_once "database/conexion.php";
require_once "modules/queries_all.php";
require_once "vendor/autoload.php";

use \Firebase\JWT\JWT;

class LoginRegister extends Connection
{


    function login($array)
    {
        try {

            $email_request = $array["user_email"];
            $pass_request = $array["user_pass"];

            $query = "SELECT * FROM users WHERE user_email=:user_email";
            $stmt = $this->conn_db->prepare($query);

            $stmt->bindParam(":user_email", $email_request);

            $sucess = $stmt->execute();
            $rows = $stmt->rowCount();
            //SE COMPRUEBA EMAIL
            if ($sucess && $rows > 0) {

                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $user = $stmt->fetchAll();
                $user_id = $user[0]["user_id"];
                $user_email = $user[0]["user_email"];
                $user_pass = $user[0]["user_pass"];
                $user_admin = $user[0]["user_admin"];

                //SE COMPRUEBA CONTRASEÑA
                $verify = password_verify($pass_request, $user_pass);
                if ($verify) {
                    $tokenArray = $this->jwtToken($user_id, $user_email);
                    $key = "dmekme3883mdkemdkk939k3dkdkmkdmkmc";
                    $jwtToken = JWT::encode($tokenArray, $key, 'HS256');
                    $tokenExp = $tokenArray["exp"];

                    try {
                        $query_update = "UPDATE users SET user_token=:user_token, user_token_expiration=:user_token_expiration WHERE user_id=:user_id";
                        $stmt_update = $this->conn_db->prepare($query_update);
                        $stmt_update->bindParam(":user_token", $jwtToken);
                        $stmt_update->bindParam(":user_token_expiration", $tokenExp);
                        $stmt_update->bindParam(":user_id", $user_id);

                        $sucess_update = $stmt_update->execute();
                        $rows_update = $stmt_update->rowCount();

                        if ($sucess_update && $rows_update > 0) {
                            Response::$resp["result"] = array(
                                "user_id" => $user_id,
                                "user_email" => $user_email,
                                "user_admin" => $user_admin,
                                "user_token" => $jwtToken
                            );
                            Response::sucessResponse(true, $rows_update);
                        } else {
                            Response::$resp["message"] = "Ocurrió un error, vuelve a intentarlo";
                            Response::sucessResponse(false, $rows_update);
                        }
                    } catch (\Throwable $th) {
                        Response::$resp["message"] = $th->getMessage();
                        Response::response_500();
                    } finally {
                        $this->conn_db = null;
                    }
                } else {
                    Response::$resp["message"] = "Contraseña no válida";
                    Response::sucessResponse(false, $rows);
                }
            } else {
                Response::$resp["message"] = "Usuario no válido";
                Response::sucessResponse(false, $rows);
            }
        } catch (\Throwable $th) {

            Response::$resp["message"] = $th->getMessage();
            Response::response_500();
        } finally {
            $this->conn_db = null;
        }
    }

    function jwtToken($id, $email)
    {

        $time = time();

        $token = array(
            "iat" => $time,
            "exp" => $time + (60 * 60 * 24),
            "data" => [
                "id" => $id,
                "email" => $email
            ]
        );
        return $token;
    }

    function checkToken()
    {
        // $queries = new Queries_All();

        $headers = getallheaders();
        $isValid = false;

        if (isset($headers["token"])) {
            $token = $headers["token"];

            try {
                $query = "SELECT * FROM users WHERE user_token=:user_token";
                $stmt = $this->conn_db->prepare($query);
                $stmt->bindParam(":user_token", $token);

                $sucess = $stmt->execute();
                $rows = $stmt->rowCount();


                if ($sucess && $rows > 0) {
                    $isValid = true;
                    Response::$resp["rows_affected"] = $rows;
                } else {
                    $isValid = false;
                }
            } catch (\Throwable $th) {
                Response::$resp["message"] = $th->getMessage();
                Response::response_500();
            } finally {
                $this->conn_db = null;
            }
        }
        return $isValid;
    }
}
