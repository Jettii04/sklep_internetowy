<?php
session_start();
// Plik odpowiedzialny za sprawdzanie formularza 
require_once("database.php");
    $data = [
        'review' => $_POST['review_id']
    ];

    try {
    $q = $pdo->prepare("DELETE FROM reviews WHERE review_id = :review");
    $q->execute($data);
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }

?>