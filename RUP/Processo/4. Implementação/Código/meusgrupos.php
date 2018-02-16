<?php


$sessao_validada = require_once('reqs/validar_sessao.php');

if($sessao_validada) {
  $limite_nome_grupo = 30;
  $limite_descricao_grupo = 190;
}

?>

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
    <link href="style/meusgrupos.css" rel="stylesheet" type="text/css">

    <title> Grupos • OurBills </title>
  </head>

  <body>
    <header role="banner">
      <?php require('navbar-in.html'); ?> 
    </header>

    <div class="main container" >
      <section class="container-wip" role="main" style="">
        <div class="row">
          <h1> Grupos </h1>
        </div>

        <div class="row">
          <div class="col">
            <button type="button" class="btn btn-success btn-sm mb-1" data-toggle="modal" data-target="#janela_novo_grupo" title="Adicionar novo grupo">
              <span class="oi oi-plus" aria-labelledby="novo-grupo"> </span>
              <span id="novo-grupo"> Novo Grupo </span>
            </button>
          </div>
        </div>

        <!-- ========== Modal para adicionar novo evento ========== -->

        <form class="modal fade" id="janela_novo_grupo" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title"> Novo Grupo </h3>

                <button type="button" class="close" data-dismiss="modal" title="Fechar">
                  <span aria-hidden="true"> &times; </span>
                </button>   
              </div>

              <div class="modal-body">
                <?php
                  
                ?>

                <div class="row">
                  <div class="col">
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
                  <div class="col">
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
                <button type="submit" class="btn btn-success"> Criar Grupo </button>
              </div>
            </div> <!-- modal-content -->
          </div> <!-- modal-dialog -->
        </form>

        <!-- ========== FIM DO MODAL ========== -->

        <div class="row">
          <div class="col mb-2">
            <div class="list-group pre-scrollable" id="lista-de-grupos" role="tablist" style="overflow: auto;">
              <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Home</a>
              <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">Profile</a>
              <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab" aria-controls="messages">Messages</a>
              <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">Settings</a>
            </div>
          </div>

          <div class="col">
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                <div class="card border-0">
                  <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title"> Nome do Grupo </h5>
                      </div>

                      <div class="col">
                        <span class="text-muted float-right align-text-bottom" id="numero-de-membros">
                          7 Membros
                        </span>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col">
                        <p class="card-text"> <small> Descrição do grupo. </small> </p>
                      </div>
                    </div>                    
                  </div>

                  <div class="card-footer border-light">
                    <div class="row">
                      <div class="col">
                        <small class="text-muted" id="ultima-atualizacao"> Última atualização há 3 minutos </small>
                      </div>

                      <div class="col">
                        <a href="#" class="btn btn-sm float-right" id="btn-submit">
                          <span class="oi oi-account-login" aria-labelledby="entrar-no-grupo"> </span>
                          <span id="entrar-no-grupo"> Entrar no Grupo </span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                Grupo 2
              </div>

              <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
                Grupo 3
              </div>

              <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
                Grupo 4
              </div>
            </div>
          </div>
        </div>
        
      </section>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- Personal -->
    <!--  -->
    <script type="text/javascript" src="js/meusgrupos.js"> </script>
  </body>
</html>