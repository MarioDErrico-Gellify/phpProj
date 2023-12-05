<?php
include 'createuser.php'
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registrazione</title>
</head>
<body>
<form method="post" action='index.php'>
    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome" required><br><br>
    <label for="cognome">Cognome:</label>
    <input type="text" name="cognome" id="cognome" required><br><br>
    <label for="password">Password:</label>
    <input type="text" name="password" id="password" required><br><br>
    <label for="email">email:</label>
    <input type="email" name="email" id="email" required><br><br>
    <label for="vatnumber">vatnumber:</label>
    <input type="text" name="vatnumber" id="vatnumber" required><br><br>
    <input type="submit" value="Invia">
</form>
<h2>Login</h2>
<form method="post" action="index.php">
    <label for="logMail">Email:</label>
    <input type="email" name="logMail" id="logMail" required><br><br>

    <label for="LogPassword">Password:</label>
    <input type="password" name="LogPassword" id="LogPassword" required><br><br>

    <input type="submit" value="Login">
</form>


<a href='index.php'>Password Dimenticata</a>
<?php

if (isset($_POST['nome'],$_POST['cognome'], $_POST['password'] , $_POST['vatnumber'] , $_POST['email'])) {
    $createUser = new CreateUser($_POST['email'], $_POST['nome'], $_POST['cognome'], $_POST['password'], $_POST['vatnumber']);
    $result = $createUser->checkEmptyValue();
    echo $createUser->insertUserToDb();
}
if (isset($_POST['LogPassword'], $_POST['logMail'])) {
    $retrieveUser = new CreateUser($_POST['logMail'], '', '', $_POST['LogPassword'], '');
    $result = $retrieveUser->retrieveUser();
    if ($result){
        $_SESSION['email_session'] = $_POST['logMail'];
        echo $_SESSION['email_session'] . loadStringForJson("welcometomywebsite");
    }

}

?>
</body>
</html>

