<?php
    session_start();
    if(isset($_SESSION["usuario"])) {
        Header("Location: View/index.php");
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/imagens/imbel.ico">

    <title>Avaliação de Desempenho</title>

    <!-- Bootstrap core CSS -->
    <link href="estilos/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="estilos/css/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
        <form class="form-signin" action="Controler/controlerLogin.php" method="post">
            
            <img class="mb-4" src="imagens/logo1.png" alt="" height="106">
            <h1 class="h3 mb-3 font-weight-normal">Acessar</h1>
            <label class="sr-only">Login</label>
            <input type="text" name="login" id="inputEmail" class="form-control" placeholder="Login" required autofocus>
            <label for="inputPassword" class="sr-only">Senha</label>
            <input type="password" name="senha" id="inputPassword" class="form-control" placeholder="Password" required>
            
            <?php
                if(isset($_GET['erro'])) {
                    echo '<div class="erro">Usuário e/ou senha incorretos</div><br />';
                }            
            ?>
            
            <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>

            <p class="mt-5 mb-3 text-muted">
                Seção de Administração de Pessoal<br />
                Divisão de Recursos Humanos <br /> 
                Fábrica Juiz de Fora<br />
                IMBEL&reg;<br />
            </p> 
        </form>
  </body>
</html>
