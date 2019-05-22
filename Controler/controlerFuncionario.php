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
    
    //Lista todos os funcionarios
    if($opcao == 1){
        unset($_SESSION['funcionarios']);
        unset($_SESSION['usuarios']);
        unset($_SESSION['secoes']);
        unset($_SESSION['divisoes']);
        unset($_SESSION['gerencias']);
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
        $dataNascimento = $_REQUEST["dataNascimento"];
        $sexo = $_REQUEST["sexo"];
        $diaNascimento = substr($dataNascimento, 0, 2);
        $mesNascimento = substr($dataNascimento, 3, 2);
        $anoNascimento = substr($dataNascimento, 6, 4);
        $dataAdmissao = $_REQUEST["dataAdmissao"];
        $diaAdmissao = substr($dataAdmissao, 0, 2);
        $mesAdmissao = substr($dataAdmissao, 3, 2);
        $anoAdmissao = substr($dataAdmissao, 6, 4);
        $dataAdmissao = $anoAdmissao.'-'.$mesAdmissao.'-'.$diaAdmissao;
        $dataNascimento = $anoNascimento.'-'.$mesNascimento.'-'.$diaNascimento;
        //$dataAdmissao = date('Y-m-d H:i:s',strtotime($_REQUEST["dataAdmissao"]));      
        $funcionario->setDataAdmissao($dataAdmissao);
        $funcionario->setSituacao($_REQUEST["situacao"]);
        $funcionario->setIdSecao($_REQUEST['idSecao']);
        $funcionario->setFuncAtivo($_REQUEST["funcAtivo"]);
        $funcionario->setDataNascimento($dataNascimento);
        $funcionario->setSexo($sexo);
        if($funcionario->getFuncAtivo()==0) {
            date_default_timezone_set('America/Sao_Paulo');
            $funcionario->setDataInativacao(date('Y-m-d H:i:s'));
        } else {
            $funcionario->setDataInativacao("0000-00-00 00:00:00");
        }
        
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
        $funcionario->setDataAdmissao($_REQUEST["dataAdmissao"]);
        $funcionario->setSituacao($_REQUEST["funcAtivo"]);
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
        $funcionario->setDataNascimento($_REQUEST["dataNascimento"]);
        $funcionario->setSexo($_REQUEST["sexo"]);
        
        echo 'Cargo: '.$funcionario->getCargo().'<br>';
        echo 'Crachá: '.$funcionario->getCracha().'<br>';
        echo 'Data de Admissão: '.$funcionario->getDataAdmissao().'<br>';
        echo 'Data de Nascimento: '.$funcionario->getDataNascimento().'<br>';
        echo 'Data de Inativação: '.$funcionario->getDataInativacao().'<br>';
        echo 'Ativo? '.$funcionario->getFuncAtivo().'<br>';
        echo 'Usuário '.$funcionario->getIdUsuario().'<br>';
        echo 'Seção: '.$funcionario->getIdSecao().'<br>';
        echo 'Nome: '.$funcionario->getNome().'<br>';
        echo 'Situação: '.$funcionario->getSituacao().'<br>';
                
        $funcionarioDAO = new FuncionarioDAO();
        $funcionarioDAO->incluirFuncionario($funcionario);
        echo "insert into funcionario (idUsuario, idSecao, nome, cargo, situacao, dataAdmissao, cracha, dataCadastro, funcAtivo, dataInativacao, cargaHoraria, sexo, dataNascimento) "
        . "values (1,30, 'Antonio da Silva Filho A', 'teste', 1, '2019-20-05', 120, '2019-20-05', 1, '0000-00-00', 44, 'masculino', '1989-07-02')";
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
        unset($_SESSION['funcionarios']);
        unset($_SESSION['usuarios']);
        unset($_SESSION['secoes']);
        unset($_SESSION['divisoes']);
        unset($_SESSION['gerencias']);
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
        unset($_SESSION['funcionarios']);
        unset($_SESSION['usuarios']);
        unset($_SESSION['secoes']);
        unset($_SESSION['divisoes']);
        unset($_SESSION['gerencias']);
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
    
    //Lista funcionários por divisão
    if($opcao == 8) {
        unset($_SESSION['funcionarios']);
        unset($_SESSION['usuarios']);
        unset($_SESSION['secoes']);
        unset($_SESSION['divisoes']);
        unset($_SESSION['gerencias']);
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
        unset($_SESSION['funcionarios']);
        unset($_SESSION['usuarios']);
        unset($_SESSION['secoes']);
        unset($_SESSION['divisoes']);
        unset($_SESSION['gerencias']);
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
        unset($_SESSION['funcionarios']);
        unset($_SESSION['usuarios']);
        unset($_SESSION['secoes']);
        unset($_SESSION['divisoes']);
        unset($_SESSION['gerencias']);
        $idFuncionario = $_REQUEST["idFuncionario"];                
        $funcionarioDAO = new FuncionarioDAO();
        $usuarioDAO = new UsuarioDAO();
        $secaoDAO = new SecaoDAO();
        $divisaoDAO = new DivisaoDAO();
        $gerenciaDAO = new GerenciaDAO();
        $absenteismoDAO = new AbsenteismoDAO();
        $desempenhoDAO = new DesempenhoDAO();
        $sancaoDAO = new SancaoDAO();
        $tipoSancaoDAO = new TipoSancaoDAO();
        $aproveitamentoDAO = new AproveitamentoDAO();
        $listaUsuarios = $usuarioDAO->getUsuarios();
        $listaSecoes = $secaoDAO->getSecoes();
        $listaDivisoes = $divisaoDAO->getDivisoes();
        $listaGerencias = $gerenciaDAO->getGerencias();
        $listaAbsenteismo = $absenteismoDAO->getAbsenteismo();
        $listaDesempenho = $desempenhoDAO->getDesempenhos();
        $listaSancoes = $sancaoDAO->getSancoes();
        $listaTipos = $tipoSancaoDAO->getTipoSancoes();
        $listaAproveitamento = $aproveitamentoDAO->getAproveitamento();
        $_SESSION['funcionario'] =  $funcionarioDAO->getFuncionarioByID($idFuncionario);
        $_SESSION['usuarios'] = $listaUsuarios;
        $_SESSION['secoes'] = $listaSecoes;
        $_SESSION['divisoes'] = $listaDivisoes;
        $_SESSION['gerencias'] = $listaGerencias;
        $_SESSION['notasDesempenho'] = $listaDesempenho;
        $_SESSION['sancoes'] = $listaSancoes;
        $_SESSION['tipoSancoes'] = $listaTipos;
        $_SESSION['absenteismo'] = $listaAbsenteismo;
        $_SESSION['aproveitamento'] = $listaAproveitamento;
        header("Location:../View/Funcionario/DetalhesFuncionario.php");
    }
    
    //Lista funcionários por cargo
    if($opcao == 11) {
        unset($_SESSION['funcionarios']);
        unset($_SESSION['usuarios']);
        unset($_SESSION['secoes']);
        unset($_SESSION['divisoes']);
        unset($_SESSION['gerencias']);
        $cargo = $_REQUEST['cargo'];
        $funcionarioDAO = new FuncionarioDAO();
        $usuarioDAO = new UsuarioDAO();
        $secaoDAO = new SecaoDAO();
        $divisaoDAO = new DivisaoDAO();
        $gerenciaDAO = new GerenciaDAO();
        echo $cargo;
        $listaFuncionarios = $funcionarioDAO->getFuncionarioByCargo($cargo);
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
    
     