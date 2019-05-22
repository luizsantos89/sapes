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

    <title>Relatórios - Sistema de Aproveitamento Funcional - DVRH/FJF</title>

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
        <h1 class="display-4">Relatórios:</h1><br />
      
    </div>
    <div class="container-fluid">
        <div class="card-deck mb-3 text-center">
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Funcionarios</h4>
                </div>
                <div class="card-body">
                    <br />
                    <a href="Funcionarios.php">
                        <img src="../../imagens/func1.png" width="120px" height="120px" /> 
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
                    <a href="GeraAbsenteismo.php">
                        <img src="../../imagens/horas.png" height="120px" />
                    </a>
                    <br /><br /><br /><br />
                </div>
            </div>
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Sanções</h4>
                </div>
                <div class="card-body">
                    <br />
                    <a href="GeraSancao.php">
                        <img src="../../imagens/disc.png"  height="120px" /> 
                    </a>
                    <br /><br /><br /><br />
                </div>
            </div>
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Desempenho</h4>
                </div>
                <div class="card-body">
                    <br />
                    <a href="GeraDesempenho.php">
                        <img src="../../imagens/desemp.png" height="120px" /> 
                    </a>
                    <br /><br /><br /><br />
                </div>
            </div>
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Aproveitamento</h4>
                </div>
                <div class="card-body">
                    <br />
                    <a href="GeraAproveitamento.php">
                        <img src="../../imagens/aprov.png" height="120px" /> 
                    </a>
                    <br /><br /><br /><br />
                </div>
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

  </body>
</html>
