<?php
    include "../connect.php";
    $regNo = $_POST['regNo'];
    
    $bests = selectBestStudent();
    if($bests > 0) {
        foreach($bests as $best){
            if($best['regNo'] == $regNo){
                echo $best['rannk'];
            }    
        }
    }
    
    function selectBestStudent(){
        global $conn;
        $stmt = $conn->prepare("SELECT FullName, NomClasse, MGM ,b.Matricule as regNo , RANK() over(ORDER BY MGM DESC) as rannk FROM bulletins b JOIN etudiants e JOIN classes c ON c.idClasse = b.idClasse AND b.Matricule = e.Matricule ORDER BY MGM DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

?>