<?php
    session_start();
    include("../includes/verificaSessao.php");
    $usuario = $_SESSION['usuario'];
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../imagens/imbel.ico">

    <title>Avaliação de Desempenho - DVRH/FJF</title>

    <!-- Bootstrap core CSS -->
    <link href="../estilos/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../estilos/css/pricing.css" rel="stylesheet">
  </head>

  <body>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
      <!--<h5 class="my-0 mr-md-auto font-weight-normal">Company name</h5>-->
      <img src="../imagens/logo2.png" class="my-0 mr-md-auto font-weight-normal" />
      
      <nav class="my-2 my-md-0 mr-md-3">
          <?php
            include('../includes/MenuIndex.php');
          ?>
      </nav>
      <a class="btn btn-outline-primary" href="../Controler/logout.php">Sair</a>
    </div>

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Bem vindo(a)</h1><br /><h3> 
      <?php
        echo $usuario->nome;
      ?>
      </h3>
      <p class="lead">
          Seu último acesso foi em: 
      <?php        
            echo date('d/m/Y H:i:s', strtotime($usuario->ultimoAcesso));
      ?>
      </p>
    </div>

    <div class="container">
        <div class="card-deck mb-3 text-center">
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Funcionarios</h4>
                </div>
                <div class="card-body">
                    <br />
                    <a href="../Controler/controlerFuncionario.php?opcao=1">
                        <img src="../imagens/func1.png" width="120px" height="120px" /> 
                    </a>
                    <br /><br /><br /><br />
                </div>
            </div>
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Absenteísmo</h4>
                </div>
                <div class="card-body">
                    <br />
                    <img src="../imagens/horas.png" height="120px" /> 
                    <br /><br /><br /><br />
                </div>
            </div>
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Desempenho</h4>
                </div>
                <div class="card-body">
                    <br />
                    <img src="../imagens/desemp.png" height="120px" /> 
                    <br /><br /><br /><br />
                </div>
            </div>
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Disciplina</h4>
                </div>
                <div class="card-body">
                    <br />
                    <img src="../imagens/disc.png"  height="120px" /> 
                    <br /><br /><br /><br />
                </div>
            </div>
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Relatórios</h4>
                </div>
                <div class="card-body">
                    <br />
                    <img src="../imagens/relat.png" width="120px" height="120px" /> 
                    <br /><br /><br /><br />
                </div>
            </div>
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Normas</h4>
                </div>
                <div class="card-body">
                    <br />
                    <img src="../imagens/normas.png" width="120px" height="120px" /> 
                    <br /><br /><br /><br />
                </div>
            </div>
        </div>

      <footer class="pt-4 my-md-5 pt-md-5 border-top">
          <div class="row">
            <div class="col-12 col-md">
                <img class="mb-2" src="../imagens/imbel.ico" alt="">
            </div>
          <div class="col-6 col-md">
            <h5>Lançamentos</h5>
            <ul class="list-unstyled text-small">
              <li><a class="text-muted" href="#">Funcionários</a></li>
              <li><a class="text-muted" href="#">Sanções</a></li>
              <li><a class="text-muted" href="#">Desempenho</a></li>
              <li><a class="text-muted" href="#">Absenteísmo</a></li>
            </ul>
          </div>
          <div class="col-6 col-md">
            <h5>Relatórios</h5>
            <ul class="list-unstyled text-small">
              <li><a class="text-muted" href="#">Funcionários</a></li>
              <li><a class="text-muted" href="#">Horas de Absenteísmo</a></li>
              <li><a class="text-muted" href="#">Notas de Desempenho</a></li>
              <li><a class="text-muted" href="#">Aproveitamento</a></li>
            </ul>
          </div>
          <div class="col-6 col-md">
            <h5>Normas</h5>
            <ul class="list-unstyled text-small">
                <li><a class="text-muted" href="../arquivos/2.A.12.N-001 - Rev.00 - Critérios para Aproveitamento Funcional.pdf" download>2.A.12.N-001-Rev.00</a></li>
            </ul>
          </div>
        </div>
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
