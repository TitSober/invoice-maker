<?php
require_once("model/DBInvoice.php");
require_once("ViewHelper.php");

class HomeController{
    public static function home(){
        ViewHelper::render("view/home.php");

    }
    public static function create(){
        ViewHelper::render("view/create.php");
    }
    public static function createCompany(){
        if(isset($_SESSION["id"])){
            ViewHelper::render("view/create-company.php");
        }
        else{
            ViewHelper::render("view/home.php");
        }
    }
    public static function createFooter(){
        if(isset($_SESSION["id"])){
            ViewHelper::render("view/create-footer.php");
        }
        else{
            ViewHelper::render("view/home.php");
        }
    }
    public static function login(){
        ViewHelper::render("view/login.php");
    }
    public static function register(){
        ViewHelper::render("view/register.php");
    }
    public static function anon(){
        ViewHelper::render("view/anon_create.php");
    }
    

}








