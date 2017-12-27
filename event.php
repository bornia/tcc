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
    <title> WIP | Gastos </title>
    
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!-- makes browsers render all elements more consistently and in line with modern standards -->
    <link href="style/normalize.css" rel="stylesheet" type="text/css">
    <link href="style/event.css" rel="stylesheet" type="text/css">
    <link href="style/navbar.css" rel="stylesheet" type="text/css">
    

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  	<header role="banner">
      <?php require("navbar-in.html"); ?> 
    </header>

    <div class="main container">
      <section id="gastos">
        <div class="container-wip">
          <div class="row">
            <div class="col-md-11">
              <h1> Gastos </h1>
            </div>

            <div class="col-md-1 text-right">
              <a href=""> Voltar </a>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3 col-md-offset-7 form-group"> <!-- ordena eventos -->
              <div class="row">
                <div class="col-md-3 col-xs-2">
                  <label for="ordem"> Ordem: </label>
                </div>

                <div class="col-md-9 col-xs-8">
                  <select class="form-control" arial-label="Ordenar eventos de acordo com o critério selecionado." id="ordem">
                    <option value="" selected> Data de Pagamento </option>
                    <option value=""> Título </option>
                    <option value=""> Valor </option>
                  </select>
                </div>
              </div>
            </div>

            <div class="col-md-2 text-right"> <!-- adicionar eventos -->
              <button type="button" class="form-control btn btn-success btn-crud" data-toggle="modal" data-target="#janela-adicionar-evento" title="Adicionar novo gasto">
                <span class="glyphicon glyphicon-plus"> </span>
              </button>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 table-responsive">
              <table class="table table-stripped table-hover" summary="">
                <caption class="sr-only">
                  Título da Tabela
                </caption>

                <thead>
                  <tr>
                    <th aria-label="Marque para excluir um ou mais itens">
                      <input type="checkbox" value="todo-item-selecionado" onclick="return toggle_all_checkboxes(this);">
                    </th>
                    <th> Descrição </th>
                    <th> Categoria </th>
                    <th> Data de <br> Pagamento </th>
                    <th> Valor </th>
                    <th> Opções </th>
                  </tr>
                </thead>

                <tbody>
                  <tr>
                    <td>
                      <input aria-label="Marque o item" type="checkbox" name="item" value="item-selecionado-1" onchange="return verify_checkbox_status(this);">
                    </td>
                    <td class="change-cursor adjust-width" onclick="return redirect_page();"> REP </td>
                    <td class="change-cursor adjust-width" onclick="return redirect_page();"> Comida </td>
                    <td class="change-cursor adjust-width" onclick="return redirect_page();"> 27/10/2017 </td>
                    <td class="change-cursor adjust-width" onclick="return redirect_page();"> R$ 32,34 </td>
                    <td>
                      <button type="button" class="btn btn-warning btn-crud" title="Editar gasto">
                        <span class="glyphicon glyphicon-pencil"> </span>
                      </button>

                      <button type="button" class="btn btn-danger btn-crud" title="Excluir gasto" data-toggle="modal" data-target="#janela-excluir-gasto">
                        <span class="glyphicon glyphicon-remove"> </span>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div> <!-- col table-responsive -->

            <form class="modal fade" id="janela-excluir-gasto"> <!-- Modal para adicionar novo evento -->
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" title="Fechar">
                      <span> &times; </span>
                    </button>
                    <h3 class="modal-title"> Excluir Gasto </h3>
                  </div>

                  <div class="modal-body">
                    <p> Tem certeza que deseja excluir o gasto selecionado? </p>
                  </div> <!-- modal-body -->

                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"> Cancelar </button>
                    <button type="submit" class="btn btn-danger"> Excluir </button>
                  </div>
                </div> <!-- modal-content -->
              </div> <!-- modal-dialog -->
            </form>

          </div> <!-- row -->
        </div>
      </section>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>