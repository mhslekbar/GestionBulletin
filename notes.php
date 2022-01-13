<?php
    session_start();
    ob_start();
    if(isset($_SESSION['id'])){
        $userid = $_SESSION['id']; 
        include "init.php"; 
        echo "<div class='container notes'>";
        echo "<h1 class='text-center'>Gestion Des Notes</h1>";
?>        
       <form action="" method="POST">
            <div class="search row">
                <div class="col-md-4 mb-2">
                    <div class="form-group p-arrow">
                        <select name="classe" id="classe" class="form-control">
                            <?php
                                echo '<option value="">Choisir une Classe</option>';
                                foreach(getAllClasses() as $classe){
                                    echo "<option value='".$classe['idClasse']."'>".$classe['NomClasse']."</option>";
                                }
                            ?>
                        </select>
                        <i class="fas fa-angle-down"></i>
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="form-group p-arrow afficherMatIntoNote d-none">
                        <select name="subject" id="subject" class="form-control">
                            
                        </select>
                        <i class="fas fa-angle-down"></i>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                <div class="table-note table-responsive d-none">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Matricule</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Note Devoir</th>
                            <th scope="col-edit">
                                Note Compo
                                <div id="col-custom">
                                    <i class="fas fa-edit custom-edit-note"></i>
                                    <i class="fas fa-print custom-print-notes" onclick="window.print()"></i>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="assignNotes">
                        
                    </tbody>
                </table>
                <button type="submit" name="updateNotes" class="btn btn-success float-end" id="modifierNotes">Modifier les notes</button>
            </div> 

                </div>
            </div>
        </form>

        <?php
            if(isset($_POST['updateNotes'])) {
                $regNo = $_POST['matricule'];
                $devoirs = $_POST['devoir'];
                $compos = $_POST['compo'];
                $classe = $_POST['classe'];
                $matiere = $_POST['subject'];
                $success = false;

                foreach($devoirs as $index => $devoir){
                    // echo "Matricule : "  . $regNo[$index] . " dev : " . $devoir . " compo " . $compos[$index] . " classe : " . $classe . " matiere : ". $matiere ."<br>";
                    if( ($compos[$index] > 20 || $compos[$index] <0) || ($devoir > 20 || $devoir <0) ){
                        continue;
                    }
                    $update = updateNotes($devoir,$compos[$index],$classe,$matiere,$regNo[$index]);
                    
                    $success = true;
                    $sumMGM = 0;
                    $sumCoeff = 0;
                    foreach(SelectMGMFromBulletin($regNo[$index]) as $bulletin){
                        $sumMGM += $bulletin['MGM'];
                        $sumCoeff += $bulletin['Coeff'];
                    }
                    $MoyenTOT = $sumMGM / $sumCoeff;
                    UpdateBulletin($MoyenTOT,$regNo[$index]);  
                    
                }
                if($success) {
                    echo "<div class='alert alert-success msg'>Les Notes Ont Ete Modifier Avec succes</div>";
                    header("refresh: 3");
                } else {
                    echo "<div class='alert alert-danger msg'>Fail</div>";
                    header("refresh: 3");
                }

            }
        
        ?>

<?php
        echo "</div>";
        include $tpl . "footer.php";
    }else {
        header("Location: index.php");
    }

    ob_end_flush();
?>