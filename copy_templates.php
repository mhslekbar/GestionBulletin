<?php
    session_start();
    ob_start();
    if(isset($_SESSION['id'])){
        $userid = $_SESSION['id']; 
        include "init.php"; 
        echo "<div class='container notes'>";
        echo "<h1 class='text-center'>Gestion Des Notes</h1>";

        echo "</div>";
        include $tpl . "footer.php";
    }else {
        header("Location: index.php");
    }

    ob_end_flush();
?>