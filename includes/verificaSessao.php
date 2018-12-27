<?php
    if(isset($_SESSION["usuario"])) {
        
    } else {
        header("Location: ../index.php");
    }
