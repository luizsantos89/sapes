<?php
    session_start();
    include("../../includes/verificaSessao.php");
    require '../../Model/DesempenhoDAO.php';
    require '../../Model/SancaoDAO.php';
    require '../../Model/TipoSancaoDAO.php';
    require '../../Model/AbsenteismoDAO.php';
    
    
    if(isset($_SESSION['funcionario'])){
        $funcionario = $_SESSION['funcionario'];
    } else {
        header("Location: ../../Controler/controlerFuncionario.php?opcao=6&pagina=1");
    }
    
    $usuario = $_SESSION['usuario'];    
    $secoes = $_SESSION['secoes'];
    $divisoes = $_SESSION['divisoes'];
    $gerencias = $_SESSION['gerencias'];
    $notasDesempenho = $_SESSION['notasDesempenho'];
    $sancoes = $_SESSION['sancoes'];
    $tiposSancoes = $_SESSION['tipoSancoes'];
    $listaAbsenteismo = $_SESSION['absenteismo'];
    $listaAproveitamento = $_SESSION['aproveitamento'];
    
    $idFuncionario = $funcionario->idFuncionario;
?>

<!doctype html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../imagens/imbel.ico">

        <title>Detalhes do funcionário</title>

        <!-- Bootstrap core CSS -->
        <link href="../../estilos/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="../../estilos/css/pricing.css" rel="stylesheet">
        
        <style>            
        @media print{
            #noprint{
                display:none;
            }
           
            background:transparent !important;
            color:#000 !important;
            text-shadow:none !important;
            filter:none !important;
            -ms-filter:none !important;
            font-size: smaller;
        }
        
        @page {
            margin: 0.5cm;
        }
        </style>
        
    </head>

  <body>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow" id="noprint">
        <img class="my-0 mr-md-auto font-weight-normal" src="../../imagens/logo2.png" id="noprint" />
        <nav class="my-2 my-md-0 mr-md-3" id="noprint">
            <?php include("../../includes/Menus.php"); ?>
        </nav>
        <a class="btn btn-outline-primary" href="../../Controler/logout.php" id="noprint">Sair</a>
    </div>

    <div class="pricing-header container text-center">
        <h1 class="display-4 text-center">Histórico do funcionário</h1>
        <h2><?=str_pad($funcionario->cracha,3,0, STR_PAD_LEFT).' - '.$funcionario->situacao.' '.$funcionario->nome;?></h2>        
        <br>
    </div>

    <div class="container">
        <div class="col-md-12 order-md-1">
            <h3>1. Dados Gerais:</h3>  
            
            <table class="table table-info">
                <tr>
                    <th>Carga Horária:</th>
                    <th>Data de Admissão:</th>
                    <th>Seção/Divisão/Gerência:</th>
                </tr>
                <tr>
                    <td><?=$funcionario->cargaHoraria;?> horas semanais</td>
                    <td><?=date('d/m/Y',strtotime($funcionario->dataAdmissao));?></td>
                    <td>
                        <?php
                            foreach($secoes as $secao) {
                                if($secao->idSecao == $funcionario->idSecao) {
                                    foreach($divisoes as $divisao) {
                                        if($divisao->idDivisao == $secao->idDivisao) {
                                            foreach($gerencias as $gerencia) {
                                                if($gerencia->idGerencia == $divisao->idGerencia) {
                                                    echo $secao->descricao.'/'.$divisao->descricao.'/'.$gerencia->descricao;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        ?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-12 order-md-1">
            <h3>2. Histórico de Desempenho:</h3>
            <table class="table table-info">
                <tr><th>Período</th><th>Nota: </th></tr>
            <?php
                foreach($notasDesempenho as $nota) {
                    $notas = Array();
                    if($nota->idFuncionario == $funcionario->idFuncionario) {
                        echo "<tr><td>$nota->semestre º semestre - $nota->ano </td><td>".str_replace('.',',', $nota->nota)."</td></tr>";
                        $notas[] = $nota->nota;
                    }
                }            
            ?>
                <tr>
                    <th>Média Total Histórica: </th>
                    <td>
                        <?php
                            $count = 0;
                            $total = 0;
                            
                            foreach($notasDesempenho as $nota) {
                                if($nota->idFuncionario == $funcionario->idFuncionario) {
                                    $count += 1;
                                    $total += $nota->nota;
                                }
                            }
                                                        
                            if($count != 0) {
                                echo round(($total/$count),8);
                            } else {
                                echo 0;
                            }
                        ?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-12 order-md-1">
            <h3>3. Histórico de Absenteísmo:</h3>
            <table class="table table-info">
                <tr>
                    <th>Mês/Ano: </th>
                    <th>Absenteísmo: </th>
                </tr>
            <?php
                $horas = Array();
            
                foreach($listaAbsenteismo as $absenteismo) {
                    if($absenteismo->idFuncionario == $funcionario->idFuncionario) {
                        echo '<tr>';
                        echo "<td>".str_pad($absenteismo->mes,2,0, STR_PAD_LEFT)."/$absenteismo->ano</td>";
                        echo "<td>".str_replace('.',',',$absenteismo->qtdHoras)." horas</td></tr>";
                        $horas[] = $absenteismo->qtdHoras;
                    }
                }
            ?><tr>
                    <th>Média mensal: </th>
                    <td>
                        <?php
                            $count = 0;
                            $total = 0;
                            
                            foreach ($horas as $totalHoras) {
                                $total += $totalHoras;
                                $count += 1;
                            }
                            
                            
                            if($count != 0) {
                                echo str_replace('.',',',round(($total/$count),2));
                            } else {
                                echo 0;
                            }
                        ?> horas
                    </td>
                </tr>
                <tr>
                    <th>Total histórico: </th>
                    <td>
                        <?php
                            $count = 0;
                            $total = 0;
                            
                            foreach ($horas as $totalHoras) {
                                $total += $totalHoras;
                                $count += 1;
                            }
                            
                            
                            if($count != 0) {
                                echo str_replace('.',',',$total);
                            } else {
                                echo 0;
                            }
                        ?> horas
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-12 order-md-1">
            <h3>4. Histórico de Sanções Disciplinares:</h3>            
            
            <table class="table table-info">
                <tr>
                    <th>Data:</th>
                    <th>Sanção:</th>
                    <th>Peso:</th>
                    <th>Documento:</th>
                    <th>Dias:</th>
                    <th>Motivo:</th>
                </tr>
                
            <?php 
                $totalSancoes = 0;
                foreach($sancoes as $sancao) {
                    if($sancao->idFuncionario == $funcionario->idFuncionario){
                        foreach ($tiposSancoes as $tipo) {
                            if($tipo->idTipo == $sancao->idTipo){
                                echo '<td>'.date('d/m/Y',strtotime($sancao->dataSancao)).'</td>';
                                echo '<td>'.$tipo->descricao.'</td>';
                                echo '<td>'.$tipo->peso.'</td>';
                                echo '<td>'.$sancao->numDoc.'</td>';
                                echo '<td>'.$sancao->qtdDias.'</td>';
                                echo '<td>'.$sancao->motivo.'</td></tr>';
                                $totalSancoes += 1;
                            }
                        }
                    }
                }
            
            ?>
                <tr>
                    <th>Total Histórico de Sanções: </th>
                    <td colspan="5"><?=$totalSancoes?> sanções disciplinares
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-12 order-md-1">
            <h3>5. Histórico de Aproveitamento Funcional</h3>
            <table class="table table-info">
                <tr><th>Período</th><th>Índice de aproveitamento funcional: </th></tr>
            <?php
                $aproveitamentos = Array();
                foreach($listaAproveitamento as $aproveitamento) {
                    if($aproveitamento->idFuncionario == $funcionario->idFuncionario) {
                        echo "<tr><td>$aproveitamento->semestre º semestre - $aproveitamento->ano </td><td>$aproveitamento->indiceAproveitamento</td></tr>";
                        $aproveitamentos[] = $aproveitamento->indiceAproveitamento;
                    }
                }            
            ?><tr>
                    <th>Média total histórica: </th>
                    <td>
                        <?php
                            $count = 0;
                            $total = 0;
                            
                            foreach ($aproveitamentos as $aproveit) {
                                $total += $aproveit;
                                $count += 1;
                            }
                            
                            if($count != 0) {
                                echo round(($total/$count),8);
                            } else {
                                echo 0;
                            }
                        ?>
                    </td>
                </tr>
            </table>
                Gerado em: <?php
                    date_default_timezone_set('America/Sao_Paulo');
                    $date = date('d/m/Y H:i:s');
                    echo $date;               
                ?>
        </div>
        <br />
        <div class="col-md-12 order-md-1"  id="noprint">
            <?php
                if($usuario->idTipoUsuario!=3) {
            ?>
                <a href="EditaFuncionario.php?idFuncionario=<?=$funcionario->idFuncionario?>" class="btn btn-primary" id="noprint">Editar</a>
            <?php
                }
            ?>
            <a href="../../Controler/controlerFuncionario.php?opcao=6&pagina=1" class="btn btn-outline-primary"  id="noprint">Voltar</a>
        </div>
    </div>
    <div class="container" id="noprint">
        <footer class="pt-4 my-md-5 pt-md-5 border-top" id="noprint">
          <?php
                include('../../includes/Rodape.php');
                include('../../includes/unsetSessoes.php');
          ?>
        </footer>
    </div>

  </body>
</html>