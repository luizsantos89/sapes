<?php
    session_start();
   // require('../../includes/conexao.inc');
    //require('../../includes/verificaSessao');
    
    $link = mysqli_connect("localhost", "root", "", "sapes");
    
    $querySecao = "select s.descricao, COUNT(*) as qtdFuncionario from funcionario as f inner join secao as s on f.idSecao = s.idSecao GROUP BY f.idSecao;";
    
    $queryDivisao = "select d.descricao, COUNT(*) as qtdFuncionario from funcionario as f inner join secao as s on f.idSecao = s.idSecao inner join divisao as d ON d.idDivisao = s.idDivisao GROUP BY d.idDivisao;";
    
    $queryGerencia = "select g.descricao, COUNT(*) as qtdFuncionario from funcionario as f inner join secao as s on f.idSecao = s.idSecao inner join divisao as d ON d.idDivisao = s.idDivisao INNER JOIN gerencia AS g ON g.idGerencia = d.idGerencia GROUP BY g.idGerencia;";
    
    $graficoSecao = $link->query($querySecao);
    
    $graficoDivisao = $link->query($queryDivisao);
    
    $graficoGerencia = $link->query($queryGerencia);
    
?>

<!DOCTYPE html>
<html>
<head>
    <title>Massive Electronics</title>
    <script type="text/javascript" src="../../scripts/loader.js">
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
    <div id="grafSecao" style="width: 1200px; height: 1200px"></div>
    <div id="grafDivisao" style="width: 1200px; height: 1200px"></div>
    <div id="grafGerencia" style="width: 1200px; height: 1200px"></div>
</body>
</html>