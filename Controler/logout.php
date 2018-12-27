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
    
    Header("Location: ../index.php");