<?php
require_once "modules/queries_all.php";
require_once "modules/functions_util.php";
require_once "modules/queries_users.php";
require_once "modules/queries_invoices.php";


$queries = new Queries_All();
$user = new LoginRegister();
$invoices = new Invoices();

$uri = $_SERVER["REQUEST_URI"];
$data = json_decode(file_get_contents('php://input'), true);

//GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $token = $user->checkToken();
    if (!$token) {
        Response::$resp["message"] = "Token no válido";
        Response::$resp["ok"] = false;
        Response::response_200();
        return;
    }

    if (str_contains($uri, "users")) {
        Response::$resp["message"] = "Token válido";
        Response::response_200();
        return;
    }

    if (str_contains($uri, "invoices") && isset($_GET["invoice_user_id"]) && isset($_GET["invoice_date"])) {
        $id = $_GET["invoice_user_id"];
        $date = $_GET["invoice_date"];
        $invoices->queryInvoicesUserNow("invoices", "invoice_user_id", $id, "invoice_date", $date);
        // $queries->queryGet("invoices", "invoice_user_id", $id);
    }

    if (str_contains($uri, "invoicesdates") && isset($_GET["date_begin"]) && isset($_GET["date_final"]) && isset($_GET["invoice_user_id"])) {
        $id = $_GET["invoice_user_id"];
        $date1 = $_GET["date_begin"];
        $date2 = $_GET["date_final"];
        $invoices->queryInvoicesBetweenDates("invoices", $id, $date1,  $date2);
    }

    if (str_contains($uri, "categories") && isset($_GET["category_user_id"])) {
        $id = $_GET["category_user_id"];
        $queries->queryGet("categories", "category_user_id", $id);
    }
}
//POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (str_contains($uri, "login")) {
        $user->login($data);
    } else {

        $token = $user->checkToken();
        if (!$token) {
            Response::$resp["message"] = "Token no válido";
            Response::response_500();
            return;
        }

        if (str_contains($uri, "invoices")) {
            $queries->queryPost($data, "invoices");
        }

        if (str_contains($uri, "categories")) {
            $queries->queryPost($data, "categories");
        }

        if (str_contains($uri, "register")) {
            $data["user_pass"] = password_hash($data["user_pass"], PASSWORD_DEFAULT);
            $queries->queryPost($data, "users");
        }
    }
}
//PUT
if ($_SERVER["REQUEST_METHOD"] == "PUT") {

    $token = $user->checkToken();
    if (!$token) {
        Response::$resp["message"] = "Token no válido";
        Response::response_500();
        return;
    }

    if (str_contains($uri, "invoices") && isset($_GET["invoice_id"])) {
        $id = $_GET["invoice_id"];
        $queries->queryPut($data, "invoices", "invoice_id", $id);
    }

    if (str_contains($uri, "categories") && isset($_GET["category_id"])) {
        $id = $_GET["category_id"];
        $queries->queryPut($data, "categories", "category_id", $id);
    }
}
//DELETE
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {

    $token = $user->checkToken();
    if (!$token) {
        Response::$resp["message"] = "Token no válido";
        Response::response_500();
        return;
    }

    if (str_contains($uri, "invoices") && isset($_GET["invoice_id"])) {
        $id = $_GET["invoice_id"];
        $queries->queryDelete("invoices", "invoice_id", $id);
    }

    if (str_contains($uri, "categories") && isset($_GET["category_id"])) {
        $id = $_GET["category_id"];
        $queries->queryDelete("categories", "category_id", $id);
    }
}
