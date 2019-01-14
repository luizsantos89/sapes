<?php
    session_start();
    include("../../includes/verificaSessao.php");
    require '../../Model/Funcionario.php';
    require '../../Model/Usuario.php';
    require '../../Model/Sancao.php';
    require '../../Model/TipoSancao.php';
    
    if(!isset($_SESSION['tipoSancoes'])) {
        header("Location: ../../Controler/controlerFuncionario.php?opcao=6&pagina=1");
    }
    
    $usuarios = $_SESSION['usuarios'];
    $tiposSancoes = $_SESSION['tipoSancoes'];
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../imagens/imbel.ico">

    <title>Tipos de sanções cadastrados</title>

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
        <h1 class="display-4">Tipos de Sanções</h1>
        <p class="lead">
            Tipos de sanções cadastradas:
        </p>
        <p>
            <a class="btn btn-outline-primary" href="CadastrarTipoSancao.php">Novo tipo de sanção</a>
        </p>
    </div>

    <div class="container-fluid">
      <div class="col-md-12 order-md-1">
            <div>

            <?php
            if($tiposSancoes == null) {
                
            } else {
            ?>
            <table class="table table-striped">
                <tr class="thead-dark text-center">
                    <th colspan="2">Ações:</th>
                    <th>Descrição:</th>
                    <th>Peso:</th>
                    <th>Cadastrada por:</th>
                    <th>Data de Cadastro:</th>
                </tr>
                <?php
                    foreach ($tiposSancoes as $tipo) {
                ?>
                <tr class="">
                        <td>
                            <a href="../../Controler/controlerTipoSancao.php?opcao=2&idTipoSancao=<?=$tipo->idTipo?>">
                                <img title="Editar" src="../../imagens/edit.png" height="25px" /></a>
                            </td>
                        <td>
                            <a href="../../Controler/controlerTipoSancao.php?opcao=5&idTipoSancao=<?=$tipo->idTipo?>">
                                <img title="Excluir" src="../../imagens/excluir.png" height="25px" /></a>
                        </td>
                        <td>
                            <?=$tipo->descricao?> 
                        </td>
                        <td>
                            <?=$tipo->peso;?>
                        </td>
                        <td>
                            <?php
                                foreach($usuarios as $usuario) {
                                    if($usuario->idUsuario == $tipo->idUsuario) {
                                        echo $usuario->nome;
                                    }
                                }
                            ?>
                        </td>
                        <td>
                            <?= date('d/m/Y',strtotime($tipo->dataCadastro)); ?>
                        </td>
                    </tr>
                    <?php } ?>
            </table>
            <?php
            
                                }
                                ?>
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
    <script>
        Holder.addTheme('thumb', {
          bg: '#55595c',
          fg: '#eceeef',
          text: 'Thumbnail'
        });
    </script>
    </body>
</html>