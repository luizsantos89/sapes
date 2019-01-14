<?php
    session_start();
    require('../includes/conexao.inc');
    require('../Model/FuncionarioDAO.php');  
    require('../Model/UsuarioDAO.php');
    require('../Model/AbsenteismoDAO.php');
    require('../Model/DesempenhoDAO.php');
    require('../Model/SancaoDAO.php');
    require('../Model/TipoSancaoDAO.php');
    $funcionarioDAO = new FuncionarioDAO();
    $funcionarios = $funcionarioDAO->getFuncionarios();
    $usuario = $_SESSION['usuario'];
    
    $indiceDesempenho = 1;
    $indiceAbsent = 1;
    $indiceDisciplinar = 1;
    
    if(!isset($_REQUEST['opcao'])) {
        Header("location:../index.php");
    }
    
    $opcao = (int)$_REQUEST['opcao'];
    
    //Página de inicio
    if($opcao == 1) {
        header('Location:../View/Aproveitamento/index.php');
    }
    
    // GERAR O RELATÓRIO
    if ($opcao == 2) {
        $funcionarioDAO = new FuncionarioDAO();
        $usuarioDAO = new UsuarioDAO();        
        $sancaoDAO = new SancaoDAO();
        $tipoSancaoDAO = new TipoSancaoDAO();
        $absenteismoDAO = new AbsenteismoDAO();
        $desempenhoDAO = new DesempenhoDAO();
        
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
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content=""><style type="text/css">

      /* Sticky footer styles
      -------------------------------------------------- */

      html,
      body {
        height: 100%;
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

    <!-- Bootstrap core CSS -->
    <link href="../estilos/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../estilos/css/pricing.css" rel="stylesheet">
  </head>

  <body>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow"  id="noprint">
      <!--<h5 class="my-0 mr-md-auto font-weight-normal">Company name</h5>-->
      <img src="../imagens/logo2.png" class="my-0 mr-md-auto font-weight-normal"  id="noprint"/>
      
      <nav class="my-2 my-md-0 mr-md-3" id="noprint">
          <?php
            include('../includes/MenusAproveitamento.php');
          ?>
      </nav>
      <a class="btn btn-outline-primary" href="../Controler/logout.php" id="noprint">Sair</a>
    </div>

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Aproveitamento Funcional</h1><br /><h3> Gerado por:  
      <?php
        echo $usuario->nome;
      ?>
      </h3>
      <p class="lead">
          Em: 
      <?php 
            date_default_timezone_set('America/Sao_Paulo');
            echo date('d/m/Y H:i:s');
      ?>
      </p>
    </div>

    <div class="container-fluid">
        <?php
            if($funcionarios == null) {
                echo 'Nenhum funcionario cadastrado!';
            } else {
            ?>
        <table border="1" class="table">
            <tr>
                <th>Crachá:</th>
                <th>Funcionário:</th>
                <th>Carga Horária:</th>
                <th>Nota Desempenho:</th>
                <th>i<sub>desemp</sub>:</th>
                <th>P<sub>desemp</sub>:</th>
                <th>Horas de absenteísmo:</th>
                <th>Max. absent. período:</th>
                <th>i<sub>absent</sub>:</th>
                <th>P<sub>absent</sub>:</th>
                <th>f<sub>disc</sub>:</th>
                <th>MAX f<sub>disc</sub>:</th>
                <th>i<sub>disc</sub>:</th>
                <th>P<sub>disc</sub></th>
                <th>i<sub>aprov</sub></th>
            </tr>
            <?php
                foreach($funcionarios as $funcionario) {
                    $indiceDesempenho = 0;
                    $indiceAbsent = 1;
                    $indiceDisciplinar = 1;
                    $indiceAproveitamento = 0; 
                    $absentTotal = 0; 
                    $maxAbsenteismo = 0;
                    $fatorDisciplinar = 0;
                    
            ?>
                <tr>
                    
                    <!--Crachá do funcionário -->
                    <td><?=$funcionario->cracha?></td>
                    
                    <!--Funcionário-->
                    <td><a href="../View/Aproveitamento/AproveitamentoFuncionario.php?idFuncionario=<?=$funcionario->idFuncionario?>"><?=$funcionario->nome?></a></td>
                    
                    <!--Carga Horária-->
                    <td><?=$funcionario->cargaHoraria?> horas</td>
                    
                    <!--Nota de desempenho no período -->
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
                    
                    <!--Índice de desempenho-->
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
                    
                    <!--Peso do índice de desempenho-->
                    <td>3</td>
                    
                    <!--Horas de absenteísmo-->
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
                    
                    <!-- Máximo de absenteímo no período -->
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
                    
                    <!--Índice de absenteísmo-->
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
                    
                    <!-- Peso do absenteísmo -->
                    <td>2</td>
                    
                    <!-- Fator disciplinar-->
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
                    
                    <!-- Máximo Fator Disciplinar no período -->
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
                    
                    <!-- Índice disciplinar = Fator disciplinar dividido pelo maior valor do período -->
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
                    
                    <!-- Peso do fator disciplinar -->
                    <td>1</td>
                    
                    <!--Índice de aproveitamento -->
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
            <?php
                }
            ?>
        </table>
            <?php } ?>
    </div>
      
      
    <div class="container">
        
        
        <footer class="pt-4 my-md-5 pt-md-5 border-top" id="noprint">
          <?php
              include('../includes/RodapeIndex.php');
          ?>
        </footer>
    </div>

  </body>
</html>
<?php
    }
?>