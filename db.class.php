<?php
if(file_exists('config.php')){
    require_once('config.php');
}
class db {
    public $dbcon = null;
    public $result = null;

    public function __construct(){
        if(!empty(DBHOST) && !empty(DBUSER) && !empty(DBNAME)){
            $this->dbcon = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        }
        if(!empty($this->dbcon->connect_error)){
            $error = $this->dbcon->connect_error;
            error_log($error .' CONNECT ERROR ON LINE 15 db.class.php ' . date('l jS \of F Y h:i:s A')); 
        } else {
            $this->dbcon->query("CREATE TABLE IF NOT EXISTS users(
                id INT(6) AUTO_INCREMENT PRIMARY KEY,
                username varchar(20) NOT NULL,
                userpass varchar(1000) NOT NULL,
                firstname varchar(15) NOT NULL,
                lastname varchar(20) NOT NULL,
                birthday date NOT NULL
            );"); 
        }
    }
    public function selectFunction($sql){
        if(!empty($sql)){
            $sql = trim($sql);
            if($this->result = $this->dbcon->query($sql)){
                if($this->result->num_rows > 0){
                    $records = $this->result->fetch_all();
                    if(!empty($records)){
                        return array('true', $records);
                    }
                } else {
                    return 'No records found';
                }
            } else {
                return 'Query failed' . $this->dbcon->error;
            }
        } else {
            return 'no query given';
        }
    }
    public function otherSqlFunction($sql){
        if(!empty($sql)){
            $sql = trim($sql);
            if($this->result = $this->dbcon->query($sql)){
                if($this->result->num_rows > 0){
                    return true;
                } else {
                    return 'No records found';
                }
            } else {
                return 'Query failed' . $this->dbcon->error;
            }
        } else {
            return 'no query given';
        }
    }
}
class user {
    public $dbObj = null;
    public $con = null;
    public $result = null;

    public function __construct(){
        $this->dbObj = new db;
        $this->con = $this->dbObj->dbcon;
    }
    public function userLogin($username, $password){
        $sql = "SELECT * FROM users WHERE username = '" . $username . "' AND userpass = password('" . $password . "');";
        if(!empty($sql)){
            $sql = trim($sql);
            if($this->result = $this->con->query($sql)){
                if($this->result->num_rows > 0){
                    $records = $this->result->fetch_all();
                    if(!empty($records)){
                        return 'ingelogd!';
                        $_SESSION['userStatus'] = 1;
                    }
                } else {
                    return 'No records found';
                }
            } else {
                return 'Query failed' . $this->con->error;
            }
        } else {
            return 'no query given';
        }
    }

    public function isUserLoggedIn(){
        if(empty($_POST)){
            session_start();
            if($_SESSION['userStatus'] == 0){
                $_SESSION['userStatus'] = 0;
                return false;
            } else {
                $_SESSION['userStatus'] = 1;
                return true;
            }
        } else {
            session_start();
            $_SESSION['userStatus'] = 1;
        }
    }

    public function registerUser($userNameFromPOST, $userPassFromPOST, $firstFromPOST, $lastFromPOST, $dateOfBirthFromPOST){
        $sql = "INSERT INTO users(username, userpass, firstname, lastname, birthday) VALUES('" . $userNameFromPOST . "', password('" . $userPassFromPOST . "'), '" . $firstFromPOST . "', '" . $lastFromPOST . "', '" . $dateOfBirthFromPOST . "');";
        if(!empty($sql)){
            $sql = trim($sql);
            if($this->result = $this->con->query($sql)){
                if($this->result->num_rows > 0){
                    $records = $this->result->fetch_all();
                    return $records;
                } else {
                    return 'No records found';
                }
            } else {
                return 'Query failed' . $this->con->error;
            }
        } else {
            return 'no query given';
        }
    }

    public function logoutUser(){
        if(isset($_SESSION)){
            $_SESSION['userStatus'] = 0;
            session_unset();
        }
    }
}
?>