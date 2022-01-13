<?php
    include  "../connect.php";
    $matricule = $_GET['regNo'] ?? null;
    
    if(check($matricule) > 0){
        header("content-type: application/json");
        echo json_encode(check($matricule));
    }

    function check($matricule){
        global $conn;
        $stmt = $conn->prepare("SELECT  *, n.idMatiere as Matiere , FullName , n.idClasse  as classe FROM notes n JOIN matieres m JOIN  classes c JOIN etudiants e ON e.Matricule = n.Matricule AND m.idMatiere = n.idMatiere AND n.idClasse = c.idClasse WHERE n.Matricule = ?");
        $stmt->execute([$matricule]);
        return $stmt->fetchAll();
    }

?>