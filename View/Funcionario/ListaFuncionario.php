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
        $usuarios = $_SESSION['usuarios'];
        $secoes = $_SESSION['secoes'];
        $divisoes = $_SESSION['divisoes'];
        $gerencias = $_SESSION['gerencias'];
    } else {
        header("Location:../../Controler/controlerFuncionario?opcao=6&pagina=1");
    }
    
    $usuario = $_SESSION['usuario'];
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
    <link rel="icon" href="../../imagens/imbel.ico">

    <title>Funcionários - Sistema de Aproveitamento Funcional - DVRH/FJF</title>
    
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
           
           a {
               text-decoration: none;
               color: black;
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
        <img class="my-0 mr-md-auto font-weight-normal" src="../../imagens/logo2.png"   />
        <nav class="my-2 my-md-0 mr-md-3"  id="noprint">
            <?php include("../../includes/Menus.php"); ?>
        </nav>
        <a class="btn btn-outline-primary" href="../../Controler/logout.php"  id="noprint">Sair</a>
    </div>

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Funcionários</h1>
        <p class="lead">
            Funcionários cadastrados:
        </p>
        <?php
            if($usuario->idTipoUsuario != 3) {
        ?>
            <a class="btn btn-outline-primary" href="CadastrarFuncionario.php">Cadastrar</a>
        <?php
            }
        ?>
    </div>

    <div class="container-fluid">
            <div>
                
            <?php
            $qtd = 0;
            
            if($funcionarios == null) {
                
            } else {   
                foreach($funcionarios as $funcionario) {
                    $qtd+=1;
                }
                echo 'Total de <b>'.$qtd.'</b> funcionários ';
                if(isset($_SESSION['porSecao'])) {
                    unset($_SESSION['porSecao']);
                    echo '<a href="../../Controler/controlerFuncionario.php?opcao=6&pagina=1">[Listar todos]</a>';
                }
                
            ?>
            <table class="table table-striped text-small">
                <thead class='thead-dark text-center'>
                    <tr>
                        <?php
                            if($usuario->idTipoUsuario != 3) {
                        ?>
                        <th colspan="2" id="noprint">Ações:</th>
                        <?php
                            }
                        ?>
                        <th class="center">Crachá:</th>
                        <th>Nome:</th>
                        <th>Nascimento:</th>
                        <th>Sexo:</th>
                        <th>Cargo:</th>
                        <th>Tipo:</th>
                        <th>Carga Horária:</th>
                        <th>Situação:</th>
                        <th>Admissão:</th>
                        <th>Seção:</th>
                        <th>Divisão:</th>
                        <th>Gerência:</th>
                    </tr>
                </thead>
                <tbody class="text-small">
                <?php
                    foreach ($funcionarios as $funcionario) {
                ?>
                    <tr class="text-small">
                        <?php
                            if($usuario->idTipoUsuario != 3) {
                        ?>
                                <td id="noprint">
                                    <a href="../../Controler/controlerFuncionario.php?opcao=2&idFuncionario=<?=$funcionario->idFuncionario?>">
                                        <img title="Editar Funcionário" src="../../imagens/edit.png" height="25px" /></a>
                                    </td>
                                <td id="noprint">
                                    <a href="../../Controler/controlerFuncionario.php?opcao=5&idFuncionario=<?=$funcionario->idFuncionario?>">
                                        <img title="Excluir Funcionário" src="../../imagens/excluir.png" height="25px" /></a>
                                </td>
                        <?php
                            }
                        ?>
                        
                        <!--CRACHÁ -->
                        <td class="text-center">
                            <?=str_pad($funcionario->cracha,3,0, STR_PAD_LEFT)?>
                        </td>
                        
                        <!--NOME -->
                        <td> 
                            <a href="../../Controler/controlerFuncionario.php?opcao=10&idFuncionario=<?=$funcionario->idFuncionario;?>" title="Detalhes"><?=$funcionario->nome; ?></a>  
                        </td>
                        
                        <td>
                            <?php
                            if($funcionario->dataNascimento != "0000-00-00" ) {
                                echo date('d/m/Y',strtotime($funcionario->dataNascimento));
                            }
                            ?> 
                        </td>
                        
                        <td style="text-transform: capitalize;">
                            <?=$funcionario->sexo;?>
                        </td>
                        
                        <!--CARGO-->
                        <td>
                            <a href="../../Controler/controlerFuncionario.php?opcao=11&cargo=<?=$funcionario->cargo;?>" title="Filtrar por cargo"><?=$funcionario->cargo;?></a>
                        </td>
                        
                        <!--TIPO/CARGO-->
                        <td>
                            <?=$funcionario->situacao; ?>  
                        </td>
                        
                        <!--CARGA HORARIA-->
                        <td class="text-center">
                            <?=$funcionario->cargaHoraria; ?>  hrs
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
                        <td class="text-center">
                            <?php                            
                                foreach($secoes as $secao) {
                                    if($secao->idSecao == $funcionario->idSecao) {
                                        echo "<a href='../../Controler/controlerFuncionario.php?opcao=7&idSecao=".$secao->idSecao."'>".$secao->descricao."</a>";
                                    }
                                }                            
                            ?>  
                        </td>    
                        
                        <!-- DIVISAO -->
                        <td class="text-center">
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
                        <td class="text-center">
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
                        
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
                <?php
                    date_default_timezone_set('America/Sao_Paulo');
                    $date = date('d/m/Y H:i:s');
                    echo $date;               
                ?>
                <p class="alert-warning">
                    <?php
                        if(isset($_SESSION['erroExclusao'])) {
                            echo '<script>alert("Impossível excluir funcionário. Há lançamentos relacionados."); </script>';
                            unset($_SESSION['erroExclusao']);
                        }                    
                    ?>
                </p>
            <?php
            
                                }
                                ?>
            </div>
    </div>
    <div class="container">
        <footer class="pt-4 my-md-5 pt-md-5 border-top" id="noprint" >
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