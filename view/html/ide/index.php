<?php 
	require_once dirname(__FILE__).'/functions.php';

	$aBaseURL = View::baseUrl() . '/ide';
	
	layoutHeader('IDE', $aBaseURL);
	layoutToolbar();
	
	$aData		  = View::data();
	$aChallengeId = $aData['challengeId'];	
	$aChallenge   = $aData['challenge'];
	$aUserInfo	  = $aData['user'];
	$aProgram	  = $aData['program'];
	
	if($aProgram['grade'] >= 0) { 
		echo '<div class="alert alert-warning"><strong>Atenção!</strong> Você não pode mais alterar o código porque ele já recebeu uma nota.</div>';
	}
		
	echo '<form action="code.php" method="post" name="formCode" id="formCode">';
		echo '<input type="hidden" name="action" value="savecode" />';
		echo '<input type="hidden" name="programId" value="'.$aProgram['id'].'" />';
		echo '<textarea name="code" id="code" style="width: 100%; height: 100%;">'.$aProgram['code'].'</textarea>';
	echo '</form>'; 
		
	echo '
	<script>
	  var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
		lineNumbers: true,
		matchBrackets: true,
		mode: "text/x-csrc",
		electricChars : false,
		readOnly: '.($aProgram['grade'] < 0 ? 'false' : 'true').',
		onKeyEvent: IDE.onCodingKeyEvent
	  });
	</script>';
	
	layoutFooter($aBaseURL);
?>