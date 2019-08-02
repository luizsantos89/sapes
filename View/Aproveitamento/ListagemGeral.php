<?php
    session_start();
    include("../../includes/verificaSessao.php");
    require '../../Model/Funcionario.php';
    require '../../Model/Usuario.php';
    require '../../Model/Secao.php';
    require '../../Model/Divisao.php';
    require '../../Model/Gerencia.php';
    require '../../Model/Aproveitamento.php';

    if(!isset($_SESSION['aproveitamento'])) {
        header("Location:../../Controler/controlerAproveitamento.php?opcao=1");
    }
        
    $funcionarios = $_SESSION['funcionarios'];
    $usuarios = $_SESSION['usuarios'];
    $listaAproveitamento = $_SESSION['aproveitamento'];
    $secoes = $_SESSION['secoes'];
    $divisoes = $_SESSION['divisoes'];
    $gerencias = $_SESSION['gerencias'];
    if(isset($_SESSION['semestre'])){
        $semestre = $_SESSION['semestre'];
        $ano = $_SESSION['ano'];
        //unset($_SESSION['periodo']);
    } else {
        header("Location: ../../Controler/controlerAproveitamento.php?opcao=3");
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

    <title>Sistema de Aproveitamento Funcional - DVRH/FJF</title>
    <script type="text/javascript">
    // função para desabilitar a tecla F5.
        window.onkeydown = function (e) {
            if (e.keyCode === 116) {
                alert("Função não permitida");
                e.keyCode = 0;
                e.returnValue = false;
                return false;
            }
        }
    </script>
    
    <style>            
    @media print{
       #noprint{
           display:none;
       }
       margin: 0;
       padding: 0;
       filter: progid:DXImageTransform.Microsoft.BasicImage(Rotation=3);
       
    }
    
    th {
        position: sticky;
        background-color: #999;
    }
    </style>

    <!-- Bootstrap core CSS -->
    <link href="../../estilos/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../estilos/css/pricing.css" rel="stylesheet">
  </head>

  <body>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow" id="noprint">
        <img class="my-0 mr-md-auto font-weight-normal" src="../../imagens/logo2.png" />
        <nav class="my-2 my-md-0 mr-md-3" id="noprint">
            <?php include("../../includes/Menus.php"); ?>
        </nav>
        <a class="btn btn-outline-primary" href="../../Controler/logout.php" id="noprint">Sair</a>
    </div>

    <div class="pricing-header container text-center">
        <h1 class="display-4">Aproveitamento Funcional</h1>
        <h3>
            <?php
            if($semestre)
                echo "$semestre º semestre - $ano";
            else
                echo "Todos os lançamentos";
            ?>
        </h3>
        <a href="ConsultaAproveitamento.php" class="btn btn-primary" id="noprint">Consultar novamente</a><br /><br />
    </div>

    <div class="container-fluid">

            <?php
            
            if($listaAproveitamento == null) {
                ?>                
                <div class="alert alert-danger" id="noprint">Não foi gerado o aproveitamento funcional do período selecionado ou não há dados para tal, por favor selecione outro período, ou gere o aproveitamento do período correto.</div><br>
            <?php    
            } else {
               
            ?>
            <div>
            <table border="1" class="table table-light small">
                <thead class='thead-dark text-center table-striped'>
                    <tr>
                        <th>#</th>
                        <th>Funcionário:</th>
                        <th>Nota de Desempenho:</th>
                        <th>i<sub>Desempenho</sub>:</th>
                        <th>P<sub>desempenho</sub>:</th>
                        <th>Horas absenteísmo:</th>
                        <th>i<sub>horas</sub>:</th>
                        <th>i<sub>absent</sub>:</th>
                        <th>P<sub>absent</sub>:</th>
                        <th>f<sub>disc</sub>:</th>
                        <th>i<sub>disc</sub>:</th>
                        <th>P<sub>disc</sub>:</th>
                        <th>i<sub>aprov</sub>:</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $contador = 0;
                    foreach ($listaAproveitamento as $aproveitamento) {
                        $contador += 1;
                ?>
                    <tr>   
                        <td>
                            <?=$contador?>
                        </td>
                        <td>
                            <?php                            
                                foreach($funcionarios as $funcionario) {
                                    if($funcionario->idFuncionario == $aproveitamento->idFuncionario) {
                                        echo $funcionario->cracha.' - '.$funcionario->nome;
                                        foreach ($secoes as $secao) {
                                            if($secao->idSecao == $funcionario->idSecao) {
                                                echo ' ('.$secao->descricao.' / ';
                                                foreach($divisoes as $divisao) {
                                                    if($divisao->idDivisao == $secao->idDivisao) {
                                                        echo $divisao->descricao.' / ';
                                                        foreach ($gerencias as $gerencia) {
                                                            if($gerencia->idGerencia == $divisao->idGerencia) {
                                                                echo $gerencia->descricao.') ';
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }     
                                
                                
                            ?> 
                        </td>    
                        
                        <td align="center"> 
                            <?php echo str_replace('.',',', ($aproveitamento->indiceDesempenho)*10); ?>
                        </td>
                        
                        <td align="center"> 
                            <?php echo str_replace('.',',', $aproveitamento->indiceDesempenho); ?>
                        </td>
                        
                        <td align="center"> 
                            <?php echo str_replace('.',',', $aproveitamento->pesoDesempenho); ?>
                        </td>
                        
                        <td align="center"> 
                            <?php echo str_replace('.',',', $aproveitamento->horasAbsenteismo); ?>
                        </td>
                        
                        <td align="center"> 
                            <?php echo str_replace('.',',', $aproveitamento->indiceCargaHoraria); ?>
                        </td>
                        
                        <td align="center"> 
                            <?php echo str_replace('.',',', $aproveitamento->indiceAbsenteismo); ?>
                        </td>
                        
                        <td align="center"> 
                            <?php echo str_replace('.',',', $aproveitamento->pesoAbsenteismo); ?>
                        </td>                        
                        
                        <td align="center"> 
                            <?php echo str_replace('.',',', $aproveitamento->fatorDisciplinar); ?>
                        </td>    
                        
                        <td align="center"> 
                            <?php echo str_replace('.',',', $aproveitamento->indiceDisciplinar); ?>
                        </td>
                        
                        <td align="center"> 
                            <?php echo str_replace('.',',', $aproveitamento->pesoFatorDisciplinar); ?>
                        </td>
                        
                        
                        <td align="center"> 
                            <?php echo str_replace('.',',', $aproveitamento->indiceAproveitamento); ?>
                            <?php echo '('.str_replace('.',',', ($aproveitamento->indiceAproveitamento*100)).'%)'; ?>
                        </td>
                        
                    </tr>
                    <?php }  ?>
                </tbody>
            </table>
            <?php
            
                                }
                                echo "Total de <b>$contador registros</b><br>";
                                ?>
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

    </body>
</html>