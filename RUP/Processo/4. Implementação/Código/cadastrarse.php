<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- makes browsers render all elements more consistently and in line with modern standards -->
    <link href="style/normalize.css" rel="stylesheet" type="text/css">
    <!--  -->
    <link href="style/navbar.css" rel="stylesheet" type="text/css">
    <!--  -->
    <link href="style/cadastrarse.css" rel="stylesheet" type="text/css">

    <title> Cadastre-se • OurBills </title>
  </head>
  <body>
    <header role="banner">
      <?php require('navbar-out.html'); ?> 
    </header>

    <div class="main container">
      <section class="container-wip" role="main">
        <div class="row">
          <h1> Cadastre-se </h1>
        </div>

        <div class="row" id="container_alerta_mensagem">
          <div id="alerta_mensagem"> </div>
        </div>

        <form id="form_cadastro">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="nome" class="font-weight-bold"> Nome </label>
                <input type="text" name="nome" id="nome" placeholder="Nome que será exibido para os seus amigos" class="form-control" autofocus required>
              </div>
            </div>
          </div> <!-- Nome -->

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="email" class="font-weight-bold"> E-mail </label>
                <input id="email" type="email" name="email" placeholder="exemplo@dominio.com" class="form-control" required>
              </div>
            </div>
          </div> <!-- Mensagem de alerta -->

          <div class="row">      
            <div class="col-md-6">
              <div class="form-group">
                <label for="senha" class="font-weight-bold"> Senha </label>
                <input id="senha" type="password" name="senha" placeholder="Mínimo de 6 caracteres" class="form-control" minlength="6" maxlength="32" required>
                <small class="pull-right">
                  <span id="senha_contador"> 32 </span> caracteres restantes
                </small>
              </div>
            </div> <!-- Senha -->

            <div class="col-md-6">
              <div class="form-group">
                <label for="confirmar_senha" class="font-weight-bold"> Confirme sua senha </label>
                <input id="confirmar_senha" type="password" name="confirmar_senha" placeholder="Digite novamente a senha criada" class="form-control" onpaste="return false;" ondrop="return false;" minlength="6" maxlength="32" required>
                <small class="pull-right">
                  <span id="confirmar_senha_contador"> 32 </span> caracteres restantes
                </small>
              </div>
            </div> <!-- Confirmação da senha -->
          </div>

          <div class="row">      
            <div class="col-md-12">
              <div class="form-group">
                <label for="pais_moeda" class="font-weight-bold"> País </label>
                <?php require('paises_moedas.html'); ?>
              </div>
            </div>
          </div> <!-- Moeda -->

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="conheceu_ferramenta" class="font-weight-bold"> Como conheceu a ferramenta? </label>
              
                <select id="conheceu_ferramenta" name="conheceu_ferramenta" class="form-control" onchange="/*especifica_opcao();*/" required>
                  <option value="" disabled selected> Selecione uma opção... </option>
                  <option value="amigo"> Amigo </option>
                  <option value="artigo"> Artigo </option>
                  <option value="jornal"> Jornal </option>
                  <option value="forum"> Fórum </option>
                  <option value="google"> Google </option>
                  <option value="noticias"> Notícia </option>
                  <option value="propaganda"> Propaganda </option>
                  <option value="revista"> Revista </option>
                  <option value="yahoo"> Yahoo </option>
                  <option value="outro"> Outros meios </option>
                </select>
              </div>
              <!--
              <div id="conheceu_ferramenta_outro" style="display: none;">
                <label for="conheceu_ferramenta_especificacao" class="sr-only"> Especifique onde conheceu a ferramenta. </label>
                <input id="conheceu_ferramenta_especificacao" type="text" name="conheceu_ferramenta_especificacao" class="form-control">
              </div> -->
            </div>
          </div> <!-- Como conheceu a ferramenta -->

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <button type="button" class="btn btn-default" id="btn-submit"> Cadastrar </button>
              </div>
            </div>
          </div> <!-- Botão Cadastrar -->
        </form>
      </section>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- Personal -->
    <!--  -->
    <script type="text/javascript" src="js/cadastrarse.js"> </script>
  </body>
</html>