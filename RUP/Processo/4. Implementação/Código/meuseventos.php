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
    <title> WIP | Meus Eventos </title>
    
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!-- makes browsers render all elements more consistently and in line with modern standards. -->
    <link href="style/normalize.css"    rel="stylesheet" type="text/css">
    <link href="style/navbar.css"       rel="stylesheet" type="text/css">
    <link href="style/myevents.css"     rel="stylesheet" type="text/css">
    <!-- <link href="style/inner-addon.css"  rel="stylesheet" type="text/css"> -->
    

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Substitui/adiciona algumas formatações do bootstrap -->
    <style type="text/css" rel="stylesheet">
      #img-financial-summary {
        padding-left: 3%;
      }

      .modal-title {
        color: #F9775F;
      }

      #submenu-user-options {
        margin-top: 0.3em;
      }
    </style>
  </head>
  <body>
  	<header role="banner">
      <?php require("navbar-in.html"); ?> 
    </header>
   
   	<div class="main container" role="main">
      <section id="resumo-financeiro">
        <div class="container-wip">
        	<div class="row">
      			<div class="col-md-12">
      				<h1> Resumo </h1>
      			</div>
        	</div> <!-- row -->

        	<div class="row" id="financial-summary-format">
        		<div class="col-md-3" id="img-financial-summary"> 
        			<img src="img/no-profile-picture.jpg" class="img-responsive" id="profile-picture" alt="Profile Picture">
        		</div> <!-- Foto de perfil -->

        		<div class="col-md-4">
      				<p class="financial-summary-glyphicon" id="glyphicon-import-color">
      					<span class="glyphicon glyphicon-import"> </span>
      				</p>

      				<p class="financial-summary-status">
      					Você tem de receber <span id="value-to-receive"> R$ 00,00 reais</span>.
      				</p>
        		</div> <!-- A receber -->

        		<div class="col-md-5">
      				<p class="financial-summary-glyphicon" id="glyphicon-export-color">
      					<span class="glyphicon glyphicon-export"> </span>
      				</p>

      				<p class="financial-summary-status">
      					Você tem de pagar <span id="value-to-pay"> R$ 00,00 reais</span>.
      				</p>
        		</div> <!-- A pagar -->
        	</div> <!-- row financial-summary-format -->
        </div> <!-- container-wip -->
      </section> <!-- Resumo Financeiro -->

      <section id="meus-eventos">
        <div class="container-wip">
          <div class="row">
            <div class="col-md-12">
              <h1> Eventos </h1>
            </div>
          </div> <!-- row -->

          <div class="row">
            <div class="col-md-4"> <!-- busca de eventos -->
              <div class="input-group">
                <label for="search-bar" class="sr-only"> Barra de Pesquisa </label>
                <span class="input-group-addon"> <i class="glyphicon glyphicon-search"> </i> </span>
                <input id="search-bar" type="search" class="form-control" placeholder="Buscar por título de evento">
              </div>
            </div>

            <div class="col-md-3 form-group"> <!-- ordena eventos -->
              <div class="row">
                <div class="col-md-3 col-xs-2">
                  <label for="ordem"> Ordem: </label>
                </div>

                <div class="col-md-9 col-xs-8">
                  <select class="form-control" arial-label="Ordenar eventos de acordo com o critério selecionado." id="ordem">
                    <option value="titulo"> Título </option>
                    <option value="total"> Total </option>
                    <option value="modificacao" selected> Última Modificação </option>
                  </select>
                </div>
              </div>
            </div>

            <div class="col-md-3 form-group"> <!-- eventos abertos/fechados -->
              <div class="row">
                <div class="col-md-3">
                  <label for="ordem"> Status: </label>
                </div>
                
                <div class="col-md-9">
                  <select class="form-control" arial-label="Listar eventos abertos ou fechados, dependendo da opção selecionada.">
                    <option value="abertos"> Abertos </option>
                    <option value="fechados"> Fechados </option>
                  </select>
                </div>
              </div>
            </div>

            <div class="col-md-2 text-right"> <!-- adicionar eventos -->
              <button type="button" class="form-control btn btn-success btn-crud" data-toggle="modal" data-target="#janela-adicionar-evento" title="Adicionar novo evento">
                <span class="glyphicon glyphicon-plus" aria-label="Pequeno ícone simbolizando um botão de adicionar."> </span>
              </button>
                
              <form class="modal fade" id="janela-adicionar-evento"> <!-- Modal para adicionar novo evento -->
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" title="Fechar">
                        <span> &times; </span>
                      </button>
                      <h3 class="modal-title"> Novo Evento </h3>
                    </div>

                    <div class="modal-body">
                      <div class="form-group">
                        <label for="titulo"> Título do Evento: </label>
                        <input type="text" class="form-control" id="titulo" placeholder="Digite o nome do evento">
                      </div>

                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-5">
                            <label for="participantes"> Selecione os Participantes: </label>
                          </div>

                          <div class="col-md-7">
                            <div class="form-group">
                              <label class="sr-only" for="buscar-email-participante">
                                Buscar E-mail do Participante:
                              </label>
                               <input type="text" placeholder="Busque pelo e-mail" class="form-control" id="buscar-email-participante">
                            </div>
                          </div>
                        </div>

                        <div id="participantes"> 
                          <div class="row item-participante">
                            <div class="col-md-2" >
                              <img src="img/no-profile-picture.jpg" class="img-responsive" id="friend-profile-picture" alt="Profile Picture" title="E-mail do usuário"> 
                            </div>

                            <div class="col-md-6" style="padding: 0.25em 0em;">
                              <span>
                                Guilherme Bornia Miranda <br>
                                guilhermeborniamiranda@gmail.com
                              </span>
                            </div>

                            <div class="col-md-4">
                              <div class="row" style="padding: 0.67em 0em;">
                                <div class="col-md-12 permissoes-container">
                                  <label class="sr-only" for="dpbox-permissoes">
                                    Defina as permissões do usuário:
                                  </label>
                                  <select class="form-control" id="dpbox-permissoes">
                                    <option name="proprietario"> É proprietário </option>
                                    <option name="visualizar"> Pode visualizar </option>
                                    <option name="editar"> Pode editar </option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div> <!-- participantes -->
                      </div>
                    </div> <!-- modal-body -->

                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal"> Cancelar </button>
                      <button type="submit" class="btn btn-success"> Adicionar </button>
                    </div>
                  </div> <!-- modal-content -->
                </div> <!-- modal-dialog -->
              </form>
            </div> <!-- col -->
          </div> <!-- row -->

          <div class="row" id="table-events">
            <div class="col-md-12 table-responsive">
              <table class="table table-stripped table-hover" summary="Lista de eventos cadastrados com indicações sobre a data da última modificação e sobre o total de gastos em relação a cada evento.">
                <caption class="sr-only">
                  Lista de Eventos
                </caption>

                <thead>
                  <tr>
                    <th>
                      <input type="checkbox" title="Selecionar todos" value="todo-item-selecionado" onclick="return toggle_all_checkboxes(this);">
                    </th>
                    <th>                  Título                              </th>
                    <th>                  Total                               </th>
                    <th>                  Última Modificação                  </th>
                    <th>                  Opções                              </th>
                  </tr>
                </thead>

                <tbody>
                  <tr>
                    <td>
                      <input aria-label="Marque o item" type="checkbox" name="item" value="item-selecionado-1" onchange="return verify_checkbox_status(this);">
                    </td>
                    <td class="change-cursor" onclick="return redirect_page();"> REP - Aluguel de Julho </td>
                    <td class="change-cursor" onclick="return redirect_page();"> R$ 17.389,56 </td>
                    <td class="change-cursor" onclick="return redirect_page();"> 27/10/2017 as 15:18:35 </td>
                    <td>
                      <button type="button" class="btn btn-warning btn-crud" title="Editar evento">
                        <span class="glyphicon glyphicon-pencil"> </span>
                      </button>

                      <button type="button" class="btn btn-danger btn-crud" title="Excluir evento" data-toggle="modal" data-target="#janela-excluir-evento">
                        <span class="glyphicon glyphicon-remove"> </span>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div> <!-- row -->

          <form class="modal fade" id="janela-excluir-evento"> <!-- Modal para adicionar novo evento -->
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" title="Fechar">
                    <span> &times; </span>
                  </button>
                  <h3 class="modal-title"> Excluir Evento </h3>
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

          <div class="row">
            <div class="col-md-12">
              <p id="paginacao">
                Páginas: <span class="numero-da-pagina" aria-label="Número da página."> </span>
              </p>
            </div>
          </div>
        </div> <!-- container-wip -->
      </section> <!-- Meus Eventos -->
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <!-- Meus Eventos JavaScript -->
    <script src="js/myevents.js" type="text/javascript"> </script>
  </body>
</html>