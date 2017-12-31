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
    <title> WIP | Meus Grupos </title>
    
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!-- makes browsers render all elements more consistently and in line with modern standards -->
    <link href="style/normalize.css" rel="stylesheet" type="text/css">
    <link href="style/meusgrupos.css" rel="stylesheet" type="text/css">
    <link href="style/navbar.css" rel="stylesheet" type="text/css">
    <link href="style/inner-addon.css" rel="stylesheet" type="text/css">
    

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  	<header role="banner">
      <?php require('navbar-in.html'); ?> 
    </header>

    <div class="main container">
      <section class="container-wip" role="main">
        <!-- <div class="panel"> -->
          <div class="row">
            <div class="col-md-12">
              <h1> Grupos </h1>
            </div>
          </div>
        <!-- </div> -->

        <div class="panel panel-default">
          <div class="panel-heading">
            <div class="row">
              <a href="" title="Adicionar um novo grupo">
                <div class="col-md-4">
                  <span id="plus-sign" class="glyphicon glyphicon-plus-sign"> </span>
                  <span> Novo Grupo </span>
                </div>
              </a>
            </div> <!-- Botão para adicionar novo grupo -->
          </div>

          <div class="panel-body">
            <div class="row panel">
              <div class="col-md-2" align="center">
                <img src="img/no-profile-picture-160x120.jpg" class="img-responsive img-circle">
              </div> <!-- Imagem do grupo -->

              <div class="col-md-9">
                <div class="row" style="margin-bottom: 1.5em;">
                  <div class="col-md-12">
                    Nome do Grupo
                  </div>
                </div>
              </div> <!-- Nome, e-mail, número de participantes -->
            </div> <!-- Grupo -->

            <div class="row panel">
              <div class="col-md-2" align="center">
                <img src="img/no-profile-picture-160x120.jpg" class="img-responsive img-circle">
              </div> <!-- Imagem do grupo -->

              <div class="col-md-9">
                <div class="row" style="margin-bottom: 1.5em;">
                  <div class="col-md-12">
                    Nome do Grupo
                  </div>
                </div>
              </div> <!-- Nome, e-mail, número de participantes -->
            </div> <!-- Grupo -->
          </div>
        </div>


      </section>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>