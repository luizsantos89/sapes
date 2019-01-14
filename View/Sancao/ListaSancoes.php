<?php
    session_start();
    include("../../includes/verificaSessao.php");
    
    
    if(!isset($_SESSION['tipoSancoes'])) {
        header("Location: ../../Controler/controlerSancao.php?opcao=6&pagina=1");
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

    <title>Funcionários cadastrados</title>

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
        <h1 class="display-4">Sanções</h1>
        <p class="lead">
            Sanções lançadas:
        </p>
        <p>
            <a class="btn btn-outline-primary" href="LancarSancao.php">Nova sanção</a>
        </p>
    </div>

    <div class="container-fluid">
      <div class="col-md-12 order-md-1">
            <div>

            <?php
            require '../../Model/Funcionario.php';
            require '../../Model/Usuario.php';
            require '../../Model/Sancao.php';
            require '../../Model/TipoSancao.php';
            
            $funcionarios = $_SESSION['funcionarios'];
            $usuarios = $_SESSION['usuarios'];
            $tiposSancoes = $_SESSION['tipoSancoes'];
            
            if(!isset($_SESSION['sancoes'])) {
                header("Location: ../../Controler/controlerSancao.php?opcao=6&pagina=1");
            } else {
                $sancoes = $_SESSION['sancoes'];
                $qtd = 0;
                
                foreach($sancoes as $sancao) {
                    $qtd++;
                }
                echo 'Quantidade total de sanções: '.$qtd.'<br>';
            ?>
            <table border='1' class="table table-striped">
                <tr class="thead-dark text-center">
                    <th colspan="2">Ações:</th>
                    <th>Funcionário:</th>
                    <th>Tipo de Sanção:</th>
                    <th>Peso:</th>
                    <th>Data da Sanção:</th>
                    <th>Motivo:</th>
                    <th>Documento:</th>
                    <th>Dias de suspensão:</th>
                    <th>Lançamento:</th>
                    <th>Data de Lançamento:</th>
                </tr>
                <?php
                    foreach ($sancoes as $sancao) {
                ?>
                <tr class="">
                        <td>
                            <a href="../../Controler/controlerSancao.php?opcao=2&idSancao=<?=$sancao->idSancao?>">
                                <img title="Editar Sanção" src="../../imagens/edit.png" height="25px" /></a>
                            </td>
                        <td>
                            <a href="../../Controler/controlerSancao.php?opcao=5&idSancao=<?=$sancao->idSancao?>">
                                <img title="Excluir Sanção" src="../../imagens/excluir.png" height="25px" /></a>
                        </td>
                        <td>
                            <?php                            
                                foreach($funcionarios as $funcionario) {
                                    if($funcionario->idFuncionario == $sancao->idFuncionario) {
                                        echo $funcionario->nome;
                                    }
                                }                            
                            ?>  
                        </td>
                        <td>
                            <?php
                                foreach($tiposSancoes as $tipoSancao) {
                                    if($tipoSancao->idTipo == $sancao->idTipo) {
                                        echo $tipoSancao->descricao;
                                    }
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                foreach($tiposSancoes as $tipoSancao) {
                                    if($tipoSancao->idTipo == $sancao->idTipo) {
                                        echo $tipoSancao->peso;
                                    }
                                }
                            ?>
                        </td>
                        <td>
                            <?= date('d/m/Y',strtotime($sancao->dataSancao)); ?>  
                        </td>
                        <td>
                            <?= $sancao->motivo;?>
                        </td>
                        <td>
                            <?= $sancao->numDoc;?>
                        </td>
                        <td>
                            <?php
                                if($sancao->idTipo == 4) {
                                    echo $sancao->qtdDias;
                                } else {
                                    echo 'Não se aplica';
                                }
                            
                            ?>
                        </td>
                        <td>
                            <?php                            
                                foreach($usuarios as $usuario) {
                                    if($usuario->idUsuario == $sancao->idUsuario) {
                                        echo $usuario->nome;
                                    }
                                }                            
                            ?>  
                        </td>
                        <td>
                            <?= date('d/m/Y',strtotime($sancao->dataLancamento)); ?>  
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
              unset($_SESSION['sancoes']);
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