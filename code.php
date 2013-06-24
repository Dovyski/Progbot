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
	
	if ($aChallenge == null) {
		echo '<div class="row">';
			echo '<div class="span12">';
				echo '<p>O desafio informado não existe ou você não possui acesso a ele.</p>';
			echo '</div>';
		echo '</div>';
	} else {
	
		echo '<div class="row">';
			echo '<div class="span12">';
				echo '<h2>'.$aChallenge['name'].'</h2><br/>';
			echo '</div>';
		echo '</div>';
		
		echo '<div class="tabbable">';
			echo '<ul class="nav nav-tabs">';
				echo '<li class="active"><a href="#tab1" data-toggle="tab">Código</a></li>';
				echo '<li><a href="#tab2" data-toggle="tab">Terminal</a></li>';
				echo '<li><a href="#tab3" data-toggle="tab">Descrição</a></li>';
			echo '</ul>';
			echo '<div class="tab-content">';
				echo '<div class="tab-pane active" id="tab1">';
					if ($aProgram != null) {
						echo '<div>';
							echo '<form action="code.php" method="post" name="formCode" id="formCode">';
								echo '<input type="hidden" name="action" value="savecode" />';
								echo '<input type="hidden" name="programId" value="'.$aProgram['id'].'" />';
								// TODO: deny edition if program has already received any grades.
								echo '<textarea name="code" id="code" style="width: 100%; height: 600px;">'.$aProgram['code'].'</textarea>';
							echo '</form>'; 
						echo '</div>';
						
						echo '<div>';
							echo 'Resposta (by '.$aProgram['fk_user'].') '.($aProgram['grade'] < 0 ? '' : '<strong>NOTA:</strong> ' . $aProgram['grade']).': <br/>';
						echo '</div>';
						
					} else {
						echo '<div class="span12">';
							echo 'Não foi possível obter informações sobre a resposta<br/>';
						echo '</div>';
					}
				echo '</div>';
				echo '<div class="tab-pane" id="tab2">';
					echo '<p>O terminal ainda não está em funcionamento. Teste seu programa offline.</p>';
				echo '</div>';
				echo '<div class="tab-pane" id="tab3">';
					echo '<p>'.$aChallenge['description'].'</p>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
		
		// Code review
		if($aIsReviewing) {
			echo '<div class="row">';
				echo '<div class="span12">';
					echo '<p>REVISANDO CÓDIGO!</p>';
					
					if ($aProgram != null) {
						echo '<form action="ajax-code.php" method="post" name="formReview" id="formReview">';
							echo '<input type="hidden" name="action" value="writereview" />';
							echo '<input type="hidden" name="programId" value="'.$aProgram['id'].'" />';
							echo '<textarea name="comment" id="comment" style="width: 100%; height: 80px;"></textarea>';
							echo '<input type="text" name="grade" value="'.$aProgram['grade'].'" />';
							echo '<input type="submit" name="submit" value="Enviar" />';
						echo '</form>';
						
						echo 'Reviews:<br/>';
						$aReviews = reviewFindByProgramId($aProgram['id']);
						var_dump($aReviews);
					}
				echo '</div>';
			echo '</div>';
		}
		
		if($aProgram['grade'] < 0 && !$aIsReviewing) {
			echo '<script type="text/javascript">CODEBOT.initAutoSave();</script>';
		}
		
		// Codemirror stuff
		echo '<style>@import url("./js/codemirror/lib/codemirror.css");</style>';
		echo '<script src="./js/codemirror/lib/codemirror.js"></script>';
		echo '<script src="./js/codemirror/addon/edit/matchbrackets.js"></script>';
		echo '<script src="./js/codemirror/mode/clike/clike.js"></script>';
			
		echo '
		<script>
		  var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
			lineNumbers: true,
			matchBrackets: true,
			mode: "text/x-csrc"
		  });
		</script>';
		
	}
	
	layoutFooter();
?>