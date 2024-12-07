<?php
session_start();
require_once('database.php');
if(htmlspecialchars($_POST['new_pass'])==htmlspecialchars($_POST['repeat_pass'])){

$q = $pdo->prepare("UPDATE users SET password = :pass WHERE login = :login");
$q->bindValue(':pass',sha1(htmlspecialchars($_POST['new_pass'])), PDO::PARAM_STR);
$q->bindValue(':login',$_SESSION['changePassLogin'], PDO::PARAM_STR);
$q->execute();

echo 'changed';
session_destroy();
}else{
    echo'
    <div class="form-group">
        <label  for="new_pass">Nowe Hasło</label>
        <input type="password" class="form-control mb-3" name="new_pass" id="new_pass" placeholder="Nowe hasło" pattern="[A-Za-z0-9\-\\?\/.>,<\|;:\]\[\}\{+=_\-\)\(*&^%$#@!]{8,50}" title="Hasło musi mieć od 8 do 50 zanków, oraz może zawierać tylko A-Z a-z 0-9 i znaki ?\/><.,:;}{][+=_-)(*&^%$#@!" maxlength="50" required>
    </div> 
    <div class="form-group">
        <label  for="repeat_pass">Powtórz Hasło</label>
        <input type="password" class="form-control mb-3 is-invalid" name="repeat_pass" id="repeat_pass" placeholder="Powtórz hasło" pattern="[A-Za-z0-9\-\\?\/.>,<\|;:\]\[\}\{+=_\-\)\(*&^%$#@!]{8,50}" title="Hasło musi mieć od 8 do 50 zanków, oraz może zawierać tylko A-Z a-z 0-9 i znaki ?\/><.,:;}{][+=_-)(*&^%$#@!" maxlength="50" required>
        <div class="invalid-feedback mb-2" style="font-size:15px">
        Hasła nie zgadzają się!
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary" id="send_button">Zmień</button>
    </div>
    ';
}
?>