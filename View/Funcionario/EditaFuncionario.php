<?php
    session_start();
    include("../../includes/verificaSessao.php");
    require('../../Model/Funcionario.php');
    $funcionario = $_SESSION['funcionario'];
    $secoes = $_SESSION['secoes'];
    $divisoes = $_SESSION['divisoes'];
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="favicon.ico">

        <title>Editar funcionário</title>

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
        <h1 class="display-4">Funcionário </h1><h3><?=$funcionario->nome;?></h3>
        <p class="lead">
            Editar funcionário:
        </p>
    </div>

    <div class="container">
      <div class="col-md-12 order-md-1">
            <h4 class="mb-3">Dados do funcionário:</h4>
            <form class="needs-validation" action="../../Controler/controlerFuncionario.php?opcao=3" method="post" novalidate>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>Nome:</label>
                        <input type="text" class="form-control" name="nome" value="<?php echo $funcionario->nome;?>" value="" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>Matrícula/Crachá:</label>
                        <input type="text" class="form-control" name="cracha" value="<?php echo $funcionario->cracha;?>" value="" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>Situação:</label>
                        <input type="text" class="form-control" name="situacao" value="<?php echo $funcionario->situacao;?>" value="" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>Cargo:</label>
                        <input type="text" class="form-control" name="cargo" value="<?php echo $funcionario->cargo;?>" value="" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>Data de Admissão:</label>
                        <input type="text" class="form-control" name="dataAdmissao" value="<?= date('d/m/Y',strtotime($funcionario->dataAdmissao)); ?>" value="" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>Situação:</label>
                        <select name="funcAtivo" class="form-control" >
                            <option value="1">Ativo</option>
                            <option value="0">Inativo</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>Seção:</label>
                        <select name="idSecao" class="form-control" >
                            <?php
                                foreach($secoes as $secao) {
                                    if($funcionario->idSecao == $secao->idSecao){
                                        echo "<option selected value=$secao->idSecao>$secao->descricao</option>";
                                    } else {
                                        echo "<option value=$secao->idSecao>$secao->descricao</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
                
                <input type="hidden" value="<?=$funcionario->idFuncionario;?>" name="idFuncionario" />
                <hr class="mb-6">
                <button class="btn btn-outline-primary" type="submit">Alterar dados</button>
                <a class="btn btn-outline-danger" href="../../Controler/controlerFuncionario.php?opcao=5&idFuncionario=<?php echo $funcionario->idFuncionario;?>">Exclui</a>
                <a  class="btn btn-outline-primary" href="../../Controler/controlerFuncionario.php?opcao=1">Cancelar</a>
            </form>
        </div>

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