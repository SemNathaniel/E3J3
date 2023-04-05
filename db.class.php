<?php
if(file_exists('functions.php')){
    require_once('functions.php');
}
class dbExec {
    public $con = null;
    public $result = null;

    public function __construct(){
        if(!empty(DBHOST) && !empty(DBUSER) && !empty(DBNAME)){
            $this->con = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        }
        if(!empty($this->con->connect_error)){
            $error = $this->con->connect_error;
            error_log($error .' CONNECT ERROR ON LINE 15 db.class.php ' . date('l jS \of F Y h:i:s A')); // even kijken of het in een error log kan
        }
    }
    public function userLogin($username, $password){
        $sql = "SELECT * FROM e3j3 WHERE username = '" . $username . "' AND userpass = password('" . $password . "');";
        if(!empty($sql)){
            $sql = trim($sql);
            if($result = $this->con->query($sql)){
                if($result->num_rows > 0){
                    $records = $result->fetch_all();
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

    public function isUserLoggedIn(){
        if(isset($_SESSION)){
            if($_SESSION['userStatus'] == 0){
                header('index.php');
            }
        } else {
            session_start();
            $_SESSION['userstatus'] = 0;
        }
    }

    public function registerUser(){

    }

    public function logoutUser(){

    }
}
?>