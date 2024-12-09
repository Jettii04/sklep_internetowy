<?php
session_start();
// Plik odpowiedzialny za sprawdzanie formularza 
require_once("database.php");
    $data = [
        'site' => $_POST['id']
    ];

    try {
    $q = $pdo->prepare("DELETE FROM info_sites WHERE site_id = :site");
    $q->execute($data);
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }

?>