<?php
    include "connect.php";
    
    // FIles 
    $func   = "includes/functions/";
    $tpl    = "includes/templates/";
    $css    = "layout/css/";
    $js     = "layout/js/"; 
    $images = "layout/images/";

    // includes 
    
    include $func . "functions.php";
    include $func . "query_functions.php";

    include $tpl . "header.php";
    if(!isset($noNav)):
        include $tpl . "navbar.php";
    endif;



?>