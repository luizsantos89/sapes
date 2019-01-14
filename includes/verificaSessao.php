<?php
    require 'conexao.inc';
    

    if(isset($_SESSION["usuario"])) {
        
    } else {
        header("Location: ../index.php");
    }
