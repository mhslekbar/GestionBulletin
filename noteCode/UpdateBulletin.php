<?php
    include "../connect.php";
    $moyenne    = $_GET['MGM'];
    $matricule  = $_GET['Matricule'];
    $classe     = $_GET['classe'];
    // $stmt = $conn->prepare("SELECT FullName , NomMatiere , (0.4 * NoteDevoir + 0.6 * NoteCompo ) * Coeff AS MGM  , sum((0.4 * NoteDevoir + 0.6 * NoteCompo ) * Coeff) FROM notes n JOIN matieres m JOIN classes c JOIN etudiants e ON e.Matricule = n.Matricule AND m.idMatiere = n.idMatiere AND n.idClasse = c.idClasse GROUP BY n.Matricule , n.idMatiere");
    // $stmt = $conn->prepare("SELECT FullName , NomMatiere , (0.4 * NoteDevoir + 0.6 * NoteCompo ) * Coeff AS MGM  , sum((0.4 * NoteDevoir + 0.6 * NoteCompo ) * Coeff) FROM notes n JOIN matieres m JOIN classes c JOIN etudiants e ON e.Matricule = n.Matricule AND m.idMatiere = n.idMatiere AND n.idClasse = c.idClasse GROUP BY n.Matricule , n.idMatiere");




?>