<?php    
    session_start();
    
    require('../includes/conexao.inc');
    require('../Model/FuncionarioDAO.php');  
    require('../Model/UsuarioDAO.php');
    require('../Model/SecaoDAO.php');
    require('../Model/DivisaoDAO.php');
    require('../Model/GerenciaDAO.php');
    
    
    $usuario = $_SESSION['usuario'];
    $sancoes = $_SESSION['sancoes'];
    $listaAbsenteismo = $_SESSION['absenteismo'];
    $notasDesempenho = $_SESSION['notasDesempenho'];
    $sancoes = $_SESSION['sancoes'];
    
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
        $funcionario->setCargaHoraria((int) ($_REQUEST["cargaHoraria"]));
        
        $dataAdmissao = date('Y-m-d H:i:s',strtotime($_REQUEST["dataAdmissao"]));      
        $funcionario->setDataAdmissao($dataAdmissao);
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
        
        
        
        header("Location:controlerFuncionario.php?opcao=6&pagina=1");
    }
    
    //Cadastrar funcionario
    if ($opcao == 4){
        $funcionario = new Funcionario();       
        $funcionario->setNome($_REQUEST["nome"]);
        $funcionario->setCracha($_REQUEST["cracha"]);
        $funcionario->setCargo($_REQUEST["cargo"]);        
        $dataAdmissao = date('Y-m-d H:i:s',strtotime($_REQUEST["dataAdmissao"]));      
        $funcionario->setDataAdmissao($dataAdmissao);
        $funcionario->setSituacao($_REQUEST["situacao"]);
        $funcionario->setIdSecao((int)$_REQUEST['idSecao']);
        $funcionario->setIdUsuario((int) $usuario->idUsuario);
        $funcionario->setFuncAtivo($_REQUEST["funcAtivo"]);
        $funcionario->setCargaHoraria((int) ($_REQUEST["cargaHoraria"]));
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
        echo 'Usuário '.$funcionario->getIdUsuario().'<br>';
        echo 'Seção: '.$funcionario->getIdSecao().'<br>';
        echo 'Nome: '.$funcionario->getNome().'<br>';
        echo 'Situação: '.$funcionario->getSituacao().'<br>';
                
        $funcionarioDAO = new FuncionarioDAO();
        $funcionarioDAO->incluirFuncionario($funcionario);
        header("Location:controlerFuncionario.php?opcao=1");
    }
    
    //Exclui funcionário
    if ($opcao == 5) {
        $funcionario = new Funcionario();
        $funcionario->setIdFuncionario((int) $_REQUEST['idFuncionario']);
        
        foreach ($listaAbsenteismo as $absenteismo) {
            if($absenteismo->idFuncionario == $funcionario->getIdFuncionario()) {
                $_SESSION['erroExclusao'] = true;
            }
        }
        
        foreach ($notasDesempenho as $desempenho) {
            if($desempenho->idFuncionario == $funcionario->getIdFuncionario()) {
                $_SESSION['erroExclusao'] = true;
            }
        }
        
        foreach ($sancoes as $sancao) {
            if($sancao->idFuncionario == $funcionario->getIdFuncionario()) {
                $_SESSION['erroExclusao'] = true;
            }
        }
        
        if(isset($_SESSION['erroExclusao'])) {
            header("Location:controlerFuncionario.php?opcao=1");
        } else {        
            $funcionarioDAO = new FuncionarioDAO();
            $funcionarioDAO->excluiFuncionario($funcionario);
            header("Location:controlerFuncionario.php?opcao=1");
        }
    }
    
    //Funcionario paginado
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
    
    //Lista funcionários por seção
    if($opcao == 7) {
        $idSecao = $_REQUEST['idSecao'];
        $funcionarioDAO = new FuncionarioDAO();
        $usuarioDAO = new UsuarioDAO();
        $secaoDAO = new SecaoDAO();
        $divisaoDAO = new DivisaoDAO();
        $gerenciaDAO = new GerenciaDAO();
        echo $idSecao;
        echo '<br>';
        echo $qtdFuncPorSecao;
        $listaFuncionarios = $funcionarioDAO->getFuncionariosBySecao($idSecao);
        $listaUsuarios = $usuarioDAO->getUsuarios();
        $listaSecoes = $secaoDAO->getSecoes();
        $listaDivisoes = $divisaoDAO->getDivisoes();
        $listaGerencias = $gerenciaDAO->getGerencias();
        $_SESSION['funcionarios'] = $listaFuncionarios;
        $_SESSION['usuarios'] = $listaUsuarios;
        $_SESSION['secoes'] = $listaSecoes;
        $_SESSION['porSecao'] = 0;
        $_SESSION['divisoes'] = $listaDivisoes;
        $_SESSION['gerencias'] = $listaGerencias;
        header("Location:../View/Funcionario/ListaFuncionario.php");
    }
    
    //Lista funcionários por seção
    if($opcao == 8) {
        $idDivisao = $_REQUEST['idDivisao'];
        $funcionarioDAO = new FuncionarioDAO();
        $usuarioDAO = new UsuarioDAO();
        $secaoDAO = new SecaoDAO();
        $divisaoDAO = new DivisaoDAO();
        $gerenciaDAO = new GerenciaDAO();
        echo $idDivisao;
        $listaFuncionarios = $funcionarioDAO->getFuncionarioByDivisao($idDivisao);
        $listaUsuarios = $usuarioDAO->getUsuarios();
        $listaSecoes = $secaoDAO->getSecoes();
        $listaDivisoes = $divisaoDAO->getDivisoes();
        $listaGerencias = $gerenciaDAO->getGerencias();
        $_SESSION['funcionarios'] = $listaFuncionarios;
        $_SESSION['usuarios'] = $listaUsuarios;
        $_SESSION['secoes'] = $listaSecoes;
        $_SESSION['divisoes'] = $listaDivisoes;
        $_SESSION['porSecao'] = 0;
        $_SESSION['gerencias'] = $listaGerencias;
        header("Location:../View/Funcionario/ListaFuncionario.php");
    }
    
    //Lista funcionários por gerência
    if($opcao == 9) {
        $idGerencia = $_REQUEST['idGerencia'];
        $funcionarioDAO = new FuncionarioDAO();
        $usuarioDAO = new UsuarioDAO();
        $secaoDAO = new SecaoDAO();
        $divisaoDAO = new DivisaoDAO();
        $gerenciaDAO = new GerenciaDAO();
        echo $idGerencia;
        $listaFuncionarios = $funcionarioDAO->getFuncionarioByGerencia($idGerencia);
        $listaUsuarios = $usuarioDAO->getUsuarios();
        $listaSecoes = $secaoDAO->getSecoes();
        $listaDivisoes = $divisaoDAO->getDivisoes();
        $listaGerencias = $gerenciaDAO->getGerencias();
        $_SESSION['funcionarios'] = $listaFuncionarios;
        $_SESSION['usuarios'] = $listaUsuarios;
        $_SESSION['secoes'] = $listaSecoes;
        $_SESSION['porSecao'] = 0;
        $_SESSION['divisoes'] = $listaDivisoes;
        $_SESSION['gerencias'] = $listaGerencias;
        header("Location:../View/Funcionario/ListaFuncionario.php");
    }
    
     
    
    //Lista funcionario por ID
    if($opcao == 10){
        $idFuncionario = $_REQUEST["idFuncionario"];                
        $funcionarioDAO = new FuncionarioDAO();
        $usuarioDAO = new UsuarioDAO();
        $secaoDAO = new SecaoDAO();
        $divisaoDAO = new DivisaoDAO();
        $gerenciaDAO = new GerenciaDAO();
        $listaUsuarios = $usuarioDAO->getUsuarios();
        $listaSecoes = $secaoDAO->getSecoes();
        $listaDivisoes = $divisaoDAO->getDivisoes();
        $listaGerencias = $gerenciaDAO->getGerencias();
        $_SESSION['funcionario'] =  $funcionarioDAO->getFuncionarioByID($idFuncionario);
        $_SESSION['usuarios'] = $listaUsuarios;
        $_SESSION['secoes'] = $listaSecoes;
        $_SESSION['divisoes'] = $listaDivisoes;
        $_SESSION['gerencias'] = $listaGerencias;
        header("Location:../View/Funcionario/DetalhesFuncionario.php");
    }