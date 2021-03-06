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
      <?php require("navbar-in.php"); ?> 
    </header>

    <!-- ========== RESUMO FINANCEIRO ========== -->
   
    <div class="main container mt-4" role="main">

      <!-- ========== AUXILIARES ========== -->

      <input type="hidden" id="registros_por_pagina"  readonly value="6" />
      <input type="hidden" id="offset"                readonly value="0" />
      <input type="hidden" id="info_usuario_id"       readonly value="<?= $_SESSION['id']     ?>">
      <div id="alerta_mensagem"> </div>

      <!-- ========== EVENTOS ========== -->

      <section id="meus-eventos">
        <div class="container-wip">
          <div class="row mb-2">
            <div class="col col-md-5 no-pl">
              <h1 class="less-mb"> Eventos </h1>
            </div>

            <div class="col-12 col-md-7 text-right">
              <button type="button" class="btn btn-lg btn-none btn-link float-right" aria-describedby="info_grupo_titulo_label" title="Consultar pagadores e devedores." data-toggle="modal" data-target="#janela-consultar-lista">
                <small> <span class="oi oi-info mr-1"> </span> </small>
                <span class="info_grupo_titulo text-muted text-size-responsive" id="info_grupo_titulo_label"> </span>
              </button>
            </div>
          </div> <!-- row -->

          <ul class="nav nav-tabs" id="abas-eventos" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="lista-tab" data-toggle="tab" href="#lista-tab-ref" role="tab" aria-controls="lista-tab-ref" aria-selected="true"> Lista </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" id="saldo-tab" data-toggle="tab" href="#saldo-tab-ref" role="tab" aria-controls="saldo-tab-ref" aria-selected="false"> Saldo </a>
            </li>
          </ul>

          <div class="tab-content" id="abas-eventos-ref">
            <div class="tab-pane fade show active" id="lista-tab-ref" role="tabpanel" aria-labelledby="lista-tab">
              <div class="row mb-2">

                <!-- ========== BARRA DE PESQUISA DE EVENTOS ========== -->

                <div class="col-12 col-md-5">
                  <label for="barra-de-pesquisa-label" class="text-muted font-weight-bold mt-2"> Pesquisa </label>

                  <div class="input-group" id="barra-de-pesquisa-label">
                    <input type="text" class="form-control text-size-responsive" id="barra-de-pesquisa" placeholder="Procure pelo título do evento" aria-label="Barra de pesquisa de eventos." onkeyup="atualizar_lista_eventos();">
                    
                    <div class="input-group-prepend">
                      <button type="button" class="btn btn-sm btn-none" onclick="apagar_texto('barra-de-pesquisa'); atualizar_lista_eventos();" aria-describedby="barra-de-pesquisa-icone">
                        <span class="close" id="barra-de-pesquisa-icone" aria-label="Apagar todo o texto da pesquisa."> &times; </span>
                      </button>
                    </div>
                  </div>
                </div>

                <!-- ========== ORDENAR EVENTOS ========== -->

                <div class="col-12 col-md-4">
                  <div class="row">
                    <div class="col">
                      <label class="text-muted font-weight-bold mt-2" for="ordem"> Ordem </label>

                      <div class="input-group">
                        <select class="form-control text-size-responsive" arial-label="Ordenar eventos de acordo com o critério selecionado." id="ordem" onchange="atualizar_lista_eventos();">
                          <option value="titulo"> Título </option>
                          <option value="total"> Total </option>
                          <option value="modificacao" selected> <small> Última Modificação </small> </option>
                        </select>

                        <div class="input-group-prepend" id="div-btn-ordenar-asc">
                          <button type="button" class="btn btn-sm btn-none" id="btn-ordenar-asc" title="Ordem crescente." onclick="mostrar_botao_ordenar_desc(); atualizar_lista_eventos();" data-tipo-ordem="ASC">
                            <span class="oi oi-arrow-top text-muted font-weight-bold"> </span>
                          </button>
                        </div>

                        <div class="input-group-prepend" id="div-btn-ordenar-desc">
                          <button type="button" class="btn btn-sm btn-none ordem-ativa" id="btn-ordenar-desc" title="Ordem decrescente." onclick="mostrar_botao_ordenar_asc(); atualizar_lista_eventos();" data-tipo-ordem="DESC">
                            <span class="oi oi-arrow-bottom text-muted font-weight-bold"> </span>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- ========== STATUS DOS EVENTOS ========== -->

                <div class="col-12 col-md-3">
                  <div class="row">
                    <div class="col">
                      <label class="text-muted font-weight-bold mt-2" for="status"> Status </label>

                      <select class="form-control text-size-responsive" arial-label="Filtre o evento por status." id="status" onchange="atualizar_lista_eventos();">
                        <option value="2"> Todos </option>
                        <option value="1"> Abertos </option>
                        <option value="0"> Fechados </option>
                      </select>
                    </div>
                  </div>
                </div>
              </div> <!-- row -->

              <div class="row">

                <!-- ========== BOTÃO PARA CRIAR UM NOVO EVENTO ========== -->

                <div class="col">
                  <button type="button" class="btn btn-success ml-3 mb-2 float-right" id="btn-criar-evento" title="Criar evento." data-toggle="modal" data-target="#janela-criar-evento">
                    <span class="oi oi-plus text-white" aria-labelledby="btn-criar-evento"> </span>
                  </button>
                  
                  <!-- ========== BOTÃO PARA EXCLUIR EVENTO(S) ========== -->

                  <button type="button" class="btn btn-danger mb-2 float-right" id="btn-excluir-evento" title="Excluir evento." data-toggle="modal" data-target="#janela-excluir-evento">
                    <span class="oi oi-trash text-white" aria-labelledby="btn-excluir-evento"> </span>
                  </button>

                  <!-- ========== BOTÃO PARA REABRIR EVENTO(S) ========== -->

                  <button type="button" class="btn btn-info mb-2 float-left" id="btn-reabrir-evento" title="Reabrir evento." data-toggle="modal" data-target="#janela-reabrir-evento">
                    <span class="oi oi-lock-unlocked text-white" aria-labelledby="btn-reabrir-evento"> </span>
                  </button>

                  <!-- ========== BOTÃO PARA FECHAR EVENTO(S) ========== -->

                  <button type="button" class="btn btn-dark mb-2 float-left" id="btn-finalizar-evento" title="Fechar evento." data-toggle="modal" data-target="#janela-finalizar-evento">
                    <span class="oi oi-lock-locked text-white" aria-labelledby="btn-finalizar-evento"> </span>
                  </button>
                </div>
              </div>

              <!-- ========== TABELA DE EVENTOS ========== -->

              <form method="POST" action="meusgastos.php">
                <input type="hidden" id="info_grupo_id" readonly name='grupo_id' value="<?= $_POST['grupo_id']  ?>">

                <div class="row" id="table-events">
                  <div class="col-md-12 table-responsive">
                    <table class="table table-sm table-stripped table-hover text-size-responsive" summary="Lista de eventos cadastrados com indicações sobre a data da última modificação e sobre o total de gastos em relação a cada evento.">
                      <caption class="sr-only">
                        Lista de Eventos
                      </caption>

                      <thead>
                        <tr>
                          <th class="align-middle">
                            <input type="checkbox" id="checkbox-excluir-todos-eventos" title="Selecionar todos" value="todo-item-selecionado" onclick="toggle_all_checkboxes(this);">
                          </th>
                          <th class="align-middle text-size-responsive"> Título              </th>
                          <th class="align-middle text-center text-size-responsive"> Total               </th>
                          <th class="align-middle text-center text-size-responsive"> Última modificação  </th>
                          <th class="align-middle text-center text-size-responsive"> Status  </th>
                          <th class="align-middle text-size-responsive"> Opções              </th>
                        </tr>
                      </thead>

                      <tbody id="tabela-corpo-eventos">

                      </tbody>
                    </table>
                  </div>
                </div>
              </form>

              <!-- ========== PAGINAÇÃO DE EVENTOS ========== -->

              <div class="row">
                <div class="col">
                  <nav class="float-right mt-0" aria-label="Barra de navegação das páginas dos eventos.">
                    <ul class="pagination pagination-sm" id="lista_paginas">
                      
                    </ul>
                  </nav>
                </div>
              </div>
            </div>

            <div class="tab-pane fade pt-2" id="saldo-tab-ref" role="tabpanel" aria-labelledby="saldo-tab">
              <div class="row" id="tabela-saldo">
                <div class="col">
                  <div class="table-responsive">
                    <table class="table table-stripped table-hover text-size-responsive" summary="Tabela com o saldo de cada membro, isto é, quanto cada membro deve um para o outro.">
                      <caption class="sr-only">
                        Tabela de Saldo
                      </caption>

                      <thead>
                        <tr>
                          <th class="align-middle text-center text-size-responsive no-border-top-color"> Membro </th>
                          <th class="align-middle text-size-responsive no-border-top-color"> Total Pago </th>
                          <th class="align-middle text-size-responsive no-border-top-color"> Saldo </th>
                        </tr>
                      </thead>

                      <tbody id="tabela-corpo-saldo">
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          
        </div> <!-- container-wip -->

        <!-- ========== MODAL PARA CONSULTAR A LISTA DE PAGADORES E DEVEDORES ========== -->

        <div class="modal fade" id="janela-consultar-lista" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-bg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title"> Balanço entre os Membros </h3>

                <button type="button" class="close" data-dismiss="modal" title="Fechar">
                  <span aria-hidden="true"> &times; </span>
                </button>
              </div>

              <div class="modal-body">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">
                    <div class="ml-2">
                      <span class="display-10"> Guilherme </span>
                      <small class="text-muted"> gborniam@gmail.com </small>
                    </div>

                    <div class="ml-4">
                      <span class="text-secondary text-size-responsive">
                        A receber <span class="text-success font-weight-bold"> R$ 00,00 reais</span>.
                      </span>
                    </div>

                    <div class="ml-4">
                      <span class="text-secondary text-size-responsive">
                        A pagar <span class="text-danger font-weight-bold"> R$ 00,00 reais</span>.
                      </span>
                    </div>
                  </li>
                </ul>
              </div> <!-- modal-body -->

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-size-responsive" data-dismiss="modal"> Fechar </button>
              </div>
            </div> <!-- modal-content -->
          </div>
        </div>

        <!-- ========== MODAL PARA FINALIZAR EVENTOS ========== -->

        <form class="modal fade" id="janela-finalizar-evento" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-bg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title"> Finalizar Evento </h3>

                <button type="button" class="close" data-dismiss="modal" title="Fechar">
                  <span aria-hidden="true"> &times; </span>
                </button>
              </div>

              <div class="modal-body">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col">
                      <p class="text-justify">
                        Tem certeza que deseja <u>finalizar</u> <span id="legenda_quantidade_itens_marcados_finalizar"> </span>?
                      </p>
                    </div>
                  </div>
                </div>
              </div> <!-- modal-body -->

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-size-responsive" data-dismiss="modal"> Cancelar </button>
                <button type="button" class="btn btn-dark text-size-responsive" id="modal-btn-finalizar-evento" onclick="finalizar_eventos();"> Finalizar </button>
              </div>
            </div> <!-- modal-content -->
          </div> <!-- modal-dialog -->
        </form>

        <!-- ========== MODAL PARA REABRIR EVENTOS ========== -->

        <form class="modal fade" id="janela-reabrir-evento" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-bg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title"> Reabrir Evento </h3>

                <button type="button" class="close" data-dismiss="modal" title="Fechar">
                  <span aria-hidden="true"> &times; </span>
                </button>
              </div>

              <div class="modal-body">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col">
                      <p class="text-justify">
                        Tem certeza que deseja <u>reabrir</u> <span id="legenda_quantidade_itens_marcados_reabrir"> </span>?
                      </p>
                    </div>
                  </div>
                </div>
              </div> <!-- modal-body -->

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-size-responsive" data-dismiss="modal"> Cancelar </button>
                <button type="button" class="btn btn-info text-size-responsive" id="modal-btn-reabrir-evento" onclick="reabrir_eventos();"> Reabrir </button>
              </div>
            </div> <!-- modal-content -->
          </div> <!-- modal-dialog -->
        </form>

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
                <div class="container-fluid">
                  <div class="row">
                    <div class="col">
                      <div id="alerta-janela-criar-evento"> </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label for="titulo" class="font-weight-bold"> Título do Evento </label>
                        <span id="nchar_titulo" class="badge badge-secondary" aria-label="Caracteres restantes."> 40 </span>
                        <input type="text" class="form-control text-size-responsive" id="titulo" name="titulo_evento" placeholder="Digite o nome do evento" maxlength="40" onkeyup="return check_nchar(this.id, 'nchar_titulo', 40);">
                      </div>
                    </div>
                  </div>
                </div>
              </div> <!-- modal-body -->

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-size-responsive" data-dismiss="modal"> Cancelar </button>
                <button type="button" class="btn btn-success text-size-responsive" onclick="adicionar_novo_evento();"> Adicionar </button>
              </div>
            </div> <!-- modal-content -->
          </div> <!-- modal-dialog -->
        </form>

        <!-- ========== MODAL PARA EXCLUIR EVENTOS ========== -->

        <form class="modal fade" id="janela-excluir-evento" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-bg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title"> Excluir Evento </h3>

                <button type="button" class="close" data-dismiss="modal" title="Fechar">
                  <span aria-hidden="true"> &times; </span>
                </button>
              </div>

              <div class="modal-body">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col">
                      <p class="text-justify">
                        Tem certeza que deseja <u>excluir</u> <span id="legenda_quantidade_itens_marcados_excluir"> </span>?
                      </p>
                    </div>
                  </div>
                </div>
              </div> <!-- modal-body -->

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-size-responsive" data-dismiss="modal"> Cancelar </button>
                <button type="button" class="btn btn-danger text-size-responsive" id="modal-btn-excluir-evento" onclick="excluir_eventos();"> Excluir </button>
              </div>
            </div> <!-- modal-content -->
          </div> <!-- modal-dialog -->
        </form>

        <!-- ========== MODAL PARA EDITAR EVENTOS ========== -->

        <form class="modal fade" id="janela-editar-evento" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-bg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title"> Editar Evento </h3>

                <button type="button" class="close" data-dismiss="modal" title="Fechar">
                  <span aria-hidden="true"> &times; </span>
                </button>
              </div>

              <div class="modal-body">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col">
                      <div id="alerta-janela-editar-evento"> </div>
                    </div>
                  </div>

                  <div class="row" style="display: none;">
                    <div class="col">
                      <div class="form-group">
                        <label for="info-evento-id" class="font-weight-bold sr-only"> ID do Evento </label>
                        <input type="text" class="form-control" id="info-evento-id" aria-describedby="info-evento-id-help" placeholder="Novo título do evento" readonly>
                        <small id="info-evento-id-help" class="form-text text-muted sr-only">Campo criado apenas para auxiliar com o ID do evento selecionado.</small>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label for="editar-titulo" class="font-weight-bold"> Alterar Título </label>
                        <span id="nchar-editar-titulo" class="badge badge-secondary" aria-label="Caracteres restantes."> 40 </span>
                        <input type="text" class="form-control" id="editar-titulo" aria-describedby="editar-titulo-help" placeholder="Novo título do evento" maxlength="40" onkeyup="return check_nchar(this.id, 'nchar-editar-titulo', 40);">
                        <small id="editar-titulo-help" class="form-text text-muted sr-only">Preencha este campo com o novo título do evento.</small>
                      </div>
                    </div>
                  </div>
                </div>
              </div> <!-- modal-body -->

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-size-responsive" data-dismiss="modal"> Cancelar </button>
                <button type="button" class="btn btn-warning text-size-responsive" id="modal-btn-editar-evento" onclick="editar_evento(this);"> Editar </button>
              </div>
            </div> <!-- modal-content -->
          </div> <!-- modal-dialog -->
        </form>
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