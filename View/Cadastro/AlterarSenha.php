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
            <h3>Dados do funcionário:</h3>
            <form action="../../Controler/controlerAcesso.php?opcao=1" method="post" id="login-form">
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>Senha atual:</label>
                        <input type="password" class="form-control" name="senhaAtual" value="" required>
                        <?php
                            if(isset($_REQUEST['erro']) && ($_REQUEST['erro'] == 2)){
                                echo '<p class="alert alert-danger" role="alert">Senha atual incorreta</p>';
                            }  
                            if(isset($_REQUEST['erro']) && ($_REQUEST['erro'] == 3)){
                                echo '<p class="alert alert-danger" role="alert">Nova senha não pode ser igual à atual</p>';
                            }                     
                        ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="inputPassword" class="control-label">Nova senha: </label>
                    <input name="novaSenha" type="password" class="form-control" id="inputPassword" data-minlength="6" required>
                    <span class="help-block">Mínimo de seis (6) digitos</span>
                </div>

                <div class="form-group">
                    <label for="inputConfirm" class="control-label">Confirme a Senha</label>
                    <input name="confirmacaoSenha" type="password" class="form-control" id="inputConfirm" data-match="#inputPassword" data-match-error="Atenção! As senhas não estão iguais." required>
                    <div class="help-block with-errors"></div>
                    <?php
                        if(isset($_REQUEST['erro']) && ($_REQUEST['erro'] == 1)){
                            echo '<p class="alert alert-danger" role="alert"">Senhas não conferem</p>';
                        }                    
                    ?>
                </div>
                
                <div class="row">                    
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </div>
            </form>
    </div>
    <div class="container">
        <footer class="pt-4 my-md-5 pt-md-5 border-top">
          <?php
              include('../../includes/Rodape.php');
          ?>
        </footer>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../scripts/bootstrap.min.js"></script>
    <script src="../../scripts/validator.min.js"></script>
  </body>
</html>