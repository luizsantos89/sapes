<?php
    session_start();
    include("../../includes/verificaSessao.php");
    require '../../Model/Funcionario.php';
    require '../../Model/Usuario.php';
    require '../../Model/Secao.php';
    require '../../Model/Divisao.php';
    require '../../Model/Gerencia.php';

    if(!isset($_SESSION['notasDesempenho'])) {
        header("Location: index.php");
    }
    
    $funcionarios = $_SESSION['funcionarios'];
    $usuarios = $_SESSION['usuarios'];
    $notasDesempenho = $_SESSION['notasDesempenho'];
    
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="iso-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../imagens/imbel.ico">

    <title>Desempenho - Sistema de Aproveitamento Funcional - DVRH/FJF</title>
    
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

    <!-- Bootstrap core CSS -->
    <link href="../../estilos/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../estilos/css/pricing.css" rel="stylesheet">
  </head>

  <body>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
        <img class="my-0 mr-md-auto font-weight-normal" src="../../imagens/logo2.png" />
        <nav class="my-2 my-md-0 mr-md-3">
            <?php include("../../includes/Menus.php"); ?>
        </nav>
        <a class="btn btn-outline-primary" href="../../Controler/logout.php">Sair</a>
    </div>

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Notas de Desempenho:</h1>
        
        <?php
            if($usuario->idTipoUsuario != 3) {
        ?>
                <a class="btn btn-outline-primary" href="LancaDesempenho.php">Lançamento</a>
        <?php
            }
        ?>
    </div>

    <div class="container-fluid">
            <div>
            <?php
                if($notasDesempenho != null) {
            ?>
                <table class="table table-striped">
                    <thead class='thead-dark text-center'>
                        <tr>
                            <?php
                                if($usuario->idTipoUsuario !=3 ) {
                            ?>
                                <th colspan="2">Ações:</th>
                            <?php
                                }
                            ?>
                            <th>Funcionário:</th>
                            <th>Nota:</th>
                            <th>Semestre/Ano:</th>
                            <th>Lançado por:</th>
                            <th>Data Lançamento:</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($notasDesempenho as $nota) {
                    ?>
                        <tr>
                            <?php
                                if($usuario->idTipoUsuario !=3 ) {
                            ?>                                 
                                <td>
                                    <a href="../../Controler/controlerDesempenho.php?opcao=2&idDesempenho=<?=$nota->idDesempenho?>">
                                        <img title="Editar Horas de Absenteísmo" src="../../imagens/edit.png" height="25px" /></a>
                                    </td>
                                <td>
                                    <a href="../../Controler/controlerDesempenho.php?opcao=5&idDesempenho=<?=$nota->idDesempenho?>">
                                        <img title="Excluir Horas de Absenteísmo" src="../../imagens/excluir.png" height="25px" /></a>
                                </td>   
                            <?php
                                }
                            ?>                
                            <td>
                                <?php                            
                                    foreach($funcionarios as $funcionario) {
                                        if($funcionario->idFuncionario == $nota->idFuncionario) {
                                            echo $funcionario->cracha.' - '.$funcionario->nome;
                                        }
                                    }                            
                                ?> 
                            </td>

                            <td align="center"> 
                                <?php echo str_replace('.',',', $nota->nota); ?>
                            </td>

                            <td align="center"> 
                                <?=$nota->semestre;?>/<?=$nota->ano;?>
                            </td>

                            <!--CARGO-->
                            <td>
                                <?php
                                    foreach($usuarios as $user) {
                                        if($user->idUsuario == $nota->idUsuario) {
                                            echo $user->nome;
                                        }
                                    }
                                ?>
                            </td>

                            <!--DATA DE ADMISSAO-->
                            <td align="center">
                                <?= date('d/m/Y',strtotime($nota->dataLancamento)); ?> 
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php
                } else {
            ?> 
                <div class="alert alert-danger">
                    Não há desempenho lançado no período solicitado, por favor selecione outro período.
                </div><br>
            <?php
                }
            ?>
        </div>
    </div>
      <div class="container">
        <footer class="pt-4 my-md-5 pt-md-5 border-top">
            <?php
                unset($_SESSION['notasDesempenho']);
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