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
      <section id="resumo-financeiro">
        <div class="container-wip">
          <div class="row">
            <h1> Resumo do Grupo <small class="text-muted"> Rep da sua mãe </small> </h1>
          </div>

          <!-- ========== VALOR A SER RECEBIDO ========== -->

          <div class="row">
            <div class="col" data-toggle="tooltip" data-placement="bottom" title="Clique para saber mais sobre quem deve pagá-lo.">
              <button class="btn btn-info bg-white btn-block">
                <span class="oi oi-arrow-thick-top text-success font-weight-bold" aria-labelledby="a-receber"> </span>
                <span class="text-secondary text-size-responsive" id="a-receber">
                  Você deve receber <span class="text-success font-weight-bold"> R$ 00,00 reais</span>.
                </span>
              </button>
            </div> 

            <!-- ========== VALOR A SER PAGO ========== -->

            <div class="col" data-toggle="tooltip" data-placement="bottom" title="Clique para saber mais sobre quem você deve pagar.">
              <button class="btn btn-info bg-white btn-block">
                <span class="oi oi-arrow-thick-bottom text-danger font-weight-bold" aria-labelledby="a-pagar"> </span>
                <span class="text-secondary text-size-responsive" id="a-pagar">
                  Você deve pagar <span class="text-danger font-weight-bold"> R$ 00,00 reais</span>.
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
            <h1> Eventos </h1>
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
                      <input type="checkbox" title="Selecionar todos" value="todo-item-selecionado" onclick="return toggle_all_checkboxes(this);">
                    </th>
                    <th class="align-middle"> Título </th>
                    <th class="align-middle"> Última Modificação </th>
                    <th class="align-middle"> Opções </th>
                  </tr>
                </thead>

                <tbody>
                  <tr>
                    <td class="align-middle">
                      <input aria-label="Marque o item" type="checkbox" name="item" value="item-selecionado-1" onchange="return verify_checkbox_status(this);">
                    </td>
                    <td class="change-cursor align-middle" onclick="return redirect_page();"> REP - Aluguel de Julho </td>
                    <td class="change-cursor align-middle" onclick="return redirect_page();"> 27/10/2017 as 15:18:35 </td>
                    <td class="align-middle">
                      <button type="button" class="btn btn-warning" id="btn-editar-evento" title="Editar evento.">
                        <span class="oi oi-pencil text-white" aria-labelledby="btn-editar-evento" aria-describedby="btn-editar-evento-descricao"> </span>
                        <span class="sr-only" id="btn-editar-evento-descricao"> Editar evento. </span>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div> <!-- row -->

          <!-- ========== MODAL PARA CRIAR UM NOVO EVENTO ========== -->

          <form class="modal fade" tabindex="-1" id="janela-criar-evento">
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
                    <input type="text" class="form-control text-size-responsive" id="titulo" placeholder="Digite o nome do evento">
                  </div>
                </div> <!-- modal-body -->

                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal"> Cancelar </button>
                  <button type="submit" class="btn btn-success"> Adicionar </button>
                </div>
              </div> <!-- modal-content -->
            </div> <!-- modal-dialog -->
          </form>

          <!-- ========== MODAL PARA EXCLUIR EVENTOS ========== -->

          <form class="modal fade" tabindex="-1" id="janela-excluir-evento"> <!-- Modal para adicionar novo evento -->
            <div class="modal-dialog modal-sm modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title"> Excluir Evento </h3>

                  <button type="button" class="close" data-dismiss="modal" title="Fechar">
                    <span aria-hidden="true"> &times; </span>
                  </button>
                </div>

                <div class="modal-body">
                  <p> Tem certeza que deseja excluir o evento selecionado? </p>
                </div> <!-- modal-body -->

                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal"> Cancelar </button>
                  <button type="submit" class="btn btn-danger"> Excluir </button>
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