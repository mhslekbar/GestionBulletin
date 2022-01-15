<?php
    session_start();
    ob_start();
    if(isset($_SESSION['id'])){
        $userid = $_SESSION['id']; 
        include "init.php"; 

        echo "<div class='container etudiant'>";
        echo "<h1 class='text-center'>Gestion Des Etudiants</h1>";
?>
               
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fas fa-plus"></i> Add New Student
        </button>


        <!-- Add Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add New Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <?php 
                            $regNo = "ss-101";
                            if(empty(getLastRegNo()) ){
                                $regNo = "ss-100";
                            }else {
                                $regNo = getLastRegNo()[0];
                                $regNo = substr($regNo,3);
                                $regNo++;
                                $regNo = "ss-" . $regNo;
                            }
                        ?>
                        <label for="regNo">RegNo</label>
                        <input type="text" readonly name="regNo" class="form-control" value="<?= $regNo; ?>">
                    </div>            
                    <div class="form-group">
                        <label for="fname">FullName</label>
                        <input type="text" name="fname" autocomplete="off" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="phone">Cellphone</label>
                        <input type="text" name="phone" autocomplete="off" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="addr">Address</label>
                        <input type="text" name="addr" autocomplete="off" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="classe">Classe</label>
                        <select name="classe" class="form-control">
                            <option value="">Choisir la Classe</option>
                            <?php
                                // print_r(getAllClasses());
                                $classes = getAllClasses();
                                foreach($classes as $classe){
                                    echo "<option value=".$classe['idClasse'].">".$classe['NomClasse']."</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="addBtn" class="btn btn-primary">Enregister</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
        </div>

                                
        <!-- Start Insert Information  -->
        <?php
            if( isset($_POST['addBtn']) ) {
                $regNo  = filter_var($_POST['regNo'],FILTER_SANITIZE_STRING);
                $fname  = filter_var($_POST['fname'],FILTER_SANITIZE_STRING);
                $phone  = filter_var($_POST['phone'],FILTER_SANITIZE_STRING);
                $addr   = filter_var($_POST['addr'],FILTER_SANITIZE_STRING);
                $classe = filter_var($_POST['classe'],FILTER_SANITIZE_NUMBER_INT);

                $formErrors = array();
                
                if(empty($fname)):
                    $formErrors[] = "FullName <strong>can't be empty</strong>";
                endif;

                if(!is_numeric($phone)):
                    $formErrors[] = "Cellphone <strong>Must be Numeric </strong>";
                endif;

                if(empty($addr)):
                    $formErrors[] = "Address <strong>can't be empty</strong>";
                endif;

                if(!is_numeric($classe)){
                    $formErrors[] = "la Classe Est <strong>Obligatoire</strong>";
                }

                foreach($formErrors as $error):
                    echo "<div class='alert alert-danger msg'>" . $error . "</div>";
                endforeach;

                if( empty($formErrors)){
                    try{
                        $insert = insertEtudiant($regNo,$fname,$phone,$addr,$classe);
                        $theMsg = "<div class='alert alert-success msg'>Etudiant Ajouté Avec Succes</div>";
                        // Insert student into notes Table
                        $matieres = getMatiereWhereClass(getClasseUsingIdClasse($classe)['NomClasse']);
                        foreach($matieres as $matiere){
                            insertIntoNotes($regNo,$classe,$matiere['subject']);  
                        }
                        insertRegNoAndClassIntoBulletin($regNo,$classe);                    
                    }catch (PDOException $e){
                        $theMsg = "<div class='alert alert-danger msg'>".$e->getMessage()."</div>";
                    }
                }

            }
        ?>

        <!-- Edit  -->

        <!-- Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="regNo" name="regNo"> 
                    <div class="form-group">
                        <label for="fname">FullName</label>
                        <input type="text" class="form-control" id="fname" name="fname">
                    </div>
                    <div class="form-group">
                        <label for="phone">Telephone</label>
                        <input type="text" class="form-control" id="phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="addr">Addresse</label>
                        <input type="text" class="form-control" id="addr" name="addr">
                    </div>
                    <div class="form-group p-arrow">
                        <label for="classe">Classe</label>
                        <select name="classe" id="classe" class="form-control">
                            <?php
                                foreach(selectClasse() as $classe){
                                    echo "<option value='".$classe['idClasse']."'>".$classe['NomClasse']."</option>";
                                }
                            ?>
                        </select>
                        <i class="fas fa-angle-down"></i>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="editEtudiant" class="btn btn-success">Save changes</button>
                </div>
            </form>
            </div>
        </div>
        </div>
  

        <!-- Start Edit Code Php  -->
        
        <?php
            if(isset($_POST['editEtudiant'])){
                $regNo  = filter_var($_POST['regNo'],FILTER_SANITIZE_STRING);
                $fname  = filter_var($_POST['fname'],FILTER_SANITIZE_STRING);
                $phone  = filter_var($_POST['phone'],FILTER_SANITIZE_STRING);
                $addr   = filter_var($_POST['addr'],FILTER_SANITIZE_STRING);
                $classe = filter_var($_POST['classe'],FILTER_SANITIZE_NUMBER_INT);

                $student = getEtudiant($regNo);
  
                $formErrors = array();
                
                if(empty($fname)):
                    $fname = $student['FullName'];
                endif;

                if(!is_numeric($phone) && !empty($phone)):
                    $formErrors[] = "Cellphone <strong>Must be Numeric </strong>";
                endif;

                if(strlen($phone) > 11):
                    $formErrors[] = "Numero de Telephone ne peut pas <strong>depasser 11 Numero </strong>";
                endif;


                if(empty($phone)):
                    $phone = $student['Telephone'];
                endif;

                if(empty($addr)):
                    $addr = $student['Addresse'];
                endif;

                if(!is_numeric($classe)){
                    $formErrors[] = "la Classe Est <strong>Obligatoire</strong>";
                }
                
                if($classe != $student['idClasse']){
                    deleteStudentFromNote($regNo);
                    deleteStudentFromBulletin($regNo);
                    $matieres = getMatiereWhereClass(getClasseUsingIdClasse($classe)['NomClasse']);
                    foreach($matieres as $matiere){
                        insertIntoNotes($regNo,$classe,$matiere['subject']);  
                    }                    
                    insertRegNoAndClassIntoBulletin($regNo,$classe);
                }

                foreach($formErrors as $error):
                    echo "<div class='alert alert-danger msg'>" . $error . "</div>";
                endforeach;

                if(empty($formErrors)){
                    try{
                        $update  = updateEtudiant($fname,$phone, $addr,$classe,$regNo);
                        $theMsg = "<div class='alert alert-success msg'>Etudiant A ete Modifie Avec succes</div>";
                    } catch(PDOException $e){
                        $theMsg = "<div class='alert alert-success msg'>".$e->getMessage()."</div>";
                    }
                }
            }

        ?>
        
        <!-- End Edit Code Php  -->


        <!-- Start Delete  -->
        
        <!-- Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <h6 class="container">Vous Etes Sure ??</h6>
            <form action="" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="mat" name="mat">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="deleteEtudiant" class="btn btn-danger">Save changes</button>
                </div>
            </form>
            </div>
        </div>
        </div>


        <?php
        
            if(isset($_POST['deleteEtudiant'])){
                $mat = $_POST['mat'];
                try{
                    deleteEtudiant($mat);
                    $theMsg = "<div class='alert alert-success msg'> Etudiant Supprimé avec Succes";
                }
                catch(PDOException $e){
                    $theMsg = "<div class='alert alert-danger msg'>" . $e->getMessage() . "</div>";
                }
            }

        ?>


        <!-- End Delete  -->


        
    <!-- Start Table -->
        <div>
            <?php 
                if(isset($theMsg)){
                    echo $theMsg;
                    header("refresh: 5; url=etudiants.php");
                }
            ?>
        </div>
        <div class="row">
            <div class="col-md-2">
                <label for="">Afficher par Classe</label>
            </div>
            <div class="offset-md col-md-8">
                <div class="form-group p-arrow">
                    <select name="classe" id="classeEtudiant" class="form-control">
                        <option value="">Choisir Classe</option>
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
        <div class="table-responsive">
        <table class="table table-student">
            <thead>
                <tr>
                    <th scope="col">#ID</th>
                    <th scope="col">Register No</th>
                    <th scope="col">FullName</th>
                    <th scope="col">Telephone</th>
                    <th scope="col">Address</th>
                    <th scope="col">Classe</th>
                    <th scope="col">Control</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach(getAllEtudiants() as $student):
                ?>
                <tr>
                    <td scope="row"><?= $student['id'];?></td>
                    <td><?= $student['Matricule'];?></td>
                    <td><?= $student['FullName'];?></td>
                    <td><?= $student['Telephone'];?></td>
                    <td><?= $student['Addresse'];?></td>
                    <td><?= $student['classe'];?></td>
                    <td hidden><?= $student['idClasse'];?></td>
                    <td class="control">
                        <button type="button" class="btn btn-success btnEdit" data-edit="<?= $student['Matricule']; ?>" data-bs-toggle="modal" data-bs-target="#editModal">
                            <i class="fas fa-edit"></i> Edit
                        </button>     
                        <button type="button" class="btn btn-danger btnDelete" data-delete="<?= $student['Matricule'];?>" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-user-times"></i> Delete
                        </button>                             
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>

    <!-- End Table -->
  
<?php
        echo "</div>";  // End of COntainer 

        include $tpl . "footer.php";
    }else {
        header("Location: index.php");
    }

    ob_end_flush();
?>