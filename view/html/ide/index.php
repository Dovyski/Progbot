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
	$aIsAssignment= $aData['isAssignment'];
	$aCanEdit	  = $aData['canEdit'];
	
	if(!$aCanEdit) { 
		echo '<div class="alert alert-warning"><strong>Atenção!</strong> Você não pode mais alterar o código '.($aIsAssignment ? 'porque o prazo de entrega desse trabalho já passou.' : 'porque ele já recebeu uma nota').'</div>';
	}
		
	echo '<form action="code.php" method="post" name="formCode" id="formCode">';
		echo '<input type="hidden" name="action" value="savecode" />';
		echo '<input type="hidden" name="programId" value="'.$aProgram['id'].'" />';
		echo '<input type="hidden" name="challenge" value="'.$aChallengeId.'" />';
		echo '<div id="ide-code">'.htmlspecialchars($aProgram['code']).'</div>';
	echo '</form>'; 
		
	echo '
	<script>
		var editor = ace.edit("ide-code");
		editor.setTheme("ace/theme/github");
		editor.getSession().setMode("ace/mode/c_cpp");
		editor.setReadOnly('.($aCanEdit ? 'false' : 'true').');
		editor.getSession().on("change", IDE.onCodingKeyEvent);
	</script>';
	
	layoutFooter($aBaseURL);
?>