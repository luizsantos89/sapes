
<a class="p-2 text-dark" href="../View/index.php">Principal</a>
<!--<a class="p-2 text-dark" href="../Controler/controlerFuncionario.php?opcao=1">Funcionários</a>-->
<a class="p-2 text-dark" href="../Controler/controlerFuncionario.php?opcao=6&pagina=1">Funcionários</a>
<a class="p-2 text-dark" href="../Controler/controlerTipoSancao.php?opcao=1">Tipos de Sanções</a>
<!--<a class="p-2 text-dark" href="../Controler/controlerSancao.php?opcao=1">Sanções</a>-->
<a class="p-2 text-dark" href="../View/Sancao/index.php">Sanções</a>
<a class="p-2 text-dark" href="../View/Absenteismo/index.php">Absenteísmo</a>
<a class="p-2 text-dark" href="../View/Desempenho/index.php">Desempenho</a>
<a class="p-2 text-dark" href="../View/Aproveitamento/index.php">Aproveitamento</a>
<a class="p-2 text-datk" href="../Controler/controlerAcesso.php?opcao=0">Meu Cadastro</a>
<?php
    if($usuario->idTipoUsuario == 1) {
?>
    <a class="p-2 text-datk" href="../Controler/controlerUsuario.php?opcao=1">Usuários</a>
<?php
    } 
?>