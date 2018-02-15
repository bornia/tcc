<!doctype html>

<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!--  -->
    <link href="open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
    <!-- makes browsers render all elements more consistently and in line with modern standards -->
    <link href="style/normalize.css" rel="stylesheet" type="text/css">
    <!--  -->
    <link href="style/navbar.css" rel="stylesheet" type="text/css">
    <!--  -->
    <link href="style/login.css" rel="stylesheet" type="text/css">

    <title> Entrar • OurBills </title>
  </head>

  <body>
    <header role="banner">
      <?php require('navbar-out.html'); ?> 
    </header>

    <div class="container container-wip" role="main">
      <!-- 
      <div class="row container-brand">
          <img src="#" class="img-responsive" id="brand">
      </div>
       -->

      <div class="row" id="container_alerta_mensagem" aria-label="Mensagem de erro."> </div>

      <form id="form_login" role="form">
        <div class="row">
          <div class="col">
            <div class="input-group form-group">
              <div class="input-group-prepend">
                <span class="input-group-text oi oi-person align-middle"> </span>
              </div>

              <label id="user_email_label" for="user_email" class="sr-only"> Digite seu e-mail </label>
              <input type="text" name="usuario" class="form-control" id="user_email" placeholder="E-mail" aria-label="E-mail do usuário." aria-labelledby="user_email_label" autofocus required>
            </div>

          </div>
        </div>

        <div class="row">
          <div class="col">
            <div class="input-group form-group"> 
              <div class="input-group-prepend">
                <span class="input-group-text oi oi-lock-locked align-middle"> </span>
              </div>

              <label id="user_password_label" for="password" class="sr-only"> Digite sua senha </label>
              <input type="password" name="senha" class="form-control" id="password" placeholder="Digite sua senha"   aria-label="Senha do usuário." aria-labelledby="user_password_label" required>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col">
            <div class="form-group">
              <button type="button" class="btn btn-default" id="btn-submit" class="col" title="Entrar no aplicativo"> Entrar </button>
            </div>
          </div>
        </div>
      </form>

      <div class="row">
          <div class="col font-xs">
            <a href="#"> Esqueceu sua senha? </a>
          </div>

          <div class="col font-xs text-right">
            <a href="cadastrarse.php"> Cadastre-se </a>
          </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- Personal -->
    <!--  -->
    <script type="text/javascript" src="js/login.js"> </script>
  </body>
</html>