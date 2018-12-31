<?php
    session_start();
    require_once('../includes/conexao.inc');
    require_once('../Model/Usuario.php');
    
    $c = new Conexao();
    $conexao= $c->getConexao();
    
    if (isset($_REQUEST["login"])){ 
        $login = $_REQUEST["login"];
        $senha = md5($_REQUEST["senha"]);
        if($login!=null || $senha!=null) {        
            $sql = $conexao->prepare("SELECT * FROM usuario where login = :login AND senha = :senha");
            $sql->bindValue(':login', $login);
            $sql->bindValue(':senha', $senha);
            $sql->execute();        
            $usuario = new Usuario();
            $usuario = $sql->fetch(PDO::FETCH_OBJ);
            
            if ($usuario->nome != "") {
                $_SESSION["usuario"] = $usuario;
                echo $usuario->nome;
                Header("Location: ../View/index.php");
            } else {
                Header("Location: ../index.php?erro=1");
            }
        }
    }
    