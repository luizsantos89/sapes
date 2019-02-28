<?php
    session_start();
    include("../../includes/verificaSessao.php");
    require('../../Model/UsuarioDAO.php');
    
    if($usuario->idTipoUsuario == 3) {
        Header("Location:../index.php");
    }
    
    $EditUsuario = new Usuario();
    $EditUsuario = $_SESSION['EditUsuario'];
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../imagens/imbel.ico">

        <title>Editar usuario</title>
        <script language=javascript>
            //MÁSCARA DE VALORES

            function txtBoxFormat(objeto, sMask, evtKeyPress) {
                    var i, nCount, sValue, fldLen, mskLen,bolMask, sCod, nTecla;


            if(document.all) { // Internet Explorer
                    nTecla = evtKeyPress.keyCode;
            } else if(document.layers) { // Nestcape
                    nTecla = evtKeyPress.which;
            } else {
                    nTecla = evtKeyPress.which;
                    if (nTecla == 8) {
                            return true;
                    }
            }

                    sValue = objeto.value;

                    // Limpa todos os caracteres de formatação que
                    // já estiverem no campo.
                    sValue = sValue.toString().replace( "-", "" );
                    sValue = sValue.toString().replace( "-", "" );
                    sValue = sValue.toString().replace( ".", "" );
                    sValue = sValue.toString().replace( ".", "" );
                    sValue = sValue.toString().replace( "/", "" );
                    sValue = sValue.toString().replace( "/", "" );
                    sValue = sValue.toString().replace( ":", "" );
                    sValue = sValue.toString().replace( ":", "" );
                    sValue = sValue.toString().replace( "(", "" );
                    sValue = sValue.toString().replace( "(", "" );
                    sValue = sValue.toString().replace( ")", "" );
                    sValue = sValue.toString().replace( ")", "" );
                    sValue = sValue.toString().replace( " ", "" );
                    sValue = sValue.toString().replace( " ", "" );
                    fldLen = sValue.length;
                    mskLen = sMask.length;

                    i = 0;
                    nCount = 0;
                    sCod = "";
                    mskLen = fldLen;

                    while (i <= mskLen) {
                      bolMask = ((sMask.charAt(i) == "-") || (sMask.charAt(i) == ".") || (sMask.charAt(i) == "/") || (sMask.charAt(i) == ":"))
                      bolMask = bolMask || ((sMask.charAt(i) == "(") || (sMask.charAt(i) == ")") || (sMask.charAt(i) == " "))

                      if (bolMask) {
                            sCod += sMask.charAt(i);
                            mskLen++; }
                      else {
                            sCod += sValue.charAt(nCount);
                            nCount++;
                      }

                      i++;
                    }

                    objeto.value = sCod;

                    if (nTecla != 8) { // backspace
                      if (sMask.charAt(i-1) == "9") { // apenas números...
                            return ((nTecla > 47) && (nTecla < 58)); } 
                      else { // qualquer caracter...
                            return true;
                      } 
                    }
                    else {
                      return true;
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
        <h1 class="display-4">Usuário </h1><h3><?=$usuario->nome;?></h3>
        <p class="lead">
            Editar usuário:
        </p>
    </div>

    <div class="container">
      <div class="col-md-12 order-md-1">
            <h4 class="mb-3">Dados do usuário:</h4>
            <form class="needs-validation" action="../../Controler/controlerUsuario.php?opcao=3" method="post" validate>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>Tipo de usuário:</label>
                        <select name="idTipoUsuario">
                            <?php
                                if($EditUsuario->idTipoUsuario == 1) {
                            ?>
                                <option value="1" selected>Administradores</option>
                                <option value="2">SAPES</option>
                                <option value="3">Gerentes</option>
                            <?php                                
                                }
                            ?>
                            <?php
                                if($EditUsuario->idTipoUsuario == 2) {
                            ?>
                                <option value="1">Administradores</option>
                                <option value="2" selected>SAPES</option>
                                <option value="3">Gerentes</option>
                            <?php                                
                                }
                            ?>
                            <?php
                                if($EditUsuario->idTipoUsuario == 3) {
                            ?>
                                <option value="1">Administradores</option>
                                <option value="2">SAPES</option>
                                <option value="3" selected>Gerentes</option>
                            <?php                                
                                }
                            ?>
                        </select>
                    </div>
                </div><div class="row">
                    <div class="col-md-12 mb-3">
                        <label>Nome:</label>
                        <input type="text" class="form-control" name="nome" value="<?php echo $EditUsuario->nome;?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>Login:</label>
                        <input type="text" class="form-control" name="login" value="<?php echo $EditUsuario->login;?>" required>
                    </div>
                </div>
                
                <input type="hidden" value="<?=$EditUsuario->idUsuario;?>" name="idUsuario" />
                <hr class="mb-6">
                <button class="btn btn-outline-primary" type="submit">Alterar dados</button>
                <a class="btn btn-outline-danger" href="../../Controler/controlerUsuario.php?opcao=5&idUsuario=<?php echo $EditUsuario->idUsuario?>">Exclui</a>
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