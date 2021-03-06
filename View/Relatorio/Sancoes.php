<?php
    session_start();
    
    include("../../includes/verificaSessao.php");
    
    if(isset($_REQUEST['semestre'])){
        $semestre = (int) $_REQUEST['semestre'];
        $ano = (int) $_REQUEST['ano'];
        if ($semestre == 1) {
            $dataInicial = $ano.'-01-01 00:00:00';
            $dataFinal =$ano.'-06-30 23:59:59';
        } else {
            $dataInicial = $ano.'-07-01 00:00:00';
            $dataFinal = $ano.'-12-31 23:59:59';
        }
    } else {
        header("Location: GeraSancao.php");
    } 
    
    $usuario = $_SESSION['usuario'];   
    
    $link = mysqli_connect("localhost", "root", "", "sapes");
    
    $queryFuncionario = "select * FROM (select f.cracha, f.nome, COUNT(*) as quantidade from sancao AS s INNER JOIN funcionario AS f ON s.idFuncionario = f.idFuncionario WHERE dataSancao BETWEEN '$dataInicial' AND '$dataFinal' GROUP BY s.idFuncionario) as selecao ORDER BY quantidade DESC;";
        
    $querySecao = "select * FROM (select sc.descricao as nome, COUNT(*) as quantidade from sancao AS s INNER JOIN funcionario AS f ON s.idFuncionario = f.idFuncionario INNER JOIN secao AS sc ON f.idSecao = sc.idSecao WHERE dataSancao BETWEEN '$dataInicial' AND '$dataFinal' GROUP BY sc.idSecao) as selecao ORDER BY quantidade DESC;";
    
    $queryDivisao = "select * FROM (select d.descricao as nome, COUNT(*) as quantidade from sancao AS s INNER JOIN funcionario AS f ON s.idFuncionario = f.idFuncionario INNER JOIN secao AS sc ON f.idSecao = sc.idSecao INNER JOIN divisao AS d ON sc.idDivisao = d.idDivisao WHERE dataSancao BETWEEN '$dataInicial' AND '$dataFinal'   GROUP BY d.idDivisao) as selecao ORDER BY quantidade DESC;";
    
    $queryGerencia = "select * FROM (select g.descricao as nome, COUNT(*) as quantidade from sancao AS s INNER JOIN funcionario AS f ON s.idFuncionario = f.idFuncionario INNER JOIN secao AS sc ON f.idSecao = sc.idSecao INNER JOIN divisao AS d ON sc.idDivisao = d.idDivisao INNER JOIN gerencia AS g ON g.idGerencia = d.idGerencia WHERE dataSancao BETWEEN '$dataInicial' AND '$dataFinal' GROUP BY g.idGerencia) as selecao ORDER BY quantidade DESC;";
    
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
                ['Seção: ','Quantidade: '],
                <?php
                    while ($array = mysqli_fetch_array($graficoSecao)){
                        echo "['".$array[0]."', ".$array[1]."],";
                    }
                ?>
               ]);

            
            var options = {
              title: 'Total de sanções por seção',
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
                ['Divisão: ','Quantidade: '],
                <?php
                    while ($array = mysqli_fetch_array($graficoDivisao)){
                        echo "['".$array[0]."', ".$array[1]."],";
                    }
                ?>
               ]);

            
            var options = {
                title: 'Total de sanções divisão',
                is3D: true,
                slices: {  8: {offset: 0.2},
                          9: {offset: 0.4},
                          10: {offset: 0.7},
                          11: {offset: 1.0},
                },

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
                ['Gerência: ','Quantidade: '],
                <?php
                    while ($array = mysqli_fetch_array($graficoGerencia)){
                        echo "['".$array[0]."', ".$array[1]."],";
                    }
                ?>
               ]);

            
            var options = {
              title: 'Total de sanções por gerência',
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
        <h3>Sanções - <?=$semestre?>º semestre - <?=$ano?></h3>
        <a href="GeraAbsenteismo.php" class="btn btn-primary">Voltar</a>
    </div>

    <div class="container">
        <div class="text-center">   
            <!--<div id="grafFuncMais" style="width: 1000px; height: 1200px"></div>-->
            <table border='1' class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th colspan="4" class='text-center h4'>Funcionários com sanções no período:</th>
                    </tr>
                </thead>
                <tr>
                    <th>Ordem:</th>
                    <th>Crachá:</th>
                    <th>Funcionário: </th>
                    <th>Quant. Sanções: </th>
                </tr>
                <?php
                    $cont = 1;
                    while ($array = mysqli_fetch_array($graficoFuncionario)){
                        echo "<tr><td>".$cont.'</td><td>'.str_pad($array[0],3,0,STR_PAD_LEFT)."</td><td align='left'>".$array[1]."</td><td>".$array[2]."</td></tr>";
                        $cont+=1;
                    }
                ?>
            </table>
            <div class="card-deck mb-2 text-center">
                <div class="card mb-3 box-shadow">                
                    <div id="grafSecao" style="width: 920px; height: 600px"></div>
                </div>
            </div>
            <div class="card-deck mb-2 text-center">
                <div class="card mb-3 box-shadow">                
                    <div id="grafDivisao" style="width: 920px; height:600px"></div>
                </div>
            </div>
            <div class="card-deck mb-2 text-center">
                <div class="card mb-3 box-shadow">                
                    <div id="grafGerencia" style="width: 920px; height: 600px"></div>
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
