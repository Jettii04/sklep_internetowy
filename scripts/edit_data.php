<?php
session_start();
require_once('database.php');

$_SESSION['name']=htmlspecialchars($_POST['firstName']);
$_SESSION['surname']=htmlspecialchars($_POST['lastName']);
$_SESSION['email']=htmlspecialchars($_POST['email']);
$_SESSION['phone']=htmlspecialchars($_POST['phone']);
$_SESSION['postal_code']=htmlspecialchars($_POST['postalCode']);
$_SESSION['city']=htmlspecialchars($_POST['city']);
$_SESSION['road']=htmlspecialchars($_POST['road']);
$_SESSION['house_number']=htmlspecialchars($_POST['houseNumber']);

$data = [
    'login' => $_SESSION['login'],
    'name' =>htmlspecialchars($_POST['firstName']),
    'surname' =>htmlspecialchars($_POST['lastName']),
    'email' =>htmlspecialchars($_POST['email']),
    'phone'=>htmlspecialchars($_POST['phone']),
    'postal_code'=>htmlspecialchars($_POST['postalCode']),
    'city'=>htmlspecialchars($_POST['city']),
    'road'=>htmlspecialchars($_POST['road']),
    'house_number'=>htmlspecialchars($_POST['houseNumber'])
];
try {
$update = $pdo->prepare("UPDATE users SET email = :email, phone= :phone, surname = :surname, name= :name, postal_code = :postal_code, city = :city, road = :road, house_number = :house_number WHERE login=:login");
$update->execute($data);
}catch (PDOException $e) {
    echo 'Nie udało się odczytać danych z bazy';
    //exit();
}

header("Location: ../konto/dane/");
exit;

?>