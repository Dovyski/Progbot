<?php 
	require_once dirname(__FILE__).'/inc/globals.php';
	
	// TODO: allow authenticated users and professors only
	layoutHeader('Start');
	
	$aChallengeId = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

	if (isset($_POST['hasValue'])) {
		// TODO: check for privileges to create or update challenge
		$aOk = challengeCreateOrUpdate($aChallengeId, $_POST);
		if ($aOk) {
			echo 'Desafio alterado com sucesso!';
		} else {
			echo 'Alguma coisa errada!';
		}
	}
	
	$aChallengeInfo = challengeGetById($aChallengeId);
	
	echo '<div class="hero-unit">';
		echo '<h1>Gerenciador de Desafios</h1>';
		echo '<p>Adicionar e editar desafios.</p>';
	echo '</div>';
	
	echo '<div class="row">';
		echo '<div class="span12">';
				echo '<h1>Desafio</h1>';
				echo '<form action="challenges-manager.php" method="post" name="formChallenges" id="formChallenges">';
					echo '<input type="hidden" name="hasValue" value="1" />';
					echo '<input type="hidden" name="id" value="'.$aChallengeId.'" />';
					echo 'Name: <input type="text" name="name" value="'.@$aChallengeInfo['name'].'" /><br/>';
					echo 'Level: <input type="text" name="level" value="'.@$aChallengeInfo['level'].'" /><br/>';
					echo 'Grupo: <input type="text" name="fk_group" value="'.@$aChallengeInfo['fk_group'].'" /><br/>'; // TODO: add dropdown
					echo 'Categoria: <input type="text" name="fk_category" value="0" /><br/>'; // TODO: add dropdown
					echo 'Descrição: <br/><textarea name="description" id="description" style="width: 100%; height: 80px;">'.@$aChallengeInfo['description'].'</textarea>';
					echo '<input type="submit" name="submit" value="Enviar" />';
				echo '</form>';
			echo '</div>';
	echo '</div>';
	
	layoutFooter();
?>