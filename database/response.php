<?php

class Response
{


    public  $resp = array(
        "status" => "Ok",
        "result" => array(),
        "msg" => ""
    );


    public function response_200()
    {
         header("Content-Type: application/json");
        echo json_encode($this->resp, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        // echo json_last_error_msg();
         http_response_code(200);
    }

    public function response_500()
    {

        $this->resp["status"] = "Error";
        // $this->resp["msg"] = "No se completó la consulta";

        header("Content-Type: application/json");
        echo json_encode($this->resp, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        // echo json_last_error_msg();
        http_response_code(500);
    }

    public function sucessResponse($sucess, $rowsAffected)
    {
        if ($sucess) {
            $this->resp["msg"] = "La consulta se completó satisfactoriamente, " . $rowsAffected . " filas afectadas";
            $this->response_200();
        } else {
            $this->response_500();
        }
    }
}
