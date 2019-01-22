<?php
    session_start();
    include("../../includes/verificaSessao.php");
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

    <title>Aproveitamento Funcional</title>

    <!-- Bootstrap core CSS -->
    <link href="../../estilos/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../estilos/css/pricing.css" rel="stylesheet">
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
        <h1 class="display-4">Consultar aproveitamento</h1><br />
    </div>
    <div class="container">
        <?php
            if(isset($_REQUEST['erro'])) {
        ?>
                
        <div class="alert alert-danger">Já foi gerado o aproveitamento do período. Utilize a ferramenta abaixo para visualizar: </div><br>
        <?php
            }
            
        ?>
        <?php
            if(isset($_REQUEST['sucesso'])) {
        ?>
                
        <div class="alert alert-danger">Gerado com sucesso. Utilize a ferramenta abaixo para visualizar: </div><br>
        <?php
            }
            
        ?>
            <form action='../../Controler/controlerAproveitamento.php?opcao=1' method='post'>
                <label>Selecione o período para <b>VISUALIZAR</b> o aproveitamento funcional:</label>
                <select name='semestre' class='form-control'>
                    <option value='1'>Primeiro semestre</option>                
                    <option value='2'>Segundo semestre</option>
                </select>
                <label>Ano: </label>
                <input type="text" class="form-control" name="ano" value="" value="" required>
                <p></p>
                <button class='btn btn-primary'>Consultar</button>
            </form>
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
