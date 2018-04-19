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
    <link href="style/configuracoes.css" rel="stylesheet" type="text/css">

    <title> Configurações • OurBills </title>

    <style type="text/css">
      .fonte-tamanho-notificacoes {
        font-size: 0.85em;
      }
    </style>
  </head>

  <body>
    <header role="banner">
      <?php require("navbar-in.php"); ?> 
    </header>
   
    <div class="main container" role="main">
      <section id="configuracoes-pessoais" class="container-wip">
        <div class="row"> 
          <h1> Configurações </h1>
        </div>

        <form method="" action="">
          <div class="row">
            <!-- 
            <div class="col-md-2">
              <div class="row">
                <div class="col-md-12" align="center">           
                  <img id="foto-perfil" src="img/no-profile-picture.jpg" class="img-responsive img-rounded" style="width: 10em; height: 10em;" alt="Foto de perfil">
                  <input id="btn-foto-perfil" type="file" class="btn btn-link pull-right" accept="image/png, image/jpeg"> Editar Foto </input>
                </div>
              </div> 
            </div>
             -->

            <div class="col-md-5">
              <div class="row">
                <div class="panel">
                  <h4> Dados Primários </h4>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="nome" class="font-weight-bold"> Nome </label>
                    <input id="nome" type="text" name="nome" class="form-control" value="<?= $nome = 'Maria Paula Oliveira' ?>" required>
                  </div>
                </div>
              </div> <!-- Nome -->

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="email" class="font-weight-bold"> E-mail </label>
                    <input id="email" type="email" name="email" class="form-control" value="<?= $email = 'maria@gmail.com' ?>" autocomplete="off" required>
                  </div>
                </div>
              </div> <!-- E-mail -->

              <div class="row">      
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="pais_moeda" class="font-weight-bold"> País e Moeda </label>
                    <?php require('paises_moedas.html'); ?>
                  </div>
                </div>
              </div> <!-- Moeda -->

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="senha" class="font-weight-bold"> Senha </label>
                    <a class="btn btn-link btn-sm float-right" href="#" role="button"> Editar </a>
                    <input id="senha" type="password" name="senha" class="form-control" value="<?= $senha = '123456789' ?>" readonly>
                  </div>
                </div>
              </div> <!-- Senha -->
            </div> <!-- Dados primários -->

            <div class="col-md-5 offset-md-2">
              <div class="row">
                <div class="panel">
                  <h4> Dados Secundários </h4>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="celular" class="font-weight-bold"> Celular </label>
                    <input id="celular" type="tel" name="celular" class="form-inline form-control" placeholder="DD+número" pattern="[0-9]{11}" title=" ** Não insira espaços, letras e caracteres especiais. &#013; ** O número de celular deve conter 11 dígitos. **" data-toggle="tooltip" data-placement="bottom">
                  </div>
                </div> <!-- Celular -->

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nascimento" class="font-weight-bold"> Nascimento </label>
                    <input id="nascimento" type="date" name="nascimento" class="form-control" max="2018-01-01">
                  </div>
                </div>
              </div> <!-- Celular e data de nascimento -->

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="estado" class="font-weight-bold"> Estado </label>
                    <select id="estado" name="estado" class="form-control">
                      <option value="saopaulo"> São Paulo </option>
                    </select>
                  </div>
                </div>
              </div> <!-- Estado -->

              <div class="row">
                <div class="panel">
                  <h4> Notificações <small class="text-muted"> Receber notificões quando: </small> </h4>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <div class="row">
                      <div class="col">
                        <label>
                          <input type="checkbox" name="notificacoes" value="grupo_criado_modificado">
                          <span class="fonte-tamanho-notificacoes"> Um <u>grupo</u> for criado/modificado. </span>
                        </label>
                      </div>

                      <div class="col-1">
                        <button type="button" class="btn btn-link btn-sm float-right" data-toggle="tooltip" data-placement="left" title="O usuário será notificado quando um grupo, no qual ele foi incluído, for criado, excluído ou sofrer qualquer tipo de modificação.">
                          <small>
                            <span class="oi oi-info align-top" aria-label="Mais informações."></span>
                          </small>
                        </button>
                      </div>
                    </div>
                  
                    <div class="row">
                      <div class="col">
                        <label>
                          <input type="checkbox" name="notificacoes" value="evento_incluido_alterado">
                          <span class="fonte-tamanho-notificacoes"> Um <u>evento</u> for incluído/alterado. </span>
                        </label>
                      </div>

                      <div class="col-1">
                        <button type="button" class="btn btn-link btn-sm float-right" data-toggle="tooltip" data-placement="left" title="O usuário será notificado quando um evento, no qual ele foi incluído, for adicionado, excluído ou sofrer qualquer tipo de alteração.">
                          <small>
                            <span class="oi oi-info align-top" aria-label="Mais informações."></span>
                          </small>
                        </button>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col">
                        <label>
                          <input type="checkbox" name="notificacoes" value="conta_expirar">
                          <span class="fonte-tamanho-notificacoes"> Faltar 2 dias para uma conta expirar. </span>
                        </label>
                      </div>

                      <div class="col-1">
                        <button type="button" class="btn btn-link btn-sm float-right" data-toggle="tooltip" data-placement="left" title="O usuário será notificado 2 dias antes de uma conta, na qual ele foi incluído, atingir sua data de pagamento.">
                          <small>
                            <span class="oi oi-info align-top" aria-label="Mais informações."></span>
                          </small>
                        </button>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col">
                        <label>
                          <input type="checkbox" name="notificacoes" value="novas_funcionalidades">
                          <span class="fonte-tamanho-notificacoes"> Surgirem novas funcionalidades. </span>
                        </label>
                      </div>

                      <div class="col-1">
                        <button type="button" class="btn btn-link btn-sm float-right" data-toggle="tooltip" data-placement="left" title="O usuário será notificado quando novas funcionalidades ficarem disponíveis.">
                          <small>
                            <span class="oi oi-info align-top" aria-label="Mais informações."></span>
                          </small>
                        </button>
                      </div>
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

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- Personal -->
    <!--  -->
    <script type="text/javascript" src="js/configuracoes.js"> </script>
  </body>
</html>