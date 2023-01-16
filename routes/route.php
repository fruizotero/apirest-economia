<?php
require_once "modules/queries_all.php";
require_once "modules/functions_util.php";
require_once "modules/queries_users.php";


$queries = new Queries_All();
$user = new LoginRegister();



$uri = $_SERVER["REQUEST_URI"];
$data = json_decode(file_get_contents('php://input'), true);

if ($_SERVER["REQUEST_METHOD"] == "POST" && str_contains($uri, "login")) {
    $user->login($data);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && str_contains($uri, "register")) {
    $data["user_pass"] = password_hash($data["user_pass"], PASSWORD_DEFAULT);
    $queries->queryPost($data, "users");
}

//TOKEN VALID



if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if (str_contains($uri, "invoices") && isset($_GET["invoice_user_id"])) {
        $id = $_GET["invoice_user_id"];
        $queries->queryGet("invoices", "invoice_user_id", $id);
    }

    if (str_contains($uri, "categories") && isset($_GET["category_user_id"])) {
        $id = $_GET["category_user_id"];
        $queries->queryGet("categories", "category_user_id", $id);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (str_contains($uri, "invoices")) {
        $queries->queryPost($data, "invoices");
    }

    if (str_contains($uri, "categories")) {
        $queries->queryPost($data, "categories");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "PUT") {

    if (str_contains($uri, "invoices") && isset($_GET["invoice_id"])) {
        $id = $_GET["invoice_id"];
        $queries->queryPut($data, "invoices", "invoice_id", $id);
    }

    if (str_contains($uri, "categories") && isset($_GET["category_id"])) {
        $id = $_GET["category_id"];
        $queries->queryPut($data, "categories", "category_id", $id);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {

    if (str_contains($uri, "invoices") && isset($_GET["invoice_id"])) {
        $id = $_GET["invoice_id"];
        $queries->queryDelete("invoices", "invoice_id", $id);
    }

    if (str_contains($uri, "categories") && isset($_GET["category_id"])) {
        $id = $_GET["category_id"];
        $queries->queryDelete("categories", "category_id", $id);
    }
}

//GET

//POST

//PUT

//DELETE