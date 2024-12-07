<?php

// Plik odpowiedzialny za sprawdzanie formularza 

require_once("database.php");
$error=false;

$login=htmlspecialchars($_POST['login']);
$password=sha1(htmlspecialchars($_POST['password']));
$repeatPassword=sha1(htmlspecialchars($_POST['repeatPassword']));
$name=htmlspecialchars($_POST['name']);
$surname=htmlspecialchars($_POST['surname']);
$email=htmlspecialchars($_POST['email']);

try{
$q = $pdo->prepare("SELECT login FROM users WHERE login = :login");
$q->bindValue(':login',$login, PDO::PARAM_STR);
$q->execute();
$resultLogin = $q->fetchColumn();

$q = $pdo->prepare("SELECT email FROM users WHERE email = :email");
$q->bindValue(':email',$email, PDO::PARAM_STR);
$q->execute();
$resultEmail = $q->fetchColumn();
}catch(PDOException $e){
    $error=true;
}

$form = '';

    if($login==$resultLogin){
        $error = true;
        $form = '
        <div class="form-group">
        <label  for="login">Login</label>
        <input type="text" class="form-control mb-3 is-invalid" name="login" id="login" placeholder="Login" pattern="[0-9a-z\-_]{2,30}" title="Login musi zawierać do 30 zanków, oraz może zawierać tylko a-z 0-9 i znaków _ -" maxlength="30" value="'.$login.'" required>
        <div class="invalid-feedback mb-2" style="font-size:15px">
        Login zajęty!
        </div>
        </div>';
    }else{
        $form = '<div class="form-group">
        <label  for="login">Login</label>
        <input type="text" class="form-control mb-3" name="login" id="login" placeholder="Login" pattern="[0-9a-z\-_]{2,30}" title="Login musi zawierać do 30 zanków, oraz może zawierać tylko a-z 0-9 i znaków _ -" maxlength="30" value="'.$login.'" required>
        </div>';
    }

    $form .='
    <div class="form-group">
        <label  for="name">Imię</label>
        <input type="text" class="form-control mb-3" name="name" id="name" placeholder="Imię" pattern="[A-ZÀ-ÿA-ZŻŹĆĄŚĘŁÓŃ][\-,a-z.'."'".'żźćńółęąś]+" maxlength="50" value="'.$name.'" required>
    </div>
    <div class="form-group">
        <label  for="surname">Nazwisko</label>
        <input type="text" class="form-control mb-3" name="surname" id="surname" placeholder="Nazwisko" pattern="([A-Za-zÀ-ÿA-ZŻŹĆĄŚĘŁÓŃżźćńółęąś][\-,a-z. '."'".'żźćńółęąś]+[ ]*)+[a-zżźćńółęąś]" maxlength="60" value="'.$surname.'" required>
    </div>';

    if($email==$resultEmail){
        $error = true;
        $form .= '
        <div class="form-group">
        <label  for="email">Email</label>
        <input type="email" class="form-control mb-3 is-invalid" name="email" id="email" placeholder="Email" pattern="^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$" value="'.$email.'" required>
        <div class="invalid-feedback mb-2" style="font-size:15px">
        Email jest już przypisany do innego konta!
        </div>
        </div>';
    }else{
        $form .= '<div class="form-group">
        <label  for="email">Email</label>
        <input type="email" class="form-control mb-3" name="email" id="email" placeholder="Email" pattern="^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$" value="'.$email.'" required>
        </div>';
    }

    $form .='
    <div class="form-group">
        <label for="password">Hasło</label>
        <input type="password" class="form-control mb-3" name="password" id="password" placeholder="Hasło" pattern="[A-Za-z0-9\-\\?\/.>,<\|;:\]\[\}\{+=_\-\)\(*&^%$#@!]{8,50}" title="Hasło musi mieć od 8 do 50 zanków, oraz może zawierać tylko A-Z a-z 0-9 i znaki ?\/><.,:;}{][+=_-)(*&^%$#@!" maxlength="50" required>
    </div>
    <div class="form-group">
        <label for="repeat_password">Powtórz hasło</label>
        <input type="password" class="form-control mb-3" name="repeat_password" id="repeat_password" placeholder="Hasło" pattern="[A-Za-z0-9\-\\?\/.>,<\|;:\]\[\}\{+=_\-\)\(*&^%$#@!]{8,50}" title="Hasło musi mieć od 8 do 50 zanków, oraz może zawierać tylko A-Z a-z 0-9 i znaki ?\/><.,:;}{][+=_-)(*&^%$#@!" maxlength="50" required>
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