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
    <title> WIP | Cadastrar-se </title>
    
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!-- makes browsers render all elements more consistently and in line with modern standards -->
    <link href="style/normalize.css" rel="stylesheet" type="text/css">
    <link href="style/cadastrarse.css" rel="stylesheet" type="text/css">
    <link href="style/navbar.css" rel="stylesheet" type="text/css">
    

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  	<header role="banner">
      <?php require('navbar-out.html'); ?> 
    </header>

    <div class="main container">
      <section class="container-wip" role="main">
        <div class="row">
          <div class="col-md-12">
            <h1> Cadastre-se </h1>
          </div>
        </div>

        <form method="post" action="reqs/cadastrar_usuario.php">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="nome"> Nome </label>
                <input type="text" name="nome" id="nome" placeholder="Nome que será exibido para os seus amigos" class="form-control" required>
              </div>
            </div>
          </div> <!-- Nome -->

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="email"> E-mail </label>
                <input type="email" name="email" placeholder="exemplo@dominio.com" class="form-control" id="email" required>
              </div>
            </div>
          </div>

          <div class="row">      
            <div class="col-md-6">
              <div class="form-group">
                <label for="senha"> Senha </label>
                <input type="password" name="senha" placeholder="Senha" class="form-control" id="senha" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="confirmar_senha"> Confirme sua senha </label>
                <input type="password" name="confirmar_senha" placeholder="Digite novamente sua senha" class="form-control" id="confirmar_senha" onpaste="return false;" ondrop="return false;" required>
              </div>
            </div>
          </div>

          <div class="row">      
            <div class="col-md-12">
              <div class="form-group">
                <label for="pais_moeda"> País </label>
                <?php require('paises_moedas.html'); ?>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <button type="submit" class="btn btn-default" id="btn-submit" title="Entrar no aplicativo"> Cadastrar </button>
              </div>
            </div>
          </div>
        </form>
      </section>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>