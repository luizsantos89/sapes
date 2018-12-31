<?php
    session_start();
    include("../../includes/verificaSessao.php");
    require '../../Model/Funcionario.php';
    require '../../Model/Usuario.php';
    require '../../Model/Secao.php';
    require '../../Model/Divisao.php';
    require '../../Model/Gerencia.php';

    $funcionarios = $_SESSION['funcionarios'];
    $usuarios = $_SESSION['usuarios'];
    $secoes = $_SESSION['secoes'];
    $divisoes = $_SESSION['divisoes'];
    $gerencias = $_SESSION['gerencias'];
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="iso-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

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
        <h1 class="display-4">Funcionários</h1>
        <p class="lead">
            Funcionários cadastrados:
        </p>
        <a class="btn btn-outline-primary" href="CadastrarFuncionario.php">Cadastrar</a>
    </div>

    <div class="container">
            <div>

            <?php
            
            if($funcionarios == null) {
                
            } else {
            ?>
            <table class="table table-striped">
                <thead class='thead-dark text-center'>
                    <tr>
                        <th>Crachá:</th>
                        <th>Nome:</th>
                        <th>Cargo:</th>
                        <th>Tipo:</th>
                        <th>Situação:</th>
                        <th>Data de Admissão:</th>
                        <th>Seção:</th>
                        <th>Divisão:</th>
                        <th>Gerência:</th>
                        <th>Data de Cadastro:</th>
                        <th>Cadastrado por:</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($funcionarios as $funcionario) {
                ?>
                    <tr>
                        
                        <!--CRACHÁ -->
                        <td>
                            <?=$funcionario->cracha; ?>  
                        </td>
                        
                        <!--NOME -->
                        <td> 
                            <a href="../../Controler/controlerFuncionario.php?opcao=2&idFuncionario=<?=$funcionario->idFuncionario;?>"><?=$funcionario->nome; ?></a>  
                        </td>
                        
                        <!--CARGO-->
                        <td>
                            <a href="../../Controler/controlerFuncionario.php?opcao=5&filtroCargo='<?=$funcionario->cargo;?>'"><?=$funcionario->cargo;?></a> 
                        </td>
                        
                        <!--TIPO/CARGO-->
                        <td>
                            <?=$funcionario->situacao; ?>  
                        </td>
                        
                        <!--ATIVO/INATIVO-->
                        <td>
                            <?php
                                if ($funcionario->funcAtivo == 1) {
                                    echo 'Ativo';
                                } else {
                                    echo 'Inativo';
                                }
                            
                            
                            ?>
                        </td>
                        
                        <!--DATA DE ADMISSAO-->
                        <td>
                            <?= date('d/m/Y',strtotime($funcionario->dataAdmissao)); ?> 
                        </td>
                        
                        <!--SEÇÃO -->
                        <td>
                            <?php                            
                                foreach($secoes as $secao) {
                                    if($secao->idSecao == $funcionario->idSecao) {
                                        echo $secao->descricao;
                                    }
                                }                            
                            ?>  
                        </td>    
                        
                        <!-- DIVISAO -->
                        <td>
                            <?php
                            foreach($secoes as $secao) {
                                    if($secao->idSecao == $funcionario->idSecao) {
                                        foreach($divisoes as $divisao) {
                                            if($secao->idDivisao == $divisao->idDivisao) {
                                                echo $divisao->descricao;
                                            }
                                        }
                                    }
                                }
                            
                            ?>  
                        </td>
                        
                        <!-- GERENCIA -->
                        <td>
                            <?php
                            foreach($secoes as $secao) {
                                    if($secao->idSecao == $funcionario->idSecao) {
                                        foreach($divisoes as $divisao) {
                                            if($secao->idDivisao == $divisao->idDivisao) {
                                                foreach($gerencias as $gerencia) {
                                                    if($gerencia->idGerencia == $divisao->idGerencia) {
                                                        echo $gerencia->descricao;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            
                            ?>  
                        </td>
                        
                        <!--DATA DE CADASTRO -->
                        <td>
                            <?= date('d/m/Y',strtotime($funcionario->dataCadastro)); ?>  
                        </td>
                        
                        <!-- CADASTRADO POR: -->
                        <td>
                            <?php
                            
                                foreach($usuarios as $usuario) {
                                    if($usuario->idUsuario == $funcionario->idUsuario) {
                                        echo $usuario->nome;
                                    }
                                }
                            
                            ?>  
                        </td>
                        
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php
            
                                }
                                ?>
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