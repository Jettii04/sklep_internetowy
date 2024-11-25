<?php

// Plik odpowiedzialny za sprawdzanie formularza 

require_once("database.php");

$q = $pdo->prepare("SELECT login FROM users WHERE email = :email");
$q->bindValue(':email',htmlspecialchars($_POST['email']), PDO::PARAM_STR);
$q->execute();
$login = $q->fetchColumn();

$q = $pdo->prepare("SELECT email FROM users WHERE login = :login");
$q->bindValue(':login',$login, PDO::PARAM_STR);
$q->execute();
$email = $q->fetchColumn();

//echo htmlspecialchars($_POST['login']);

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $randomString;
}

if($email==htmlspecialchars($_POST['email']) && htmlspecialchars($_POST['email']) && filter_var(htmlspecialchars($_POST['email']), FILTER_VALIDATE_EMAIL)){
    session_start();
    $_SESSION['code']=generateRandomString(6);
    $_SESSION['change_pas_login']=$login;

    $form ='
    <div class="form-group">
        <label  for="code">Kod</label>
        <input type="text" class="form-control mb-3" name="code" id="code" placeholder="XXXXXX" maxlength="6">
    </div>
    <div class="form-group">
        <label for="password">Hasło</label>
        <input type="password" class="form-control mb-3" name="password" id="password" placeholder="Hasło" maxlength="50">
    </div>
    <div class="form-group">
        <label for="repeatPassword">Hasło</label>
        <input type="password" class="form-control mb-3" name="repeatPassword" id="repeatPassword" placeholder="Powtórz hasło" maxlength="50">
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary" id="change_button">Zmień Hasło</button>
    </div>';
   
}else{
    $form ='
    <div class="form-group">
        <label  for="email">Podaj email powiązany z kontem</label>
        <input type="email" class="form-control mb-3 is-invalid" name="email" id="email" placeholder="Email" maxlength="320">
    </div>
    <div class="invalid-feedback mb-2" style="font-size:15px">
        Nieprawidłowy email!
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary" id="send_button">Wyślij kod</button>
    </div>';
}


echo $form;

?>