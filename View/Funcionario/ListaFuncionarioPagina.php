<?php
    session_start();
    include("../../includes/verificaSessao.php");
    require '../../Model/Funcionario.php';
    require '../../Model/Usuario.php';
    require '../../Model/Secao.php';
    require '../../Model/Divisao.php';
    require '../../Model/Gerencia.php';

    if ($_SESSION['gerencias'])  {
        $funcionarios = $_SESSION['funcionarios'];
        $numpaginas = $_REQUEST['paginas'];
        $usuarios = $_SESSION['usuarios'];
        $secoes = $_SESSION['secoes'];
        $divisoes = $_SESSION['divisoes'];
        $gerencias = $_SESSION['gerencias'];
    } else {
        header("Location:../../Controler/controlerFuncionario?opcao=6&pagina=1");
    }
    
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
            Funcionários cadastrados (25 por página):
        </p>
        <a class="btn btn-outline-primary" href="CadastrarFuncionario.php">Cadastrar</a>
    </div>

    <div class="container-fluid">
        Páginas: 
        <?php  
                for ($i = 1; $i < $numpaginas; $i++) {                    
            ?>
            <a  href="../../Controler/controlerFuncionario.php?opcao=6&pagina=<?=$i?>">
                <?php
                    echo $i;
                ?>
            </a>
            <?php
                
                    if($i < ($numpaginas-1))
                        echo ' - ';
                }
            ?>
                - <a href="../../Controler/controlerFuncionario.php?opcao=1">Mostrar todos em uma única página </a>
               
            <?php
            if($funcionarios == null) {
                
            } else {
            ?>
            <table class="table table-striped">
                <thead class='thead-dark text-center'>
                    <tr>
                        <th colspan="2">Ações:</th>
                        <th>Crachá:</th>
                        <th>Nome:</th>
                        <th>Cargo:</th>
                        <th>Tipo:</th>
                        <th>Carga Horária:</th>
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
                        <td>
                            <a href="../../Controler/controlerFuncionario.php?opcao=2&idFuncionario=<?=$funcionario->idFuncionario?>">
                                <img title="Editar Funcionário" src="../../imagens/edit.png" height="25px" /></a>
                            </td>
                        <td>
                            <a href="../../Controler/controlerFuncionario.php?opcao=5&idFuncionario=<?=$funcionario->idFuncionario?>">
                                <img title="Excluir Funcionário" src="../../imagens/excluir.png" height="25px" /></a>
                        </td>
                        
                        <!--CRACHÁ -->
                        <td align="center">
                            <?=$funcionario->cracha; ?>  
                        </td>
                        
                        <!--NOME -->
                        <td> 
                            <a href="../../Controler/controlerFuncionario.php?opcao=10&idFuncionario=<?=$funcionario->idFuncionario;?>" title="Detalhes"><?=$funcionario->nome; ?></a>  
                        </td>
                        
                        <!--CARGO-->
                        <td>
                            <?=$funcionario->cargo;?> 
                        </td>
                        
                        <!--TIPO/CARGO-->
                        <td>
                            <?=$funcionario->situacao; ?>  
                        </td>
                        
                        <!--CARGA HORARIA-->
                        <td>
                            <?=$funcionario->cargaHoraria; ?> horas semanais 
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
                        <td align="center">
                            <?= date('d/m/Y',strtotime($funcionario->dataAdmissao)); ?> 
                        </td>
                        
                        <!--SEÇÃO -->
                        <td>
                            <?php                            
                                foreach($secoes as $secao) {
                                    if($secao->idSecao == $funcionario->idSecao) {
                                        echo "<a href='../../Controler/controlerFuncionario.php?opcao=7&idSecao=".$secao->idSecao."'>".$secao->descricao."</a>";
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
                                                echo "<a href='../../Controler/controlerFuncionario.php?opcao=8&idDivisao=".$divisao->idDivisao."'>".$divisao->descricao."</a>";
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
                                                        echo "<a href='../../Controler/controlerFuncionario.php?opcao=9&idGerencia=".$divisao->idGerencia."'>".$gerencia->descricao."</a>";
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            
                            ?>  
                        </td>
                        
                        <!--DATA DE CADASTRO -->
                        <td align="center">
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
            </table><div>Páginas:  
            <?php
                for ($i = 1; $i < $numpaginas; $i++) {                    
            ?>
            <a href="../../Controler/controlerFuncionario.php?opcao=6&pagina=<?=$i?>">
                <?php
                    echo $i;
                ?>
            </a>
            <?php
                
                    if($i < ($numpaginas-1))
                        echo ' - ';
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