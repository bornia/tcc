<?php

$sessao_validada = require_once('reqs/validar_sessao.php'); // sessio_start()

if($sessao_validada) {

  // Se o id do grupo existir então empty() retorna false e o usuário não será redirecionado, pois não há erro.
  if(empty($_POST['grupo_id'])) {
    header('Location: meusgrupos.php');
  }
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
    <link href="style/meuseventos.css" rel="stylesheet" type="text/css">

    <title> Eventos • OurBills </title>
  </head>

  <body>
    <header role="banner">
      <?php require("navbar-in.html"); ?> 
    </header>

    <!-- ========== RESUMO FINANCEIRO ========== -->
   
    <div class="main container" role="main">

      <!-- ========== AUXILIARES ========== -->

      <input type="text" id="info_grupo_id"   readonly value="<?= $_POST['grupo_id']  ?>" style="display: none;">
      <input type="text" id="info_usuario_id" readonly value="<?= $_SESSION['id']     ?>" style="display: none;">
      <div id="alerta_mensagem"> </div>

      <!-- ============================ -->

      <section id="resumo-financeiro">
        <div class="container-wip">
          <div class="row" >
            <h1 style="width: 100%;">
              Resumo do Grupo
              <small>
                <small class="text-muted float-right pr-4">
                  <small class="info_grupo_titulo text-size-responsive" style="vertical-align: bottom;"> </small>
                </small>
              </small>
            </h1>
          </div>

          <!-- ========== VALOR A SER RECEBIDO ========== -->

          <div class="row">
            <div class="col" data-toggle="tooltip" data-placement="bottom" title="Clique para saber mais sobre quem deve pagá-lo.">
              <button class="btn btn-info bg-white btn-block">
                <span class="oi oi-arrow-thick-top text-success font-weight-bold" aria-labelledby="a-receber"> </span>
                <span class="text-secondary text-size-responsive" id="a-receber">
                  A receber <span class="text-success font-weight-bold"> R$ 00,00 reais</span>.
                </span>
              </button>
            </div> 

            <!-- ========== VALOR A SER PAGO ========== -->

            <div class="col" data-toggle="tooltip" data-placement="bottom" title="Clique para saber mais sobre quem você deve pagar.">
              <button class="btn btn-info bg-white btn-block">
                <span class="oi oi-arrow-thick-bottom text-danger font-weight-bold" aria-labelledby="a-pagar"> </span>
                <span class="text-secondary text-size-responsive" id="a-pagar">
                  A pagar <span class="text-danger font-weight-bold"> R$ 00,00 reais</span>.
                </span>
              </button>
            </div>

          </div> 
        </div>
      </section>

      <!-- ========== EVENTOS ========== -->

      <section id="meus-eventos">
        <div class="container-wip">
          <div class="row">
            <h1 style="width: 100%;">
              Eventos
             <small>
                <small class="text-muted float-right pr-4">
                  <small class="info_grupo_titulo text-size-responsive" style="vertical-align: bottom;"> </small>
                </small>
              </small>
            </h1>
          </div> <!-- row -->

          <div class="row mb-2">

            <!-- ========== BARRA DE PESQUISA DE EVENTOS ========== -->

            <div class="col-12 col-md-5">
              <label for="barra-de-pesquisa-label" class="text-muted font-weight-bold mt-2"> Pesquisa </label>

              <div class="input-group" id="barra-de-pesquisa-label">
                <input type="text" class="form-control text-size-responsive" placeholder="Procure pelo nome" aria-label="Barra de pesquisa de eventos." aria-describedby="barra-de-pesquisa-icone">

                <div class="input-group-apend">
                  <button class="btn btn-outline-secondary" type="button" aria-label="Pesquisar.">
                    <span class="oi oi-magnifying-glass"> </span>
                  </button>
                </div>
              </div>
            </div>

            <!-- ========== ORDENAR EVENTOS ========== -->

            <div class="col-12 col-md-4">
              <div class="row">
                <div class="col">
                  <label class="text-muted font-weight-bold mt-2" for="ordem"> Ordem </label>

                  <select class="form-control text-size-responsive" arial-label="Ordenar eventos de acordo com o critério selecionado." id="ordem">
                    <option value="titulo"> Título </option>
                    <option value="total"> Total </option>
                    <option value="modificacao" selected> <small> Última Modificação </small> </option>
                  </select>
                </div>
              </div>
            </div>

            <!-- ========== STATUS DOS EVENTOS ========== -->

            <div class="col-12 col-md-3">
              <div class="row">
                <div class="col">
                  <label class="text-muted font-weight-bold mt-2" for="status"> Status </label>

                  <select class="form-control text-size-responsive" arial-label="" id="status">
                    <option value="todos"> Todos </option>
                    <option value="abertos"> Abertos </option>
                    <option value="fechados"> Fechados </option>
                  </select>
                </div>
              </div>
            </div>
          </div> <!-- row -->

          <div class="row">

            <!-- ========== BOTÃO PARA CRIAR UM NOVO EVENTO ========== -->

            <div class="col">
              <button type="button" class="btn btn-success mb-2 float-right" id="btn-criar-evento" title="Criar evento." data-toggle="modal" data-target="#janela-criar-evento">
                <span class="oi oi-plus text-white" aria-labelledby="btn-criar-evento" aria-describedby="btn-criar-evento-descricao"> </span>
                <span class="sr-only" id="btn-criar-evento-descricao"> Criar evento. </span>
              </button>

              <!-- ========== BOTÃO PARA EXCLUIR EVENTO(S) ========== -->

              <button type="button" class="btn btn-danger mb-2 float-right" id="btn-excluir-evento" title="Excluir evento." data-toggle="modal" data-target="#janela-excluir-evento">
                <span class="oi oi-trash text-white" aria-labelledby="btn-excluir-evento" aria-describedby="btn-excluir-evento-descricao"> </span>
                <span class="sr-only" id="btn-excluir-evento-descricao"> Excluir evento. </span>
              </button>
            </div>
          </div>

          <!-- ========== TABELA DE EVENTOS ========== -->

          <div class="row" id="table-events">
            <div class="col-md-12 table-responsive">
              <table class="table table-stripped table-hover text-size-responsive" summary="Lista de eventos cadastrados com indicações sobre a data da última modificação e sobre o total de gastos em relação a cada evento.">
                <caption class="sr-only">
                  Lista de Eventos
                </caption>

                <thead>
                  <tr>
                    <th class="align-middle">
                      <input type="checkbox" id="checkbox-excluir-todos-eventos" title="Selecionar todos" value="todo-item-selecionado" onclick="toggle_all_checkboxes(this);">
                    </th>
                    <th class="align-middle"> Título              </th>
                    <th class="align-middle text-center"> Total               </th>
                    <th class="align-middle text-center"> Última modificação  </th>
                    <th class="align-middle"> Opções              </th>
                  </tr>
                </thead>

                <tbody id="tabela-corpo-eventos">

                </tbody>
              </table>
            </div>
          </div> <!-- row -->

          <!-- ========== MODAL PARA CRIAR UM NOVO EVENTO ========== -->

          <form class="modal fade" id="janela-criar-evento" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-md modal-dialog-centered">
              <div class="modal-content text-size-responsive">
                <div class="modal-header">
                  <h3 class="modal-title"> Novo Evento </h3>

                  <button type="button" class="close" data-dismiss="modal" title="Fechar">
                    <span> &times; </span>
                  </button>
                </div>

                <div class="modal-body">
                  <div class="form-group">
                    <label for="titulo" class="font-weight-bold"> Título do Evento </label>
                    <input type="text" class="form-control text-size-responsive" id="titulo" name="titulo_evento" placeholder="Digite o nome do evento">
                  </div>
                </div> <!-- modal-body -->

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary text-size-responsive" data-dismiss="modal"> Cancelar </button>
                  <button type="button" class="btn btn-success text-size-responsive" onclick="adicionar_novo_evento();" data-dismiss="modal"> Adicionar </button>
                </div>
              </div> <!-- modal-content -->
            </div> <!-- modal-dialog -->
          </form>

          <!-- ========== MODAL PARA EXCLUIR EVENTOS ========== -->

          <form class="modal fade" id="janela-excluir-evento" tabindex="-1" role="dialog"> <!-- Modal para adicionar novo evento -->
            <div class="modal-dialog modal-sm modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title"> Excluir Evento </h3>

                  <button type="button" class="close" data-dismiss="modal" title="Fechar">
                    <span aria-hidden="true"> &times; </span>
                  </button>
                </div>

                <div class="modal-body">
                  <p>
                    Tem certeza que deseja <u>excluir</u> <span id="legenda_quantidade_itens_marcados"> </span>?
                  </p>
                </div> <!-- modal-body -->

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary text-size-responsive" data-dismiss="modal"> Cancelar </button>
                  <button type="button" class="btn btn-danger text-size-responsive" onclick="excluir_eventos();"> Excluir </button>
                </div>
              </div> <!-- modal-content -->
            </div> <!-- modal-dialog -->
          </form>

          <!-- ========== PAGINAÇÃO DE EVENTOS ========== -->

          <div class="row">
            <div class="col">
              <nav class="float-right mt-2" aria-label="Barra de navegação das páginas dos eventos.">
                <ul class="pagination pagination-sm">
                  <li class="page-item disabled">
                    <a class="page-link" href="#" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                      <span class="sr-only">Previous</span>
                    </a>
                  </li>
                  <li class="page-item active"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                      <span class="sr-only">Next</span>
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>

        </div> <!-- container-wip -->
      </section> <!-- Meus Eventos -->
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- Personal -->
    <!--  -->
    <script src="js/meuseventos.js" type="text/javascript"> </script>
  </body>
</html>