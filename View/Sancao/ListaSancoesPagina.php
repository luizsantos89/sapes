<?php
    session_start();
    include("../../includes/verificaSessao.php");
    require '../../Model/Sancao.php';
    require '../../Model/Funcionario.php';
    require '../../Model/Usuario.php';
    require '../../Model/Secao.php';
    require '../../Model/Divisao.php';
    require '../../Model/Gerencia.php';

    if(!isset($_SESSION['tipoSancoes'])) {
        header("Location: ../../Controler/controlerSancao.php?opcao=6&pagina=1");
    }
    
    $funcionarios = $_SESSION['funcionarios'];
    $sancoes = $_SESSION['sancoes'];
    $numpaginas = $_REQUEST['paginas'];
    $usuarios = $_SESSION['usuarios'];
    $secoes = $_SESSION['secoes'];
    $divisoes = $_SESSION['divisoes'];
    $gerencias = $_SESSION['gerencias'];
    $tiposSancoes = $_SESSION['tipoSancoes'];
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="iso-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../imagens/imbel.ico">

    <title>Funcionários cadastrados</title>
    
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
            Sanções lançadas (25 por página):
        </p>
        <?php
            if($usuario->idTipoUsuario !=3 ){
        ?>
                <a class="btn btn-outline-primary" href="LancarSancao.php">Nova Sanção</a>
        <?php
            }
        ?>
    </div>

    <div class="container-fluid">
            <div>Páginas:  
            <?php
                for ($i = 1; $i < $numpaginas; $i++) {                    
            ?>
            <a class="btn-group" href="../../Controler/controlerSancao.php?opcao=6&pagina=<?=$i?>">
                <?php
                    echo $i;
                ?>
            </a>
            <?php
                
                    if($i < ($numpaginas-1))
                        echo ' - ';
                }
            
            if($funcionarios == null) {
                
            } else {
                if($sancoes != null) {
            ?>
            <table class="table table-striped">
                <tr class="thead-dark text-center">
                    <?php
                        if($usuario->idTipoUsuario != 3) {
                    ?>
                            <th colspan="2">Ações:</th>
                    <?php
                        }
                    ?>
                    <th>Id Sanção: </th>
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
                        
                    <?php
                        if($usuario->idTipoUsuario != 3) {
                    ?>                            
                        <td>
                            <a href="../../Controler/controlerSancao.php?opcao=2&idSancao=<?=$sancao->idSancao?>">
                                <img title="Editar Sanção" src="../../imagens/edit.png" height="25px" /></a>
                            </td>
                        <td>
                            <a href="../../Controler/controlerSancao.php?opcao=5&idSancao=<?=$sancao->idSancao?>">
                                <img title="Excluir Sanção" src="../../imagens/excluir.png" height="25px" /></a>
                        </td>
                    <?php
                        }
                    ?>
                        <td><?=$sancao->idSancao?></td>
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
                                foreach($usuarios as $user) {
                                    if($user->idUsuario == $sancao->idUsuario) {
                                        echo $user->nome;
                                    }
                                }                            
                            ?>  
                        </td>
                        <td>
                            <?= date('d/m/Y',strtotime($sancao->dataLancamento)); ?>  
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
                <?php
                } else {
                    echo '<h3>Nenhuma sanção foi lançada ainda.</h3>';
                }
                ?>
                
            <div>  
                <?php
                    if($numpaginas > 0) {
                        echo 'Páginas: ';
                        for ($i = 1; $i < $numpaginas; $i++) {                    
                ?>
                        <a href="../../Controler/controlerSancao.php?opcao=6&pagina=<?=$i?>">
                <?php
                            echo $i;
                ?>
                        </a>
                <?php

                        if($i < ($numpaginas-1))
                            echo ' - ';
                        }
                    }
                }
            ?>
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