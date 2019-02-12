<?php
    session_start();
    
    include("../../includes/verificaSessao.php");
    
    $usuario = $_SESSION['usuario'];    
    
    $link = mysqli_connect("localhost", "sapes", "seti@2018", "sapes");
    
    $queryFuncionario = "select * FROM (select f.nome, COUNT(*) as quantidade from sancao AS s INNER JOIN funcionario AS f ON s.idFuncionario = f.idFuncionario GROUP BY s.idFuncionario) as selecao ORDER BY quantidade DESC LIMIT 10;";
    
    $querySecao = "select * FROM (select sc.descricao as nome, COUNT(*) as quantidade from sancao AS s INNER JOIN funcionario AS f ON s.idFuncionario = f.idFuncionario INNER JOIN secao AS sc ON f.idSecao = sc.idSecao GROUP BY sc.idSecao) as selecao ORDER BY quantidade DESC;";
    
    $queryDivisao = "select * FROM (select d.descricao as nome, COUNT(*) as quantidade from sancao AS s INNER JOIN funcionario AS f ON s.idFuncionario = f.idFuncionario INNER JOIN secao AS sc ON f.idSecao = sc.idSecao INNER JOIN divisao AS d ON sc.idDivisao = d.idDivisao GROUP BY d.idDivisao) as selecao ORDER BY quantidade DESC;";
    
    $queryGerencia = "select * FROM (select g.descricao as nome, COUNT(*) as quantidade from sancao AS s INNER JOIN funcionario AS f ON s.idFuncionario = f.idFuncionario INNER JOIN secao AS sc ON f.idSecao = sc.idSecao INNER JOIN divisao AS d ON sc.idDivisao = d.idDivisao INNER JOIN gerencia AS g ON g.idGerencia = d.idGerencia GROUP BY g.idGerencia) as selecao ORDER BY quantidade DESC;";
    
    $graficoFuncionario = $link->query($queryFuncionario);
    
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

    <title>Avaliação de Desempenho - DVRH/FJF</title>

    <!-- Bootstrap core CSS -->
    <link href="../../estilos/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../estilos/css/pricing.css" rel="stylesheet">
    <script type="text/javascript" src="../../scripts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});

        google.charts.setOnLoadCallback(drawChart);
        function drawChart(){
            var data = new google.visualization.DataTable();
            var data = google.visualization.arrayToDataTable([
                ['Nome','Quantidade'],
                <?php
                    while ($array = mysqli_fetch_array($graficoFuncionario)){
                        echo "['".$array[0]."', ".$array[1]."],";
                    }
                ?>
               ]);

           
            var options = {
              title: '10 funcionários com mais sanções disciplinares',
              is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('grafFunc'));
            chart.draw(data, options);
        }

    </script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});

        google.charts.setOnLoadCallback(drawChart);
        function drawChart(){
            var data = new google.visualization.DataTable();
            var data = google.visualization.arrayToDataTable([
                ['Nome','Quantidade'],
                <?php
                    while ($array = mysqli_fetch_array($graficoSecao)){
                        echo "['".$array[0]."', ".$array[1]."],";
                    }
                ?>
               ]);

            
            var options = {
              title: 'Sanções por seção (total)',
              is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('grafSecao'));
            chart.draw(data, options);
        }

    </script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});

        google.charts.setOnLoadCallback(drawChart);
        function drawChart(){
            var data = new google.visualization.DataTable();
            var data = google.visualization.arrayToDataTable([
                ['Nome','Quantidade'],
                <?php
                    while ($array = mysqli_fetch_array($graficoDivisao)){
                        echo "['".$array[0]."', ".$array[1]."],";
                    }
                ?>
               ]);

            
            var options = {
              title: 'Sanções por divisão (total)',
              is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('grafDivisao'));
            chart.draw(data, options);
        }

    </script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});

        google.charts.setOnLoadCallback(drawChart);
        function drawChart(){
            var data = new google.visualization.DataTable();
            var data = google.visualization.arrayToDataTable([
                ['Nome','Quantidade'],
                <?php
                    while ($array = mysqli_fetch_array($graficoGerencia)){
                        echo "['".$array[0]."', ".$array[1]."],";
                    }
                ?>
               ]);

            
            var options = {
              title: 'Sanções por gerência (total)',
              pieHole: 0.4,
            };

            var chart = new google.visualization.PieChart(document.getElementById('grafGerencia'));
            chart.draw(data, options);


        }

    </script>
  </head>

  <body>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
      <!--<h5 class="my-0 mr-md-auto font-weight-normal">Company name</h5>-->
      <img src="../../imagens/logo2.png" class="my-0 mr-md-auto font-weight-normal" />
      
      <nav class="my-2 my-md-0 mr-md-3">
          <?php
            include('../../includes/Menus.php');
          ?>
      </nav>
      <a class="btn btn-outline-primary" href="../../Controler/logout.php">Sair</a>
    </div>

     <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Relatório</h1><br />
        <h3>Sanções disciplinares</h3>
    </div>

    <div class="container">
        <div class="card-deck mb-2 text-center">
            <div class="card mb-3 box-shadow">                
                <div id="grafFunc" style="width: 1100px; height: 650px"></div>
                <div id="grafSecao" style="width: 1100px; height: 650px"></div>
                <div id="grafDivisao" style="width: 1100px; height: 650px"></div>
                <div id="grafGerencia" style="width: 1100px; height: 650px"></div>
            </div>
        </div>
    </div>
    <div class="container">
        <footer class="pt-4 my-md-5 pt-md-5 border-top">
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
