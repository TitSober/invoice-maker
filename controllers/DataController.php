<?php
require_once("model/DBInvoice.php");
require_once("ViewHelper.php");


class DataController{
    public static function saveFooter($id,$footer,$color){
        DBInvoice::insertFooter($id,$footer,$color);
    }
    public static function saveCompany($name,$data){
        if(empty($_SESSION["id"])){
            ViewHelper::redirect(BASE_URL);
            return;
        }
        $id=$_SESSION["id"];
        $companyUserExist = DBInvoice::checkIfUserHasCompanyWithName($id,$name);
        if($companyUserExist>0){
            self::addToCompany($id,$name,$data);
            return;
        }
        DBInvoice::createCompany($id,$name);
        self::addToCompany($id,$name,$data);
    }
    public static function getAttrID($name){
        DBInvoice::getAttrID($name)["id_attr"];
        
    
    }
    public static function addAttribute($name){
        return DBInvoice::addAttribute($name);
    }
    public static function displayData($data){
        $json = json_decode($data);
        foreach($json as $el){
            echo $el->key;
            echo $el->value;
        }
        
    }
    public static function addToCompany($id,$name,$data){
        $jsonData = json_decode($data);
        foreach ($jsonData as $el){
            $key = $el->key;
            $value = $el->value;
         
            $createdAttribute = DBInvoice::addAttribute($key);
            if($createdAttribute != null && $createdAttribute){
                $resut = DBInvoice::mapValueToAttrToCompany($id,$name,$key,$value);
                if(!$resut){
                    continue;
                }
            }else{
                continue;
            }
            
        }
        ViewHelper::Success();
    }
    public static function displayUserData(){
        if(!empty($_SESSION["id"])){

        }else{
            ViewHelper::redirect("view/index.php");
        }
    }
    public static function returnUserCompanyNames(){
        if(empty($_SESSION["id"])){
            ViewHelper::redirect("/");
            exit();
        }
        return DBInvoice::getUserCompany($_SESSION["id"]);


    }
    public static function getUserCompanyData($name){
        if(empty($_SESSION["id"])){
            ViewHelper::redirect("/");
            exit();
        }
        $data = DBInvoice::getUserCompanyData($_SESSION["id"],$name);
        ViewHelper::apiJSONcompanyData($data);

    }
    public static function returnUserFooterID(){
        if(empty($_SESSION["id"])){
            ViewHelper::redirect("/");
            exit();
        }
        return DBInvoice::getUserFooterID($_SESSION["id"]);
    }
    public static function getFooterData($fid){
        if(empty($_SESSION["id"])){
            ViewHelper::render("/");
            exit();
        }
        $data = DBInvoice::getFooterData($_SESSION["id"],$fid);
        ViewHelper::apiJSONFooterData($data);

    }
    public static function uploadInvoice($pdf) {
        if (empty($_SESSION["id"])) {
            ViewHelper::redirect("/");
            exit();
        }
    
        if (isset($pdf['name']) && $pdf['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../uploads/'; // Use __DIR__ to ensure the path is correct
    
            // Ensure the upload directory exists and is writable
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
    
            $id = DBInvoice::getLatestInvoiceID($_SESSION["id"])["id"];
            $fileExtension = pathinfo($pdf['name'], PATHINFO_EXTENSION);
            $uploadFile = $uploadDir . 'invoice_' . $id . '.' . $fileExtension;
    
            if (move_uploaded_file($pdf['tmp_name'], $uploadFile)) {
                echo json_encode(['status' => 'success', 'message' => 'File uploaded successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to move uploaded file']);
            }
        } else {
            $error = isset($pdf['error']) ? $pdf['error'] : 'No file uploaded';
            echo json_encode(['status' => 'error', 'message' => 'Upload error: ' . $error]);
        }
    }
}