<?php
    session_start();
    ob_start();
    if(isset($_SESSION['id'])){
        $userid = $_SESSION['id']; 
        include "init.php"; 
        echo "<div class='container dashboard'>";
?>

        <h1 class='text-center mt-3 mb-2'>Voir Les Bulletins</h1>
            <div class="row">
                <div class="offset-md-2 col-md-2">
                <div class='form-group checkMatDiv'>
                    <input class='form-control' type='text' placeholder="Entrer Votre Matricule" id="matriculeCheck">
                    <label class="displayErrorCheck"></label>
                </div>
                </div>
            </div>
        <div class="row mt-3">
            <div class="offset-md-1 col-md-6">
                <div class="form-group infoBulletin">
                </div>
            </div>
        </div>    
        <div class="row table-bulletin d-none">
            <div class="offset-md-1 col-md-10 mt-2">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Code U.V</th>
                            <th>Nom de la Matiere</th>
                            <th>Coeff</th>
                            <th>Devoir</th>
                            <th>Compo</th>
                            <!-- <th>Moyenne</th> -->
                            <th>MGM</th>
                        </tr>
                    </thead>
                    <tbody class="bulletin">

                    </tbody>
                </table>
                <div class="decision">
                    
                </div>
            </div>
            <div class="row btn-imprimer">
                <div class="offset-md-10 col-md-2">
                <button class="btn btn-success float-end mb-5" onclick="window.print()">imprimer</button>
                </div>
            </div>
        </div>              
    

<?php    
        echo "</div>";

        include $tpl . "footer.php";
    }else {
        header("Location: index.php");
    }

    ob_end_flush();
?>