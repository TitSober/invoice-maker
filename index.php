<?php

session_start();

require_once("controllers/HomeController.php");
require_once("controllers/UserController.php");
require_once("controllers/DataController.php");


define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("ASSETS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "bootstrap/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

$urls = [
   "/" => function () {
      HomeController::home();
   },
    # routing
    "index.php" => function () {
      HomeController::home();
   },
    "" => function () {
       HomeController::home();
    },
    "create" => function () {
        HomeController::create();
     },
     "anon" => function () {
        HomeController::anon();
     },
     "create-company" => function () {
        HomeController::createCompany();
     },
     "create-footer" => function () {
        HomeController::createFooter();
     },
     "login" => function () {
        HomeController::login();
     },
     "register" => function () {
        HomeController::register();
     },
     "registerUser" => function () {
      UserControler::registerUser($_POST["username"],$_POST["password"]);
     },
     "loginUser" => function () {
      UserControler::loginUser($_POST["username"],$_POST["password"]);
     },
     "logout" => function () {
      UserControler::logout();
     },
     "saveFooter" => function () {
      DataController::saveFooter($_SESSION["id"],$_POST["footer"],$_POST["color"]);
     },
     "saveCompany" => function () {
      DataController::saveCompany($_POST["name"],$_POST["data"]);
     },
     "getAttrId" => function () {
      DataController::getAttrID($_POST["name"]);
     },
     "addAttribute" => function () {
      DataController::addAttribute($_POST["name"]);
     },
     "displayData" => function () {
      DataController::displayData($_POST["data"]);
     },
     "apiCompanyData" => function () {
      DataController::getUserCompanyData($_POST["name"]);
     },
     "apiFooterData" => function () {
      DataController::getFooterData($_POST["fid"]);
     },"uploadInvoice" => function () {
      DataController::uploadInvoice($_FILES['pdfFile']);
     },
     
];

try {
    if (isset($urls[$path])) {
       $urls[$path]();
    } else {
        echo "No controller for '$path'";
    }
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
    // ViewHelper::error404();
} 
