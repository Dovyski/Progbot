<?php 
	require_once dirname(__FILE__).'/inc/globals.php';

	layoutHeader('Inicial');
	
	$aChallenge = challengeGetById($_GET['challenge']);
	$aAnswer	= challengeGetAnswerByUser($_GET['challenge'], $_SESSION['user']['id']);

	if ($aChallenge == null) {
		echo '<div class="row">';
			echo '<div class="span12">';
				echo '<p>O desafio informado não existe.</p>';
			echo '</div>';
		echo '</div>';
	} else {
		echo '<div class="row">';
			echo '<div class="span12">';
				echo '<h1>'.$aChallenge['name'].'</h1>';
				echo '<p>'.$aChallenge['description'].'</p>';
			echo '</div>';
			
			if ($aAnswer != null) {
				echo '<div class="span12">';
					echo 'Resposta: <br/>';
					var_dump($aAnswer);
				echo '</div>';
			}
		echo '</div>';
	}
	
	layoutFooter();
?>