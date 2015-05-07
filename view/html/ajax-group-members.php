<?php
	require_once dirname(__FILE__).'/layout.php';

	header('Content-Type: text/html; charset=utf8');

	$aData 			= View::data();
	$aMembers		= $aData['members'];
	$aGroup			= $aData['group'];
	$aIsProfessor	= $aData['isProfessor'];

	if (count($aMembers) == 0) {
		echo '<p style="padding: 15px;">Não há membros nesse grupo ainda.</p>';

	} else {
		echo '<table class="table table-hover">';
			echo '<tbody>';
				foreach($aMembers as $aUserId => $aUser) {
					echo '<tr>';
						echo '<td style="width: 4%; text-align: center;">';
							echo '<i class="fa fa-user"></i>';
						echo '</td>';
						echo '<td style="width: 90%;">';
							echo $aUser['name'];
						echo '</td>';
						echo '<td>';
							if($aIsProfessor) {
								echo '<a href="javascript:void(0);" onclick="CODEBOT.changeGroupMember(\'group-members\', '.$aGroup['id'].', '.$aUserId.', \'remove\')" title="Remover usuario do grupo"><i class="fa fa-remove"></i></a>';
							}
						echo '</td>';
					echo '</tr>';
				}
			echo '</tbody>';
		echo '</table>';
	}
?>
