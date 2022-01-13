<?php
    session_start();
    ob_start();
    if(isset($_SESSION['id'])){
        $userid = $_SESSION['id']; 
        include "init.php"; 
        echo "<div class='container classes'>";
        echo "<h1 class='text-center'>Gestion Des Classes</h1>";
?>
        <button type="button" class="btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fas fa-plus"></i> Ajouter une nouvelle classe
        </button>
        
        <!-- Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Ajouter la classe et Matiere</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <form action="" method="POST" class="">
                    <div class="modal-body">
                        <div class="from-group">
                            <button type="button" class="btn btn-success float-end mb-2" id="add-new-matiere"> <span>+</span> Matiere</button>
                        </div>
                        <div class="form-group main-classe">
                            <input type="text" name="classe" id="classe" class="form-control">
                        </div>
                        <div class="form-group mt-2 main-matiere p-arrow">
                            <select name="matieres[]" id="matiere" class="form-control">
                                <?php
                                    foreach(getAllMatieres() as $matiere) {
                                        echo "<option value='".$matiere['idMatiere']."'>".$matiere['NomMatiere']."</option>";
                                    }
                                ?>
                            </select>
                            <i class="fas fa-angle-down"></i>
                        </div>                                                   
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" name="insertClass" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
        </div>

        <!-- Insert Classes Into Database -->
 
        <?php
            if(isset($_POST['insertClass'])) {
                $classe  = $_POST['classe'];
                $matieres = $_POST['matieres'];

                $error = false;

                if(empty($classe)) {
                    echo "<div class='alert alert-danger mt-2 msg'> Ajouter Une Classe</div>";
                    $error = true;
                }

                foreach($matieres as $matiere) {
                    if(CheckIfMatiereExist($matiere,$classe) > 0){
                        echo "<div class='alert alert-danger mt-2 msg'> " . CheckIfMatiereExist($matiere,$classe)['NomMatiere'] . " Existe deja</div>";
                        $error = true;
                    }
                }
                if($error == false ){
                    $array = [];
                    foreach($matieres as $index => $mat){
                        if( in_array($mat,$array) ){
                            continue;
                        }
                        $insert = insertMatiere($classe,$mat);
                        $student = getStudentsUsingClasse($classe);
                        if(!empty($student)){
                            foreach($student as $regNo ){
                                $idClasse = getIdClasseUsingNomClasse($classe)['idClasse'];                                    
                                insertIntoNotes($regNo['Matricule'],$idClasse,$mat);
                            }
                        } 
                        array_push($array,$mat);
                    }
                    
                    if(isset($insert) && $insert > 0){
                        echo "<div class='alert alert-success mt-2 msg'>Ajouter Avec Succes</div>";
                        header("refresh: 3");
                    }else {
                        echo "<div class='alert alert-danger mt-2 msg'>Fail</div>";
                        header("refresh: 3");
                    }
                }

            }
                    
        ?>


        <!-- Start Afficher les classes  -->

        <div class="row mt-2">
            <div class="col-md-4">
                <div class="form-group p-arrow">
                    <select name="" id="selectClasse" class="form-control">
                        <option value="">Choisir Une Classe</option>
                        <?php
                            foreach(getAllClasses() as $classe){
                                echo "<option value='".$classe['idClasse']."'>".$classe['NomClasse']."</option>";
                            }
                        ?>
                    </select>
                    <i class="fas fa-angle-down"></i>                    
                </div>
            </div>
        </div>
        <div class="display-msg"></div>
        <div class="table-responsive">
            <table class="table d-none">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th scope="delete">Delete</th>
                    </tr>
                </thead>
                <tbody class="afficherMatiereInClasseFile">
                    
                </tbody>
            </table>
        </div>
        <!-- End Afficher les classes  -->

        
    <!-- Start Delete -->

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Supprimer la matiere</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="POST">
            <div class="container">
                <h6>voulez-vous supprimer??</h6>
            </div>
            <div class="modal-body">
                <input type="hidden" id="deleteIdClasse" name="deleteIdClasse" >
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" name="btn-delete-class" class="btn btn-danger">Supprimer</button>
            </div>
        </form>
        </div>
    </div>
    </div>


    <?php
        if( isset($_POST['btn-delete-class']) ) {
            $id = $_POST['deleteIdClasse'];

            if(deleteClass($id) > 0 ){
                echo "<div class='alert alert-success msg mt-2'>Matiere supprimer avec succes</div>";
                header("refresh: 3");
            }
        }


    ?>


    <!-- End Delete -->

<?php
        echo "</div>";
        include $tpl . "footer.php";
    }else {
        header("Location: index.php");
    }

    ob_end_flush();
?>