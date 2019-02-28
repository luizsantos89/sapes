<?php
    session_start();
    include("../../includes/verificaSessao.php");
    $usuario = $_SESSION['usuario'];
    if($usuario->idTipoUsuario == 3) {
        Header("Location:../../index.php");
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
    <script type='text/javascript'>
        var filtroTeclas = function(event) {
            return ((event.charCode >= 48 && event.charCode <= 57) || event.keyCode == 8 || event.charCode == 9)
        }  
        var filtroLetras = function(event) {
            return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.keyCode == 8) || (event.charCode == 32))
        }
        function mascaraData(val) {
        var pass = val.value;
        var expr = /[0123456789]/;

        for (i = 0; i < pass.length; i++) {
          // charAt -> retorna o caractere posicionado no índice especificado
          var lchar = val.value.charAt(i);
          var nchar = val.value.charAt(i + 1);

          if (i == 0) {
            // search -> retorna um valor inteiro, indicando a posição do inicio da primeira
            // ocorrência de expReg dentro de instStr. Se nenhuma ocorrencia for encontrada o método retornara -1
            // instStr.search(expReg);
            if ((lchar.search(expr) != 0) || (lchar > 3)) {
              val.value = "";
            }

          } else if (i == 1) {

            if (lchar.search(expr) != 0) {
              // substring(indice1,indice2)
              // indice1, indice2 -> será usado para delimitar a string
              var tst1 = val.value.substring(0, (i));
              val.value = tst1;
              continue;
            }

            if ((nchar != '/') && (nchar != '')) {
              var tst1 = val.value.substring(0, (i) + 1);

              if (nchar.search(expr) != 0)
                var tst2 = val.value.substring(i + 2, pass.length);
              else
                var tst2 = val.value.substring(i + 1, pass.length);

              val.value = tst1 + '/' + tst2;
            }

          } else if (i == 4) {

            if (lchar.search(expr) != 0) {
              var tst1 = val.value.substring(0, (i));
              val.value = tst1;
              continue;
            }

            if ((nchar != '/') && (nchar != '')) {
              var tst1 = val.value.substring(0, (i) + 1);

              if (nchar.search(expr) != 0)
                var tst2 = val.value.substring(i + 2, pass.length);
              else
                var tst2 = val.value.substring(i + 1, pass.length);

              val.value = tst1 + '/' + tst2;
            }
          }

          if (i >= 6) {
            if (lchar.search(expr) != 0) {
              var tst1 = val.value.substring(0, (i));
              val.value = tst1;
            }
          }
        }

        if (pass.length > 10)
          val.value = val.value.substring(0, 10);
        return true;
      }
    </script>


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
        <h1 class="display-4">Usuários</h1>
    </div>

    <div class="container">
      <div class="col-md-12 order-md-1">
                
            <h4 class="mb-3">Dados do usuário:</h4>
            <form class="needs-validation" action="../../Controler/controlerUsuario.php?opcao=4" method="post" validate>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>Nome:</label>
                        <input type="text" class="form-control" name="nome" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>Login:</label>
                        <input type="text" class="form-control" name="login" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>Tipo de Usuário:</label>
                        <select name="idTipoUsuario" class="form-control">
                            <option value="1">Administrador</option>
                            <option value="2">SAPES</option>
                            <option value="3">Gerentes</option>
                        </select>
                    </div>
                </div>
                <hr class="mb-6">
                <button class="btn btn-outline-primary" type="submit">Cadastrar</button>
                <a  class="btn btn-outline-primary" href="../../Controler/controlerUsuario.php?opcao=1">Cancelar</a>
            </form>
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