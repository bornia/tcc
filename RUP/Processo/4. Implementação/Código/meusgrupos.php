<?php


$sessao_validada = require_once('reqs/validar_sessao.php');

if($sessao_validada) {
  $limite_nome_grupo = 30;
  $limite_descricao_grupo = 100;
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
      <?php require('navbar-in.php'); ?> 
    </header>

    <div class="main container">

      <!-- ========== MENSAGEM DE ALERTA ========== -->

      <div class="mt-4" id="alerta_info_grupos"> </div>

      <!-- ========== CONTAINER-WIP ========== -->

      <section class="container-wip" role="main" style="">
        <div class="row">
          <h1> Grupos </h1>
        </div>

        <input type='hidden' id="aux_usuario_email" value="<?= $_SESSION['email']; ?>" readonly>
        <input type='hidden' id="info_usuario_id"   value="<?= $_SESSION['id']; ?>" readonly>

        <!-- ========== GRUPOS E SEUS DADOS ========== -->

        <div class="row">
          <div class="col-12 col-md-6">

            <!-- ========== BOTÕES ========== -->

            <div class="row mb-1">
              <div class="col">
                <button type="button" class="btn btn-sm btn-success btn-block" id="btn-criar-grupo" data-toggle="modal" data-target="#janela_novo_grupo" aria-labelledby="btn-novo-grupo">
                  <span class="oi oi-plus text-size-responsive" aria-labelledby="novo-grupo"> </span>
                  <span id="btn-novo-grupo" class="text-size-responsive"> Criar Grupo </span>
                </button>
              
                <button type="button" class="btn btn-sm btn-danger btn-block mt-0" id="btn-excluir-grupo-marcado" data-toggle="modal" data-target="#janela_excluir_grupo" aria-labelledby="btn-excluir-grupo-titulo" onclick="marcar_excluir_grupos();">
                  <span class="oi oi-trash text-size-responsive"> </span>
                  <span class="text-size-responsive" id="btn-excluir-grupo-titulo"> Excluir Grupo </span>
                </button>
              </div>

              <div class="col">
                <button type="button" class="btn btn-sm btn-warning mb-1 btn-block float-right" id="btn-editar-grupo" data-toggle="modal" data-target="#janela-editar-grupo" aria-labelledby="janela-editar-grupo-titulo" onclick="buscar_info_grupo();">
                  <span class="oi oi-pencil text-size-responsive"> </span>
                  <span class="text-size-responsive" id="btn-excluir-grupo-titulo"> Editar Grupo </span>
                </button>
              </div>
            </div>

            <!-- ========== LISTA DE GRUPOS ========== -->
          
            <div class='row'>
              <div class='col p-0' id='lista-de-grupos'>

              </div>
            </div>
          </div>

          <!-- ========== DADOS DOS GRUPOS ========== -->

          <div class='col-12 col-md-6'>
            <div class='tab-content pt-3' id='lista-de-grupos-detalhes'>

            </div>
          </div>
        </div>

        <!-- ========== MODAL PARA ADICIONAR NOVO GRUPO ========== -->

        <form class="modal fade text-size-responsive" id="janela_novo_grupo" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title"> Novo Grupo </h3>

                <button type="button" class="close" data-dismiss="modal" title="Fechar" onclick="limpar_formulario();">
                  <span aria-hidden="true"> &times; </span>
                </button>   
              </div>

              <div class="modal-body">
                <div class="container-fluid">
                  <div class="row"> <div class="col"> <div id="alerta_mensagem_submit"> </div> </div> </div>

                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label for="nome_grupo" class="font-weight-bold"> Título do Grupo </label>

                        <span id="nchar_nome" class="badge badge-secondary" aria-label="Caracteres restantes."> <?= $limite_nome_grupo ?> </span>
                        

                        <input type="text" class="form-control text-size-responsive" id="nome_grupo" name="titulo_grupo" maxlength="<?= $limite_nome_grupo ?>" onkeyup="return check_nchar('nome_grupo', 'nchar_nome', <?= $limite_nome_grupo ?>);">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label for="descricao_grupo" class="font-weight-bold"> Descrição </label>

                        <span id="nchar_descricao" class="badge badge-secondary" aria-label="Caracteres restantes."> <?= $limite_descricao_grupo ?> </span>

                        <textarea class="form-control text-size-responsive" id="descricao_grupo" name="descricao_grupo" rows="3" maxlength="<?= $limite_descricao_grupo ?>)" onkeyup="return check_nchar('descricao_grupo', 'nchar_descricao', <?= $limite_descricao_grupo ?>);"> </textarea>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col">
                      <span id="alerta_mensagem"> </span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-4">
                      <label for="participantes" class="font-weight-bold"> Membros </label>
                    </div>

                    <div class="col">
                      <div class="form-group">
                        <label class="sr-only" for="buscar-email-participante">
                          Buscar e-mail do membro:
                        </label>

                        <input type="text" placeholder="Insira o e-mail e tecle Enter" class="form-control text-size-responsive" id="buscar-email-participante" onkeyup="return buscar_entre_membros(this.id);" onkeypress="incluir_membro(event);" data-toggle="tooltip" data-placement="top" title="Ao pressionar Enter, o membro será incluído na lista abaixo.">

                        <div class="row">
                          <div class="col">
                            <div class="caixa-pesquisa-usuarios" id="caixa-pesquisa-usuarios-novo-grupo">
                              <ul class="lista-pesquisa-usuarios" id="lista-pesquisa-usuarios-novo-grupo">

                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div id="todos-membros-novos"> </div> <!-- participantes -->
                </div>
              </div> <!-- modal-body -->

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpar_formulario();"> Cancelar </button>
                <button type="button" class="btn btn-success" onclick="criar_grupo();"> Criar Grupo </button>
              </div>
            </div> <!-- modal-content -->
          </div> <!-- modal-dialog -->
        </form> 

        <!-- ========== MODAL PARA EXCLUIR GRUPO ATIVO ========== -->

        <form class="modal fade" id="janela_excluir_grupo" tabindex="-1" role="dialog" aria-labelledby="janela_excluir_grupo_titulo" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="janela_excluir_grupo_titulo"> Excluir Grupo </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                  <span aria-hidden="true"> &times; </span>
                </button>
              </div>
              <div class="modal-body">
                <div class="container-fluid">
                  <span id="aux-grupo-titulo"></span>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-disabled="false"> Cancelar </button>
                <button type="button" class="btn btn-danger" id="btn-excluir-grupo" aria-disabled="false" onclick="excluir_grupos();"> Excluir Grupo </button>
              </div>
            </div>
          </div>
        </form>

        <!-- ========== MODAL PARA EDITAR GRUPO ========== -->

        <form class="modal fade" id="janela-editar-grupo" tabindex="-1" role="dialog" aria-labelledby="janela-editar-grupo-titulo" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="janela-editar-grupo-titulo"> Editar Grupo </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                  <span aria-hidden="true"> &times; </span>
                </button>
              </div>
              <div class="modal-body">
                <div class="container-fluid">

                  <input type="hidden" id="info_usuario_id" readonly value="<?= $_SESSION['id'] ?>">

                  <div class="row"> <div class="col"> <div class="text-justify" id="alerta-mensagem-editar-grupo"> </div> </div> </div>

                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label for="titulo-editar-grupo" class="font-weight-bold"> Título do Grupo </label>

                        <span id="nchar_nome_editar_grupo" class="badge badge-secondary" aria-label="Caracteres restantes."> <?= $limite_nome_grupo ?> </span>
                        

                        <input type="text" class="form-control text-size-responsive" id="titulo-editar-grupo" name="titulo-editar-grupo" maxlength="<?= $limite_nome_grupo ?>" onkeyup="return check_nchar('titulo-editar-grupo', 'nchar_nome_editar_grupo', <?= $limite_nome_grupo ?>);">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label for="descricao-editar-grupo" class="font-weight-bold"> Descrição </label>

                        <span id="nchar_descricao_editar_grupo" class="badge badge-secondary" aria-label="Caracteres restantes."> <?= $limite_descricao_grupo ?> </span>

                        <textarea class="form-control text-size-responsive" id="descricao-editar-grupo" name="descricao-editar-grupo" rows="3" maxlength="<?= $limite_descricao_grupo ?>)" onkeyup="return check_nchar('descricao-editar-grupo', 'nchar_descricao_editar_grupo', <?= $limite_descricao_grupo ?>);"> </textarea>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-4">
                      <label for="todos-membros-editar-grupo" class="font-weight-bold"> Membros </label>
                    </div>

                    <div class="col">
                      <div class="form-group">
                        <label class="sr-only" for="buscar-email-participante-editar-grupo">
                          Buscar e-mail do membro:
                        </label>

                        <input type="text" placeholder="Insira o e-mail e tecle Enter" class="form-control text-size-responsive" id="buscar-email-participante-editar-grupo" onkeyup="return buscar_entre_membros_editar_grupo(this.id);" onkeypress="incluir_membro_editar_grupo(event);" data-toggle="tooltip" data-placement="top" title="Ao pressionar Enter, o membro será incluído na lista abaixo.">

                        <div class="row">
                          <div class="col">
                            <div class="caixa-pesquisa-usuarios" id="caixa-pesquisa-usuarios-editar-grupo">
                              <ul class="lista-pesquisa-usuarios" id="lista-pesquisa-usuarios-editar-grupo">

                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div id="todos-membros-editar-grupo"> </div> <!-- participantes -->
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-disabled="false"> Cancelar </button>
                <button type="button" class="btn btn-warning" id="btn-excluir-grupo" aria-disabled="false" onclick="editar_grupo();"> Editar Grupo </button>
              </div>
            </div>
          </div>
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
    <script type="text/javascript" src="js/meusgrupos.js"> </script>
  </body>
</html>