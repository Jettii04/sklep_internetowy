<?php

// Plik odpowiedzialny za sprawdzanie formularza 

require_once("database.php");

$login=htmlspecialchars($_POST['login']);
$password=sha1(htmlspecialchars($_POST['password']));
$repeatPassword=sha1(htmlspecialchars($_POST['repeatPassword']));
$name=htmlspecialchars($_POST['name']);
$surname=htmlspecialchars($_POST['surname']);
$email=htmlspecialchars($_POST['email']);

$q = $pdo->prepare("SELECT login FROM users WHERE login = :login");
$q->bindValue(':login',htmlspecialchars($_POST['login']), PDO::PARAM_STR);
$q->execute();
$result = $q->fetchColumn();

$error=false;
$form = '';

    if($login==$result){
        $error = true;
        $form = '
        <div class="form-group">
        <label  for="login">Login</label>
        <input type="text" class="form-control mb-3 is-invalid" name="login" id="login" placeholder="Login" maxlength="30" required>
        <div class="invalid-feedback mb-2" style="font-size:15px">
        Login zajęty!
        </div>
        </div>';
    }else{
        $form = '<div class="form-group">
        <label  for="login">Login</label>
        <input type="text" class="form-control mb-3" name="login" id="login" placeholder="Login" maxlength="30" value="'.$login.'" required>
        </div>';
    }

    $form .='
    <div class="form-group">
        <label  for="name">Imię</label>
        <input type="text" class="form-control mb-3" name="name" id="name" placeholder="Imię" maxlength="30" value="'.$name.'" required>
    </div>
    <div class="form-group">
        <label  for="surname">Nazwisko</label>
        <input type="text" class="form-control mb-3" name="surname" id="surname" placeholder="Nazwisko" maxlength="50" value="'.$surname.'" required>
    </div>
    <div class="form-group">
        <label  for="email">Email</label>
        <input type="email" class="form-control mb-3" name="email" id="email" placeholder="Email" maxlength="30" value="'.$email.'" required>
    </div>
    <div class="form-group">
        <label for="password">Hasło</label>
        <input type="password" class="form-control mb-3" name="password" id="password" placeholder="Hasło" maxlength="50" required>
    </div>
    <div class="form-group">
        <label for="repeat_password">Powtórz hasło</label>
        <input type="password" class="form-control mb-3" name="repeat_password" id="repeat_password" placeholder="Hasło" maxlength="50" required>
    </div>
    <div class="form-group">
        <button class="btn btn-primary" type="submit" id="create_button">Utwórz konto</button>
    </div>
    ';

if($error==false){

    $data = [
        'login' => $login,
        'name'=> $name,
        'surname'=> $surname,
        'email'=> $email,
        'password'=> $password,
    ];
    try {
    $q = $pdo->prepare("INSERT INTO users (login, password, email , name, surname) VALUES (:login,:password,:email,:name, :surname)");
    $q->execute($data);
    }catch (PDOException $e) {
        echo 'Nie udało się utworzyć konta';
        //exit();
    }
    $form ="register";

    $data = [
        'login' => $login
    ];
    try {
    $q = $pdo->prepare("INSERT INTO carts (user) VALUES (:login)");
    $q->execute($data);
    }catch (PDOException $e) {
        echo 'Nie udało się utworzyć konta';
        //exit();
    }
}
echo $form;
?>