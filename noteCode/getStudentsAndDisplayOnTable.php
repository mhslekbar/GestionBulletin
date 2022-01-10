<?php
    include "../connect.php";
    $idClasse = $_POST['idClasse'];
    $stmt = $conn->prepare("SELECT * FROM etudiants WHERE idClasse = ?");
    $stmt->execute([$idClasse]);
    $etudiant = $stmt->fetchAll();
    if($etudiant > 0){
        header("content-type: application/json");
        echo json_encode($etudiant);
    }
?>