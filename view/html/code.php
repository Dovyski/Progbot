<?php 
	require_once dirname(__FILE__).'/layout.php';

	layoutHeader('Resolução de desafio', View::baseUrl());
	
	$aData		  = View::data();
	$aIsReviewing = $aData['isReviewing'];
	$aChallengeId = $aData['challengeId'];	
	$aChallenge   = $aData['challenge'];
	$aUserInfo	  = $aData['user'];
	$aProgram	  = $aData['program'];
	
	if ($aChallenge == null) {
		echo '<div class="row">';
			echo '<div class="span12">';
				echo '<p>O desafio informado não existe ou você não possui acesso a ele.</p>';
			echo '</div>';
		echo '</div>';
	} else {
	
		echo '<div class="row">';
			echo '<div class="span7">';
				echo '<h2>'.$aChallenge['name'].'</h2><br/>';
			echo '</div>';
			echo '<div class="span3">';
				layoutPrintUser($aUserInfo['id'], $aUserInfo);
			echo '</div>';
			echo '<div class="span2">';
				if ($aProgram != null) {
					echo '<div class="grade-info">';
						echo ($aIsReviewing ? '<a href="#" id="changeGradeLink" title="Clique para editar a nota">' : '').'<strong>'.($aProgram['grade'] < 0 ? '?' : $aProgram['grade']).'</strong>' . ($aIsReviewing ? '<i class="icon-edit"></i></a>' : '');
						echo '<div id="changeGradePanel" style="display:none;">';
							echo '<form action="" method="post" name="formChangeGrade" id="formChangeGrade">';
								echo '<input type="hidden" name="action" value="changegrade" />';
								echo '<input type="hidden" name="programId" value="'.$aProgram['id'].'" />';
								echo '<input type="text" name="grade" value="'.($aProgram['grade'] < 0 ? '' : $aProgram['grade']).'" class="span1" placeholder="" />';
								echo '<input type="submit" name="submit" value="Ok" class="btn btn-primary" />';
							echo '</form>';
						echo '</div>';
						echo '<div class="grade-info-title">Nota</div>';
					echo '</div>';
				}
			echo '</div>';
		echo '</div>';
		
		echo '<div class="tabbable">';
			echo '<ul class="nav nav-tabs">';
				echo '<li class="active"><a href="#tab-code-ide" data-toggle="tab" class="codeTab">Código</a></li>';
				echo '<li><a href="#tab-code-test" data-toggle="tab" class="codeTab">Testar</a></li>';
				echo '<li><a href="#tab-code-desc" data-toggle="tab" class="codeTab">Descrição</a></li>';
			echo '</ul>';
			echo '<div class="tab-content code-tab">';
				echo '<div class="tab-pane active" id="tab-code-ide">';
					if($aProgram['grade'] >= 0) {
						echo '<div class="alert alert-error"><strong>Atenção!</strong> Você não pode mais alterar o código porque ele já recebeu uma nota.</div>';
					}
					
					if ($aProgram != null) {
						echo '<div>';
							echo '<form action="code.php" method="post" name="formCode" id="formCode">';
								echo '<input type="hidden" name="action" value="savecode" />';
								echo '<input type="hidden" name="programId" value="'.$aProgram['id'].'" />';
								echo '<textarea name="code" id="code" style="width: 100%; height: 600px;">'.$aProgram['code'].'</textarea>';
							echo '</form>'; 
						echo '</div>';
						
					} else {
						echo '<div class="span12">';
							echo 'Não foi possível obter informações sobre a resposta<br/>';
						echo '</div>';
					}
				echo '</div>';
				echo '<div class="tab-pane" id="tab-code-test">';
					echo '<div id="build-info" class="alert alert-info"><strong>Atenção!</strong> Você não pode mais alterar o código porque ele já recebeu uma nota.</div>';
					echo '<iframe src="'.TESTING_TTY_URL.'" class="terminal-frame" seamless="seamless"></iframe>';
				echo '</div>';
				echo '<div class="tab-pane" id="tab-code-desc">';
					echo '<p>'.MarkdownExtended($aChallenge['description']).'</p>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
		echo '<script type="text/javascript">CODEBOT.initCodeTabs();</script>';
		
		$aReviews = $aData['reviews'];

		echo '<h4><i class="icon-zoom-in"></i> Revisões<a href="#" id="revisions"></a></h4>';
		
		if (count($aReviews) > 0) {
			foreach($aReviews as $aReview) {
				echo '<div class="bloco-desafios">';
					echo '<div class="row">';
						echo '<div class="span11">';
							echo MarkdownExtended($aReview['comment']);
						echo '</div>';
					echo '</div>';
					echo '<div class="row" style="margin-top: 20px;">';
						echo '<div class="span3 offset8">';
							layoutPrintUser($aReview['fk_user']);
						echo '</div>';
					echo '</div>';
				echo '</div>';
			}
		} else {
			echo '<div class="row">';
				echo '<div class="span12">';	
					echo 'Nenhuma revisão foi feita ainda.';
				echo '</div>';
			echo '</div>';
		}

		// Code review
		if ($aIsReviewing && $aProgram != null) {
			echo '<div class="row">';
				echo '<div class="span12">';
					echo '<form action="ajax-code.php" method="post" name="formReview" id="formReview">';
						echo '<input type="hidden" name="action" value="writereview" />';
						echo '<input type="hidden" name="id" value="" />';
						echo '<input type="hidden" name="programId" value="'.$aProgram['id'].'" />';
						layoutPrintMarkdownTextarea('comment', '');
						echo ' <input type="submit" name="submit" value="Salvar" class="btn btn-primary" />';
					echo '</form>';
				echo '</div>';
			echo '</div>';
		}
		
		$aShouldAutoSave = $aProgram['grade'] < 0 && !$aIsReviewing;
		echo '<script type="text/javascript">CODEBOT.initCodePage('.($aShouldAutoSave ? 'true' : 'false').');</script>';
		
		$aBaseUrl = View::baseUrl();
		
		// Codemirror stuff
		echo '<style>@import url("'.$aBaseUrl.'/js/codemirror/lib/codemirror.css");</style>';
		echo '<script src="'.$aBaseUrl.'/js/codemirror/lib/codemirror.js"></script>';
		echo '<script src="'.$aBaseUrl.'/js/codemirror/addon/edit/matchbrackets.js"></script>';
		echo '<script src="'.$aBaseUrl.'/js/codemirror/mode/clike/clike.js"></script>';
			
		echo '
		<script>
		  var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
			lineNumbers: true,
			matchBrackets: true,
			mode: "text/x-csrc",
			electricChars : false,
			readOnly: '.($aProgram['grade'] < 0 ? 'false' : 'true').',
			onKeyEvent: CODEBOT.onCodingKeyEvent
		  });
		</script>';
	}
	
	layoutFooter(View::baseUrl());
?>