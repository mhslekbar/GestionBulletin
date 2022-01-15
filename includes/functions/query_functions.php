<?php

    // login FOrm 

    function checkLoginForm($username,$password){
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE Username = ? AND Password = ?");
        $stmt->execute(array($username,$password));
        return $stmt->fetch();
    }


    /* Start Manage Student  */

    function getLastRegNo() {
        global $conn;
        $stmt = $conn->prepare("SELECT Matricule FROM etudiants ORDER BY id DESC LIMIT 1");
        $stmt->execute();
        return $stmt->fetch();
    }
    function getAllClasses(){
        global $conn;
        $stmt = $conn->prepare("SELECT DISTINCT(NomClasse) , idClasse , idMatiere  FROM classes GROUP BY NomClasse ORDER BY idClasse");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function insertEtudiant($regNo,$fname,$phone,$addr,$classe){
        global $conn;
        $stmt = $conn->prepare("INSERT INTO etudiants (Matricule,FullName,Telephone,Addresse,idClasse) VALUES (?,?,?,?,?)");
        $stmt->execute([$regNo,$fname,$phone,$addr,$classe]);
        return $stmt->rowCount();
    }


    function getAllEtudiants(){
        global $conn;
        $stmt = $conn->prepare("SELECT e.* ,c.NomClasse as classe FROM etudiants e JOIN classes c ON c.idClasse = e.idClasse");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function selectClasse(){
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM classes GROUP BY NomClasse");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getEtudiant($regNo){
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM etudiants WHERE Matricule = ?");
        $stmt->execute([$regNo]);
        return $stmt->fetch();
    }

    function updateEtudiant($fname,$phone, $addr,$classe,$regNo) {
        global $conn;
        $stmt = $conn->prepare("UPDATE etudiants SET FullName = ? , Telephone = ? , Addresse = ? , idClasse = ? WHERE Matricule = ? ");
        $stmt->execute([$fname,$phone, $addr,$classe,$regNo]);
        return $stmt->rowCount();
    }

    function deleteEtudiant($mat){
        global $conn;
        $stmt = $conn->prepare("DELETE FROM etudiants WHERE Matricule = ?");
        $stmt->execute([$mat]);
        return $stmt->rowCount();
    }

    function insertIntoNotes($matricule,$classe,$matiere){
        global $conn;
        $stmt = $conn->prepare("INSERT INTO notes (Matricule,idClasse,idMatiere) VALUES (?,?,?)");
        $stmt->execute([$matricule,$classe,$matiere]);
        return $stmt->rowCount();
    }

    function getClasseUsingIdClasse($idClasse){
       global $conn;
       $stmt = $conn->prepare("SELECT NomClasse FROM classes WHERE idClasse = ? ");
       $stmt->execute([$idClasse]);
       return $stmt->fetch(); 
    }

    function getMatiereWhereClass($classe){
        global $conn;
        $stmt = $conn->prepare("SELECT c.idMatiere as subject ,NomMatiere FROM classes c join matieres m on m.idMatiere = c.idMatiere WHERE NomClasse = ?");
        $stmt->execute([$classe]);
        return $stmt->fetchAll();
    }

    function getStudentsUsingClasse($classe){
        global $conn;
        $stmt = $conn->prepare("SELECT Matricule FROM etudiants e JOIN classes c ON c.idClasse = e.idClasse WHERE NomClasse = ?");
        $stmt->execute([$classe]);
        return $stmt->fetchAll();
    }

    function insertMatiereAndRegNoIntoNotes($regNo,$idClasse,$idMatiere){
        global $conn;
        $stmt = $conn->prepare("INSERT INTO notes (Matricule,idClasse,idMatiere) VALUES (?,?,?) ");
        $stmt->execute([$regNo,$idClasse,$idMatiere]);
        return $stmt->rowCount();
    }   

    function getIdClasseUsingNomClasse($classe){
        global $conn;
        $stmt = $conn->prepare("SELECT idClasse FROM classes WHERE NomClasse = ?");
        $stmt->execute([$classe]);
        return $stmt->fetch();
    }

    function deleteStudentFromNote($regNo) {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM Notes WHERE Matricule = ?");
        $stmt->execute([$regNo]);
        return $stmt->rowCount();
    }

    function deleteStudentFromBulletin($regNo){
        global $conn;
        $stmt = $conn->prepare("DELETE FROM Bulletins WHERE Matricule = ?");
        $stmt->execute([$regNo]);
        return $stmt->rowCount();
    }

    /* End Manage Student  */

    /* Start Manage Notes  */
    
    function getAllMatieres() {
        global $conn;
        $stmt =  $conn->prepare("SELECT * FROM matieres");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function insertMatiere($classe,$subject){
        global $conn;
        $stmt = $conn->prepare("INSERT INTO classes (NomClasse,idMatiere) values (?,?)");
        $stmt->execute([$classe,$subject]);
        return $stmt->rowCount();
    }

    function CheckIfMatiereExist($matiere,$classe) {
        global $conn;
        $stmt =  $conn->prepare("SELECT c.* , m.NomMatiere as NomMatiere FROM classes c JOIN matieres m ON m.idMatiere = c.idMatiere WHERE c.idMatiere = ? AND c.NomClasse = ?");
        $stmt->execute([$matiere,$classe]);
        return $stmt->fetch();
    }


    function updateNotes($devoir,$compo,$classe,$matiere,$regNo) {
        global $conn;
        $stmt = $conn->prepare("UPDATE notes SET NoteDevoir = ? , NoteCompo = ? WHERE idClasse = ? AND idMatiere = ? AND Matricule = ?");
        $stmt->execute([$devoir,$compo,$classe,$matiere,$regNo]);
        return $stmt->rowCount();
        // return $stmt->execute([$devoir,$compo,$classe,$matiere,$regNo]);
    }


    function insertNotes($regNo,$devoir,$compo,$classe,$matiere) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO notes (Matricule,NoteDevoir,NoteCompo,idClasse,idMatiere) VALUES (?,?,?,?,?)");
        $stmt->execute([$regNo,$devoir,$compo,$classe,$matiere]);
        return $stmt->rowCount();
    }



    /* End Manage Notes  */


    /* Start CLasse */

    function deleteClass($id){
        global $conn;
        $stmt = $conn->prepare("DELETE FROM classes WHERE idClasse = ? ");
        $stmt->execute([$id]);
        return  $stmt->rowCount();
    }



    /* End CLasse */




    /**  Start Bulletin */

    function SelectMGMFromBulletin($matricule) {
        global $conn;
        $stmt = $conn->prepare("SELECT Coeff , (0.4 * NoteDevoir + 0.6 * NoteCompo ) * Coeff AS MGM FROM notes n JOIN matieres m JOIN classes c JOIN etudiants e ON e.Matricule = n.Matricule AND m.idMatiere = n.idMatiere AND n.idClasse = c.idClasse WHERE n.Matricule = ? GROUP BY n.Matricule , n.idMatiere");
        $stmt->execute([$matricule]);
        return $stmt->fetchAll();
    }

    function insertRegNoAndClassIntoBulletin($matricule,$idClasse) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO bulletins (Matricule,idClasse) VALUES (?,?)");
        $stmt->execute([$matricule,$idClasse]);
        return $stmt->rowCount();
    }

    function UpdateBulletin($MGM,$regNo) {
        global $conn;
        $stmt = $conn->prepare("UPDATE bulletins SET MGM = ? WHERE Matricule = ?");
        $stmt->execute([$MGM,$regNo]);
        return $stmt->rowCount();
    }

    function selectBestStudent(){
        global $conn;
        $stmt = $conn->prepare("SELECT FullName, NomClasse, MGM ,b.Matricule as regNo , RANK() over(ORDER BY MGM DESC) as Rank_no FROM bulletins b JOIN etudiants e JOIN classes c ON c.idClasse = b.idClasse AND b.Matricule = e.Matricule ORDER BY MGM DESC LIMIT 5");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getClasseUsingRegNo($regNo){
        global $conn;
        $stmt = $conn->prepare("SELECT NomClasse FROM etudiants e JOIN classes c ON c.idClasse = e.idClasse WHERE Matricule = ?");
        $stmt->execute([$regNo]);
        return $stmt->fetch();
    }

    /**  End  Bulletin */






?>


