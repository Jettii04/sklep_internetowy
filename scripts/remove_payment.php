<?php
session_start();
// Plik odpowiedzialny za sprawdzanie formularza 
require_once("database.php");
    $data = [
        'payment' => $_POST['id']
    ];

    try {
    $q = $pdo->prepare("DELETE FROM payment_methods WHERE payment_id = :payment");
    $q->execute($data);
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }

?>