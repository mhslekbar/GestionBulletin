<?php
    session_start();
    ob_start();
    if(isset($_SESSION['id'])){
        $userid = $_SESSION['id']; 
        include "init.php"; 
        echo "<div class='container bulletins'>";
        echo "<h1 class='text-center mt-3 mb-5'>Les Etoiles de Sup</h1>";
?>


    <div class="row">
        <div class="col-xs-6"></div>
    </div>

    <div class="row">
        <div class="offset-xs-2 col-xs-8 offset-md-2 col-md-8">
            <table class="table main-table">
                <caption>List of Best Students</caption>
                <thead>
                    <tr>
                        <th scope="col">Matricule</th>
                        <th scope="col">FullName</th>
                        <th scope="col">Classe</th>
                        <th scope="col">MGM</th>
                        <th scope="col">Rang</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $bestStudent = selectBestStudent();
                        foreach($bestStudent as $best){            
                    ?>
                <tr>
                        <th scope="row"><?= $best['regNo']; ?></th>
                        <th><?= $best['FullName']; ?></th>
                        <th><?= $best['NomClasse']; ?></th>
                        <th><?= $best['MGM']; ?></th>
                        <th><?= $best['Rank_no']; ?></th>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
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
