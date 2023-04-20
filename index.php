<?php
if(file_exists('db.class.php')){
    require_once('db.class.php');
}
$html = '';
$funcReturn = '';
$userObject = new user();
$userStatus = $userObject->isUserLoggedIn();
$html .= '<a href="index.php?module=login">Login</a><br><a href="index.php?module=account">account</a><br><a href="index.php?module=logout">Logout</a><br><a href="index.php?module=register">register</a><br>';
if(isset($_POST['username'])&& isset($_POST['userpass']) && !empty($_POST)){
    $funcReturn = $userObject->userLogin($_POST['username'], $_POST['userpass']);
}
if(isset($_POST['registerUsername']) && isset($_POST['password']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['birthdate'])){
    $userObject->registerUser($_POST['registerUsername'], $_POST['password'], $_POST['firstname'], $_POST['lastname'], $_POST['birthdate']);
    $html .= 'u bent nu geregistreerd log alstublieft in';
}
if(isset($_GET['module'])){
    if($userStatus != 1 && $_GET['module'] != 'login' && $_GET['module'] != 'register'){
        $html .= 'U mag helaas nog niet naar die pagina u bent nu terug op de login pagina,<br>u mag vanaf hier alleen maar naar de registratie pagina heehe' . include_once(__DIR__ . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'login' . DIRECTORY_SEPARATOR . 'index.php');
    } else {
        $html .= include_once(__DIR__ . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $_GET['module'] . DIRECTORY_SEPARATOR . 'index.php');
    }
} else {
    $html .= include_once(__DIR__ . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'login' . DIRECTORY_SEPARATOR . 'index.php');
}
echo $html . '<br>';
?>