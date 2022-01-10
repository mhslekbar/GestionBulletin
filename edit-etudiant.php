<?php 

    include "connect.php";
    $matricule = isset($_POST['id']);
    $stmt = $conn->prepare("SELECT e.* ,c.NomClasse as classe FROM etudiants e JOIN classes c ON c.idClasse = e.idClasse WHERE Matricule = ?");
    $stmt->execute([$matricule]);
    $etudiant = $stmt->fetch();
    if($etudiant > 0){
        header("content-type: application/json");
        echo json_encode($etudiant);
    }

?>