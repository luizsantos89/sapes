<?php    
    session_start();
    
    require('../includes/conexao.inc');
    require('../Model/FuncionarioDAO.php');  
    require('../Model/UsuarioDAO.php');
    require('../Model/AbsenteismoDAO.php');
    require('../Model/AproveitamentoDAO.php');
    require('../Model/DesempenhoDAO.php');
    require('../Model/SancaoDAO.php');
    require('../Model/TipoSancaoDAO.php');
    
    
    $usuario = $_SESSION['usuario'];
    
    if(!isset($_REQUEST['opcao'])) {
        Header("location:../index.php");
    }
    
    $opcao = (int)$_REQUEST['opcao'];
    $funcionarioDAO = new FuncionarioDAO();
    $funcionarios = $funcionarioDAO->getFuncionarios();
    $usuario = $_SESSION['usuario'];
    
    $indiceDesempenho = 1;
    $indiceAbsent = 1;
    $indiceDisciplinar = 1;
    
    if(!isset($_REQUEST['opcao'])) {
        Header("location:../index.php");
    }
    
    $opcao = (int)$_REQUEST['opcao'];
        
    //Lista todos os lançamentos de aproveitamento por periodo
    if($opcao == 1){
        $semestre = (int) $_REQUEST['semestre'];
        $ano = (int) $_REQUEST['ano'];
        
        $aproveitamentoDAO = new AproveitamentoDAO();        
        $funcionarioDAO = new FuncionarioDAO();
        $usuarioDAO = new UsuarioDAO();
        $listaAproveitamento = $aproveitamentoDAO->getAproveitamentoPorPeriodo($semestre,$ano);
        $listaUsuarios = $usuarioDAO->getUsuarios();
        $_SESSION['funcionarios'] = $funcionarios;
        $_SESSION['usuarios'] = $listaUsuarios;
        $_SESSION['aproveitamento'] = $listaAproveitamento;
        $_SESSION['semestre']= $semestre;
        $_SESSION['ano'] = $ano;
        header("Location:../View/Aproveitamento/ListagemGeral.php");
    }    
    
    // GERAR O RELATÓRIO
    if ($opcao == 2) {       
        $semestre = (int) $_REQUEST['semestre'];
        $ano = (int) $_REQUEST['ano'];
        
        $contador = 0;
        
        $aproveitamentoDAO = new AproveitamentoDAO();
        $listaAproveitamento = $aproveitamentoDAO->getAproveitamentoPorPeriodo($semestre, $ano);
        
        if($listaAproveitamento) {
           header("Location: ../View/Aproveitamento/index.php?erro");
        } else {     
            $aproveitamento = new Aproveitamento();
            $aproveitamentoDAO = new AproveitamentoDAO();

            $usuarioDAO = new UsuarioDAO();   
            $listaUsuarios = $usuarioDAO->getUsuarios();
            $sancaoDAO = new SancaoDAO();
            $listaSancoes = $sancaoDAO->getSancoes();
            $tipoSancaoDAO = new TipoSancaoDAO();
            $listaTipoSancoes = $tipoSancaoDAO->getTipoSancoes();
            $absenteismoDAO = new AbsenteismoDAO();
            $listaAbsenteismo = $absenteismoDAO->getAbsenteismo();
            $desempenhoDAO = new DesempenhoDAO();
            $listaDesempenho = $desempenhoDAO->getDesempenhos();

            $link = mysqli_connect("localhost", "root", "", "sapes");

            if ($semestre == 1) {
                $dataInicial = $ano.'0101';
                $dataFinal = $ano.'0630';
            } else {
                $dataInicial = $ano.'0701';
                $dataFinal = $ano.'1231';
            } 

            date_default_timezone_set('America/Sao_Paulo');

            foreach($funcionarios as $funcionario) {      
                $aproveitamento->setIdFuncionario($funcionario->idFuncionario);
                $aproveitamento->setIdUsuario((int) $usuario->idUsuario);
                $aproveitamento->setIndiceCargaHoraria(44/$funcionario->cargaHoraria);
                $aproveitamento->setIndiceDesempenho(1);
                $aproveitamento->setIndiceAbsenteismo(1);
                $aproveitamento->setIndiceDisciplinar(1);
                $aproveitamento->setIndiceAproveitamento(1);
                $aproveitamento->setPesoDesempenho(3);
                $aproveitamento->setPesoAbsenteismo(2);
                $aproveitamento->setPesoFatorDisciplinar(1);
                $aproveitamento->setFatorDisciplinar(0);
                $aproveitamento->setSemestre($semestre);
                $aproveitamento->setAno($ano);
                $aproveitamento->setHorasAbsenteismo(0);
                date_default_timezone_set('America/Sao_Paulo');
                $aproveitamento->setDataLancamento(date('d/m/Y H:i:s:'));


                //1. Índice de Desempenho e Peso do Desempenho
                foreach($listaDesempenho as $desempenho) {
                    if($desempenho->idFuncionario == $funcionario->idFuncionario) {
                        if(($desempenho->semestre == $semestre) && ($desempenho->ano == $ano)) {
                            //echo 'PERIODO: '.$ano.' - '.$semestre.' semestre <br>';
                            //echo "ID Funcionário: ".$funcionario->idFuncionario."<br>";
                            //echo 'Data inicial: '.$dataInicial.' - Data Final: '.$dataFinal.'<br><br>';
                            $aproveitamento->setIndiceDesempenho($desempenho->nota/10); 
                            //echo 'Nota de Desempenho: '.$desempenho->nota.'<br>';
                            //echo 'Índice de Desempenho: '.$aproveitamento->getIndiceDesempenho().'<br><br>';

                            //2. Horas de absenteísmo, índice e peso
                            if ($semestre == 1 ) {
                                $queryAbsenteismo = "select f.idFuncionario, ROUND(SUM(a.qtdHoras),2) as absentTotal FROM absenteismo as a INNER JOIN funcionario AS f ON f.idFuncionario =  a.idFuncionario WHERE a.mes < 7  AND a.ano = $ano GROUP BY a.idFuncionario;"; 
                            } else {
                                $queryAbsenteismo = "select f.idFuncionario, ROUND(SUM(a.qtdHoras),2) as absentTotal FROM absenteismo as a INNER JOIN funcionario AS f ON f.idFuncionario =  a.idFuncionario WHERE a.mes > 6  AND a.ano = $ano GROUP BY a.idFuncionario;";
                            }

                            
                            $totalAbsenteismo = $link->query($queryAbsenteismo);

                            //Imprime na tela o absenteísmo de todos
                            if($totalAbsenteismo){
                                while($row = mysqli_fetch_array($totalAbsenteismo)){
                                    $idFuncionario = $row['idFuncionario'];                                 
                                    if($funcionario->idFuncionario == $idFuncionario) {
                                        $aproveitamento->setHorasAbsenteismo(round($row['absentTotal'],2)); 
                                        //echo "Total de Absenteísmo no Período: ".$row['absentTotal']."<br>";
                                    } 
                                }
                            } 

                            // Máximo de Absenteísmo
                            if($semestre==1) {
                                $queryMaxAbsenteismo = "select ROUND(MAX(absentTotal),2) as totAbs from (select f.idFuncionario, ROUND(SUM(a.qtdHoras),2) as absentTotal FROM absenteismo as a INNER JOIN funcionario AS f ON f.idFuncionario =  a.idFuncionario WHERE a.mes < 7  AND a.ano = $ano GROUP BY a.idFuncionario) AS horas";            
                            } else {
                                $queryMaxAbsenteismo = "select ROUND(MAX(absentTotal),2) as totAbs from (select f.idFuncionario, ROUND(SUM(a.qtdHoras),2) as absentTotal FROM absenteismo as a INNER JOIN funcionario AS f ON f.idFuncionario =  a.idFuncionario WHERE a.mes > 6  AND a.ano = $ano GROUP BY a.idFuncionario) AS horas";             
                            }

                            $maxAbsenteismo = $link->query($queryMaxAbsenteismo);

                            if($maxAbsenteismo){
                                while ($row = mysqli_fetch_array($maxAbsenteismo)) {
                                    //echo 'Maximo de absenteísmo: '.$row['totAbs'].'<br>';
                                    $aproveitamento->setMaxHorasAbsenteismo($row['totAbs']);
                                }
                            }

                            //Índice de Absenteísmo:
                            if($aproveitamento->getHorasAbsenteismo() == $aproveitamento->getMaxHorasAbsenteismo()) {
                                $aproveitamento->setIndiceAbsenteismo(0);
                            } else {
                                $aproveitamento->setIndiceAbsenteismo(
                                        1 - ((
                                            $aproveitamento->getHorasAbsenteismo() * $aproveitamento->getIndiceCargaHoraria()
                                            )/$aproveitamento->getMaxHorasAbsenteismo())
                                        );
                                
                                //echo 'Índice de Absenteísmo: '.$aproveitamento->getIndiceAbsenteismo().'<br><br>';
                            }


                            //3. Fator disciplinar, sanções, tipos de sanções, índice e peso
                            $queryFatorDisciplinar = "SELECT idFuncionario, 
                                            SUM(qtd) as quantidade, 
                                            SUM(qtd*peso) AS fatorDisciplinar FROM 
                                                            (SELECT f.nome, 
                                                                                            s.idFuncionario, 
                                                                                            COUNT(*) as qtd, 
                                                                                            t.peso 
                                                                            FROM sancao AS s
                              INNER JOIN funcionario AS f ON s.idFuncionario = f.idFuncionario
                              INNER JOIN tipo_sancao AS t ON t.idTipo = s.idTipo
                                            WHERE dataSancao between '$dataInicial' AND '$dataFinal'
                                            GROUP BY s.idFuncionario, t.peso) AS fDisc GROUP BY idFuncionario;";
                            
                            $listaFatorDisciplinar = $link->query($queryFatorDisciplinar);
                            
                            if($listaFatorDisciplinar) {
                                while($row = mysqli_fetch_array($listaFatorDisciplinar)) {
                                    if($row[0] == $funcionario->idFuncionario) {
                                        $aproveitamento->setFatorDisciplinar((float) $row[2]);
                                        //echo 'Fator disciplinar: '.$aproveitamento->getFatorDisciplinar().'<br>';
                                    } 
                                }
                            }
                            
                            $queryMaxFatorDisciplinar = "SELECT idFuncionario, MAX(fatorDisciplinar) as maxFatorDisciplinar FROM (SELECT idFuncionario, 
			SUM(qtd) as quantidade, 
			SUM(qtd*peso) AS fatorDisciplinar FROM 
					(SELECT f.nome, 
									s.idFuncionario, 
									COUNT(*) as qtd, 
									t.peso 
							FROM sancao AS s
	  INNER JOIN funcionario AS f ON s.idFuncionario = f.idFuncionario
	  INNER JOIN tipo_sancao AS t ON t.idTipo = s.idTipo
			WHERE dataSancao between '$dataInicial' AND '$dataFinal'
			GROUP BY s.idFuncionario, t.peso) AS fDisc GROUP BY idFuncionario) AS totalFatorDisciplinar;";
                                    
                            $maxFatorDisciplinar = $link->query($queryMaxFatorDisciplinar);
                            
                            if($maxFatorDisciplinar) {
                                $row = mysqli_fetch_row($maxFatorDisciplinar);
                                $aproveitamento->setMaxFatorDisciplinar($row[1]);
                            }
                            
                            
                            //echo "Máximo Fator Disciplinar do Período: ".$aproveitamento->getMaxFatorDisciplinar().'<br>';
                            
                            $indiceDisciplinarFuncionario = 1 - ($aproveitamento->getFatorDisciplinar()/$aproveitamento->getMaxFatorDisciplinar());
                            $aproveitamento->setIndiceDisciplinar($indiceDisciplinarFuncionario);
                            //echo 'Índice Disciplinar: '.$aproveitamento->getIndiceDisciplinar().'<br><br>';
                            
                            
                            
                            
                            
                            //4. Índice de Aproveitamento Funcional
                            if($aproveitamento->getIndiceDesempenho() == 0) {
                                $aproveitamento->setIndiceAproveitamento(1);
                            } else {
                                $aproveitamento->setIndiceAproveitamento((
                                        ($aproveitamento->getIndiceDesempenho()*$aproveitamento->getPesoDesempenho())+
                                        ($aproveitamento->getIndiceAbsenteismo()*$aproveitamento->getPesoAbsenteismo())+
                                        ($aproveitamento->getIndiceDisciplinar()*$aproveitamento->getPesoFatorDisciplinar())
                                    ) / ($aproveitamento->getPesoDesempenho()+$aproveitamento->getPesoAbsenteismo()+$aproveitamento->getPesoFatorDisciplinar())
                                );
                                //echo 'Índice de Aproveitamento: '.$aproveitamento->getIndiceAproveitamento().'<br>';
                            }
                            
                            //echo '----------------------------------------------------------------------<br><br>';
                            $aproveitamentoDAO->incluirAproveitamento($aproveitamento);
                        }
                    }
                }
            }
            header("Location: ../View/Aproveitamento/index.php?sucesso");
        }   
    }
   
    //Lista todos os lançamentos de aproveitamento por periodo
    if($opcao == 3){
        $semestre = (int) $_REQUEST['semestre'];
        $ano = (int) $_REQUEST['ano'];        
        $aproveitamentoDAO = new AproveitamentoDAO();        
        $funcionarioDAO = new FuncionarioDAO();
        $usuarioDAO = new UsuarioDAO();
        $listaAproveitamento = $aproveitamentoDAO->getAproveitamento();
        $listaUsuarios = $usuarioDAO->getUsuarios();
        $_SESSION['funcionarios'] = $funcionarios;
        $_SESSION['usuarios'] = $listaUsuarios;
        $_SESSION['aproveitamento'] = $listaAproveitamento;
        header("Location:../View/Aproveitamento/ListagemGeral.php");
    } 
    
    // GERAR O RELATÓRIO NOVAMENTE
    if ($opcao == 4) {       
        
    }