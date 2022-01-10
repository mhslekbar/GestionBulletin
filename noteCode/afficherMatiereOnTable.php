<?php
    include "../connect.php";
    $idclasse = $_GET['idClasse'];
    $nomClasse = getNomClasse($idclasse)['NomClasse'];
    $stmt = $conn->prepare("SELECT m.idMatiere as id , NomMatiere, idClasse FROM classes c JOIN matieres m ON m.idMatiere = c.idMatiere WHERE NomClasse = ? ORDER BY id");
    $stmt->execute([$nomClasse]);
    $classe = $stmt->fetchAll();
    if( $classe > 0) {
        header("content-type: application/json");
        echo json_encode($classe);
    }

    function getNomClasse($id){
        global $conn;
        $stmt = $conn->prepare("SELECT NomClasse FROM classes WHERE idClasse = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

?>