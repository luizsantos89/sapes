<?php
    session_start();    
    $usuario = $_SESSION["usuario"];
    require('../includes/conexao.inc');
        
    $c = new Conexao();
    $conexao= $c->getConexao();
    
    $sql = $conexao->prepare("UPDATE usuario SET ultimoAcesso = CURRENT_TIME WHERE idUsuario = :idUsuario");
    $sql->bindValue(":idUsuario",$usuario->idUsuario);
    $sql->execute();
        
    unset($_SESSION['usuario']);
    unset($_SESSION['funcionarios']);
    unset($_SESSION['secoes']);
    unset($_SESSION['divisoes']);
    unset($_SESSION['gerencias']);
    unset($_SESSION['tipoSancoes']);
    unset($_SESSION['sancoes']);
    unset($_SESSION['notasDesempenho']);
    unset($_SESSION['absenteismo']);
    
    Header("Location: ../index.php");