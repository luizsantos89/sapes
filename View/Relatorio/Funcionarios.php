<?php
    session_start();
    
    include("../../includes/verificaSessao.php");
    
    $usuario = $_SESSION['usuario'];    
    
    $link = mysqli_connect("localhost", "root", "", "sapes");
    
    $querySexo = "SELECT sexo, COUNT(*) as quantidade FROM funcionario GROUP BY sexo";
    
    $queryFaixaEtaria = "select 
                            case when TIMESTAMPDIFF(YEAR, dataNascimento, CURDATE()) BETWEEN 18 AND 30 then   
                                            'Entre 18 e 30'  
                                     when TIMESTAMPDIFF(YEAR, dataNascimento, CURDATE()) BETWEEN 30 AND 40 then    
                                            'Entre 30 e 40'  
                                     when TIMESTAMPDIFF(YEAR, dataNascimento, CURDATE()) BETWEEN 40 AND 50 then    
                                            'Entre 40 e 50'
                                     when TIMESTAMPDIFF(YEAR, dataNascimento, CURDATE()) BETWEEN 50 AND 60 then    
                                            'Entre 50 e 60'
                                     when TIMESTAMPDIFF(YEAR, dataNascimento, CURDATE()) > 60 then    
                                            'Acima de 60'
                             end as faixaEtaria  
                    , count(*) as quantidade  
                    from funcionario
                    group by dataNascimento;";
    
    $queryCargo = "SELECT cargo, COUNT(*) FROM funcionario GROUP BY cargo;";
    
    $querySituacao = "SELECT situacao, COUNT(*) FROM funcionario GROUP BY situacao;";
    
    $querySecao = "select s.descricao, COUNT(*) as qtdFuncionario from funcionario as f inner join secao as s on f.idSecao = s.idSecao GROUP BY f.idSecao;";
    
    $queryDivisao = "select d.descricao, COUNT(*) as qtdFuncionario from funcionario as f inner join secao as s on f.idSecao = s.idSecao inner join divisao as d ON d.idDivisao = s.idDivisao GROUP BY d.idDivisao;";
    
    $queryGerencia = "select g.descricao, COUNT(*) as qtdFuncionario from funcionario as f inner join secao as s on f.idSecao = s.idSecao inner join divisao as d ON d.idDivisao = s.idDivisao INNER JOIN gerencia AS g ON g.idGerencia = d.idGerencia GROUP BY g.idGerencia;";
    
    $graficoSexo = $link->query($querySexo);
    
    $graficoCargo = $link->query($queryCargo);
    
    $graficoSituacao = $link->query($querySituacao);
    
    $graficoFaixaEtaria = $link->query($queryFaixaEtaria);
    
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

    <!-- Custom styles for this template -->
    <link href="../../estilos/css/pricing.css" rel="stylesheet">
    <script type="text/javascript" src="../../scripts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});

        google.charts.setOnLoadCallback(drawChart);
        function drawChart(){
            var data = new google.visualization.DataTable();
            var data = google.visualization.arrayToDataTable([
                ['Situação','Quantidade'],
                <?php
                    while ($array = mysqli_fetch_array($graficoSituacao)){
                        echo "['".$array[0]."', ".$array[1]."],";
                    }
                ?>
               ]);

            
        var options = {
          title: 'Funcionários por situação'
        };

        var chart = new google.visualization.PieChart(document.getElementById('grafSituacao'));
        chart.draw(data, options);

        }

    </script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});

        google.charts.setOnLoadCallback(drawChart);
        function drawChart(){
            var data = new google.visualization.DataTable();
            var data = google.visualization.arrayToDataTable([
                ['Cargo','Quantidade'],
                <?php
                    while ($array = mysqli_fetch_array($graficoCargo)){
                        echo "['".$array[0]."', ".$array[1]."],";
                    }
                ?>
               ]);

            
        var options = {
          title: 'Funcionários por cargo'
        };

        var chart = new google.visualization.PieChart(document.getElementById('grafCargo'));
        chart.draw(data, options);

        }

    </script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});

        google.charts.setOnLoadCallback(drawChart);
        function drawChart(){
            var data = new google.visualization.DataTable();
            var data = google.visualization.arrayToDataTable([
                ['Faixa Etaria','Quantidade'],
                <?php
                    while ($array = mysqli_fetch_array($graficoFaixaEtaria)){
                        echo "['".$array[0]."', ".$array[1]."],";
                    }
                ?>
               ]);

            
        var options = {
          title: 'Funcionários por faixa etária',
          pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('grafFaixaEtaria'));
        chart.draw(data, options);

        }

    </script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});

        google.charts.setOnLoadCallback(drawChart);
        function drawChart(){
            var data = new google.visualization.DataTable();
            var data = google.visualization.arrayToDataTable([
                ['Sexo','Quantidade'],
                <?php
                    while ($array = mysqli_fetch_array($graficoSexo)){
                        echo "['".$array[0]."', ".$array[1]."],";
                    }
                ?>
               ]);

            
        var options = {
          title: 'Funcionários por sexo',
          pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('grafSexo'));
        chart.draw(data, options);

        }

    </script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});

        google.charts.setOnLoadCallback(drawChart);
        function drawChart(){
            var data = new google.visualization.DataTable();
            var data = google.visualization.arrayToDataTable([
                ['Seção','Quantidade'],
                <?php
                    while ($array = mysqli_fetch_array($graficoSecao)){
                        echo "['".$array[0]."', ".$array[1]."],";
                    }
                ?>
               ]);

            
        var options = {
          title: 'Funcionários por seção',
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
                ['Divisão','Quantidade'],
                <?php
                    while ($array = mysqli_fetch_array($graficoDivisao)){
                        echo "['".$array[0]."', ".$array[1]."],";
                    }
                ?>
               ]);

            
        var options = {
          title: 'Funcionários por divisão',
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
                ['Gerência','Quantidade'],
                <?php
                    while ($array = mysqli_fetch_array($graficoGerencia)){
                        echo "['".$array[0]."', ".$array[1]."],";
                    }
                ?>
               ]);

            
        var options = {
          title: 'Funcionários por gerência',
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
        <h3>Funcionários</h3>
    </div>

    <div class="container">
        <div class="card-deck mb-2 text-center">
            <div class="card mb-3 box-shadow">                
                <div id="grafFaixaEtaria" style="width: 900px; height: 400px"></div>
            </div>
        </div>
        <div class="card-deck mb-2 text-center">
            <div class="card mb-3 box-shadow">                
                <div id="grafSexo" style="width: 900px; height: 400px"></div>
            </div>
        </div>
        <div class="card-deck mb-2 text-center">
            <div class="card mb-3 box-shadow">                
                <div id="grafCargo" style="width: 900px; height: 400px"></div>
            </div>
        </div>
        <div class="card-deck mb-2 text-center">
            <div class="card mb-3 box-shadow">                
                <div id="grafSituacao" style="width: 900px; height: 400px"></div>
            </div>
        </div>
        <div class="card-deck mb-2 text-center">
            <div class="card mb-3 box-shadow">                
                <div id="grafSecao" style="width: 900px; height: 400px"></div>
            </div>
        </div>
        <div class="card-deck mb-2 text-center">
            <div class="card mb-4 box-shadow">  
                <div id="grafDivisao" style="width: 900px; height: 400px"></div>
            </div>
        </div>
        <div class="card-deck mb-2 text-center">
            <div class="card mb-4 box-shadow">  
                <div id="grafGerencia" style="width: 900px; height: 400px"></div>
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
