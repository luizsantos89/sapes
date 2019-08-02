<?php
    session_start();
    
    if(isset($_REQUEST['semestre'])){
        $semestre = (int) $_REQUEST['semestre'];
        $ano = (int) $_REQUEST['ano'];
    } else {
        header("Location: geraDesempenho.php");
    }
    
    include("../../includes/verificaSessao.php");
    
    $usuario = $_SESSION['usuario'];    
    
    $link = mysqli_connect("localhost", "root", "", "sapes");
    
    $queryFuncionarioMais = "SELECT f.nome, f.cracha, a.indiceAproveitamento FROM aproveitamento as a INNER JOIN funcionario as f ON f.idFuncionario = a.idFuncionario WHERE semestre = $semestre AND ano = $ano ORDER BY a.indiceAproveitamento DESC LIMIT 30;";

    $querySecao = "SELECT s.descricao as secao, ROUND(AVG(a.indiceAproveitamento),5) as media FROM aproveitamento as a INNER JOIN funcionario as f ON f.idFuncionario = a.idFuncionario INNER JOIN secao as s ON s.idSecao = f.idSecao WHERE semestre = $semestre AND ano = $ano GROUP BY s.idSecao ORDER BY AVG(a.indiceAproveitamento) DESC;";

    $queryDivisao = "SELECT d.descricao as divisao, ROUND(AVG(a.indiceAproveitamento),5) as media FROM aproveitamento as a INNER JOIN funcionario as f ON f.idFuncionario = a.idFuncionario INNER JOIN secao as s ON s.idSecao = f.idSecao INNER JOIN divisao as d ON s.idDivisao = d.idDivisao WHERE semestre = $semestre AND ano = $ano GROUP BY d.idDivisao ORDER BY AVG(a.indiceAproveitamento) DESC;";

    $queryGerencia = "SELECT g.descricao as gerencia, ROUND(AVG(a.indiceAproveitamento),5) as media FROM aproveitamento as a INNER JOIN funcionario as f ON f.idFuncionario = a.idFuncionario INNER JOIN secao as s ON s.idSecao = f.idSecao INNER JOIN divisao as d ON s.idDivisao = d.idDivisao INNER JOIN gerencia as g ON d.idGerencia = g.idGerencia WHERE semestre = $semestre AND ano = $ano GROUP BY g.idGerencia ORDER BY AVG(a.indiceAproveitamento) DESC;";    
        
    $graficoFuncionarioMais = $link->query($queryFuncionarioMais);
    
    $graficoSecao = $link->query($querySecao);
    
    $graficoDivisao = $link->query($queryDivisao);
    
    $graficoGerencia = $link->query($queryGerencia);
    
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../imagens/imbel.ico">

    <title>Relatórios - Sistema de Aproveitamento Funcional - DVRH/FJF</title>

    <!-- Bootstrap core CSS -->
    <link href="../../estilos/css/bootstrap.min.css" rel="stylesheet">
    
    <style>            
    @media print{
       #noprint{
           display:none;
       }
    }
    </style>

    <!-- Custom styles for this template -->
    <link href="../../estilos/css/pricing.css" rel="stylesheet">
    <script type="text/javascript" src="../../scripts/loader.js"></script>
    
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});

        google.charts.setOnLoadCallback(drawChart);
        function drawChart(){
            var data = new google.visualization.DataTable();
            var data = google.visualization.arrayToDataTable([
                ['Seção','Média de Aproveitamento (em %)'],
                <?php
                    while ($array = mysqli_fetch_array($graficoSecao)){
                        echo "['".$array[0]."', ".$array[1]*100.0."],";
                    }
                ?>
               ]);

            
            var options = {
              title: 'Média de Aproveitamento Funcional por Seção',
              is3D: true,
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('grafSecao'));
            chart.draw(data, options);
        }

    </script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});

        google.charts.setOnLoadCallback(drawChart);
        function drawChart(){
            var data = new google.visualization.DataTable();
            var data = google.visualization.arrayToDataTable([
                ['Divisão','Média de Aproveitamento (em %)'],
                <?php
                    while ($array = mysqli_fetch_array($graficoDivisao)){
                        echo "['".$array[0]."', ".$array[1]*100.0."],";
                    }
                ?>
               ]);

            
            var options = {
                title: 'Média de Aprovietamento Funcional por Divisão',
                is3D: true,
                slices: {  8: {offset: 0.2},
                          9: {offset: 0.4},
                          10: {offset: 0.7},
                          11: {offset: 1.0},
                },

            };

            var chart = new google.visualization.ColumnChart(document.getElementById('grafDivisao'));
            chart.draw(data, options);
        }

    </script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});

        google.charts.setOnLoadCallback(drawChart);
        function drawChart(){
            var data = new google.visualization.DataTable();
            var data = google.visualization.arrayToDataTable([
                ['Gerência','Média de Aproveitamento (em %)'],
                <?php
                    while ($array = mysqli_fetch_array($graficoGerencia)){
                        echo "['".$array[0]."', ".$array[1]*100.0."],";
                    }
                ?>
               ]);

            
            var options = {
              title: 'Média de AproveitamentoFuncional por Gerência',
              pieHole: 0.4,
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('grafGerencia'));
            chart.draw(data, options);


        }

    </script>
  </head>

  <body>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
      <!--<h5 class="my-0 mr-md-auto font-weight-normal">Company name</h5>-->
      <img src="../../imagens/logo2.png" class="my-0 mr-md-auto font-weight-normal" id="noprint" />
      
      <nav class="my-2 my-md-0 mr-md-3" id="noprint">
          <?php
            include('../../includes/Menus.php');
          ?>
      </nav>
      <a class="btn btn-outline-primary" href="../../Controler/logout.php" id="noprint">Sair</a>
    </div>

     <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Relatório</h1><br />
        <h3>Notas de Desempenho - <?=$semestre?>º semestre - <?=$ano?></h3>
        <a href="GeraAbsenteismo.php" class="btn btn-primary">Voltar</a>
    </div>

    <div class="container">
        <div class="text-center">   
            <!--<div id="grafFuncMais" style="width: 1000px; height: 1200px"></div>-->
            <table border='1' class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th colspan="4" class='text-center h4'>30 Maiores Índices de Aproveitamento Funcional no Período</th>
                    </tr>
                </thead>
                <tr>
                    <th>Ordem: </th>
                    <th>Crachá: </th>
                    <th>Funcionário: </th>
                    <th>Nota: </th>
                </tr>
                <?php
                    $cont = 1;
                    while ($array = mysqli_fetch_array($graficoFuncionarioMais)){
                        echo "<tr><td>".$cont.'</td><td>'.str_pad($array[1],3,0, STR_PAD_LEFT).'</td><td align="left">'.$array[0]."</td><td>".$array[2]." (".$array[2]*100.0."%)</td></tr>";
                        $cont+=1;
                    }
                ?>
            </table>
            <div class="card-deck mb-2 text-center">
                <div class="card mb-3 box-shadow">                
                    <div id="grafSecao" style="width: 920px; height: 900px"></div>
                </div>
            </div>
            <div class="card-deck mb-2 text-center">
                <div class="card mb-3 box-shadow">                
                    <div id="grafDivisao" style="width: 920px; height: 900px"></div>
                </div>
            </div>
            <div class="card-deck mb-2 text-center">
                <div class="card mb-3 box-shadow">                
                    <div id="grafGerencia" style="width: 920px; height: 900px"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <footer class="pt-4 my-md-5 pt-md-5 border-top" id="noprint">
          <?php
              include('../../includes/Rodape.php');
          ?>
        </footer>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <script>
      Holder.addTheme('thumb', {
        bg: '#55595c',
        fg: '#eceeef',
        text: 'Thumbnail'
      });
    </script>
  </body>
</html>
