<?php
    include "../connect.php";
    $Matiere = $_GET['idMatiere'];
    $Classe = $_GET['idClasse'];

    $allNotes = getNoteWhereMatAndClass($Classe, $Matiere);
    $getNotes = getNotes($Classe);

    if($allNotes > 0) {
        header("content-type: application/json");
        echo json_encode($allNotes);   
    }

    function getNotes($Classe){
        global $conn;
        $stmt = $conn->prepare("SELECT FullName , n.* FROM Notes n JOIN etudiants e ON e.Matricule = n.Matricule WHERE n.idClasse = ? GROUP BY n.Matricule");
        $stmt->execute([$Classe]);
        return $stmt->fetchAll();
    }

    function getNoteWhereMatAndClass($Classe, $Matiere){
        global $conn;
        $stmt = $conn->prepare("SELECT FullName , n.* FROM Notes n JOIN etudiants e ON e.Matricule = n.Matricule WHERE n.idClasse = ? AND n.idMatiere = ? GROUP BY n.Matricule");
        $stmt->execute([$Classe, $Matiere]);
        return $stmt->fetchAll();
    }



    
    // if(empty($getNotes['idMatiere'])){
    //     header("content-type: application/json");
    //     echo json_encode($getNotes);
    // } else {
    //     header("content-type: application/json");
    //     echo json_encode($allNotes);   
    // }

    // if( $allNotes > 0 ){
    //     header("content-type: application/json");
    //     echo json_encode($allNotes);
    // } 
    // else 
    // if($getNotes > 0){
    //     header("content-type: application/json");
    //     echo json_encode($getNotes);
    // }
    
    

?>