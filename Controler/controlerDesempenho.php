<?php    
    session_start();
    
    require('../includes/conexao.inc');
    require('../Model/FuncionarioDAO.php');  
    require('../Model/UsuarioDAO.php');
    require('../Model/DesempenhoDAO.php');
    
    
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
        
        $desempenhoDAO = new DesempenhoDAO();     
        $funcionarioDAO = new FuncionarioDAO();
        $usuarioDAO = new UsuarioDAO();
        
        $listaDesempenho = $desempenhoDAO->getDesempenhos();
        
        $listaFuncionarios = $funcionarioDAO->getFuncionarios();
        $listaUsuarios = $usuarioDAO->getUsuarios();
        $_SESSION['funcionarios'] = $listaFuncionarios;
        $_SESSION['usuarios'] = $listaUsuarios;
        $_SESSION['notasDesempenho'] = $listaDesempenho;
        header("Location:../View/Desempenho/ListagemGeral.php");
    }    
    
    //Lista absenteísmo por ID
    if($opcao == 2){
        $idDesempenho = $_REQUEST["idDesempenho"];                
        $desempenhoDAO = new DesempenhoDAO();
        $desempenho = new Desempenho();
        $desempenho =  $desempenhoDAO->getDesempenhoById($idDesempenho);
        
        echo 'Funcionário: '.$desempenho->idFuncionario.'<br>';
        echo 'Usuário: '.$desempenho->idUsuario.'<br>';
        echo 'Nota: '.$desempenho->nota.'<br>';
        echo 'Período: '.$desempenho->semestre.'/'.$desempenho->ano.'<br>';
        
        $_SESSION['desempenho'] = $desempenho;
        
        header("Location:../View/Desempenho/EditaDesempenho.php");
    }
    
    //Editar absenteísmo
    if($opcao == 3){
        $desempenho = new Desempenho();
        $desempenho->setIdDesempenho((int) $_REQUEST['idDesempenho']);
        $nota = str_replace(",",".",$_REQUEST['nota']);
        $desempenho->setNota($nota);
        
        echo $nota;
        
        $desempenho->setSemestre((int) $_REQUEST['semestre']);
        $desempenho->setAno((int) $_REQUEST['ano']);
        
        $desempenhoDAO = new DesempenhoDAO();
        $desempenhoDAO->editarDesempenho($desempenho);
        
        header("Location:controlerDesempenho.php?opcao=1");
    }
    
    //Cadastrar desempenho
    if ($opcao == 4){              
        $desempenho = new Desempenho();
        $desempenho->setIdFuncionario((int) $_REQUEST['idFuncionario']);
        $desempenho->setIdUsuario((int) $_REQUEST['idUsuario']);
        $nota = str_replace(",",".",$_REQUEST['nota']);
        $desempenho->setNota($nota);
        $desempenho->setSemestre((int) $_REQUEST['semestre']);
        $desempenho->setAno((int) $_REQUEST['ano']);
        date_default_timezone_set('America/Sao_Paulo');
        $desempenho->setDataLancamento(date('Y-m-d H:i:s'));
        
        $desempenhoDAO = new DesempenhoDAO();
        $desempenhoDAO->incluirDesempenho($desempenho);
                
        header("Location:controlerDesempenho.php?opcao=1");
    }
    
    //Exclui desempenho
    if ($opcao == 5) {
        $desempenho = new Desempenho();
        $desempenho->setIdDesempenho((int) $_REQUEST['idDesempenho']);
        
        $desempenhoDAO = new DesempenhoDAO();
        $desempenhoDAO->excluirDesempenho($desempenho);
        
        header("Location:controlerDesempenho.php?opcao=1");
    }
    
    //Desempenho paginado
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
    
    
    //Lista notas por período (SEMESTRE/ANO)
    if($opcao == 7) {
        $semestre = $_REQUEST['semestre'];
        $ano = $_REQUEST['ano'];
        
        $desempenhoDAO = new DesempenhoDAO();      
        $funcionarioDAO = new FuncionarioDAO();
        $usuarioDAO = new UsuarioDAO();
        
        echo 'semestre: '.$semestre.'<br>ano: '.$ano;
        
        $listaDesempenho = $desempenhoDAO->getDesempenhosPeriodo($semestre, $ano);
        
        
        $listaFuncionarios = $funcionarioDAO->getFuncionarios();
        $listaUsuarios = $usuarioDAO->getUsuarios();
        $_SESSION['funcionarios'] = $listaFuncionarios;
        $_SESSION['usuarios'] = $listaUsuarios;
        $_SESSION['notasDesempenho'] = $listaDesempenho;
        $_SESSION['filtroPorPeriodo'] = 0;
        header("Location:../View/Desempenho/ListagemGeral.php");
    }