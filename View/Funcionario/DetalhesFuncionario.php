<?php
    session_start();
    include("../../includes/verificaSessao.php");
    
    if(isset($_SESSION['funcionario'])){
        $funcionario = $_SESSION['funcionario'];
    } else {
        header("Location: ../../Controler/controlerFuncionario.php?opcao=6&pagina=1");
    }
    
    if(!isset($_SESSION['tipoSancoes'])) {
        include('../../includes/setSessoes.php');
        echo 'entrou aqui';
        $secoes = $_SESSION['secoes'];
        $divisoes = $_SESSION['divisoes'];
        $gerencias = $_SESSION['gerencias'];
        $notasDesempenho = $_SESSION['notasDesempenho'];
        $sancoes = $_SESSION['sancoes'];
        $tiposSancoes = $_SESSION['tipoSancoes'];
        $listaAbsenteismo = $_SESSION['absenteismo'];
    }
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
        
    </head>

  <body>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
        <img class="my-0 mr-md-auto font-weight-normal" src="../../imagens/logo2.png" />
        <nav class="my-2 my-md-0 mr-md-3">
            <?php include("../../includes/Menus.php"); ?>
        </nav>
        <a class="btn btn-outline-primary" href="../../Controler/logout.php">Sair</a>
    </div>

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Detalhes do funcionário </h1><h2><?=$funcionario->nome;?></h2>        
    </div>

    <div class="container">
        <div class="col-md-12 order-md-1 ">
            <h3>Dados do funcionário:</h3>
            <table class="table table-success">
                <tr>
                    <th>ID Funcionário: </th>
                    <td><?=$funcionario->idFuncionario;?></td>
                </tr>
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
                            $link = mysqli_connect("localhost", "root", "", "sapes");
                        
                            $query = "select idFuncionario,round(avg(nota),5) as media from desempenho group by idFuncionario";
                        
                            $mediaDesempenho = $link->query($query);
                            
                            while($media = mysqli_fetch_array($mediaDesempenho)) {
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
                            $link = mysqli_connect("localhost", "root", "", "sapes");
                        
                            $query = "select idFuncionario, AVG(qtdHoras) as quant from absenteismo GROUP BY idFuncionario;";
                        
                            $mediaDesempenho = $link->query($query);
                            
                            while($media = mysqli_fetch_array($mediaDesempenho)) {
                                $idFunc = $media['idFuncionario'];
                                $qtdHoras = $media['quant'];
                                
                                if($idFunc == $funcionario->idFuncionario) {
                                    echo round($qtdHoras,2);
                                }
                            }
                        ?> horas
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-12 order-md-1">
            <h3>3. Histórico de Sanções Disciplinares:</h3>            
            
            <table class="table table-success">
                <tr>
                    <th>ID:</th>
                    <th>Data:</th>
                    <th>Documento:</th>
                    <th>Dias:</th>
                    <th>Motivo:</th>
                </tr>
                
            <?php 
                foreach($sancoes as $sancao) {
                    if($sancao->idFuncionario == $funcionario->idFuncionario){
                        echo '<tr><td>'.$sancao->idSancao.'</td>';
                        echo '<td>'.date('d/m/Y',strtotime($sancao->dataSancao)).'</td>';
                        //echo '<td>'.$tipo->descricao.'</td>';
                        //echo '<td>'.$tipo->peso.'</td>';
                        echo '<td>'.$sancao->numDoc.'</td>';
                        echo '<td>'.$sancao->qtdDias.'</td>';
                        echo '<td>'.$sancao->motivo.'</td></tr>';
                    }
                }
            
            ?>
                <tr>
                    <th>Total Histórico de Sanções: </th>
                    <td colspan="4">
                        <?php
                            $link = mysqli_connect("localhost", "root", "", "sapes");
                        
                            $query = "select idFuncionario, COUNT(*) as quantidade from sancao GROUP BY idFuncionario;";
                        
                            $totalSancoes = $link->query($query);
                            
                            while($media = mysqli_fetch_array($totalSancoes)) {
                                $idFunc = $media['idFuncionario'];
                                $quantidade = $media['quantidade'];
                                
                                if($idFunc == $funcionario->idFuncionario) {
                                    echo $quantidade;
                                }
                            }
                        ?> sanções disciplinares
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="container">
        <footer class="pt-4 my-md-5 pt-md-5 border-top">
          <?php
              include('../../includes/Rodape.php');
              include('../../includes/unsetSessoes.php');
          ?>
        </footer>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="assets/js/vendor/popper.min.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
    <script src="assets/js/vendor/holder.min.js"></script>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js'></script>
    <script>
        $('.input-group.date').datepicker({format: "dd/mm/yyyy"});
    </script>
    <script>
      Holder.addTheme('thumb', {
        bg: '#55595c',
        fg: '#eceeef',
        text: 'Thumbnail'
      });
    </script>
  </body>
</html>