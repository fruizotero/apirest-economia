<?php
require_once "modules/queries_all.php";
require_once "modules/functions_util.php";


$queries = new Queries_All();


//$queries->queryGet("categories", "category_id_user", 1);
//$queries->queryGet("invoices", "invoice_user_id", 1);
//$queries->queryGet("users", "user_email", "frank@gmail.com");
$arrayUser = array(
    "user_email" => "juan@gmail.com",
    "user_pass" => "123456"
);
$arrayCategories = array(
    "category_name" => "apuestas",
    "category_expense_type" => 0,
    "category_user_id" => 3
);
$arrayInvoices = array(
    "invoice_amount" => 80,
    "invoice_description" => "apostando en casino",
    "invoice_user_id" => 3,
    "invoice_category_id" => 5
);

$arrayPutUsers = array(
    "user_email" => "eduardo@gmai.com"
);

$arrayPutInvoices = array(
    "invoice_description" => "casino"
);

$arrayPutCategorie = array(
    "category_expense_type" => 0
);

// $queries->queryPut($arrayPutCategorie, "categories", "category_id", 2);
//$queries->queryPost($arrayInvoices, "invoices");
// $queries->queryPut($arrayPutUsers, "users", "user_id", 2);
//$queries->queryPut($arrayPutInvoices, "invoices", "invoice_id", 3);
//$queries->queryDelete("categories","category_id", 4 );

//USER (Login)

//USER (register)


//TOKEN VALID

//GET

//POST

//PUT

//DELETE