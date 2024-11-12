<?php

require_once("DBInnit.php");



class DBInvoice {
    public static function registerUser($username, $password){
        
        if(self::checkUsername($username)){
            $db = DBInit::getInstance();
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $statement = $db->prepare("INSERT INTO user 
                (username,password) VALUES (:username, :password)");

            $statement->bindParam(":username", $username, PDO::PARAM_STR);
            $statement->bindParam(":password", $hashed_password, PDO::PARAM_STR);
            return $statement->execute();
            
          
        }else{
            //return to page let the user know account exists
            return false;
        }
    
    }
    public static function checkUsername($username){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT id_user FROM user 
        WHERE username = :username");
        $statement->bindParam(":username", $username, PDO::PARAM_STR);
        $statement->execute();

        $user = $statement->fetch();

        if ($user == null) {
            return true;
        } else {
            return false;
        }
    }
    public static function getUserPassword($username){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT id_user, password FROM user 
        WHERE username = :username");
        $statement->bindParam(":username", $username);
        $statement->execute();
    

       $row = $statement->fetch();
       
       return $row;
    }      
    public static function insertFooter($id, $footer,$color){

        $db = DBInit::getInstance();
        $statement = $db->prepare("INSERT INTO footer 
                (id_user,data,color) VALUES (:id, :data,:color)");
        $statement->bindParam(":id", $id,PDO::PARAM_INT);
        $statement->bindParam(":data",$footer,PDO::PARAM_STR);
        $statement->bindParam(":color",$color,PDO::PARAM_STR);

        $statement->execute();
        return $statement;
    }
    public static function createCompany($uid,$name){
        $db = DBInit::getInstance();
        $statement = $db->prepare("INSERT INTO company 
                (id_user,name) VALUES (:uid, :name)");
        $statement->bindParam(":uid",$uid,PDO::PARAM_INT);
        $statement->bindParam(":name",$name,PDO::PARAM_STR);
        $statement->execute();

    }
    public static function checkIfUserHasCompanyWithName($uid,$name){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT id_company FROM company WHERE id_user = :uid AND name = :name");
        $statement->bindParam(":uid",$uid,PDO::PARAM_INT);
        $statement->bindParam(":name",$name,PDO::PARAM_STR);

        $statement->execute();
        return $statement->rowCount();
    }
    public static function addAttribute($name){
        if(self::getAttrID($name) == null){
            $db = DBInit::getInstance();
            $statement = $db->prepare("INSERT INTO `company_attr` (`name`) VALUES (:aname);");
            $statement->bindParam(":aname",$name,PDO::PARAM_STR);

            $statement->execute();
            
            return $statement;
        }
        return true;
        
    }
    public static function getAttrID($name){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT id_attr FROM company_attr WHERE name = :aname");
        $statement->bindParam(":aname",$name);

        $statement->execute();

        if($statement->rowCount() == 0){
            return null;
        }
        //var_dump($statement->fetch());
        return $statement->fetch();
        
    }
    public static function getCompanyID($uid,$name){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT id_company FROM company WHERE id_user = :uid AND name = :name");
        $statement-> bindParam(":uid",$uid);
        $statement-> bindParam(":name",$name);

        $statement->execute();

        if($statement->rowCount() > 0){
            return $statement->fetch()["id_company"];
        }
        return null;


    }
    public static function mapValueToAttrToCompany($uid, $cname,$key,$value){
        $db = DBInit::getInstance();
        $cid = self::getCompanyID($uid,$cname);
        $attrID = self::getAttrID($key)["id_attr"];

        if($cid == null || $attrID == null){
            return false;
        }
        $statement = $db->prepare("INSERT INTO company_attr_mn (id_company, id_attr, value) VALUES (:cid,:aid,:val)");
        $statement->bindParam(":cid",$cid);
        $statement->bindParam(":aid",$attrID);
        $statement->bindParam(":val",$value,PDO::PARAM_STR);
        $statement->execute();
        return $statement;
    }
    public static function getUserCompany($uid){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT name FROM company WHERE id_user = ". $uid);
        $statement->execute();
        $arr = array();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $name = $row['name'];
            array_push($arr,$name);
          }
        return $arr;
    }
    public static function getUserCompanyData($uid,$name){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT company.name as companyName, company_attr.name as `key`, company_attr_mn.value as `value` FROM company_attr_mn,company_attr,company,user WHERE user.id_user = company.id_user AND company_attr_mn.id_attr = company_attr.id_attr AND company_attr_mn.id_company = company.id_company AND user.id_user = :uid AND company.name = :name;");
        $statement->bindParam(":uid",$uid,PDO::PARAM_INT);
        $statement->bindParam(":name",$name,PDO::PARAM_STR);

        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getUserFooterID($uid){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT id_footer FROM footer WHERE id_user = ". $uid);
        $statement->execute();
        $arr = array();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $ID = $row['id_footer'];
            array_push($arr,$ID);
          }
        return $arr;

    }
    public static function getFooterData($uid, $fid){
        $db = DBInit::getInstance();
        $statement = $db->prepare("SELECT data,color FROM footer WHERE id_footer = :fid AND id_user = :uid");
        $statement->bindParam(":fid",$fid);
        $statement->bindParam(":uid",$uid);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    public static function getLatestInvoiceID($uid){
        $db = DBInit::getInstance();
        $statement = $db->prepare("INSERT INTO invoice (id_user) VALUES (".$uid.")");
        $statement->execute();
        $getID = $db->prepare("SELECT LAST_INSERT_ID() as id;");
        $getID->execute();
        return $getID->fetch();

    }

}
