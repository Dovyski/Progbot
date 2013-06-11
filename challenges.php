<?php 
	require_once dirname(__FILE__).'/inc/globals.php';
	
	// TODO: allow authenticated users only
	layoutHeader('Start');
	
	echo '<div class="hero-unit">';
		echo '<h1>Desafios</h1>';
		echo '<p>Lista de desafios que podem ser resolvidos.</p>';
	echo '</div>';
	
	
	// Active challenges
	$aChallenges = challengeFindActivesByUser($_SESSION['user']['id']);
	
	echo '<div class="row">';
		echo '<div class="span12">';
				echo '<h1>Desafios ativos</h1>';
			echo '</div>';
	echo '</div>';
	
	if (count($aChallenges) == 0) {
		echo '<div class="row">';
			echo '<div class="span12">';
					echo '<p>Não há desafios ativos para você no momento</p>';
				echo '</div>';
		echo '</div>';
	} else {
		foreach($aChallenges as $aIdChallenge => $aRow) {
			echo '<div class="row">';
				echo '<div class="span12">';
						echo '<h2><a href="code.php?challenge='.$aIdChallenge.'" target="_blank">'.$aRow['name'].'</a> <span class="label label-warning">Nível '.$aRow['level'].'</span></h2>';
						echo '<p>'.$aRow['description'].'</p>';
					echo '</div>';
			echo '</div>';
		}
	}
	
	// Answered challenges
	echo '<div class="row">';
		echo '<div class="span12">';
				echo '<h1>Desafios já respondidos</h1>';
			echo '</div>';
	echo '</div>';
	
	$aAnswered = challengeFindAnsweredByUser($_SESSION['user']['id']);
	
	if (count($aAnswered) == 0) {
		echo '<div class="row">';
			echo '<div class="span12">';
					echo '<p>Você ainda não resolveu desafios.</p>';
				echo '</div>';
		echo '</div>';
	} else {
		foreach($aAnswered as $aIdChallenge => $aRow) {
			echo '<div class="row">';
				echo '<div class="span12">';
						echo '<h2><a href="code.php?challenge='.$aIdChallenge.'">'.$aRow['name'].'</a> <span class="label label-warning">Nível '.$aRow['level'].'</span></h2>';
						echo '<p>'.$aRow['description'].'</p>';
					echo '</div>';
			echo '</div>';
		}
	}
	
	layoutFooter();
?>