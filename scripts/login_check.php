<?php

// Plik odpowiedzialny za sprawdzanie formularza 

require_once("database.php");

$q = $pdo->prepare("SELECT login FROM users WHERE login = :login and password= :password");
$q->bindValue(':login',htmlspecialchars($_POST['login']), PDO::PARAM_STR);
$q->bindValue(':password',sha1(htmlspecialchars($_POST['password'])), PDO::PARAM_STR);
$q->execute();
$login = $q->fetchColumn();

$admins = $pdo->prepare("SELECT login FROM admins WHERE login = :login and password= :password");
$admins->bindValue(':login',htmlspecialchars($_POST['login']), PDO::PARAM_STR);
$admins->bindValue(':password',sha1(htmlspecialchars($_POST['password'])), PDO::PARAM_STR);
$admins->execute();
$adminLogin = $admins->fetchColumn();

$employees = $pdo->prepare("SELECT login FROM employees WHERE login = :login and password= :password");
$employees->bindValue(':login',htmlspecialchars($_POST['login']), PDO::PARAM_STR);
$employees->bindValue(':password',sha1(htmlspecialchars($_POST['password'])), PDO::PARAM_STR);
$employees->execute();
$employeeLogin = $employees->fetchColumn();

//echo htmlspecialchars($_POST['login']);

if((htmlspecialchars($_POST['login'])==$login || htmlspecialchars($_POST['login'])==$adminLogin || htmlspecialchars($_POST['login'])==$employeeLogin) && htmlspecialchars($_POST['login'])!=''){
    session_start();
    if($adminLogin!="" || $employeeLogin!=""){
        $form='admin';
        $_SESSION['admin']=1;
    }else{
        $form='login';
        $_SESSION['admin']=0;
    }
    $_SESSION['login']=$login;
   
}else{
    $form ='
    <div class="form-group">
        <label  for="login">Login</label>
        <input type="text" class="form-control mb-3 is-invalid" name="login" id="login" placeholder="Login" maxlength="30" value="'.htmlspecialchars($_POST['login']).'">
    </div>
    <div class="form-group">
        <label for="password">Hasło</label>
        <input type="password" class="form-control mb-3 is-invalid" name="password" id="password" placeholder="Hasło" maxlength="50">
        <div class="invalid-feedback mb-2" style="font-size:15px">
        Nieprawidłowe hasło lub login!
        </div>
        <a href="zmiana_hasla.php">Nie pamiętasz hasła?</a>
    </div>
    <div class="form-group">
    <button type="submit" class="btn btn-primary mt-2" id="login_button">Zaloguj się</button>
    </div>';
}


echo $form;

?>