<?php 
	require_once dirname(__FILE__).'/inc/globals.php';

	layoutHeader('Inicial');
	
	$aChallengeId 	= $_GET['challenge'];
	$aChallenge 	= null;
	$aUserInfo		= userGetById($_SESSION['user']['id']);
	
	if (challengeCanBeViewed($aChallengeId, $aUserInfo)) {
		$aChallenge = challengeGetById($aChallengeId);
		$aProgram 	= codeGetProgramByUser($aUserInfo['id'], $aChallengeId);

		if ($aProgram == null) {
			$aProgram = codeCreate($aUserInfo['id'], $aChallengeId);
		}
	}
	
	if ($aChallenge == null) {
		echo '<div class="row">';
			echo '<div class="span12">';
				echo '<p>O desafio informado não existe ou você não possui acesso a ele.</p>';
			echo '</div>';
		echo '</div>';
	} else {
		echo '<div class="row">';
			echo '<div class="span12">';
				echo '<h1>'.$aChallenge['name'].'</h1>';
				echo '<p>'.$aChallenge['description'].'</p>';
			echo '</div>';
			
			echo '<div class="span12">';
				echo '<form action="code.php" method="post" name="formCode" id="formCode">';
					echo '<input type="hidden" name="action" value="savecode" />';
					echo '<input type="hidden" name="programId" value="'.$aProgram['id'].'" />';
					// TODO: deny edition if program has already received any grades.
					echo '<textarea name="code" id="code" style="width: 100%; height: 600px;">'.$aProgram['code'].'</textarea>';
				echo '</form>'; 
			echo '</div>';
			
			if ($aProgram != null) {
				echo '<div class="span12">';
					echo 'Resposta: <br/>';
					var_dump($aProgram);
				echo '</div>';
			}
		echo '</div>';
		
		if($aProgram['grade'] < 0) {
			echo '<script type="text/javascript">CODEBOT.initAutoSave();</script>';
		}
	}
	
	layoutFooter();
?>