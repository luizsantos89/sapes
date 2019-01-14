<?php
    session_start();
    
    require('../includes/conexao.inc');
    require_once('../Model/SancaoDAO.php'); 
    require('../Model/FuncionarioDAO.php'); 
    require('../Model/UsuarioDAO.php'); 
    require('../Model/TipoSancaoDAO.php'); 
    require('../Model/SecaoDAO.php'); 
    require('../Model/DivisaoDAO.php'); 
    require('../Model/GerenciaDAO.php');
    
    $secaoDAO = new SecaoDAO();
    $_SESSION['secoes'] = $secaoDAO->getSecoes();
    $divisaoDAO = new DivisaoDAO();
    $_SESSION['divisoes'] = $divisaoDAO->getDivisoes();
    $gerenciaDAO = new GerenciaDAO();
    $_SESSION['gerencias'] = $gerenciaDAO->getGerencias();
    
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
        $idSancao = $_REQUEST["idSancao"];                
        $sancaoDAO = new SancaoDAO();
        $_SESSION['sancao'] =  $sancaoDAO->getSancaoById($idSancao);
        
        header("Location:../View/Sancao/EditaSancao.php");
    }
    
    //Editar sanção
    if($opcao == 3){
        $sancao = new Sancao();
        $sancao->setIdSancao((int) $_REQUEST['idSancao']);
        $sancao->setIdFuncionario((int) $_REQUEST["idFuncionario"]);
        $sancao->setIdUsuario($_SESSION['usuario']->idUsuario);
        $sancao->setIdTipo((int)$_REQUEST["idTipo"]);
        $sancao->setQtdDias($_REQUEST['qtdDias']);
        $sancao->setMotivo($_REQUEST['motivo']);
        $sancao->setNumDoc($_REQUEST['numDoc']);
        
        
        $dataSancao = date('Y-m-d H:i:s',strtotime($_REQUEST["dataSancao"]));      
        $sancao->setDataSancao($dataSancao);
        
        date_default_timezone_set('America/Sao_Paulo');
        $sancao->setDataLancamento(date('Y-m-d H:i:s'));
                
        echo 'Sanção: '.$sancao->getIdSancao().'<br>';
        echo 'Funcionário: '.$sancao->getIdFuncionario().'<br>';
        echo 'Usuario: '.$sancao->getIdUsuario().'<br>';
        echo 'ID Tipo de Sanção: '.$sancao->getIdTipo().'<br>';
        echo 'Motivo: '.$sancao->getMotivo().'<br>';
        echo 'Num DOC: '.$sancao->getNumDoc().'<br>';
        echo 'Quant. Dias: '.$sancao->getQtdDias().'<br>';
        echo 'Data de Lançamento: '.$sancao->getDataLancamento().'<br>';
        echo 'Data de Sanção: '.$sancao->getDataSancao().'<br>';
        
        $sancaoDAO = new SancaoDAO();
        $sancaoDAO->editarSancao($sancao);
        
        header("Location:controlerSancao.php?opcao=6&pagina=1");
    }
    
    //Cadastrar sanção
    if ($opcao == 4){
        $sancao = new Sancao();
        $sancao->setIdFuncionario((int) $_REQUEST["idFuncionario"]);
        $sancao->setIdUsuario($_SESSION['usuario']->idUsuario);
        $sancao->setIdTipo((int)$_REQUEST["idTipo"]);
        $sancao->setDataSancao($_REQUEST["dataSancao"]);
                
        $dataSancao = date('Y-m-d H:i:s',strtotime($_REQUEST["dataSancao"]));      
        $sancao->setDataSancao($dataSancao);
        
        $sancao->setQtdDias($_REQUEST['qtdDias']);
        $sancao->setMotivo($_REQUEST['motivo']);
        $sancao->setNumDoc($_REQUEST['numDoc']);
        date_default_timezone_set('America/Sao_Paulo');
        $sancao->setDataLancamento(date('Y-m-d H:i:s'));
                
        echo 'Funcionário: '.$sancao->getIdFuncionario().'<br>';
        echo 'Usuario: '.$sancao->getIdUsuario().'<br>';
        echo 'ID Tipo de Sanção: '.$sancao->getIdTipo().'<br>';
        echo 'Motivo: '.$sancao->getMotivo().'<br>';
        echo 'Num DOC: '.$sancao->getNumDoc().'<br>';
        echo 'Quant. Dias: '.$sancao->getQtdDias().'<br>';
        echo 'Data de Lançamento: '.$sancao->getDataLancamento().'<br>';
        echo 'Data de Sanção: '.$sancao->getDataSancao().'<br>';
        
        $sancaoDAO = new SancaoDAO();
        $sancaoDAO->incluirSancao($sancao);
        
        header("Location:controlerSancao.php?opcao=6&pagina=1");
    }
    
    //Exclui sanção
    if ($opcao == 5) {
        $sancao = new Sancao();
        $sancao->setIdSancao((int) $_REQUEST['idSancao']);
        
        $sancaoDAO = new SancaoDAO();
        $sancaoDAO->excluirSancao($sancao);
        header("Location:controlerSancao.php?opcao=6&pagina=1");
    }
    
    //Sanções paginado
    if($opcao == 6) {
        $sancaoDAO = new SancaoDAO();
        $funcionarioDAO = new FuncionarioDAO();
        $usuarioDAO = new UsuarioDAO();
        $secaoDAO = new SecaoDAO();
        $divisaoDAO = new DivisaoDAO();
        $gerenciaDAO = new GerenciaDAO();
        $pagina = (int) $_REQUEST['pagina'];
        
        $lista = $sancaoDAO->getSancoesPaginacao($pagina);
        $numpaginas = $sancaoDAO->getPagina();
        $listaUsuarios = $usuarioDAO->getUsuarios();
        $listaSecoes = $secaoDAO->getSecoes();
        $listaDivisoes = $divisaoDAO->getDivisoes();
        $listaGerencias = $gerenciaDAO->getGerencias();
        $_SESSION['usuarios'] = $listaUsuarios;       
        $_SESSION['sancoes'] = $lista;
        $_SESSION['funcionarios'] = $funcionarioDAO->getFuncionarios();
        
        header("Location: ../View/Sancao/ListaSancoesPagina.php?paginas=".$numpaginas);
    }
    