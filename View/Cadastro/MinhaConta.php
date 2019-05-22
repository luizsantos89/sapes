<?php
    session_start();
    include("../../includes/verificaSessao.php");
    require('../../Model/Funcionario.php');
    $usuario = $_SESSION['usuario'];
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../imagens/imbel.ico">

        <title>Meu cadastro - Sistema de Aproveitamento Funcional - DVRH/FJF</title>

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
        <h1 class="display-4">Minha conta</h1><h2><?=$usuario->nome;?></h2>        
    </div>

    <div class="container">
        <div class="col-md-12 order-md-1 ">
            <h3>Dados cadastrais</h3>
            
            <?php
                if(isset($_REQUEST['senha']) && ($_REQUEST['senha'] = 'sucesso')) {
                    echo '<p class="alert alert-danger" role="alert">Senha alterada com sucesso</p>';
                }
            
            ?>
            
            <table class="table">
                <tr>
                    <th>Nome: </th>
                    <td><?=$usuario->nome;?></td>
                </tr>
                <tr>
                    <th>Login:</th>
                    <td><?=$usuario->login;?></td>
                </tr>
                <tr>
                    <td>
                        <a href="AlterarSenha.php" class="btn btn-primary">Alterar senha</a>
                    </td>
                    <td>
                        
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="EditarConta.php" class="btn btn-primary">Alterar dados</a>
                    </td>
                    <td>
                        
                    </td>
                </tr>
            </table>
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
    <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="assets/js/vendor/popper.min.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
    <script src="assets/js/vendor/holder.min.js"></script>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js'></script>
    <script>
        $('.input-group.date').datepicker({format: "dd/mm/yyyy"});
    </script>
    <script>
      Holder.addTheme('thumb', {
        bg: '#55595c',
        fg: '#eceeef',
        text: 'Thumbnail'
      });
    </script>
  </body>
</html>