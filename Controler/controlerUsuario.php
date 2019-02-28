<?php    
    session_start();
    
    require('../includes/conexao.inc');
    require('../Model/FuncionarioDAO.php');  
    require('../Model/UsuarioDAO.php');
    require('../Model/SecaoDAO.php');
    require('../Model/DivisaoDAO.php');
    require('../Model/GerenciaDAO.php');
    require('../Model/AbsenteismoDAO.php');
    require('../Model/DesempenhoDAO.php');
    require('../Model/SancaoDAO.php');
    require('../Model/TipoSancaoDAO.php');
    require('../Model/AproveitamentoDAO.php');
    
    //controlerFuncionario?opcao=6&pagina=1
    
    $usuario = $_SESSION['usuario'];
    
    if(!isset($_REQUEST['opcao'])) {
        Header("location:../index.php");
    }
    
    $opcao = (int)$_REQUEST['opcao'];
    
    //Lista todos os usuarios
    if($opcao == 1){
        $funcionarioDAO = new FuncionarioDAO();
        $usuarioDAO = new UsuarioDAO();
        $listaUsuarios = $usuarioDAO->getUsuarios();
        $_SESSION['usuarios'] = $listaUsuarios;
        header("Location:../View/Usuario/ListaUsuario.php");
    }    
    
    //Lista funcionario por ID
    if($opcao == 2){
        $idUsuario = $_REQUEST["idUsuario"];                
        $usuarioDAO = new UsuarioDAO();
        $_SESSION['EditUsuario'] =  $usuarioDAO->getUsuarioById($idUsuario);
        header("Location:../View/Usuario/EditaUsuario.php");
    }
    
    //Editar usuário
    if($opcao == 3){
        $usuario = new Usuario();       
        $usuario->setNome($_REQUEST["nome"]);
        $usuario->setLogin($_REQUEST["login"]);
        $usuario->setIdTipoUsuario((int) $_REQUEST["idTipoUsuario"]);   
        $usuario->setIdUsuario((int) $_REQUEST['idUsuario']);
        
        echo 'Usuário: '.$usuario->getNome().'<br>';
        echo 'Login: '.$usuario->getLogin().'<br>';
        echo 'Id Tipo Usuário: '.$usuario->getIdTipoUsuario().'<br>';
        echo 'Id Usuário: '.$usuario->getIdUsuario().'<br>';
        
        $usuarioDAO = new UsuarioDAO();
        $usuarioDAO->editarUsuario($usuario);
        header("Location:controlerUsuario.php?opcao=1");
    }
    
    //Cadastrar usuário
    if ($opcao == 4){
        $usuario = new Usuario();       
        $usuario->setNome($_REQUEST["nome"]);
        $usuario->setLogin($_REQUEST["login"]);
        $usuario->setIdTipoUsuario($_REQUEST["idTipoUsuario"]);        
         
        $usuario->setSenha(md5("imbel@123"));
                
        $usuarioDAO = new UsuarioDAO();
        $usuarioDAO->novoUsuario($usuario);
        header("Location:controlerUsuario.php?opcao=1");
    }
    
    //Exclui usuário
    if ($opcao == 5) {
        $user = new Usuario();
        $user->setIdUsuario((int) $_REQUEST['idUsuario']);
        
        $erroExclusao = false;
        
        $absenteismoDAO = new AbsenteismoDAO();
        $listaAbsenteismo = $absenteismoDAO->getAbsenteismo();
        
        foreach ($listaAbsenteismo as $absenteismo) {
            if($absenteismo->idUsuario == $user->getIdUsuario()) {
                $erroExclusao = true;
            }
        }
        
        $desempenhoDAO = new DesempenhoDAO();
        $notasDesempenho = $desempenhoDAO->getDesempenhos();
        
        foreach ($notasDesempenho as $desempenho) {
            if($desempenho->idUsuario == $user->getIdUsuario()) {
                $erroExclusao = true;
            }
        }
        
        $sancaoDAO = new SancaoDAO();
        $sancoes = $sancaoDAO->getSancoes();
        
        foreach ($sancoes as $sancao) {
            if($sancao->idUsuario  == $user->getIdUsuario()) {
                $erroExclusao = true;
            }
        }
        
        echo 'Id Usuário: '.$user->getIdUsuario().'<br>';
                
        if($erroExclusao == true) {
            $_SESSION["erroExclusao"] = true;
            header("Location:controlerUsuario.php?opcao=1");
        } else {        
            echo 'excluído';
            $usuarioDAO = new UsuarioDAO();
            $usuarioDAO->excluiUsuario($user);
            header("Location:controlerUsuario.php?opcao=1");
        }
    }
    
    if ($opcao == 6) {
        $idUsuario = (int) $_REQUEST['idUsuario'];
        
        $usuarioDAO = new UsuarioDAO();
        $usuarioDAO->resetaSenha($idUsuario);
        
        $_SESSION['resetSenha'] = true;
        
        header("Location:controlerUsuario.php?opcao=1");
    }