<?php

$sessao_validada = require_once('reqs/validar_sessao.php');

if($sessao_validada) {
  $limite_nome_grupo = 30;
  $limite_descricao_grupo = 190;
}

return true;
?>

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

    <style type="text/css">
      div.main {
        height: 100%;
      }

      section.container-wip {
        height: 100%;
      }

      div.panel {
        height: 80%;
      }
    </style>

    <script type="text/javascript" src="js/meusgrupos.js"> </script>
  </head>
  <body>
  	<header role="banner">
      <?php require('navbar-in.html'); ?> 
    </header>

    <div class="main container" >
      <section class="container-wip" role="main">
        <div class="row">
          <div class="col-md-12">
            <h1> Grupos </h1>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#janela_novo_grupo" title="Adicionar novo grupo">
              <span class="glyphicon glyphicon-plus-sign"> </span> Novo Grupo
            </button>
          </div>
        </div>

        <form class="modal fade" id="janela_novo_grupo"> <!-- Modal para adicionar novo evento -->
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="Fechar">
                  <span> &times; </span>
                </button>
                <h3 class="modal-title"> Novo Grupo </h3>
              </div>

              <div class="modal-body">
                <?php
                  
                ?>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="nome_grupo"> Nome do Grupo: </label>
                      <small class="sub-font pull-right">
                        <span id="nchar_nome"> <?= $limite_nome_grupo ?> </span> caracteres restantes
                      </small>
                      <input id="nome_grupo" type="text" name="nome_grupo" class="form-control" maxlength="30" onkeyup="return check_nchar('nome_grupo', 'nchar_nome', <?= $limite_nome_grupo ?>);" onpaste="return false;">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for=""> Descrição: </label>
                      <small class="sub-font pull-right">
                        <span id="nchar_descricao"> <?= $limite_descricao_grupo ?> </span> caracteres restantes
                      </small>
                      <textarea id="descricao_grupo" class="form-control" style="min-width: 100%; max-width: 100%; max-height: 6em;" rows="3" maxlength="190" onkeyup="return check_nchar('descricao_grupo', 'nchar_descricao', <?= $limite_descricao_grupo ?>);" onpaste="return false;"> </textarea>
                    </div>
                  </div>
                </div>
              </div> <!-- modal-body -->

              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"> Cancelar </button>
                <button type="submit" class="btn btn-success"> Adicionar </button>
              </div>
            </div> <!-- modal-content -->
          </div> <!-- modal-dialog -->
        </form> <!-- fim do modal -->

        <div class="panel panel-default" style="overflow-y: auto;">
          <div class="panel-body">
            <a class="group-link" href="#">
              <div class="row panel" style="padding-bottom: 0.8em;">
                <div class="col-md-2" align="center">
                  <img src="img/no-profile-picture-160x120.jpg" class="img-responsive img-circle">
                </div> <!-- Imagem do grupo -->

                <div class="col-md-10">
                  <div class="row">
                    <div class="col-md-8">
                      <span class="group-name"> Nome do Grupo </span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <small class="sub-font"> 7 Membros </small>
                    </div>
                  </div>
                </div> <!-- Nome, e-mail, número de participantes -->
              </div> <!-- Grupo -->
            </a>
          </div>
        </div>
      </section>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="bootstrap/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>