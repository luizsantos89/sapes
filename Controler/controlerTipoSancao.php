<?php
    session_start();
    
    require '../includes/conexao.inc';
    require '../Model/SancaoDAO.php';
    require '../Model/UsuarioDAO.php'; 
    require '../Model/TipoSancaoDAO.php'; 
    
    if(!isset($_REQUEST['opcao'])) {
        Header("location:../index.php");
    }
    
    $opcao = (int)$_REQUEST['opcao'];
    
    //Lista todos tipos de sanção
    if($opcao == 1){
        $tiposSancaoDAO = new TipoSancaoDAO();
        $usuarioDAO = new UsuarioDAO();
        $listaTipos = $tiposSancaoDAO->getTipoSancoes();
        $listaUsuarios = $usuarioDAO->getUsuarios();
        $_SESSION['tipoSancoes'] = $listaTipos;
        header("Location:../View/TipoSancao/ListaTipoSancoes.php");
    }    
    
    //Lista tipo de sanção por ID
    if($opcao == 2){
        $idTipoSancao = $_REQUEST["idTipoSancao"];                
        $tipoSancaoDAO = new TipoSancaoDAO();
        $_SESSION['tipoSancao'] =  $tipoSancaoDAO->getTipoSancaoById($idTipoSancao);
        echo $idTipoSancao;
        header("Location:../View/TipoSancao/EditaTipoSancao.php");
    }
    
    //Editar tipo de sanção
    if($opcao == 3){
        $tipoSancao = new TipoSancao();
        $tipoSancao->setIdTipo((int) $_REQUEST['idTipo']);
        $tipoSancao->setDescricao($_REQUEST['descricao']);
        $tipoSancao->setPeso((int) $_REQUEST['peso']);
        
                
        echo 'Tipo de Sanção: '.$tipoSancao->getIdTipo().'<br>';
        echo 'Descrição: '.$tipoSancao->getDescricao().'<br>';
        echo 'Peso: '.$tipoSancao->getPeso().'<br>';
        
        $tipoSancaoDAO = new TipoSancaoDAO();
        $tipoSancaoDAO->editarTipoSancao($tipoSancao);
        
        header("Location:controlerTipoSancao.php?opcao=1");
    }
    
    //Cadastrar funcionario
    if ($opcao == 4){
        $tipoSancao = new TipoSancao();
        $tipoSancao->setDescricao($_REQUEST['descricao']);
        $tipoSancao->setPeso((int) $_REQUEST['peso']);
        $tipoSancao->setIdUsuario((int) $_REQUEST['idUsuario']);
        $tipoSancao->setDataCadastro(date('Y:m:d H:i:s'));
        
                
        echo 'Descrição: '.$tipoSancao->getDescricao().'<br>';
        echo 'Peso: '.$tipoSancao->getPeso().'<br>';
        echo 'Usuário: '.$tipoSancao->getIdUsuario().'<br>';
        echo 'Data de Cadastro: '.$tipoSancao->getDataCadastro().'<br>';
        
        $tipoSancaoDAO = new TipoSancaoDAO();
        $tipoSancaoDAO->incluirTipoSancao($tipoSancao);
        
        header("Location:controlerTipoSancao.php?opcao=1");
    }
    
    //Exclui sanção
    if ($opcao == 5) {
        $tipoSancao = new TipoSancao();
        $tipoSancao->setIdTipo((int) $_REQUEST['idTipoSancao']);
        
        echo $tipoSancao->getIdTipo();
        
        
        $tipoSancaoDAO = new TipoSancaoDAO();
        $tipoSancaoDAO->excluirTipoSancao($tipoSancao);
        header("Location:controlerTipoSancao.php?opcao=1");
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
        $_SESSION['secoes'] = $listaSecoes;
        $_SESSION['divisoes'] = $listaDivisoes;
        $_SESSION['gerencias'] = $listaGerencias;        
        $_SESSION['sancoes'] = $lista;
        
        header("Location: ../View/Sancao/ListaSancoesPagina.php?paginas=".$numpaginas);
    }
    