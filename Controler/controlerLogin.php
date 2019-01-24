<?php
    session_start();
    require_once('../includes/conexao.inc');
    require '../Model/FuncionarioDAO.php';
    require '../Model/UsuarioDAO.php';
    require '../Model/SecaoDAO.php';
    require '../Model/DivisaoDAO.php';
    require '../Model/GerenciaDAO.php';
    require '../Model/TipoSancaoDAO.php';
    require '../Model/SancaoDAO.php';
    require '../Model/DesempenhoDAO.php';
    require '../Model/AbsenteismoDAO.php';
    
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
    