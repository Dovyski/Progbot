<?php 
	require_once dirname(__FILE__).'/inc/globals.php';
	
	// TODO: allow authenticated users only and professors or TA
	layoutHeader('Reviews');

	$aChallengeId 		= isset($_GET['challenge']) ? $_GET['challenge'] : 0;
	$aUserInfo	 		= userGetById($_SESSION['user']['id']);
	
	echo '<div class="hero-unit">';
		echo '<h1>Reviews</h1>';
		echo '<p>Revisão de trabalhos.</p>';
	echo '</div>';		
	
	if ($aChallengeId != 0) {
		// Showing all answers of a challenge
		$aAnswers = challengeFindAnswersById($aChallengeId);
		
		echo '<div class="row">';
			echo '<div class="span12">';
					echo '<h1>Respostas até o momento</h1>';
				echo '</div>';
		echo '</div>';
		
		if (count($aAnswers) == 0) {
			echo '<div class="row">';
				echo '<div class="span12">';
						echo '<p>Não há respostas para esse desafio.</p>';
					echo '</div>';
			echo '</div>';
		} else {
			foreach($aAnswers as $aIdProgram => $aRow) {
				echo '<div class="row">';
					echo '<div class="span12">';
							echo '<h2><a href="code.php?challenge='.$aChallengeId.'&user='.$aRow['fk_user'].'">User_id='.$aRow['fk_user'].'</a> <span class="label label-warning">Nota '.$aRow['grade'].'</span></h2>';
						echo '</div>';
				echo '</div>';
			}
		}
		
	} else {
		// Showing all challenges of user's group
		$aChallenges = challengeFindByGroup($aUserInfo['fk_group']);
		
		echo '<div class="row">';
			echo '<div class="span12">';
					echo '<h1>Desafios do seu grupo</h1>';
				echo '</div>';
		echo '</div>';
		
		if (count($aChallenges) == 0) {
			echo '<div class="row">';
				echo '<div class="span12">';
						echo '<p>Não há desafios ativos para o seu grupo.</p>';
					echo '</div>';
			echo '</div>';
		} else {
			foreach($aChallenges as $aIdChallenge => $aRow) {
				echo '<div class="row">';
					echo '<div class="span12">';
							echo '<h2><a href="reviews.php?challenge='.$aIdChallenge.'">'.$aRow['name'].'</a> <span class="label label-warning">Nível '.$aRow['level'].'</span></h2>';
						echo '</div>';
				echo '</div>';
			}
		}
	}
	
	
	
	
	
	layoutFooter();
?>