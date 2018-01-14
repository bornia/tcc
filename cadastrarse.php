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
    <!--  -->
    <link href="style/cadastrarse.css" rel="stylesheet" type="text/css">
    <!--  -->
    <link href="style/navbar.css" rel="stylesheet" type="text/css">
    

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="bootstrap/js/jquery.min.js"> </script>
    <!--  -->
    <script type="text/javascript" src="js/cadastrarse.js"> </script>
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

        <div class="row" id="container_alerta_mensagem">
          <div id="alerta_mensagem"> </div>
        </div>

        <form id="form_cadastro">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="nome"> Nome </label>
                <input type="text" name="nome" id="nome" placeholder="Nome que será exibido para os seus amigos" class="form-control" autofocus required>
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
          </div> <!-- Mensagem de alerta -->

          <div class="row">      
            <div class="col-md-6">
              <div class="form-group">
                <label for="senha"> Senha </label>
                <input type="password" name="senha" placeholder="Crie sua senha" class="form-control" id="senha" maxlength="32" required>
                <small class="pull-right">
                  <span id="senha_contador"> 32 </span> caracteres restantes
                </small>
              </div>
            </div> <!-- Senha -->

            <div class="col-md-6">
              <div class="form-group">
                <label for="confirmar_senha"> Confirme sua senha </label>
                <input type="password" name="confirmar_senha" placeholder="Digite novamente a senha criada" class="form-control" id="confirmar_senha" onpaste="return false;" ondrop="return false;" maxlength="32" required>
                <small class="pull-right">
                  <span id="confirmar_senha_contador"> 32 </span> caracteres restantes
                </small>
              </div>
            </div> <!-- Confirmação da senha -->
          </div>

          <div class="row">      
            <div class="col-md-12">
              <div class="form-group">
                <label for="pais_moeda"> País </label>
                <?php require('paises_moedas.html'); ?>
              </div>
            </div>
          </div> <!-- Moeda -->

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="conheceu_ferramenta"> Como conheceu a ferramenta? </label>
              
                <select id="conheceu_ferramenta" name="conheceu_ferramenta" class="form-control" onchange="/*especifica_opcao();*/" required>
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

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>