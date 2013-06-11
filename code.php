<?php 
	require_once dirname(__FILE__).'/inc/globals.php';

	layoutHeader('Inicial');
	
	$aChallengeId 	= isset($_GET['challenge']) ? (int)$_GET['challenge'] : 0;
	$aChallenge 	= challengeGetById($aChallengeId);
	
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
		echo '</div>';
	}
	
	layoutFooter();
?>