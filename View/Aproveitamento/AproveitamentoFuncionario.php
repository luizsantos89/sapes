<?php
    session_start();
    require '../../includes/Conexao.inc';
    require '../../Model/FuncionarioDAO.php';
    $usuario = $_SESSION['usuario'];
    $idFuncionario = $_REQUEST['idFuncionario'];
    $funcionario = new Funcionario();
    $funcionarioDAO = new FuncionarioDAO();
    $funcionario = $funcionarioDAO->getFuncionarioByID($idFuncionario);
    $indiceDesempenho = 0;
    $indiceAbsent = 1;
    $indiceDisciplinar = 1;
    $indiceAproveitamento = 0; 
    $absentTotal = 0; 
    $maxAbsenteismo = 0;
    $fatorDisciplinar = 0;
    
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap core CSS -->
    <link href="../../estilos/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../estilos/css/pricing.css" rel="stylesheet">
    
    <style type="text/css">

      /* Sticky footer styles
      -------------------------------------------------- */

        html,
        body {
          height: 100%;
          size: A4 landscape;
          /* The html and body elements cannot have any padding or margin. */
        }

        /* Wrapper for page content to push down footer */
        #wrap {
          min-height: 100%;
          height: auto !important;
          height: 100%;
          /* Negative indent footer by it's height */
          margin: 0 auto -60px;
        }

        /* Set the fixed height of the footer here */
        #push,
        #footer {
          height: 60px;
        }
        #footer {
          background-color: #f5f5f5;
        }

        /* Lastly, apply responsive CSS fixes as necessary */
        @media (max-width: 767px) {
          #footer {
            margin-left: -20px;
            margin-right: -20px;
            padding-left: 20px;
            padding-right: 20px;
          }
        }

        @media print{
           #noprint{
               display:none;
           }
        }


      /* Custom page CSS
      -------------------------------------------------- */
      /* Not required for template or sticky footer method. */

      .container {
        width: auto;
        max-width: 680px;
      }
      .container .credit {
        margin: 20px 0;
      }

    </style>
    <link rel="icon" href="../imagens/imbel.ico">
    
    <title>Avaliação de Desempenho - DVRH/FJF</title>
  </head>

  <body>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow" id="noprint">
      <!--<h5 class="my-0 mr-md-auto font-weight-normal">Company name</h5>-->
      <img src="../imagens/logo2.png" class="my-0 mr-md-auto font-weight-normal" />
      
      <nav class="my-2 my-md-0 mr-md-3" id="noprint">
          <?php
            include('../../includes/Menus.php');
          ?>
      </nav>
      <a class="btn btn-outline-primary" href="../Controler/logout.php" id="noprint">Sair</a>
    </div>

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Aproveitamento Funcional</h1><br />
    </div>

    <div class="container">
        <?php
            if(isset($_REQUEST['semestre'])) {
                $semestre = (int) $_REQUEST['semestre'];
                $ano = (int) $_REQUEST['ano'];
        
        
                $link = mysqli_connect("localhost", "root", "", "sapes");

                if ($semestre == 1) {
                    $dataInicial = $ano.'0101';
                    $dataFinal = $ano.'0630';
                } else {
                    $dataInicial = $ano.'0701';
                    $dataFinal = $ano.'1231';
                } 
                
        ?>
        
        <b>Parâmetros: </b><br>
        Peso índice absenteísmo: 1<br>Peso índice disciplinar: 2<br>Peso índice aval. desempenho: 3<br />
        
        <table border="1" class="table table-striped">
            <tr>
                <th colspan="2" class="h4 text-center">Funcionario: <?=$funcionario->nome?> - Período: <?=$semestre?>º semestre <?=$ano?></th>
            </tr>
            <tr>
                <th>Crachá:</th>
                <td><?=$funcionario->cracha?></td>                
            </tr>
            <tr>                
                <th>Funcionário:</th>
                <td><?=$funcionario->nome?></td>
            </tr>
            
            <tr>
                <th>Carga Horária:</th>
                <td><?=$funcionario->cargaHoraria?></td>
            </tr>
            <tr>
                <th>Nota Desempenho:</th>
                <td>
                    <?php                        
                        $listaDesempenho = "SELECT d.idFuncionario, d.nota FROM desempenho as d 
                            INNER JOIN funcionario as f ON d.idFuncionario = f.idFuncionario
                            WHERE semestre = $semestre AND ano = $ano
                            GROUP BY idFuncionario;";

                        $desempenhoPeriodo = $link->query($listaDesempenho);

                        $nota = 0;   

                        //Imprime na tela o absenteísmo de todos
                        if($desempenhoPeriodo){
                            while($row = mysqli_fetch_array($desempenhoPeriodo)){
                                $idFuncionario = $row['idFuncionario'];
                                if($funcionario->idFuncionario == $idFuncionario) {
                                    $nota = $row['nota']; 
                                }
                            }
                        }

                        echo $nota;
                    ?>                        
                </td>
            </tr>
            <tr>
                <th>i<sub>desemp</sub>:</th>
                <td>
                    <?php
                        if ($semestre == 1 ) {
                            $listaDesempenho = "SELECT d.idFuncionario, d.nota FROM desempenho as d 
                                                INNER JOIN funcionario as f ON d.idFuncionario = f.idFuncionario
                                                WHERE semestre = 1 AND ano = $ano
                                                GROUP BY idFuncionario;";
                        } else {
                            $listaDesempenho = "SELECT d.idFuncionario, d.nota FROM desempenho as d 
                                                INNER JOIN funcionario as f ON d.idFuncionario = f.idFuncionario
                                                WHERE semestre = 2 AND ano = $ano
                                                GROUP BY idFuncionario;";
                        }

                        $desempenhoPeriodo = $link->query($listaDesempenho);

                        //Define índice de desempenho
                        if($desempenhoPeriodo){
                            while($row = mysqli_fetch_array($desempenhoPeriodo)){
                                $idFuncionario = $row['idFuncionario'];
                                $nota = $row['nota'];
                                if($funcionario->idFuncionario == $idFuncionario)
                                    $indiceDesempenho = $nota/10;
                            }
                        }

                        echo $indiceDesempenho;
                    ?>
                </td>
            </tr>
            <tr>
                <th>P<sub>desemp</sub>:</th>
                <td>3</td>
            </tr>
            <tr>
                <th>Horas de absenteísmo:</th>
                <td>
                    <?php
                        if ($semestre == 1 ) {
                            $queryAbsenteismo = "select f.idFuncionario, ROUND(SUM(a.qtdHoras),2) as absentTotal FROM absenteismo as a
                            INNER JOIN funcionario AS f ON f.idFuncionario =  a.idFuncionario
                            WHERE a.mes between 1 AND 6  AND a.ano = $ano 
                            GROUP BY a.idFuncionario;";
                        } else {
                            $queryAbsenteismo = "select f.idFuncionario, ROUND(SUM(a.qtdHoras),2) as absentTotal FROM absenteismo as a
                            INNER JOIN funcionario AS f ON f.idFuncionario =  a.idFuncionario
                            WHERE a.mes between 7 AND 12  AND a.ano = $ano 
                            GROUP BY a.idFuncionario;";
                        }

                        $totalAbsenteismo = $link->query($queryAbsenteismo);

                        //Imprime na tela o absenteísmo de todos
                        if($totalAbsenteismo){
                            while($row = mysqli_fetch_array($totalAbsenteismo)){
                                $idFuncionario = $row['idFuncionario'];                                 
                                if($funcionario->idFuncionario == $idFuncionario) {
                                    $absentTotal = round($row['absentTotal'],2);   
                                } 
                            }
                        } 

                        echo $absentTotal;
                    ?>
                </td>
            </tr>
            <tr>
                <th>Max. absent. período:</th>
                <td>
                    <?php

                        if($semestre<2) {
                            $queryMaxAbsenteismo = "select idFuncionario, MAX(total) as totAbs from (SELECT idFuncionario, SUM(qtdHoras) AS total FROM absenteismo WHERE mes < 7 AND ano = $ano GROUP BY idFuncionario) AS horas";            
                        } else {
                            $queryMaxAbsenteismo = "select idFuncionario, MAX(total) as totAbs from (SELECT idFuncionario, SUM(qtdHoras) AS total FROM absenteismo WHERE mes < 7 AND ano = $ano GROUP BY idFuncionario) AS horas";             
                        }

                        $maxAbsenteismo =  $link->query($queryMaxAbsenteismo);

                        if($maxAbsenteismo){
                            $row = mysqli_fetch_array($maxAbsenteismo);
                            $idFuncionario = $row[0];
                            $maxAbsenteismo = (float) $row[1];
                            echo round($maxAbsenteismo,2);
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <th>i<sub>absent</sub>:</th>
                <td>
                    <?php
                        if ($semestre == 1 ) {
                            $queryAbsenteismo = "select f.idFuncionario, ROUND(SUM(a.qtdHoras),2) as absentTotal FROM absenteismo as a
                            INNER JOIN funcionario AS f ON f.idFuncionario =  a.idFuncionario
                            WHERE a.mes between 1 AND 6  AND a.ano = $ano 
                            GROUP BY a.idFuncionario;";
                        } else {
                            $queryAbsenteismo = "select f.idFuncionario, ROUND(SUM(a.qtdHoras),2) as absentTotal FROM absenteismo as a
                            INNER JOIN funcionario AS f ON f.idFuncionario =  a.idFuncionario
                            WHERE a.mes between 7 AND 12  AND a.ano = $ano 
                            GROUP BY a.idFuncionario;";
                        }

                        $totalAbsenteismo = $link->query($queryAbsenteismo);

                        if($semestre<2) {
                            $queryMaxAbsenteismo = "select idFuncionario, MAX(total) as totAbs from (SELECT idFuncionario, SUM(qtdHoras) AS total FROM absenteismo WHERE mes < 7 AND ano = $ano GROUP BY idFuncionario) AS horas";            
                        } else {
                            $queryMaxAbsenteismo = "select idFuncionario, MAX(total) as totAbs from (SELECT idFuncionario, SUM(qtdHoras) AS total FROM absenteismo WHERE mes < 7 AND ano = $ano GROUP BY idFuncionario) AS horas";             
                        }

                        $maxAbsenteismo =  $link->query($queryMaxAbsenteismo);

                        if($maxAbsenteismo){
                            $row = mysqli_fetch_array($maxAbsenteismo);
                            $idFuncionario = $row[0];
                            $maxAbsenteismo = (float) $row[1];
                        }
                        //Imprime na tela o absenteísmo de todos
                        if($totalAbsenteismo){
                            while($row = mysqli_fetch_array($totalAbsenteismo)){
                                $idFuncionario = $row['idFuncionario'];
                                if($idFuncionario == $funcionario->idFuncionario) {
                                    $absentTotal = $row['absentTotal'];
                                    if(round($absentTotal,2) == round($maxAbsenteismo,2)) {
                                        $indiceAbsent = 0;                                            
                                    } else {                                        
                                        if($absentTotal > 0) {
                                            $indiceAbsent = (1-round((($absentTotal*(round(($funcionario->cargaHoraria/44),1)))/$maxAbsenteismo),8));
                                        } else {
                                            $indiceAbsent = 1;
                                        }                                    
                                    }
                                }
                            }
                        }
                        echo $indiceAbsent;
                    ?>

                </td>
            </tr>
            <tr>
                <th>P<sub>absent</sub>:</th>
                <td>2</td>
            </tr>
            <tr>
                <th>f<sub>disc</sub>:</th>
                <td>
                    <?php
                    $querySancao = "SELECT idFuncionario, 
                        SUM(qtd*peso) AS fatorDisciplinar 
                             FROM 
                                             (SELECT f.nome, 
                                                             s.idFuncionario, 
                                                             COUNT(*) as qtd, 
                                                             t.peso 
                                         FROM sancao AS s
                                   INNER JOIN funcionario AS f ON s.idFuncionario = f.idFuncionario
                                   INNER JOIN tipo_sancao AS t ON t.idTipo = s.idTipo
                                   WHERE dataSancao between '20180101' AND '20180630'
                                   GROUP BY s.idFuncionario, 
                                                        t.peso) AS fDisc 
                             GROUP BY idFuncionario;";

                     $totalSancoesPeriodoFuncionario = $link->query($querySancao);


                     //Total de sanções disciplinares e o fator dsciplinar por período por funcionário
                     if($totalSancoesPeriodoFuncionario){
                         while($row = mysqli_fetch_array($totalSancoesPeriodoFuncionario)){
                             $idFuncionario = $row['idFuncionario'];
                             if($idFuncionario == $funcionario->idFuncionario) {
                                $fatorDisciplinar = $row['fatorDisciplinar'];
                             }
                         }
                     } 
                     echo $fatorDisciplinar;
                    ?>
                </td>
                
            </tr>
            <tr>
                <th>Máx. Fator Disciplinar Período:</th>
                    <td>
                        <?php  
                            //Maior índice no período:
                            $queryMaxSancao = "SELECT idFuncionario, MAX(fatorDisciplinar) as maxFator FROM (
                                SELECT nome, idFuncionario, SUM(qtd) as quantidade, SUM(qtd*peso) AS fatorDisciplinar FROM (SELECT f.nome, s.idFuncionario, COUNT(*) as qtd, t.peso 
                                  FROM sancao AS s
                            INNER JOIN funcionario AS f ON s.idFuncionario = f.idFuncionario
                            INNER JOIN tipo_sancao AS t ON t.idTipo = s.idTipo
                            WHERE dataSancao between '$dataInicial' AND '$dataFinal'
                            GROUP BY s.idFuncionario, t.peso) AS fDisc GROUP BY idFuncionario) AS fatorDisc";

                            $maxSancao = $link->query($queryMaxSancao);

                            if($maxSancao){
                                $row = mysqli_fetch_array($maxSancao);
                                $idFuncionario = $row[0];
                                $fatorDisciplinarMax = (float) $row[1];
                                echo $fatorDisciplinarMax;
                            }
                        ?>
                    </td>
            </tr>
            <tr>
                <th>i<sub>disc</sub>:</th>
                <td>
                    <?php  
                        //Maior índice no período:
                        //Maior índice no período:
                        $queryMaxSancao = "SELECT idFuncionario, MAX(fatorDisciplinar) as maxFator FROM (
                            SELECT nome, idFuncionario, SUM(qtd) as quantidade, SUM(qtd*peso) AS fatorDisciplinar FROM (SELECT f.nome, s.idFuncionario, COUNT(*) as qtd, t.peso 
                              FROM sancao AS s
                        INNER JOIN funcionario AS f ON s.idFuncionario = f.idFuncionario
                        INNER JOIN tipo_sancao AS t ON t.idTipo = s.idTipo
                        WHERE dataSancao between '$dataInicial' AND '$dataFinal'
                        GROUP BY s.idFuncionario, t.peso) AS fDisc GROUP BY idFuncionario) AS fatorDisc";

                        $maxSancao = $link->query($queryMaxSancao);

                        if($maxSancao){
                            $row = mysqli_fetch_array($maxSancao);
                            $idFuncionario = $row[0];
                            $fatorDisciplinarMax = (float) $row[1];                                
                        }

                        $querySancao = "SELECT nome, idFuncionario, SUM(qtd) as quantidade, SUM(qtd*peso) AS fatorDisciplinar FROM (SELECT f.nome, s.idFuncionario, COUNT(*) as qtd, t.peso 
                              FROM sancao AS s
                        INNER JOIN funcionario AS f ON s.idFuncionario = f.idFuncionario
                        INNER JOIN tipo_sancao AS t ON t.idTipo = s.idTipo
                        WHERE dataSancao between '$dataInicial' AND '$dataFinal'
                        GROUP BY s.idFuncionario, t.peso) AS fDisc GROUP BY idFuncionario";

                     $totalSancoesPeriodoFuncionario = $link->query($querySancao);


                     //Total de sanções disciplinares e o fator dsciplinar por período por funcionário
                     if($totalSancoesPeriodoFuncionario){
                         while($row = mysqli_fetch_array($totalSancoesPeriodoFuncionario)){
                             $idFuncionario = $row['idFuncionario'];
                             $fatorDisciplinar = $row['fatorDisciplinar'];
                             if($fatorDisciplinar && $fatorDisciplinar != 0) {
                                if($idFuncionario == $funcionario->idFuncionario)
                                    $indiceDisciplinar = 1-(($fatorDisciplinar/$fatorDisciplinarMax));

                             } 
                         }
                     }
                     echo $indiceDisciplinar;
                    ?>
                </td>
            </tr>
            <tr>
                <th>P<sub>disc</sub></th>
                <td>1</td>
            </tr>
            
            <tr>
                <th>i<sub>aprov</sub></th>
                <td>
                    <?php                          
                        //Maior índice no período:
                        //Maior índice no período:
                        $queryMaxSancao = "SELECT idFuncionario, MAX(fatorDisciplinar) as maxFator FROM (
                            SELECT nome, idFuncionario, SUM(qtd) as quantidade, SUM(qtd*peso) AS fatorDisciplinar FROM (SELECT f.nome, s.idFuncionario, COUNT(*) as qtd, t.peso 
                              FROM sancao AS s
                        INNER JOIN funcionario AS f ON s.idFuncionario = f.idFuncionario
                        INNER JOIN tipo_sancao AS t ON t.idTipo = s.idTipo
                        WHERE dataSancao between '$dataInicial' AND '$dataFinal'
                        GROUP BY s.idFuncionario, t.peso) AS fDisc GROUP BY idFuncionario) AS fatorDisc";

                        $maxSancao = $link->query($queryMaxSancao);

                        if($maxSancao){
                            $row = mysqli_fetch_array($maxSancao);
                            $idFuncionario = $row[0];
                            $fatorDisciplinarMax = (float) $row[1];
                        }

                        if($indiceDesempenho == 0) {
                            $indiceAproveitamento = 0;
                        } else {
                            $indiceAproveitamento = (($indiceDesempenho*3)+($indiceAbsent*2)+($indiceDisciplinar*1))/(3+2+1);                            
                        }

                        echo $indiceAproveitamento;
                    ?>
                </td>
            </tr>
        </table>
        <?php
            } else {
        ?>
        </h3>
        <div id="container">
            <form action='' method='post'>
                <label>Selecione o período para visualizar o aproveitamento funcional:</label>
                <select name='semestre' class='form-control'>
                    <option value='1'>Primeiro semestre</option>                
                    <option value='2'>Segundo semestre</option>
                </select>
                <label>Ano: </label>
                <input type="text" class="form-control" name="ano" value="" value="" required>
                <p></p>
                <button class='btn btn-primary'>Gerar</button>
            </form>
        </div>
        <?php
            }
        ?>
    </div>
      
      
    <div class="container">
        <footer class="pt-4 my-md-5 pt-md-5 border-top" id="noprint">
          <?php
              include('../../includes/Rodape.php');
          ?>
        </footer>
    </div>
  </body>
</html>