<?php
    include "connect.php";

    try {
        $stmt = $conn->prepare("SELECT * FROM matieres");
        $stmt->execute();
        $matiere = $stmt->fetchAll();

        if($matiere > 0){
            header("content-type: application/json");
            echo json_encode($matiere);
        }
    }catch(PDOException $e){
        echo $e->getMessage();
    }
 
?>