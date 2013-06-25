<?php 
	require_once dirname(__FILE__).'/inc/globals.php';
	
	authAllowNonAuthenticated();
	$aLoginError = false;
	
	if(count($_POST) > 0) {
		if(isset($_POST['user'], $_POST['password']) && authIsValidUser($_POST['user'], $_POST['password'])) {
			authLogin($_POST['user']);
			
			header('Location: index.php');
			exit();
		} else {
			$aLoginError = true;
		}
	}
	
	layoutHeader('Login');
	
	echo '<div class="hero-unit fundo-icone icone-password">';
		echo '<h1>Login</h1>';
		echo '<p>Você precisa efetuar login para continuar.</p>';
	echo '</div>';
	
	echo '<div class="row">';
		echo '<div class="span9">';
			echo '<form class="form-horizontal" action="login.php" method="post">
			        <fieldset>
			          <legend>Login</legend>
			          <div class="control-group '.($aLoginError ? 'error' : '').'">
			            <label class="control-label">Usuário</label>
			            <div class="controls docs-input-sizes">
			              <input name="user" class="span3" type="text" placeholder="Seu usuário NCC">
			            </div>
			            <label class="control-label">password</label>
			            <div class="controls docs-input-sizes">
			              <input name="password" class="span3" type="password" placeholder="sua password">
						  '.($aLoginError ? '<span class="help-inline">Usuário ou password inválidos.</span>' : '').'
			            </div>
			          </div>
			          <div class="form-actions">
			            <button type="submit" class="btn btn-primary">Entrar</button>
			            <button type="reset" class="btn">Limpar</button>
			          </div>
			        </fieldset>
			      </form>'; 
		echo '</div>';
	echo '</div>';
	
	layoutFooter();
?>