<nav class="navbar navbar-expand-md fixed-top navbar-dark bg-inverse" id="navigation-menu" role="navigation">
	<div class="container">
		<a class="navbar-brand" href="#"> Logo/Home </a>

		<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#barra-navegacao" aria-controls="barra-navegacao" aria-expanded="false" aria-label="Abrir menu." title="Abrir menu.">
			<!-- Por questões de usabilidade, um leitor de tela não atribuiria nenhum significado aos icon-bar. Portanto, utiliza-se a linha abaixo para que o leitor de tela seja útil. -->
			<span class="navbar-toggler-icon"> </span>
		</button>

		<div class="collapse navbar-collapse justify-content-end" id="barra-navegacao">
			<ul class="navbar-nav">
				<li class="nav-item dropdown">
					<a href="#" class="nav-link dropdown-toggle" id="opcoes_de_usuario" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?= explode(" ", $_SESSION['nome'])[0] ?> <span class="caret"> </span>
					</a>

					<div class="dropdown-menu" aria-labelledby="opcoes_de_usuario">
						<a class="dropdown-item" href="meusgrupos.php">
							<div class="row">
								<div class="col-9">
									Meus Grupos
								</div>

								<div class="col-2">
									<span class="oi oi-list" aria-label="Acessar sua lista de grupos."></span>
								</div>
							</div> 
						</a>

						<a class="dropdown-item" href="configuracoes.php">
							<div class="row">
								<div class="col-9">
									Configurações
								</div>

								<div class="col-2">
									<span class="oi oi-cog align-top" aria-label="Configurar sua conta."></span>
								</div>
							</div> 
						</a>

						<div class="dropdown-divider"></div>

						<a class="dropdown-item" href="reqs/sair.php?token='<?= md5(session_id()) ?>'">
							<div class="row">
								<div class="col-9">
									Sair
								</div>

								<div class="col-2">
									<span class="oi oi-account-logout " aria-label="Sair da sua conta."></span>
								</div>
							</div> 
						</a>
					</div>
				</li>
			</ul>
		</div>
	</div> <!-- container -->
</nav> <!-- navbar-default -->