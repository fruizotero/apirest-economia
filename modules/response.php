<?php

class Response
{


    public static $resp = array(
        "ok" => true,
        "rows_affected" => 0,
        "result" => array(),
        "message" => ""
    );


    public static function response_200()
    {
        header("Content-Type: application/json");
        echo json_encode(self::$resp, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        // echo json_last_error_msg();
        http_response_code(200);
    }

    public static function response_500()
    {

        self::$resp["ok"] = false;
        // $this->resp["msg"] = "No se completó la consulta";

        header("Content-Type: application/json");
        echo json_encode(self::$resp, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        // echo json_last_error_msg();
        http_response_code(500);
    }

    public static function sucessResponse($sucess, $rowsAffected)
    {
        if ($sucess) {
            self::$resp["message"] = "La consulta se completó satisfactoriamente, " . $rowsAffected . " filas afectadas";
            self::$resp["rows_affected"] = $rowsAffected;
            self::response_200();
        } else {
            self::response_500();
        }
    }
}
