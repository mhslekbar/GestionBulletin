<?php
    ob_start();
    session_start();
    $noNav = "";
    include "init.php";
    if(isset($_SESSION['username'])){
        // header("Location: dashboard.php");
    }
    
    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $check = checkLoginForm($username,$password);
        if($check > 0){
            $id = $check['id'];
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $id;
            header("Location: dashboard.php");
        }else {
            $theMsg = "<div class='alert alert-danger msg'>Nom d'utilisateur Ou mot de passe n'existe pas</div>";
        }
    }
?>


    <div class="container login">
        <form action="" class="form" method="POST">
            <h1 class="text-center">Login Form</h1>
            <?php 
                if(isset($theMsg))
                    echo $theMsg;
            ?>
            <div class="form-group">
                <input type="text" class="form-control input" name="username" placeholder="Entrez votre Nom d'utilisateur">
            </div>
            <div class="form-group">
                <input type="password" class="form-control input" name="password" placeholder="Entrez votre Mot de passe">
            </div>
            <div class="form-group d-grid">
                <input type="submit" value="Connecter" class="btn btn-primary input" name="submit">
            </div>
        </form>        
    </div>



<?php    

    include $tpl . "footer.php";
    ob_end_flush();
?>