<?php

$sessao_validada = require_once('reqs/validar_sessao.php'); // sessio_start()

if($sessao_validada) {

  // Se o id do grupo existir então empty() retorna false e o usuário não será redirecionado, pois não há erro.
  if(empty($_POST['grupo_id']) || empty($_POST['evento_id'])) {
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
    <link href="style/meusgastos.css" rel="stylesheet" type="text/css">

    <title> Gastos • OurBills </title>
  </head>

  <body>
    <header role="banner">
      <?php require("navbar-in.php"); ?> 
    </header>

    <div class="main container mt-4" role="main">

      <input type='hidden' id="info_usuario_email"  readonly value="<?= $_SESSION['email']; ?>">
      <input type="hidden" id="info_grupo_id"       readonly value="<?= $_POST['grupo_id']  ?>">
      <input type="hidden" id="info_evento_id"      readonly value="<?= $_POST['evento_id']  ?>">
      <input type="hidden" id="info_usuario_id"     readonly value="<?= $_SESSION['id']     ?>">

      <div id="alerta_mensagem"> </div>

      <section id="gastos">
        <div class="container-wip">
          <div class="row">
            <div class="col">
              <h1> Gastos </h1>
            </div>

            <div class="col text-right">
              <div class="row">
                <div class="col">
                  <button type="button" class="btn btn-lg btn-none text-muted font-weight-bold text-size-responsive" id="btn-titulo-gasto">
                
                  </button>
                </div>
              </div>

              <div class="row">
                <div class="col">
                  <form class="d-md-none font-weight-bold" action="meuseventos.php" method="POST">
                    <button type="submit" class="btn btn-link float-right" id="btn-voltar-meus-eventos1" name="grupo_id" value="<?= $_POST['grupo_id']  ?>" title="Voltar a Meus Eventos">
                      <span class="oi oi-arrow-thick-left" aria-describedby="btn-voltar-meus-eventos1"> </span>
                      <span class="sr-only" id="voltar-meus-eventos1"> Voltar a Meus Eventos </span>
                    </button>
                  </form>                

                  <form class="d-none d-md-block" action="meuseventos.php" method="POST">
                    <button type="submit" class="btn btn-link" id="btn-voltar-meus-eventos2" name="grupo_id" value="<?= $_POST['grupo_id']  ?>" title="Voltar a Meus Eventos">
                      <span class="oi oi-arrow-thick-left" aria-describedby="voltar-meus-eventos2"> </span>
                      <span id="voltar-meus-eventos2"> Voltar a Meus Eventos </span>
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12 col-md-3"> <!-- ordena eventos -->
              <div class="form-group">
                <label for="ordem" class="font-weight-bold text-muted text-size-responsive"> Ordem </label>

                <select class="form-control text-size-responsive" arial-label="Ordenar eventos de acordo com o critério selecionado." id="ordem">
                  <option value="data" selected>  Data de Pagamento </option>
                  <option value="descricao">      Descrição </option>
                  <option value="valor">          Valor </option>
                </select>
              </div>
            </div>

            <div class="col-12 col-md-2">
              <div class="form-group">
                <label for="" class="font-weight-bold text-muted text-size-responsive"> Itens por Página </label>

                <select class="form-control text-size-responsive" aria-label="Indica quantas linhas aparecerão na tabela.">
                  <option value="05"> 05 </option>
                  <option value="10"> 10 </option>
                  <option value="15"> 15 </option>
                  <option value="20"> 20 </option>
                  <option value="25"> 25 </option>
                </select>
              </div>
            </div>

            <div class="col">
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-12">
              <div class="form-group">
                <button type="button" class="btn btn-success float-right" id="btn-adicionar-gasto" title="Adicionar novo gasto" data-toggle="modal" data-target="#janela-adicionar-gasto" >
                  <span class="oi oi-plus text-white"> </span>
                </button>

                <button type="button" class="btn btn-danger float-right" id="btn-excluir-gasto" title="Excluir gasto." data-toggle="modal" data-target="#janela-excluir-gasto">
                  <span class="oi oi-trash text-white" aria-labelledby="btn-excluir-gasto"> </span>
                </button>
              </div>
            </div>            
          </div>

          <!-- ========== TABELA DE GASTOS ========== -->

            <div class="table-responsive">
              <table class="table table-sm table-stripped table-hover" summary="">
                <caption class="sr-only" id="tabela-gastos-caption">
                   
                </caption>

                <thead>
                  <tr>
                    <th class="align-middle" aria-label="Marque para excluir um ou mais itens">
                      <input type="checkbox" id="checkbox-excluir-todos-gastos" value="todo-item-selecionado" onclick="return toggle_all_checkboxes(this);">
                    </th>
                    <th class="align-middle text-center text-size-responsive"> Descrição </th>
                    <th class="align-middle text-center text-size-responsive"> Categoria </th>
                    <th class="align-middle text-center text-size-responsive"> Data de Pagamento </th>
                    <th class="align-middle text-center text-size-responsive"> Valor </th>
                    <th class="align-middle text-center text-size-responsive"> Opções </th>
                  </tr>
                </thead>

                <tbody id="tabela-gastos-corpo">

                </tbody>
              </table>
            </div> <!-- table-responsive -->

            <!-- ========== MODAL PARA ADICIONAR NOVO GASTO ========== -->

            <form class="modal fade" id="janela-adicionar-gasto" tabindex="-1" role="dialog" aria-label="Janela para adicionar um novo gasto no evento." aria-hidden="true">
              <div class="modal-dialog modal-bg modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h3 class="modal-title"> Novo Gasto </h3>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span> &times; </span>
                    </button>    
                  </div>

                  <div class="modal-body text-size-responsive">
                    <div class="container-fluid">
                      <div class="row">
                        <div class="col" id="alerta_mensagem_adicionar_gasto">
                          
                        </div>                        
                      </div>

                      <div class="row">
                        <div class="col">
                          <div class="form-group">
                            <label for="descricao-novo-gasto" class="font-weight-bold"> Descrição </label>
                            <input type="text" class="form-control text-size-responsive" id="descricao-novo-gasto" name="name-descricao-novo-gasto" aria-describedby="descricao-novo-gasto-help" maxlength="35" placeholder="Descreva o gasto">
                            <span id="descricao-novo-gasto-help" class="sr-only"> Se desejar, descreva o gasto em poucas palavras. </span>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col">
                          <div class="form-group">
                            <label for="categoria-novo-gasto" class="font-weight-bold"> Categoria </label>
                            <?php require('gastos_categorias.html'); ?>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col">
                          <div class="form-group">
                            <label for="data-pagamento-novo-gasto" class="font-weight-bold"> Data de Pagamento </label>
                            <input type="date" class="form-control text-size-responsive" id="data-pagamento-novo-gasto" name="name-data-pagamento-novo-gasto">
                          </div>
                        </div>

                        <div class="col">
                          <div class="form-group">
                            <label for="valor-novo-gasto" class="font-weight-bold"> Valor </label>
                            <input type="number" class="form-control text-size-responsive" id="valor-novo-gasto" name="name-valor-novo-gasto" value="00.00" min="0.01" step="0.01" placeholder="ex. 1000,50">
                          </div>
                        </div>
                      </div>

                      <!-- ========== LISTA DE PARTICIPANTES ========== -->

                      <div class="row">
                        <div class="col">
                          <div class="form-group">
                            <label for="buscar-email-participante" class="font-weight-bold" aria-describedby="aria-quem-dividira">
                              Participantes
                              <small class="text-muted" id="aria-quem-dividira"> Entre quem será dividido? </small>
                            </label>

                            <input type="text" class="form-control text-size-responsive" id="buscar-email-participante" placeholder="Busque pelo e-mail e dê Enter" onkeyup="return buscar_entre_participantes(this.id);" onkeypress="incluir_participante(event);">

                            <div class="row" id="caixa-pesquisa-usuarios">
                              <ul id="lista-pesquisa-usuarios">

                              </ul>
                            </div>
                          </div>

                          <div id="todos-participantes-novos">
                            
                          </div> <!-- 1 participante -->
                          
                        </div>
                      </div> <!-- participantes -->  
                    </div>
                  </div> <!-- end row -->

                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancelar </button>
                    <button type="button" class="btn btn-success" onclick="adicionar_gasto();"> Adicionar </button>
                  </div>
                </div> <!-- modal-content -->
              </div> <!-- modal-dialog -->
            </form>

            <!-- ========== MODAL PARA EXCLUIR GASTO ========== -->

          <form class="modal fade" id="janela-excluir-gasto" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title"> Excluir Gasto </h3>

                  <button type="button" class="close" data-dismiss="modal" title="Fechar">
                    <span> &times; </span>
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
                  <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancelar </button>
                  <button type="button" class="btn btn-danger" id="modal-btn-excluir-gasto" onclick="excluir_gastos();"> Excluir </button>
                </div>
              </div> <!-- modal-content -->
            </div> <!-- modal-dialog -->
          </form>
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
    <script type="text/javascript" src="js/meusgastos.js"> </script>
  </body>
</html>