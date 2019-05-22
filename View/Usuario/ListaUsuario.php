<?php
    session_start();
    include("../../includes/verificaSessao.php");
    require '../../Model/Usuario.php';
    
    $usuarios = $_SESSION['usuarios'];
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="iso-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../imagens/imbel.ico">

    <title>Usuários - Sistema de Aproveitamento Funcional - DVRH/FJF</title>
    
    <script type="text/javascript">
    // função para desabilitar a tecla F5.
        window.onkeydown = function (e) {
            if (e.keyCode === 116) {
                alert("Função não permitida");
                e.keyCode = 0;
                e.returnValue = false;
                return false;
            }
        }
    </script>
    
    <style type="text/css">        
        @media print{
           #noprint{
               display:none;
           }
        }
    </style>

    <!-- Bootstrap core CSS -->
    <link href="../../estilos/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../estilos/css/pricing.css" rel="stylesheet">
  </head>

  <body>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow" id="noprint">
        <img class="my-0 mr-md-auto font-weight-normal" src="../../imagens/logo2.png"  id="noprint" />
        <nav class="my-2 my-md-0 mr-md-3"  id="noprint">
            <?php include("../../includes/Menus.php"); ?>
        </nav>
        <a class="btn btn-outline-primary" href="../../Controler/logout.php"  id="noprint">Sair</a>
    </div>

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Usuários</h1>
        <p class="lead">
            Usuários cadastrados:
        </p>
        <a class="btn btn-outline-primary" href="CadastraUsuario.php">Cadastrar</a>
    </div>

    <div class="container">
            <div>
                
                
                <p class="alert-warning">
                    <?php
                        if(isset($_SESSION['erroExclusao'])) {
                            echo '<script>alert("Impossível excluir usuário. Há lançamentos relacionados."); </script>';
                            unset($_SESSION['erroExclusao']);
                        }                    
                    ?>
                </p>
                <p class="alert-warning">
                    <?php
                        if(isset($_SESSION['resetSenha'])) {
                            echo '<script>alert("Senha do usuário alterada com sucesso"); </script>';
                            unset($_SESSION['resetSenha']);
                        }                    
                    ?>
                </p>
                
            <?php
            $qtd = 0;
            
            if($usuarios == null) {
                
            } else {   
                foreach($usuarios as $user) {
                    $qtd+=1;
                }
                echo 'Total de <b>'.$qtd.'</b> usuários ';
                
            ?>
                
            <table class="table table-striped">
                <thead class='thead-dark text-center'>
                    <tr>
                        <th colspan="2">Ações:</th>
                        <th>Nome:</th>
                        <th>Login:</th>
                        <th>Ultimo Acesso:</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($usuarios as $usuario) {
                ?>
                    <tr>
                        <td>
                            <a href="../../Controler/controlerUsuario.php?opcao=2&idUsuario=<?=$usuario->idUsuario?>">
                                <img title="Editar Usuário" src="../../imagens/edit.png" height="25px" /></a>
                            </td>
                        <td>
                            <a href="../../Controler/controlerUsuario.php?opcao=5&idUsuario=<?=$usuario->idUsuario?>">
                                <img title="Excluir Usuário" src="../../imagens/excluir.png" height="25px" /></a>
                        </td>
                        
                        <!--NOME -->
                        <td>
                            <?=$usuario->nome; ?>  
                        </td>
                        
                        <!--LOGIN -->
                        <td> 
                            <?=$usuario->login; ?>
                        </td>
                        
                        <!--ÚLTIMO ACESSO -->
                        <td> 
                            <?= date('d/m/Y H:i:s',strtotime($usuario->ultimoAcesso)); ?>  
                        </td>
                        
                        <!--ÚLTIMO ACESSO -->
                        <td> 
                            <a href="../../Controler/controlerUsuario.php?opcao=6&idUsuario=<?=$usuario->idUsuario?>" class="btn btn-danger">Reset Senha</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php
            
                                }
                                ?>
            </div>

      <footer class="pt-4 my-md-5 pt-md-5 border-top"  id="noprint">
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