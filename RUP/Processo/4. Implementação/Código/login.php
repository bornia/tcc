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
    <title> WIP </title>
    
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!-- makes browsers render all elements more consistently and in line with modern standards -->
    <link href="style/normalize.css" rel="stylesheet" type="text/css">
    <link href="style/login.css" rel="stylesheet" type="text/css">
    <link href="style/navbar.css" rel="stylesheet" type="text/css">
    <link href="style/inner-addon.css" rel="stylesheet" type="text/css">
    

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="bootstrap/js/jquery.min.js"></script>
    <!--  -->
    <script type="text/javascript" src="js/login.js"> </script>
  </head>
  <body>
  	<header role="banner">
      <?php require("navbar-out.html"); ?> 
    </header>

    <section class="container-wip" role="main">
      <div class="row container-brand">
          <img src="#" class="img-responsive" id="brand">
      </div>

      <div class="row" id="container_alerta_mensagem"> </div>

      <div class="row">
        <form id="form_login" role="form">
          <div class="col-md-12">
            <div class="form-group inner-addon left-addon">
              <label for="username" class="sr-only"> Email </label>
              <input type="email" name="usuario" placeholder="Digite seu e-mail" class="form-control" id="username" autofocus required>
              <span class="glyphicon glyphicon-user"> </span>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group  inner-addon left-addon"> 
              <label for="password" class="sr-only"> Password </label>
              <input type="password" name="senha" placeholder="Digite sua senha" class="form-control" id="password" required>
              <span class="glyphicon glyphicon-lock"> </span>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <button type="button" class="btn btn-default" id="btn-submit" class="col-md-12" title="Entrar no aplicativo"> Entrar </button>
            </div>
          </div>  
        </form>
      </div> <!-- row form -->

      <div class="row">
        <div class="col-md-12">
          <div class="col-xs-6 padding-normalize font-xs"> <a href="#"> Esqueceu sua senha? </a> </div>
          <div class="col-xs-6 padding-normalize font-xs" id="btn-signin"> <a href="cadastrarse.php"> Cadastre-se </a> </div>
        </div>
      </div>
    </section>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>