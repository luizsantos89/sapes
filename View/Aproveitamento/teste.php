<?php

    session_start();

    require '../../Model/Sancao.php';

    if(isset($_SESSION['listaSancao'])) {
        echo 'existe a sessão';
        
        $listaSancao = $_SESSION['listaSancao'];
        
        foreach($listaSancao as $sancao) {
            echo $sancao->idSancao;
        }
    } else {
        echo 'nem criou a seção';
    }