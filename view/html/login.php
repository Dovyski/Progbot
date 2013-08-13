<?php 
	require_once dirname(__FILE__).'/layout.php';
	
	layoutHeader('Login', View::baseUrl());
	
	$aData = View::data();
	
	echo '<div class="hero-unit fundo-icone icone-password">';
		echo '<h1>Login</h1>';
		echo '<p>Você precisa efetuar login para continuar.</p>';
	echo '</div>';
	
	echo '<div class="row">';
		echo '<div class="span12">';
			echo '<form class="form-horizontal" action="login.php" method="post">
			        <fieldset>
			          <legend>Informações de login</legend>
			          <div class="control-group '.($aData['loginError'] ? 'error' : '').'">
			            <label class="control-label">CPF</label>
			            <div class="controls docs-input-sizes">
			              <input name="user" class="span3" type="text" placeholder="Informe seu CPF">
			            </div>
			            <label class="control-label">Senha do Moodle</label>
			            <div class="controls docs-input-sizes">
			              <input name="password" class="span3" type="password" placeholder="Sua senha usada no Moodle">
						  '.($aData['loginError'] ? '<span class="help-inline">Usuário ou password inválidos.</span>' : '').'
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
	
	layoutFooter(View::baseUrl());
?>