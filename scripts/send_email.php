<?php
session_start();
require_once('database.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$q = $pdo->prepare("SELECT login FROM users WHERE email = :email");
$q->bindValue(':email',htmlspecialchars($_POST['email']), PDO::PARAM_STR);
$q->execute();
$login = $q->fetchColumn();



if($login!=""){

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
$_SESSION['changePassLogin']=$login;
$_SESSION['code']=random_int(0,9).random_int(0,9).random_int(0,9).random_int(0,9);

$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->CharSet="UTF-8";
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'mireknwindalinkau@gmail.com';                     //SMTP username
    $mail->Password   = '';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->addAddress(htmlspecialchars($_POST['email']));


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Kod zmiany hasła';
    $mail->Body    = $_SESSION['code'];
    $mail->AltBody = '';
    $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
    $form='sent';
}else{
    $form = '
    <div class="form-group">
        <label  for="email">Podaj email powiązany z kontem</label>
        <input type="email" class="form-control mb-3 is-invalid" name="email" id="email" placeholder="Email" maxlength="320">
        <div class="invalid-feedback mb-2" style="font-size:15px">
        Nie ma konta o takim emailu!
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary" id="send_button">Wyślij kod</button>
    </div>
    ';
}

echo $form;
?>