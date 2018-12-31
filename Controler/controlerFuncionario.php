<?php    
    require('../includes/conexao.inc');
    require('../Model/FuncionarioDAO.php');  
    require('../Model/UsuarioDAO.php');
    require('../Model/SecaoDAO.php');
    require('../Model/DivisaoDAO.php');
    require('../Model/GerenciaDAO.php');
    
    session_start();
    
    if(!isset($_REQUEST['opcao'])) {
        Header("location:../index.php");
    }
    
    $opcao = (int)$_REQUEST['opcao'];
    
    //Lista todos os funcionarios
    if($opcao == 1){
        $funcionarioDAO = new FuncionarioDAO();
        $usuarioDAO = new UsuarioDAO();
        $secaoDAO = new SecaoDAO();
        $divisaoDAO = new DivisaoDAO();
        $gerenciaDAO = new GerenciaDAO();
        $listaFuncionarios = $funcionarioDAO->getFuncionarios();
        $listaUsuarios = $usuarioDAO->getUsuarios();
        $listaSecoes = $secaoDAO->getSecoes();
        $listaDivisoes = $divisaoDAO->getDivisoes();
        $listaGerencias = $gerenciaDAO->getGerencias();
        $_SESSION['funcionarios'] = $listaFuncionarios;
        $_SESSION['usuarios'] = $listaUsuarios;
        $_SESSION['secoes'] = $listaSecoes;
        $_SESSION['divisoes'] = $listaDivisoes;
        $_SESSION['gerencias'] = $listaGerencias;
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
        $funcionario->setCargo($_REQUEST["cargo"]);
        $funcionario->setDataAdmissao($_REQUEST["dataAdmissao"]);
        $funcionario->setSituacao($_REQUEST["situacao"]);
        $funcionario->setIdSecao($_REQUEST['idSecao']);
        $funcionario->setFuncAtivo($_REQUEST["funcAtivo"]);
        if($funcionario->getFuncAtivo()==0) {
            date_default_timezone_set('America/Sao_Paulo');
            $funcionario->setDataInativacao(date('Y-m-d H:i:s'));
        } else {
            $funcionario->setDataInativacao("0000-00-00 00:00:00");
        }
        
        echo 'Cargo: '.$funcionario->getCargo().'<br>';
        echo 'Crachá: '.$funcionario->getCracha().'<br>';
        echo 'Data de Admissão: '.$funcionario->getDataAdmissao().'<br>';
        echo 'Data de Inativação: '.$funcionario->getDataInativacao().'<br>';
        echo 'Ativo? '.$funcionario->getFuncAtivo().'<br>';
        echo 'Id: '.$funcionario->getIdFuncionario().'<br>';
        echo 'Seção: '.$funcionario->getIdSecao().'<br>';
        echo 'Nome: '.$funcionario->getNome().'<br>';
        echo 'Situação: '.$funcionario->getSituacao().'<br>';
        
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
    
    //Funcionário por cargo
    if($opcao == 5){
        $filtroCargo = $_REQUEST['filtroCargo'];
        echo $filtroCargo.'<br>';
        $funcionarioDAO = new FuncionarioDAO();
        $usuarioDAO = new UsuarioDAO();
        $secaoDAO = new SecaoDAO();
        $divisaoDAO = new DivisaoDAO();
        $gerenciaDAO = new GerenciaDAO();
        $listaFuncionarios = $funcionarioDAO->getFuncionariosByCargo($filtroCargo);
        $listaUsuarios = $usuarioDAO->getUsuarios();
        $listaSecoes = $secaoDAO->getSecoes();
        $listaDivisoes = $divisaoDAO->getDivisoes();
        $listaGerencias = $gerenciaDAO->getGerencias();
        $_SESSION['funcionarios'] = $listaFuncionarios;
        $_SESSION['usuarios'] = $listaUsuarios;
        $_SESSION['secoes'] = $listaSecoes;
        $_SESSION['divisoes'] = $listaDivisoes;
        $_SESSION['gerencias'] = $listaGerencias;
        //header("Location:../View/Funcionario/ListaFuncionario.php");
    }    
    
    
    