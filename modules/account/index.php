<?php
$retrieveAccount = new db();
$accountData = $retrieveAccount->selectFunction("SELECT * FROM users WHERE id = '" . $_SESSION['userId'] . "';");
return 'Uw username is: ' . $accountData[1][0][1] . '<br>Uw naam is: ' . $accountData[1][0][3] . ' ' . $accountData[1][0][4] . '<br>En uw geboorte datum is: ' . $accountData[1][0][5];
?>