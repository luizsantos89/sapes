<?php
    require_once('../Model/FuncionarioDAO.php');  
    require_once('../Model/UsuarioDAO.php');   
    
    session_start();
    
    if(!isset($_REQUEST['opcao'])) {
        Header("location:../index.php");
    }
    
    $opcao = (int)$_REQUEST['opcao'];
    //Lista todos os funcionarios
    if($opcao == 1){
        $funcionarioDAO = new FuncionarioDAO();
        $usuarioDAO = new UsuarioDAO();
        $listaFuncionarios = $funcionarioDAO->getFuncionarios();
        $listaUsuarios = $usuarioDAO->getUsuarios();
        $_SESSION['funcionarios'] = $listaFuncionarios;
        $_SESSION['usuarios'] = $listaUsuarios;
        header("Location:../View/Funcionario/ListaFuncionario.php");
    }    
    
    //Lista funcionario por ID
    if($opcao == 2){
        $idFuncionario = $_REQUEST["idFuncionario"];                
        $funcionarioDAO = new FuncionarioDAO();
        $_SESSION['funcionario'] =  $funcionarioDAO->getFuncionarioByID($idFuncionario);
        echo $idFuncionario;
        header("Location:../View/Funcionario/EditaFuncionario.php");
    }
    
    //Editar funcionario
    if($opcao == 3){
        $funcionario = new Funcionario();
        $funcionario->setIdFuncionario((int) $_REQUEST["idFuncionario"]);        
        $funcionario->setNome($_REQUEST["nome"]);
        $funcionario->setCracha($_REQUEST["cracha"]);
        $funcionario->setDataCadastro($_REQUEST["dataCadastro"]);
        $funcionario->setIdUsuario($_REQUEST["idUsuario"]);
        $funcionario->setFuncAtivo($_REQUEST["funcAtivo"]);
        
        
        $funcionarioDAO = new FuncionarioDAO();
        $funcionarioDAO->editarFuncionario($funcionario);
        header("Location:controlerFuncionario.php?opcao=1");
    }
    
    //Cadastrar funcionario
    if ($opcao == 4){
        $funcionario = new Funcionario();       
        $funcionario->setNome($_REQUEST["nome"]);
        $funcionario->setCracha($_REQUEST["cracha"]);
        $funcionario->setIdUsuario($_SESSION["usuario"]->idUsuario);
        $funcionario->setFuncAtivo($_REQUEST["funcAtivo"]);
        date_default_timezone_set('America/Sao_Paulo');
        $funcionario->setDataCadastro(date('Y-m-d H:i:s'));
                
        $funcionarioDAO = new FuncionarioDAO();
        $funcionarioDAO->incluirFuncionario($funcionario);
        header("Location:controlerFuncionario.php?opcao=1");
    }
    
    //Exclui funcionário
    if ($opcao == 5) {
        $funcionario = new Funcionario();
        $funcionario->setIdFuncionario((int) $_REQUEST['idFuncionario']);
        
        $funcionarioDAO = new FuncionarioDAO();
        $funcionarioDAO->excluiFuncionario($funcionario);
        header("Location:controlerFuncionario.php?opcao=1");
    }