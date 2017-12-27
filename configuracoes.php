<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--
      * The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags
      * A segunda tag é utilizar para criar uma compatibilidade com o Internet Explorer.
      * A terceira tag é utiliza para criar designs responsivos.
      ** O viewport é todo o conteúdo da página que é exibida pelo browser.
      ** O width=device-width, initial-scale=1 ajuda o conteúdo da página conforme o tamanho do viewport.
    -->
    <title> WIP | Configurações </title>
    
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!-- makes browsers render all elements more consistently and in line with modern standards. -->
    <link href="style/normalize.css"        rel="stylesheet" type="text/css">
    <link href="style/navbar.css"           rel="stylesheet" type="text/css">
    <link href="style/configuracoes.css"    rel="stylesheet" type="text/css">
    

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Substitui/adiciona algumas formatações do bootstrap -->
    <style type="text/css" rel="stylesheet"> </style>
  </head>
  <body>
  	<header role="banner">
      <?php require("navbar-in.html"); ?> 
    </header>
   
   	<div class="main container" role="main">
      <section id="configuracoes-basicas" class="container-wip">
        <form method="" action="">
          <div class="row">
            <div class="col-md-4">
              <div class="row">
                <div class="col-md-12" align="center">           
                  <img id="foto-perfil" src="img/no-profile-picture.jpg" class="img-responsive img-rounded" style="width: 10em; height: 10em;" alt="Foto de perfil">
                  <label id="legenda-foto-perfil" for="foto-perfil"> <a href=""> Editar Foto </a> </label>
                </div>
              </div> <!-- row - Foto de perfil -->
            </div> <!-- col - Foto de perfil -->

            <div class="col-md-8">
              <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                      <label for="nome"> Nome </label>
                      <input type="text" name="nome" class="form-control" value="<?php echo $nome = 'Maria Paula' ?>">
                    </div>
                  </div>

                  <div class="col-md-5 col-lg-offset-1">
                    <div class="form-group">
                      <label for="sobrenome"> Sobrenome </label>
                      <input type="text" name="sobrenome" class="form-control" value="<?php echo $sobrenome = 'Oliveira da Silva' ?>">
                    </div>
                  </div>
              </div> <!-- row - Informações básicas -->
            </div> <!-- col - Informações básicas -->
          </div> <!-- Foto de perfil e informações básicas -->
        </form>
      </section> <!-- Configurações Básicas -->

      <section id="configuracoes-notificacoes">
        
      </section> <!-- Configurações de Notificações -->
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <!-- Meus Eventos JavaScript -->
    <script src="js/myevents.js" type="text/javascript"> </script>
  </body>
</html>