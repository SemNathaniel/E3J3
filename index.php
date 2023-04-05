

<?php
if(file_exists('db.class.php')){
    require_once('db.class.php');
}
global $connection;
$objTest = new dbExec();
mysqli_query($connection, "CREATE TABLE IF NOT EXISTS users(
    id INT(6) AUTO_INCREMENT PRIMARY KEY,
    username varchar(20) NOT NULL,
    userpass varchar(1000) NOT NULL,
    firstname varchar(15) NOT NULL,
    lastname varchar(20) NOT NULL,
    birthday date NOT NULL
);");
$result = mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM `users`;"));
if(empty($result)){
    mysqli_query($connection, "INSERT INTO users(username, userpass, firstname, lastname, birthday) VALUES('admin', password('root'), 'Nathan', 'ten Brink', '2004-08-26');");
}

?>