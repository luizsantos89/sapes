<?php    
    session_start();
    
    require('../includes/conexao.inc');
    require('../Model/FuncionarioDAO.php');  
    require('../Model/UsuarioDAO.php');
    require('../Model/AbsenteismoDAO.php');
    
    
    $usuario = $_SESSION['usuario'];
    
    if(!isset($_REQUEST['opcao'])) {
        Header("location:../index.php");
    }
    
    $opcao = (int)$_REQUEST['opcao'];
    
    //Lista todos os lançamentos de horas de absenteísmo
    if($opcao == 1){
        
        if(isset($_SESSION['filtroPorPeriodo'])) {
            unset($_SESSION['filtroPorPeriodo']);
        }
        
        $absenteismoDAO = new AbsenteismoDAO();        
        $funcionarioDAO = new FuncionarioDAO();
        $usuarioDAO = new UsuarioDAO();
        $listaAbsenteismo = $absenteismoDAO->getAbsenteismo();
        $listaFuncionarios = $funcionarioDAO->getFuncionarios();
        $listaUsuarios = $usuarioDAO->getUsuarios();
        $_SESSION['funcionarios'] = $listaFuncionarios;
        $_SESSION['usuarios'] = $listaUsuarios;
        $_SESSION['absenteismo'] = $listaAbsenteismo;
        
        header("Location:../View/Absenteismo/ListagemGeral.php");
        
    }    
    
    //Lista absenteísmo por ID
    if($opcao == 2){
        $idAbsenteismo = $_REQUEST["idAbsenteismo"];                
        $absenteismoDAO = new AbsenteismoDAO();
        $absenteismo = new Absenteismo();
        $absenteismo =  $absenteismoDAO->getAbsenteismoById($idAbsenteismo);
        
        echo 'Funcionário: '.$absenteismo->idFuncionario.'<br>';
        echo 'Usuário: '.$absenteismo->idUsuario.'<br>';
        echo 'Qtd Horas: '.$absenteismo->qtdHoras.'<br>';
        echo 'Período: '.$absenteismo->mes.'/'.$absenteismo->ano.'<br>';
        if($absenteismo->mes < 7) {
            echo '<b>Período: </b> Primeiro Semestre de '.$absenteismo->ano;
        } else {
            echo '<b>Período: </b> Segundo Semestre de '.$absenteismo->ano;
        }
        
        $_SESSION['absenteismo'] = $absenteismo;
        
        header("Location:../View/Absenteismo/EditaAbsenteismo.php");
    }
    
    //Editar absenteísmo
    if($opcao == 3){
        $absenteismo = new Absenteismo();
        $absenteismo->setIdAbsenteismo((int) $_REQUEST['idAbsenteismo']);
        $qtdHoras = str_replace(",",".",$_REQUEST['qtdHoras']);
        $absenteismo->setQtdHoras($qtdHoras);
        
        echo $qtdHoras;
        
        $absenteismo->setMes((int) $_REQUEST['mes']);
        $absenteismo->setAno((int) $_REQUEST['ano']);
        
        $absenteismoDAO = new AbsenteismoDAO();
        $absenteismoDAO->editarAbsenteismo($absenteismo);
        
        header("Location:controlerAbsenteismo.php?opcao=1");
    }
    
    //Cadastrar funcionario
    if ($opcao == 4){              
        $absenteismo = new Absenteismo();
        $absenteismo->setIdFuncionario((int) $_REQUEST['idFuncionario']);
        $absenteismo->setIdUsuario((int) $_REQUEST['idUsuario']);
        $qtdHoras = str_replace(",",".",$_REQUEST['qtdHoras']);
        $absenteismo->setQtdHoras($qtdHoras);
        $absenteismo->setMes((int) $_REQUEST['mes']);
        $absenteismo->setAno((int) $_REQUEST['ano']);
        date_default_timezone_set('America/Sao_Paulo');
        $absenteismo->setDataLancamento(date('Y-m-d H:i:s'));
        
        $absenteismoDAO = new AbsenteismoDAO();
                
        $listaAbsenteismoFunc = $absenteismoDAO->getAbsenteismoFunc($absenteismo);
        
        foreach($listaAbsenteismoFunc as $absent) {
            if(($absent->mes == $absenteismo->getMes()) && ($absent->ano == $absenteismo->getAno())){
                header("Location: ../View/Absenteismo/LancaAbsenteismo.php?erro");
                $erro = true;
            }
        }
                
        if ($erro == $false) {
            $absenteismoDAO->incluirAbsenteismo($absenteismo);
            header("Location:controlerAbsenteismo.php?opcao=1");
        }
    }
    
    //Exclui absenteísmo
    if ($opcao == 5) {
        $absenteismo = new Absenteismo();
        $absenteismo->setIdAbsenteismo((int) $_REQUEST['idAbsenteismo']);
        
        $absenteismoDAO = new AbsenteismoDAO();
        $absenteismoDAO->excluirAbsenteismo($absenteismo);
        
        header("Location:controlerAbsenteismo.php?opcao=1");
    }
    
    //Absenteísmo paginado
    if($opcao == 6) {
        $funcionarioDAO = new FuncionarioDAO();
        $usuarioDAO = new UsuarioDAO();
        $secaoDAO = new SecaoDAO();
        $divisaoDAO = new DivisaoDAO();
        $gerenciaDAO = new GerenciaDAO();
        $pagina = (int) $_REQUEST['pagina'];
        
        $lista = $funcionarioDAO->getFuncionariosPaginacao($pagina);
        $numpaginas = $funcionarioDAO->getPagina();
        $listaUsuarios = $usuarioDAO->getUsuarios();
        $listaSecoes = $secaoDAO->getSecoes();
        $listaDivisoes = $divisaoDAO->getDivisoes();
        $listaGerencias = $gerenciaDAO->getGerencias();
        $_SESSION['usuarios'] = $listaUsuarios;
        $_SESSION['secoes'] = $listaSecoes;
        $_SESSION['divisoes'] = $listaDivisoes;
        $_SESSION['gerencias'] = $listaGerencias;
        
        $_SESSION['funcionarios'] = $lista;
        
        header("Location: ../View/Funcionario/ListaFuncionarioPagina.php?paginas=".$numpaginas);
    }
    
    if($opcao == 7) {
        $mes = $_REQUEST['mes'];
        $ano = $_REQUEST['ano'];
        $absenteismoDAO = new AbsenteismoDAO();        
        $funcionarioDAO = new FuncionarioDAO();
        $usuarioDAO = new UsuarioDAO();
        
        echo 'mes: '.$mes.'<br>ano: '.$ano;
        
        $listaAbsenteismo = $absenteismoDAO->getAbsenteismoPeriodo($mes,$ano);
        $listaFuncionarios = $funcionarioDAO->getFuncionarios();
        $listaUsuarios = $usuarioDAO->getUsuarios();
        $_SESSION['funcionarios'] = $listaFuncionarios;
        $_SESSION['usuarios'] = $listaUsuarios;
        $_SESSION['absenteismo'] = $listaAbsenteismo;
        $_SESSION['filtroPorPeriodo'] = 0;
        header("Location:../View/Absenteismo/ListagemGeral.php");
    }