<?php
    session_start();

    require('../includes/conexao.inc');
    require('../Model/FuncionarioDAO.php');  
    require('../Model/UsuarioDAO.php');
    require('../Model/AbsenteismoDAO.php');
    
    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    if(!isset($_REQUEST['opcao'])) {
        Header("location:../index.php");
    }
    
    $opcao = (int)$_REQUEST['opcao'];
    
    //Vai pra página de informação
    if($opcao == 0) {
        echo 'esou aqui? ';
        header("Location: ../View/Cadastro/MinhaConta.php");
    }
    
    //Alterar a senha
    if ($opcao == 1) {
        
        $usuarioDAO = new UsuarioDAO();        
        
        $senhaAtual = md5($_REQUEST['senhaAtual']);
        $senhaNova = md5($_REQUEST['novaSenha']);
        $confirmacaoSenha = md5($_REQUEST['confirmacaoSenha']);
        
        if($usuario->senha == $senhaAtual) { 
            if($senhaNova == $confirmacaoSenha) {
                $usuario->senha = $senhaNova;
                $usuarioDAO->editarUsuario($usuario);
                header("Location: ../View/Cadastro/MinhaConta.php?senha='sucesso'");
            } else {
                header("Location: ../View/Cadastro/AlterarSenha.php?erro=1");
            }           
        } else {
                header("Location: ../View/Cadastro/AlterarSenha.php?erro=2");
        }           
    }
    
    
    
    //Editar funcionario
    if($opcao == 3){
        $usuario->idUsuario = ((int) $_REQUEST["idUsuario"]);        
        $usuario->nome = ($_REQUEST["nome"]);
        $usuario->login = ($_REQUEST["login"]);
                
        $usuarioDAO = new UsuarioDAO();
        $usuarioDAO->editarUsuario($usuario);
        
        header("Location:controlerAcesso.php?opcao=0");
    }
    