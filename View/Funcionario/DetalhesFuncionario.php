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
    
    $secoes = $_SESSION['secoes'];
    $divisoes = $_SESSION['divisoes'];
    $gerencias = $_SESSION['gerencias'];
    $notasDesempenho = $_SESSION['notasDesempenho'];
    $sancoes = $_SESSION['sancoes'];
    $tiposSancoes = $_SESSION['tipoSancoes'];
    $listaAbsenteismo = $_SESSION['absenteismo'];
    $listaAproveitamento = $_SESSION['aproveitamento'];
?>

<!doctype html>
<html lang="en">
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

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Detalhes do funcionário </h1><h2><?=$funcionario->nome;?></h2>        
    </div>

    <div class="container">
        <div class="col-md-12 order-md-1 ">
            <h3>Dados do funcionário:</h3>
            <table class="table table-success">
                <tr>
                    <th>Nome completo: </th>
                    <td><?=$funcionario->nome;?></td>
                </tr>
                <tr>
                    <th>Crachá:</th>
                    <td><?=$funcionario->cracha;?></td>
                </tr>
                <tr>
                    <th>Tipo de Cargo:</th>
                    <td><?=$funcionario->situacao;?></td>
                </tr>
                <tr>
                    <th>Carga Horária:</th>
                    <td><?=$funcionario->cargaHoraria;?> horas semanais</td>
                </tr>
                <tr>
                    <th>Data de Admissão:</th>
                    <td><?=date('d/m/Y',strtotime($funcionario->dataAdmissao));?></td>
                </tr>
                <tr>
                    <th>Seção:</th>
                    <td>                        
                        <?php
                            foreach($secoes as $secao) {
                                if($secao->idSecao == $funcionario->idSecao) {
                                    echo $secao->descricao;
                                }
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>Divisão:</th>
                    <td>
                        <?php                
                            foreach($secoes as $secao) {
                                if($secao->idSecao == $funcionario->idSecao) {
                                    foreach($divisoes as $divisao) {
                                        if($divisao->idDivisao == $secao->idDivisao) {
                                            echo $divisao->descricao;
                                        }
                                    }
                                }
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>Gerência:</th>
                    <td>
                        <?php
                            foreach($secoes as $secao) {
                                if($secao->idSecao == $funcionario->idSecao) {
                                    foreach($divisoes as $divisao) {
                                        if($divisao->idDivisao == $secao->idDivisao) {
                                            foreach($gerencias as $gerencia) {
                                                if($gerencia->idGerencia == $divisao->idGerencia) {
                                                    echo $gerencia->descricao;
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
            <h3>1. Histórico de Desempenho:</h3>
            <table class="table table-success">
                <tr><th>Período</th><th>Nota: </th></tr>
            <?php
                foreach($notasDesempenho as $nota) {
                    if($nota->idFuncionario == $funcionario->idFuncionario) {
                        echo "<tr><td>$nota->semestre º semestre - $nota->ano </td><td>$nota->nota</td></tr>";
                    }
                }            
            ?>
                <tr>
                    <th>Média Total Histórica: </th>
                    <td>
                        <?php
                            mysql_connect("localhost", "root", "");
                            
                            mysql_select_db("sapes");
                        
                            $query = "select idFuncionario,round(avg(nota),5) as media from desempenho group by idFuncionario";
                        
                            $mediaDesempenho = mysql_query($query);
                            
                            while($media = mysql_fetch_array($mediaDesempenho)) {
                                $idFunc = $media['idFuncionario'];
                                $mediaFunc = $media['media'];
                                
                                if($idFunc == $funcionario->idFuncionario) {
                                    echo $mediaFunc;
                                }
                            }
                        ?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-12 order-md-1">
            <h3>2. Histórico de Absenteísmo:</h3>
            <table class="table table-success">
                <tr>
                    <th>Mês/Ano: </th>
                    <th>Absenteísmo: </th>
                </tr>
            <?php
                foreach($listaAbsenteismo as $absenteismo) {
                    if($absenteismo->idFuncionario == $funcionario->idFuncionario) {
                        echo '<tr>';
                        echo "<td>$absenteismo->mes/$absenteismo->ano</td>";
                        echo "<td>$absenteismo->qtdHoras horas</td></tr>";
                    }
                }
            ?><tr>
                    <th>Média mensal: </th>
                    <td>
                        <?php
                            mysql_connect("localhost", "root", "");
                            
                            mysql_select_db("sapes");                        
                            
                            $query = "select idFuncionario, AVG(qtdHoras) as quant from absenteismo GROUP BY idFuncionario;";
                        
                            $mediaDesempenho = mysql_query($query);
                            
                            $qtdHoras = 0;
                            
                            while($media = mysql_fetch_array($mediaDesempenho)) {
                                $idFunc = $media['idFuncionario'];
                                
                                if($idFunc == $funcionario->idFuncionario) {
                                    $qtdHoras = $media['quant'];
                                }
                            }
                            
                            echo round($qtdHoras,2);
                        ?> horas
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-12 order-md-1">
            <h3>3. Histórico de Sanções Disciplinares:</h3>            
            
            <table class="table table-success">
                <tr>
                    <th>Data:</th>
                    <th>Sanção:</th>
                    <th>Peso:</th>
                    <th>Documento:</th>
                    <th>Dias:</th>
                    <th>Motivo:</th>
                </tr>
                
            <?php 
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
                            }
                        }
                    }
                }
            
            ?>
                <tr>
                    <th>Total Histórico de Sanções: </th>
                    <td colspan="4">
                        <?php
                            mysql_connect("localhost", "root", "");
                            
                            mysql_select_db("sapes");                        
                            
                            $query = "select idFuncionario, COUNT(*) as quantidade from sancao GROUP BY idFuncionario;";
                        
                            $totalSancoes = mysql_query($query);
                            
                            $quantidade = 0;
                            
                            while($media = mysql_fetch_array($totalSancoes)) {
                                $idFunc = $media['idFuncionario'];
                                
                                if($idFunc == $funcionario->idFuncionario) {
                                    $quantidade = $media['quantidade'];
                                }
                            }
                            
                            echo $quantidade;
                        ?> sanções disciplinares
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="col-md-12 order-md-1">
            <h3>4. Histórico de Aproveitamento Funcional</h3>
            <table class="table table-success">
                <tr><th>Período</th><th>Índice de aproveitamento funcional: </th></tr>
            <?php
                foreach($listaAproveitamento as $aproveitamento) {
                    if($aproveitamento->idFuncionario == $funcionario->idFuncionario) {
                        echo "<tr><td>$aproveitamento->semestre º semestre - $aproveitamento->ano </td><td>$aproveitamento->indiceAproveitamento</td></tr>";
                    }
                }            
            ?><tr>
                    <th>Média total histórica: </th>
                    <td>
                        <?php
                            $aprovMedia = 0;
                        
                            mysql_connect("localhost", "root", "");
                            
                            mysql_select_db("sapes");                        
                            
                            $query = "select idFuncionario, AVG(indiceAproveitamento) as aprovMedio from aproveitamento GROUP BY idFuncionario;";
                        
                            $mediaAproveitamento = mysql_query($query);
                            
                            while($media = mysql_fetch_array($mediaAproveitamento)) {
                                $idFunc = $media['idFuncionario'];
                                
                                if($idFunc == $funcionario->idFuncionario) {
                                    $aprovMedia = $media['aprovMedio'];
                                }
                            }
                            
                            echo round($aprovMedia,5);
                        ?>
                    </td>
                </tr>
            </table>
            </table>
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