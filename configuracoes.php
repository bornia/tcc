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
    <style type="text/css" rel="stylesheet">
      .lowweight {
        font-weight: 100;
      }
    </style>
  </head>
  <body>
  	<header role="banner">
      <?php require("navbar-in.html"); ?> 
    </header>
   
   	<div class="main container" role="main">
      <section id="configuracoes-pessoais" class="container-wip">
        <div class="row">
          <div class="col-md-11">
            <h1> Configurações </h1>
          </div>
        </div>

        <form method="" action="">
          <div class="row">
            <div class="col-md-2">
              <div class="row">
                <div class="col-md-12" align="center">           
                  <img id="foto-perfil" src="img/no-profile-picture.jpg" class="img-responsive img-rounded" style="width: 10em; height: 10em;" alt="Foto de perfil">
                  <input id="btn-foto-perfil" type="file" class="btn btn-link pull-right" accept="image/png, image/jpeg"> Editar Foto </input>
                </div>
              </div> <!-- row - Foto de perfil -->
            </div> <!-- col - Foto de perfil -->



            <div class="col-md-4 col-md-offset-1">
              <div class="row">
                <div class="panel">
                  <h4> Dados Primários </h4>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="nome"> Nome </label>
                    <input id="nome" type="text" name="nome" class="form-control" value="<?= $nome = 'Maria Paula Oliveira' ?>" required>
                  </div>
                </div>
              </div> <!-- Nome -->

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="email"> E-mail </label>
                    <input id="email" type="email" name="email" class="form-control" value="<?= $email = 'maria@gmail.com' ?>" autocomplete="off" required>
                  </div>
                </div>
              </div> <!-- E-mail -->

              <div class="row">      
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pais_moeda"> País e Moeda </label>
                    <?php require('paises_moedas.html'); ?>
                  </div>
                </div>
              </div> <!-- Moeda -->

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="senha"> Senha </label>
                    <button type="button" class="btn-link pull-right" aria-label="Editar senha"> Editar </button>
                    <input id="senha" type="password" name="senha" class="form-control" value="<?= $senha = '123456789' ?>" readonly>
                  </div>
                </div>
              </div> <!-- Senha -->
            </div> <!-- Dados primários -->

            <div class="col-md-4 col-md-offset-1">
              <div class="row">
                <div class="panel">
                  <h4> Dados Secundários </h4>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="celular"> Celular </label>
                    <input id="celular" type="tel" name="celular" class="form-inline form-control" placeholder="DD + número" pattern="[0-9]{11}" title="** Não insira espaços, letras e caracteres especiais. **" >
                  </div>
                </div> <!-- Celular -->

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nascimento"> Data de Nascimento </label>
                    <input id="nascimento" type="date" name="nascimento" class="form-control" max="2018-01-01">
                  </div>
                </div>
              </div> <!-- Celular e data de nascimento -->

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="estado"> Estado </label>
                    <select id="estado" name="estado" class="form-control">
                      <option value="saopaulo"> São Paulo </option>
                    </select>
                  </div>
                </div>
              </div> <!-- Estado -->

              <div class="row">
                <div class="panel">
                  <h4> Notificações <small> Receber notificões quando: </small> </h4>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <div>
                      <label class="lowweight">
                        <input type="checkbox" name="notificacoes" value="">
                        Um <u>grupo</u> for criado/modificado.
                      </label>

                      <span class="glyphicon glyphicon-info-sign pull-right" title="O usuário será notificado quando um grupo, no qual ele foi incluído, for criado, excluído ou sofrer qualquer tipo de modificação."> </span>
                    </div>
                  
                    <div>
                      <label class="lowweight">
                        <input type="checkbox" name="notificacoes" value="">
                        Um <u>evento</u> for incluído/alterado.
                      </label>

                      <span class="glyphicon glyphicon-info-sign pull-right" title="O usuário será notificado quando um evento, no qual ele foi incluído, for adicionado, excluído ou sofrer qualquer tipo de alteração."> </span>
                    </div>

                    <div>
                      <label class="lowweight">
                        <input type="checkbox" name="notificacoes" value="">
                        Faltar 2 dias para uma conta expirar.
                      </label>

                      <span class="glyphicon glyphicon-info-sign pull-right" title="O usuário será notificado 2 dias antes de uma conta, na qual ele foi incluído, atingir sua data de pagamento."> </span>
                    </div>

                    <div>
                      <label class="lowweight">
                        <input type="checkbox" name="notificacoes" value="">
                        Novas funcionalidades forem lançadas.
                      </label>

                      <span class="glyphicon glyphicon-info-sign pull-right" title="O usuário será notificado quando novas funcionalidades ficarem disponíveis."> </span>
                    </div>
                  </div>
                </div>
              </div> <!-- Notificações -->
            </div> <!-- Dados secundários -->
          </div> <!-- Foto de perfil e informações básicas -->

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <button id="btn-submit" type="submit" class="btn btn-default pull-right"> Salvar Dados </button>
              </div>
            </div>
          </div>
        </form>
      </section> <!-- Configurações Pessoais -->
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <!-- Meus Eventos JavaScript -->
    <script src="js/myevents.js" type="text/javascript"> </script>
  </body>
</html>