<?php
    session_start();
    include("../../includes/verificaSessao.php");
    require '../../Model/Funcionario.php';
    require '../../Model/Usuario.php';
    require '../../Model/Secao.php';
    require '../../Model/Divisao.php';
    require '../../Model/Gerencia.php';

    if(!isset($_SESSION['absenteismo'])) {
        header("Location: ../../Controler/controlerAbsenteismo.php?opcao=6&pagina=1");
    }
    
    $funcionarios = $_SESSION['funcionarios'];
    $usuarios = $_SESSION['usuarios'];
    
    
    
    $listaAbsenteismo = $_SESSION['absenteismo'];
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="iso-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../imagens/imbel.ico">

    <title>Horas de absenteísmo</title>
    
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
    
    <style type="text/css">        
        @media print{
           #noprint{
               display:none;
           }
        }
    </style>

    <!-- Bootstrap core CSS -->
    <link href="../../estilos/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../estilos/css/pricing.css" rel="stylesheet">
  </head>

  <body>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow" id="noprint">
        <img class="my-0 mr-md-auto font-weight-normal" src="../../imagens/logo2.png"  id="noprint" />
        <nav class="my-2 my-md-0 mr-md-3"  id="noprint">
            <?php include("../../includes/Menus.php"); ?>
        </nav>
        <a class="btn btn-outline-primary" href="../../Controler/logout.php">Sair</a>
    </div>

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Horas de absenteísmo:</h1>
        
        <a class="btn btn-outline-primary" href="LancaAbsenteismo.php">Lançamento</a>
    </div>

    <div class="container-fluid">

            <?php
            $qtd = 0;
            
            if($listaAbsenteismo == null) {
                if(isset($_SESSION['filtroPorPeriodo'])) {
                    echo '<a href="../../Controler/controlerAbsenteismo.php?opcao=1" class="btn btn-primary">Listar todos os lançamentos</a>';
                }                
            } else {
                
                
                foreach($listaAbsenteismo as $absenteismo) {
                    $qtd+=1;
                }
                if(isset($_SESSION['porsecao'])) {
                    echo 'Total de <b>'.$qtd.'</b> funcionários';
                }
                
            ?>
            <fieldset class="blockquote">
                <legend>Filtrar por período</legend>
                <form action="../../Controler/controlerAbsenteismo.php?opcao=7" method="post" class="form-inline">
                    <select name="mes" class="form-control">
                        <option value="1">Janeiro</option>
                        <option value="2">Fevereiro</option>
                        <option value="3">Março</option>
                        <option value="4">Abril</option>
                        <option value="5">Maio</option>
                        <option value="6">Junho</option>
                        <option value="7">Julho</option>
                        <option value="8">Agosto</option>
                        <option value="9">Setembro</option>
                        <option value="10">Outubro</option>
                        <option value="11">Novembro</option>
                        <option value="12">Dezembro</option>
                    </select>
                    <input type="number" name="ano" size="6" value='2019' required class="form-control" />
                    <button class="btn btn-outline-secondary"  type="submit">Filtrar</button>
                    <input type="hidden" name="filtroPeriodo" />
                    <?php
                        if(isset($_SESSION['filtroPorPeriodo'])) {
                            echo '<a href="../../Controler/controlerAbsenteismo.php?opcao=1" class="btn btn-primary">Listar todos os lançamentos</a>';
                        }
                    ?>
                </form>
            </fieldset>
            <div>
            <table class="table table-striped">
                <thead class='thead-dark text-center'>
                    <tr>
                        <th colspan="2">Ações:</th>
                        <th>Funcionário:</th>
                        <th>Qtde. Horas:</th>
                        <th>Mês/Ano:</th>
                        <th>Lançado por:</th>
                        <th>Data Lançamento:</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($listaAbsenteismo as $absenteismo) {
                ?>
                    <tr>     
                        <td>
                            <a href="../../Controler/controlerAbsenteismo.php?opcao=2&idAbsenteismo=<?=$absenteismo->idAbsenteismo?>">
                                <img title="Editar Horas de Absenteísmo" src="../../imagens/edit.png" height="25px" /></a>
                            </td>
                        <td>
                            <a href="../../Controler/controlerAbsenteismo.php?opcao=5&idAbsenteismo=<?=$absenteismo->idAbsenteismo?>">
                                <img title="Excluir Horas de Absenteísmo" src="../../imagens/excluir.png" height="25px" /></a>
                        </td>                   
                        <td>
                            <?php                            
                                foreach($funcionarios as $funcionario) {
                                    if($funcionario->idFuncionario == $absenteismo->idFuncionario) {
                                        echo $funcionario->nome;
                                    }
                                }                            
                            ?> 
                        </td>
                        
                        <td align="center"> 
                            <?php echo str_replace('.',',', $absenteismo->qtdHoras); ?>
                        </td>
                        
                        <td align="center"> 
                            <?=$absenteismo->mes;?>/<?=$absenteismo->ano;?>
                        </td>
                        
                        <!--CARGO-->
                        <td>
                            <?php
                                foreach($usuarios as $usuario) {
                                    if($usuario->idUsuario == $absenteismo->idUsuario) {
                                        echo $usuario->nome;
                                    }
                                }
                            ?>
                        </td>
                        
                        <!--DATA DE ADMISSAO-->
                        <td align="center">
                            <?= date('d/m/Y',strtotime($absenteismo->dataLancamento)); ?> 
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php
            
                                }
                                ?>
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
    <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="assets/js/vendor/popper.min.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
    <script src="assets/js/vendor/holder.min.js"></script>
    <script>
        Holder.addTheme('thumb', {
          bg: '#55595c',
          fg: '#eceeef',
          text: 'Thumbnail'
        });
    </script>
    </body>
</html>