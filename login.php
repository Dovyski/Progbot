<?php 
	require_once dirname(__FILE__).'/inc/globals.php';
	
	authAllowNonAuthenticated();
	$aLoginError = false;
	
	if(count($_POST) > 0) {
		if (isset($_POST['user'], $_POST['password'])) {
			
			// TODO: fix this because the login string might have . and -
			$aCpf = str_replace(array('.', '-', ' '), '', $_POST['user']);
			$aCpf = ltrim($aCpf,  '0');
			
			$aHasAccount = authIsValidUser($aCpf, $_POST['password']);
			$aUser = '';
			
			if ($aHasAccount) {
				$aUser = $aCpf;	

			} else {
				// TODO: it would be nice to have some sort of auth plugins here :)
				$aMoodleInfo = authLoginUsingMoodle($aCpf, $_POST['password']);
				
				if ($aMoodleInfo != null) {
					$aHasAccount = authCreateLocalAccountUsingLoginMoodle($aMoodleInfo, $aCpf, $_POST['password']);
				
					if($aHasAccount) {
						$aUser = $aCpf;
					}
				} else {
					$aLoginError = true;
				}
			}
			
			if($aHasAccount) {
				authLogin($aUser);
				header('Location: challenges.php');
				exit();
			}
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
		echo '<div class="span12">';
			echo '<form class="form-horizontal" action="login.php" method="post">
			        <fieldset>
			          <legend>Informações de login</legend>
			          <div class="control-group '.($aLoginError ? 'error' : '').'">
			            <label class="control-label">CPF</label>
			            <div class="controls docs-input-sizes">
			              <input name="user" class="span3" type="text" placeholder="Informe seu CPF">
			            </div>
			            <label class="control-label">Senha do Moodle</label>
			            <div class="controls docs-input-sizes">
			              <input name="password" class="span3" type="password" placeholder="Sua senha usada no Moodle">
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