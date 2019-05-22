<?php
    session_start();
    
    if(isset($_REQUEST['semestre'])){
        $semestre = (int) $_REQUEST['semestre'];
        $ano = (int) $_REQUEST['ano'];
    } else {
        header("Location: GeraAbsenteismo.php");
    }
    
    include("../../includes/verificaSessao.php");
    
    $usuario = $_SESSION['usuario'];    
    
    $link = mysqli_connect("localhost", "root", "", "sapes");
    
    if($semestre == 1) {
        $queryFuncionarioMais = "SELECT f.cracha, f.nome, ROUND(SUM(a.qtdHoras),2) as totalHorasFunc FROM absenteismo as a INNER JOIN funcionario as f ON a.idFuncionario = f.idFuncionario WHERE mes < 7  AND ano = $ano GROUP BY f.idFuncionario ORDER BY totalHorasFunc DESC LIMIT 30;";

        $queryTotalSecao = "SELECT s.descricao, ROUND(SUM(a.qtdHoras),2) as totalHorasFunc FROM absenteismo as a INNER JOIN funcionario as f ON a.idFuncionario = f.idFuncionario INNER JOIN secao as s ON f.idSecao = s.idSecao WHERE mes < 7  AND ano = $ano GROUP BY s.idSecao ORDER BY totalHorasFunc DESC;";
        
        $queryMediaSecao = "SELECT TotFuncSecao.descricao, ROUND((totalHorasFunc/totFunc),2) as mediaSecao FROM (SELECT s.idSecao, ROUND(SUM(a.qtdHoras),2) as totalHorasFunc FROM absenteismo as a INNER JOIN funcionario as f ON a.idFuncionario = f.idFuncionario INNER JOIN secao as s ON f.idSecao = s.idSecao WHERE mes < 7  AND ano = $ano GROUP BY s.idSecao ORDER BY totalHorasFunc DESC) as TotHorasSecao INNER JOIN (SELECT s.idSecao, s.descricao, COUNT(f.idFuncionario) as totFunc FROM funcionario as f INNER JOIN secao as s ON s.idSecao = f.idSecao GROUP BY f.idSecao) as TotFuncSecao ON TotHorasSecao.idSecao = TotFuncSecao.idSecao;";

        $queryTotalDivisao = "SELECT d.descricao, ROUND(SUM(a.qtdHoras),2) as totalHorasFunc FROM absenteismo as a INNER JOIN funcionario as f ON a.idFuncionario = f.idFuncionario INNER JOIN secao as s ON f.idSecao = s.idSecao INNER JOIN divisao as d ON d.idDivisao = s.idDivisao WHERE mes < 7  AND ano = $ano GROUP BY d.idDivisao ORDER BY totalHorasFunc DESC;";
        
        $queryMediaDivisao = "SELECT TotFuncDivisao.descricao, ROUND((totalHorasFunc/totFunc),2) as mediaDivisao FROM (SELECT d.idDivisao, ROUND(SUM(a.qtdHoras),2) as totalHorasFunc FROM absenteismo as a INNER JOIN funcionario as f ON a.idFuncionario = f.idFuncionario INNER JOIN secao as s ON f.idSecao = s.idSecao INNER JOIN divisao as d ON d.idDivisao = s.idDivisao WHERE mes < 7  AND ano = $ano GROUP BY d.idDivisao ORDER BY totalHorasFunc DESC) as TotHorasDivisao INNER JOIN (SELECT d.idDivisao, d.descricao, COUNT(f.idFuncionario) as totFunc FROM funcionario as f INNER JOIN secao as s ON s.idSecao = f.idSecao INNER JOIN divisao as d ON s.idDivisao = d.idDivisao GROUP BY d.idDivisao) as TotFuncDivisao ON TotHorasDivisao.idDivisao = TotFuncDivisao.idDivisao;";

        $queryMediaGerencia = "SELECT TotFuncGerencia.descricao, ROUND((totalHorasFunc/totFunc),2) as mediaGerencia FROM (SELECT g.idGerencia, g.descricao, ROUND(SUM(a.qtdHoras),2) as totalHorasFunc FROM absenteismo as a INNER JOIN funcionario as f ON a.idFuncionario = f.idFuncionario INNER JOIN secao as s ON f.idSecao = s.idSecao INNER JOIN divisao as d ON d.idDivisao = s.idDivisao INNER JOIN gerencia as g ON g.idGerencia = d.idGerencia WHERE mes < 7  AND ano = $ano GROUP BY g.idGerencia ORDER BY totalHorasFunc DESC) as TotHorasGerencia INNER JOIN (SELECT g.idGerencia, g.descricao, COUNT(f.idFuncionario) as totFunc FROM funcionario as f INNER JOIN secao as s ON s.idSecao = f.idSecao INNER JOIN divisao as d ON s.idDivisao = d.idDivisao INNER JOIN gerencia as g ON g.idGerencia = d.idGerencia GROUP BY g.idGerencia) as TotFuncGerencia ON TotHorasGerencia.idGerencia = TotFuncGerencia.idGerencia;";
        
        $queryTotalGerencia = "SELECT g.descricao, ROUND(SUM(a.qtdHoras),2) as totalHorasFunc FROM absenteismo as a INNER JOIN funcionario as f ON a.idFuncionario = f.idFuncionario INNER JOIN secao as s ON f.idSecao = s.idSecao INNER JOIN divisao as d ON d.idDivisao = s.idDivisao INNER JOIN gerencia as g ON g.idGerencia = d.idGerencia WHERE mes < 7  AND ano = $ano GROUP BY g.idGerencia ORDER BY totalHorasFunc DESC;";
        
        $queryFuncSemAbsenteismo = "SELECT * FROM funcionario WHERE idFuncionario NOT IN (SELECT idFuncionario FROM absenteismo where mes < 7 AND ano = $ano)";
    } else {
        $queryFuncionarioMais = "SELECT f.cracha, f.nome, ROUND(SUM(a.qtdHoras),2) as totalHorasFunc FROM absenteismo as a INNER JOIN funcionario as f ON a.idFuncionario = f.idFuncionario WHERE mes > 6  AND ano = $ano GROUP BY f.idFuncionario ORDER BY totalHorasFunc DESC LIMIT 30;";

        $queryMediaSecao = "SELECT TotFuncSecao.descricao, ROUND((totalHorasFunc/totFunc),2) as mediaSecao FROM (SELECT s.idSecao, ROUND(SUM(a.qtdHoras),2) as totalHorasFunc FROM absenteismo as a INNER JOIN funcionario as f ON a.idFuncionario = f.idFuncionario INNER JOIN secao as s ON f.idSecao = s.idSecao WHERE mes > 6   AND ano = $ano GROUP BY s.idSecao ORDER BY totalHorasFunc DESC) as TotHorasSecao INNER JOIN (SELECT s.idSecao, s.descricao, COUNT(f.idFuncionario) as totFunc FROM funcionario as f INNER JOIN secao as s ON s.idSecao = f.idSecao GROUP BY f.idSecao) as TotFuncSecao ON TotHorasSecao.idSecao = TotFuncSecao.idSecao;";

        $queryTotalSecao = "SELECT s.descricao, ROUND(SUM(a.qtdHoras),2) as totalHorasFunc FROM absenteismo as a INNER JOIN funcionario as f ON a.idFuncionario = f.idFuncionario INNER JOIN secao as s ON f.idSecao = s.idSecao WHERE mes > 6   AND ano = $ano GROUP BY s.idSecao ORDER BY totalHorasFunc DESC;";
        
        $queryMediaDivisao = "SELECT TotFuncDivisao.descricao, ROUND((totalHorasFunc/totFunc),2) as mediaDivisao FROM (SELECT d.idDivisao, ROUND(SUM(a.qtdHoras),2) as totalHorasFunc FROM absenteismo as a INNER JOIN funcionario as f ON a.idFuncionario = f.idFuncionario INNER JOIN secao as s ON f.idSecao = s.idSecao INNER JOIN divisao as d ON d.idDivisao = s.idDivisao WHERE mes > 6  AND ano = $ano GROUP BY d.idDivisao ORDER BY totalHorasFunc DESC) as TotHorasDivisao INNER JOIN (SELECT d.idDivisao, d.descricao, COUNT(f.idFuncionario) as totFunc FROM funcionario as f INNER JOIN secao as s ON s.idSecao = f.idSecao INNER JOIN divisao as d ON s.idDivisao = d.idDivisao GROUP BY d.idDivisao) as TotFuncDivisao ON TotHorasDivisao.idDivisao = TotFuncDivisao.idDivisao;";

        $queryTotalDivisao = "SELECT d.descricao, ROUND(SUM(a.qtdHoras),2) as totalHorasFunc FROM absenteismo as a INNER JOIN funcionario as f ON a.idFuncionario = f.idFuncionario INNER JOIN secao as s ON f.idSecao = s.idSecao INNER JOIN divisao as d ON d.idDivisao = s.idDivisao WHERE mes > 6  AND ano = $ano GROUP BY d.idDivisao ORDER BY totalHorasFunc DESC;";
        
        $queryMediaGerencia = "SELECT TotFuncGerencia.descricao, ROUND((totalHorasFunc/totFunc),2) as mediaGerencia FROM (SELECT g.idGerencia, g.descricao, ROUND(SUM(a.qtdHoras),2) as totalHorasFunc FROM absenteismo as a INNER JOIN funcionario as f ON a.idFuncionario = f.idFuncionario INNER JOIN secao as s ON f.idSecao = s.idSecao INNER JOIN divisao as d ON d.idDivisao = s.idDivisao INNER JOIN gerencia as g ON g.idGerencia = d.idGerencia WHERE mes > 6  AND ano = $ano GROUP BY g.idGerencia ORDER BY totalHorasFunc DESC) as TotHorasGerencia INNER JOIN (SELECT g.idGerencia, g.descricao, COUNT(f.idFuncionario) as totFunc FROM funcionario as f INNER JOIN secao as s ON s.idSecao = f.idSecao INNER JOIN divisao as d ON s.idDivisao = d.idDivisao INNER JOIN gerencia as g ON g.idGerencia = d.idGerencia GROUP BY g.idGerencia) as TotFuncGerencia ON TotHorasGerencia.idGerencia = TotFuncGerencia.idGerencia;";
        
        $queryTotalGerencia = "SELECT g.descricao, ROUND(SUM(a.qtdHoras),2) as totalHorasFunc FROM absenteismo as a INNER JOIN funcionario as f ON a.idFuncionario = f.idFuncionario INNER JOIN secao as s ON f.idSecao = s.idSecao INNER JOIN divisao as d ON d.idDivisao = s.idDivisao INNER JOIN gerencia as g ON g.idGerencia = d.idGerencia WHERE mes > 6  AND ano = $ano GROUP BY g.idGerencia ORDER BY totalHorasFunc DESC;";
        
        $queryFuncSemAbsenteismo = "SELECT f.cracha, f.nome FROM funcionario AS f WHERE f.idFuncionario NOT IN (SELECT idFuncionario FROM absenteismo where mes > 6 AND ano = $ano)";
    }
        
    $graficoFuncionarioMais = $link->query($queryFuncionarioMais);
    
    $graficoSecao = $link->query($queryMediaSecao);
    
    $graficoSecao2 = $link->query($queryTotalSecao);
    
    $graficoDivisao = $link->query($queryMediaDivisao);
    
    $graficoDivisao2 = $link->query($queryTotalDivisao);
    
    $graficoGerencia = $link->query($queryMediaGerencia);
    
    $graficoGerencia2 = $link->query($queryTotalGerencia);
    
    $graficoFuncionarioZero = $link->query($queryFuncSemAbsenteismo);
    
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
                ['Seção ','Média de horas '],
                <?php
                    while ($array = mysqli_fetch_array($graficoSecao)){
                        echo "['".$array[0]."', ".$array[1]."],";
                    }
                ?>
               ]);

            
            var options = {
              title: 'Média de horas de absenteísmo por seção'
            };

            var chart = new google.visualization.BarChart(document.getElementById('grafSecao'));
            chart.draw(data, options);
        }

    </script>
    
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});

        google.charts.setOnLoadCallback(drawChart);
        function drawChart(){
            var data = new google.visualization.DataTable();
            var data = google.visualization.arrayToDataTable([
                ['Seção ','Total de horas '],
                <?php
                    while ($array = mysqli_fetch_array($graficoSecao2)){
                        echo "['".$array[0]."', ".$array[1]."],";
                    }
                ?>
               ]);

            var options = {
              title: 'Total de horas de absenteísmo por seção',
              is3D: true,
            };
            

            var chart = new google.visualization.ColumnChart(document.getElementById('grafSecao2'));
            chart.draw(data, options);
        }

    </script>
    
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});

        google.charts.setOnLoadCallback(drawChart);
        function drawChart(){
            var data = new google.visualization.DataTable();
            var data = google.visualization.arrayToDataTable([
                ['Divisão: ','Média de horas '],
                <?php
                    while ($array = mysqli_fetch_array($graficoDivisao)){
                        echo "['".$array[0]."', ".$array[1]."],";
                    }
                ?>
               ]);

            
            var options = {
                title: 'Média de horas de absenteísmo por divisão'

            };

            var chart = new google.visualization.BarChart(document.getElementById('grafDivisao'));
            chart.draw(data, options);
        }

    </script>
    
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});

        google.charts.setOnLoadCallback(drawChart);
        function drawChart(){
            var data = new google.visualization.DataTable();
            var data = google.visualization.arrayToDataTable([
                ['Divisão: ','Total de horas '],
                <?php
                    while ($array = mysqli_fetch_array($graficoDivisao2)){
                        echo "['".$array[0]."', ".$array[1]."],";
                    }
                ?>
               ]);

            
            var options = {
                title: 'Total de horas de absenteísmo por divisão',
                is3D: true

            };

            var chart = new google.visualization.PieChart(document.getElementById('grafDivisao2'));
            chart.draw(data, options);
        }

    </script>
    
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});

        google.charts.setOnLoadCallback(drawChart);
        function drawChart(){
            var data = new google.visualization.DataTable();
            var data = google.visualization.arrayToDataTable([
                ['Gerência: ','Média de horas '],
                <?php
                    while ($array = mysqli_fetch_array($graficoGerencia)){
                        echo "['".$array[0]."', ".$array[1]."],";
                    }
                ?>
               ]);

            
            var options = {
              title: 'Média de horas de absenteísmo por gerência',
              pieHole: 0.4,
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('grafGerencia'));
            chart.draw(data, options);


        }

    </script>
    
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});

        google.charts.setOnLoadCallback(drawChart);
        function drawChart(){
            var data = new google.visualization.DataTable();
            var data = google.visualization.arrayToDataTable([
                ['Gerência: ','Total de horas '],
                <?php
                    while ($array = mysqli_fetch_array($graficoGerencia2)){
                        echo "['".$array[0]."', ".$array[1]."],";
                    }
                ?>
               ]);

            
            var options = {
              title: 'Total de horas de absenteísmo por gerência',
              pieHole: 0.4,
            };

            var chart = new google.visualization.PieChart(document.getElementById('grafGerencia2'));
            chart.draw(data, options);


        }

    </script>
  </head>

  <body>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
      <!--<h5 class="my-0 mr-md-auto font-weight-normal">Company name</h5>-->
      <img src="../../imagens/logo2.png" class="my-0 mr-md-auto font-weight-normal" />
      
      <nav class="my-2 my-md-0 mr-md-3" id="noprint">
          <?php
            include('../../includes/Menus.php');
          ?>
      </nav>
      <a class="btn btn-outline-primary" href="../../Controler/logout.php" id="noprint">Sair</a>
    </div>

     <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Relatório</h1><br />
        <h3>Horas de absenteísmo - <?=$semestre?>º semestre - <?=$ano?></h3>
        <a href="GeraAbsenteismo.php" class="btn btn-primary" id="noprint">Voltar</a>
    </div>

    <div class="container">
        <div>   
            <!--<div id="grafFuncMais" style="width: 1000px; height: 1200px"></div>-->
            <table border='1' class="table">
                <thead class="thead-dark">
                    <tr>
                        <th colspan="4" class='text-center h4'>30 Funcionários com os maiores absenteísmo no período:</th>
                    </tr>
                </thead>
                <tr class="text-center">
                    <th>Ordem:</th>
                    <th>Crachá:</th>
                    <th>Funcionário: </th>
                    <th>Quant. Horas: </th>
                </tr>
                <?php
                    $cont = 1;
                    while ($array = mysqli_fetch_array($graficoFuncionarioMais)){
                        echo "<tr><td class='text-center'>".$cont."</td><td class='text-center'>".str_pad($array[0],3,0, STR_PAD_LEFT)."</td><td>".$array[1]."</td></td><td class='text-center'>".$array[2]."</td></tr>";
                        $cont+=1;
                    }
                ?>
            </table>
            <table border='1' class="table">
                <thead class="thead-dark">
                    <tr>
                        <th colspan="4" class='text-center h4'>Funcionários com absenteísmo 0 no período (por crachá):</th>
                    </tr>
                </thead>
                <tr class="text-center">
                    <th>Ordem:</th>
                    <th>Crachá:</th>
                    <th>Funcionário: </th>
                </tr>
                <?php
                    $cont = 1;
                    while ($array = mysqli_fetch_array($graficoFuncionarioZero)){
                        echo "<tr><td class='text-center'>".$cont."</td><td class='text-center'>".str_pad($array[0],3,0, STR_PAD_LEFT)."</td><td>".$array[1]."</td></td></tr>";
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
                    <div id="grafSecao2" style="width: 920px; height: 900px"></div>
                </div>
            </div>
            <div class="card-deck mb-2 text-center">
                <div class="card mb-3 box-shadow">                
                    <div id="grafDivisao" style="width: 920px; height: 600px"></div>
                </div>
            </div>
            <div class="card-deck mb-2 text-center">
                <div class="card mb-3 box-shadow">                
                    <div id="grafDivisao2" style="width: 920px; height: 600px"></div>
                </div>
            </div>
            <div class="card-deck mb-2 text-center">
                <div class="card mb-3 box-shadow">                
                    <div id="grafGerencia" style="width: 920px; height: 600px"></div>
                </div>
            </div>
            <div class="card-deck mb-2 text-center">
                <div class="card mb-3 box-shadow">                
                    <div id="grafGerencia2" style="width: 920px; height: 600px"></div>
                </div>
            </div>
                Gerado em: <?php
                    date_default_timezone_set('America/Sao_Paulo');
                    $date = date('d/m/Y H:i:s');
                    echo $date;               
                ?>
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
