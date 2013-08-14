<?php 
	require_once dirname(__FILE__).'/layout.php';

	layoutHeader('IDE', View::baseUrl());
	
	$aData		  = View::data();
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
		if($aProgram['grade'] >= 0) { 
			echo '<div class="alert alert-warning"><strong>Atenção!</strong> Você não pode mais alterar o código porque ele já recebeu uma nota.</div>';
		}
		
		echo '<form action="code.php" method="post" name="formCode" id="formCode">';
			echo '<input type="hidden" name="action" value="savecode" />';
			echo '<input type="hidden" name="programId" value="'.$aProgram['id'].'" />';
			echo '<textarea name="code" id="code" style="width: 100%; height: 100%;">'.$aProgram['code'].'</textarea>';
		echo '</form>'; 
	
		$aBaseUrl = View::baseUrl();
		
		// Codemirror stuff
		// TODO: replace with syntax highlighter?
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