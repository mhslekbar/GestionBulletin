<?php
    include "../connect.php";
    $id = $_GET['idClasse'];
    $mat = getClass($id)['NomClasse'];   
    // $stmt = $conn->prepare("SELECT  m.idMatiere, NomMatiere FROM matieres m JOIN classes c ON c.idMatiere = m.idMatiere WHERE NomClasse = ? GROUP BY NomMatiere");
    $stmt = $conn->prepare("SELECT  m.idMatiere, NomMatiere FROM matieres m JOIN classes c ON c.idMatiere = m.idMatiere WHERE NomClasse = ? ");
    $stmt->execute([$mat]);
    $matieres = $stmt->fetchAll();

    if($matieres > 0) {
        header("content-type: application/json");
        echo json_encode($matieres);
    }


    function getClass($idc){
        global $conn;
        $stmt = $conn->prepare("SELECT NomClasse FROM classes WHERE idClasse = ? limit 1");
        $stmt->execute([$idc]);
        return $stmt->fetch();
    }


?>