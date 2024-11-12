<?php

require_once("model/DBInvoice.php");
require_once("ViewHelper.php");

class UserControler{
    public static function registerUser($username, $password){
        $result =  DBInvoice::registerUser($username,$password);
        ViewHelper::registerResponse($result);
        //echo $result;
        
    }
    public static function loginUser($username, $password){
        $userExists = DBInvoice::checkUsername($username);
        
        if(!$userExists){
            $row = DBInvoice::getUserPassword($username);
            $id = $row["id_user"];
            $hashedPassword = $row["password"];
            if(password_verify($password,$hashedPassword)){
                $_SESSION["id"] = $id;
                $_SESSION["username"] = $username;
                ViewHelper::loginResponse(true,true);
                
            }else{
                ViewHelper::loginResponse(true,false);
            }
        }else{
            ViewHelper::loginResponse(false,false);
        }
    }
    public static function logout(){
        unset($_SESSION["id"]);
        ViewHelper::render("view/home.php");
    }
    public static function displayUserData(){
        if(empty($_SESSION["id"])){
            ViewHelper::render("/");
            exit();
        }
        ViewHelper::render("view/user.php");
    }
}