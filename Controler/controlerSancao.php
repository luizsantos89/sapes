<?php
    require('../includes/conexao.inc');
    require_once('../Model/SancaoDAO.php'); 
    require('../Model/FuncionarioDAO.php'); 
    require('../Model/UsuarioDAO.php'); 
    require('../Model/TipoSancaoDAO.php'); 
    
    session_start();
    
    if(!isset($_REQUEST['opcao'])) {
        Header("location:../index.php");
    }
    
    $opcao = (int)$_REQUEST['opcao'];
    
    //Lista todas sanções ordenadas por data
    if($opcao == 1){
        $sancaoDAO = new SancaoDAO();
        $usuarioDAO = new UsuarioDAO();
        $funcionarioDAO = new FuncionarioDAO();
        $tipoSancaoDAO = new TipoSancaoDAO();
        $listaFuncionarios = $funcionarioDAO->getFuncionarios();
        $listaUsuarios = $usuarioDAO->getUsuarios();
        $listaSancoes = $sancaoDAO->getSancoes();
        $tiposSancao = $tipoSancaoDAO->getTipoSancoes();
        $_SESSION['funcionarios'] = $listaFuncionarios;
        $_SESSION['usuarios'] = $listaUsuarios;
        $_SESSION['sancoes'] = $listaSancoes;
        $_SESSION['tipoSancoes'] = $tiposSancao;
        header("Location:../View/Sancao/ListaSancoes.php");
    }    
    
    //Lista sanc
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