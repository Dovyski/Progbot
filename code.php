<?php 
	require_once dirname(__FILE__).'/inc/globals.php';

	layoutHeader('Inicial');
	
	$aIsReviewing = false;
	$aChallengeId = $_GET['challenge'];	
	$aChallenge   = null;
	$aUserId	  = 0;
	
	if (isset($_GET['user'])) {
		// Someone is trying to review something specific. We must check if
		// the authenticated user has privileges to review that code.
		$aAuthedUserInfo = userGetById($_SESSION['user']['id']);
		
		if(challengeCanBeReviewedBy($aChallengeId, $aAuthedUserInfo)) {
			$aIsReviewing 	= true;
			$aUserId 		= $_GET['user'];
		}
	} else {
		// The page is being access by the answer owner, which is the 
		// currently authenticated user.
		$aUserId = $_SESSION['user']['id'];
	}

	$aUserInfo	= userGetById($aUserId);
	
	if ($aIsReviewing || challengeCanBeViewedBy($aChallengeId, $aUserInfo)) {
		$aChallenge = challengeGetById($aChallengeId);
		$aProgram 	= codeGetProgramByUser($aUserInfo['id'], $aChallengeId);

		if ($aProgram == null && !$aIsReviewing) {
			$aProgram = codeCreate($aUserInfo['id'], $aChallengeId);
		}
	}
	
	if($aIsReviewing) {
		echo '<div class="row">';
			echo '<div class="span12">';
				echo '<p>REVISANDO CÓDIGO!</p>';
			echo '</div>';
		echo '</div>';
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
			
			if ($aProgram != null) {
				echo '<div class="span12">';
					echo 'Resposta (by '.$aProgram['fk_user'].'): <br/>';
				echo '</div>';
				
				echo '<div class="span12">';
					echo '<form action="code.php" method="post" name="formCode" id="formCode">';
						echo '<input type="hidden" name="action" value="savecode" />';
						echo '<input type="hidden" name="programId" value="'.$aProgram['id'].'" />';
						// TODO: deny edition if program has already received any grades.
						echo '<textarea name="code" id="code" style="width: 100%; height: 600px;">'.$aProgram['code'].'</textarea>';
					echo '</form>'; 
				echo '</div>';
			} else {
				echo '<div class="span12">';
					echo 'Não foi possível obter informações sobre a resposta<br/>';
				echo '</div>';
			}
		echo '</div>';
		
		if($aProgram['grade'] < 0 && !$aIsReviewing) {
			echo '<script type="text/javascript">CODEBOT.initAutoSave();</script>';
		}
	}
	
	layoutFooter();
?>