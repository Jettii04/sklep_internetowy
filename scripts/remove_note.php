<?php
session_start();
// Plik odpowiedzialny za sprawdzanie formularza 
require_once("database.php");
    $data = [
        'note' => $_POST['note_id']
    ];

    try {
    $q = $pdo->prepare("DELETE FROM note WHERE note_id = :note");
    $q->execute($data);
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }

?>