<?php
if(file_exists('db.class.php')){
    require_once('db.class.php');
}
$html = '';
$userObject = new user();
$userStatus = $userObject->isUserLoggedIn();
$html .= '<a href="index.php?module=login">Login</a><br><a href="index.php?module=account">account</a><br><a href="index.php?module=logout">Logout</a><br><a href="index.php?module=register">register</a><br>';
if(isset($_GET['module'])){
    if(empty($userStatus)){
        $html .= 'U mag helaas nog niet naar die pagina u bent nu terug op de login pagina,<br>u mag vanaf hier alleen maar naar de registratie pagina' . include_once(__DIR__ . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'login.php');
    } else {
        $html .= include_once(__DIR__ . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $_GET['module'] . '.php');
    }
} else {
    $html .= include_once(__DIR__ . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'login.php');
}
if(isset($_POST) && !empty($_POST)){
    $html .= $userObject->userLogin($_POST['username'], $_POST['userpass']);
}
echo $html;
print_r($userStatus);
?>