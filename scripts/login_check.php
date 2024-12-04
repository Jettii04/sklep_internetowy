<?php

// Plik odpowiedzialny za sprawdzanie formularza 

require_once("database.php");

$q = $pdo->prepare("SELECT login, admin, employee FROM users WHERE login = :login and password= :password");
$q->bindValue(':login',htmlspecialchars($_POST['login']), PDO::PARAM_STR);
$q->bindValue(':password',sha1(htmlspecialchars($_POST['password'])), PDO::PARAM_STR);
$q->execute();
$result = $q->fetch(PDO::FETCH_ASSOC);
$login = $result['login'];
$employee = $result['employee'];
$admin = $result['admin'];

//echo htmlspecialchars($_POST['login']);

if((htmlspecialchars($_POST['login'])==$login || htmlspecialchars($_POST['login'])==$adminLogin || htmlspecialchars($_POST['login'])==$employeeLogin) && htmlspecialchars($_POST['login'])!=''){
    session_start();
    if($admin==1){
        $form='admin';
        $_SESSION['admin']=1;
    }elseif($employee==1){
        $form='admin';
        $_SESSION['employee']=1;
    }else{
        $form='login';
        $_SESSION['admin']=0;
    }
    $_SESSION['login']=$login;
    $u = $pdo->prepare("SELECT * FROM users WHERE login = :login");
    $u->bindValue(':login',htmlspecialchars($_POST['login']), PDO::PARAM_STR);
    $u->execute();
    $user = $u->fetch(PDO::FETCH_ASSOC);
    $_SESSION['name']=$user['name'];
    $_SESSION['surname']=$user['surname'];
    $_SESSION['email']=$user['email'];
    $_SESSION['phone']=$user['phone'];
    $_SESSION['postal_code']=$user['postal_code'];
    $_SESSION['city']=$user['city'];
    $_SESSION['road']=$user['road'];
    $_SESSION['house_number']=$user['house_number'];
   
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