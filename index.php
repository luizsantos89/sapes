<?php
    session_start();
    if(isset($_SESSION["usuario"])) {
        Header("Location: View/index.php");
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        
        <!-- meta Data -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        
        <!-- title -->
        <title>DVRH - Sistema de Aproveitamento Funcional</title>
        
        <!-- stylesheet -->
        <link rel="stylesheet" href="estilos/css/fontawesome-all.min.css" />
        <link rel="stylesheet" href="estilos/css/bootstrap.min.css" />
        <link rel="stylesheet" href="estilos/css/main.css" />
        <link rel="stylesheet" href="estilos/css/responsive.css" />
        <link rel="stylesheet" href="estilos/css/light_template.css" />
        <link rel="stylesheet" href="estilos/css/colors/default-color.css" />
        <link rel="icon" href="imagens/favicon.ico">
        
        
        <style type="text/css">
            .image-right-sub {
                position: fixed;

                top: 92%;
                right: 0;

                height: 100px;

                margin-top: -50px;
            }
        </style>
        
        <!-- Plugins -->
        <link rel="stylesheet" href="estilos/css/magnific-popup.css" />
        
        <!-- google Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kaushan+Script|Poppins:300i,400,600" />
    </head>
    <body>
        <img class="image-right-sub" src="imagens/logo1.jpg" height="90px" />
        <section id="home-cont" class="home2 home">
            <div class="skewed">
                <div class="overlay"></div>
                <div class="my-bg bg-image"></div>
            </div>
            <div class="title">
                <h1 class="text-uppercase"><strong>Aproveitamento<br> Funcional</strong></h1>
                <p class="type"></p>  <!-- Texto no arquivo custom.js -->
                <div class="btn-home">
                    
                </div>
                
            
                <?php
                    if(isset($_GET['erro'])) {
                        echo '<div class="erro">Usuário e/ou senha incorretos</div><br />';
                    }            
                ?>
                
                <div class="login-form">    
                    <form action="Controler/controlerLogin.php" method="post">
                        <h4 class="modal-title"></h4>
                        <div class="form-group">
                            <input type="text" class="form-control" name="usuario" placeholder="Entre com seu usuário" required="required">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="senha" placeholder="Entre com sua senha" required="required">
                        </div>
                        <div class="form-group small clearfix">
                            
                            <a href="http://192.168.131.30" target="_blank" class="forgot-link">Esqueceu sua senha?</a>
                        </div> 
                        <input type="submit" class="btn btn-primary btn-block btn-lg" value="Acessar">              
                    </form>			
                </div>
            </div>
        </section>
        
        <!-- End Header -->
        <!-- Start Loading -->
        
        <div class="loading">
            <div class="blob-grid">
                <div class="blob blob-0"></div>
                <div class="blob blob-1"></div>
                <div class="blob blob-2"></div>
                <div class="blob blob-3"></div>
                <div class="blob blob-4"></div>
                <div class="blob blob-5"></div>
            </div>
        </div>
        
        <!-- End Loading -->
        
        
        <script src="estilos/js/jquery-3.1.1.min.js"></script>
        <script src="estilos/js/jquery.magnific-popup.min.js"></script>
        <script src="estilos/js/typed.js"></script>
        <script src="estilos/js/popper.min.js"></script>
        <script src="estilos/js/bootstrap.min.js"></script>
        <script src="estilos/js/custom.js"></script>
    </body>
</noscript>
<div style="text-align: center;"><div style="position:relative; top:0; margin-right:auto;margin-left:auto; z-index:99999">

</div></div>
</html>