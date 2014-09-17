<?php 
	require_once dirname(__FILE__).'/layout.php';
	
	layoutHeader('Login', View::baseUrl());
	
	$aData = View::data();
	
	echo '<div class="jumbotron">';
		echo '<div class="container">';
			echo '<h1>Login</h1>';
			echo '<p>Você precisa efetuar login para continuar.</p>';
		echo '</div>';
	echo '</div>';
	
	echo '<div class="container">';
		echo '<div class="row">';
			echo '<div class="col-md-12">';
				echo '<form class="form-horizontal" action="login.php" method="post" role="form">
						<div class="form-group">
						  <div class="form-group '.($aData['loginError'] ? 'error' : '').'">
							<label class="col-md-2 control-label">CPF</label>
							<div class="col-md-5">
							  <input name="user" type="text" placeholder="Informe seu CPF" class="form-control">
							</div>
						  </div>
						  <div class="form-group '.($aData['loginError'] ? 'error' : '').'">
							<label class="col-md-2 control-label">Senha do Moodle</label>
							<div class="col-md-5">
							  <input name="password" type="password" placeholder="Sua senha usada no Moodle" class="form-control">
							  '.($aData['loginError'] ? '<span class="help-inline">Usuário ou password inválidos.</span>' : '').'
							</div>
						  </div>
						  
						  <div class="form-group">
							<div class="col-md-2"></div>
							<div class="col-md-6">
							  <button type="submit" class="btn btn-success">Entrar</button>
							  <button type="reset" class="btn">Limpar</button>
							</div>
						  </div>
						</div>
					  </form>'; 
			echo '</div>';
		echo '</div>';
	echo '</div>';
	
	layoutFooter(View::baseUrl());
?>