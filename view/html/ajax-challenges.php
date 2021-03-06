<?php
	require_once dirname(__FILE__).'/layout.php';

	header('Content-Type: text/html; charset=utf8');

	$aData 			= View::data();
	$aUser 			= $aData['user'];
	$aIsProfessor 	= $aData['isProfessor'];
	$aChallenges	= $aData['challenges'];
	$aType			= $aData['type'];
	$aMaxPages 		= $aData['maxPages'];
	$aPageSize 		= $aData['pageSize'];
	$aPage 			= $aData['page'];

	if (count($aChallenges) == 0) {
		echo '<p style="padding: 15px;">'.($aType == 'actives' ? 'Não existem desafios ativos no momento.' : 'Você não resolveu desafios até agora.').'</p>';

	} else {
		echo '<table class="table table-hover">';
			echo '<tbody>';
				foreach($aChallenges as $aIdChallenge => $aRow) {
					echo '<tr>';
						echo '<td style="width: 4%; text-align: center;">';
							echo '<i class = "fa fa-'.($aType == 'actives' ? 'book' : 'circle').'" > </i>';
							echo layoutCreateChallengeLevelBadge($aRow['level']);
						echo '</td>';
						echo '<td>';
							echo '<strong><a href="code.php?challenge='.$aIdChallenge.'">'.$aRow['name'].'</a></strong>';

							if($aIsProfessor) {
								echo ' <a href="challenges-manager.php?id='.$aIdChallenge.'" title="Editar desafio"><span class="fa fa-edit"></span></a>';
							}

							$aPos = strpos($aRow['description'], '.');
							$aPos = $aPos === false ? strlen($aRow['description']) : $aPos + 1;

							echo '<p>'.MarkdownExtended(substr($aRow['description'], 0, $aPos)).'</p>';
						echo '</td>';
					echo '</tr>';
				}
			echo '</tbody>';
		echo '</table>';

		$aBlock = $aType == 'actives' ? 'active-challenges' : 'answered-challenges';

		// Pagination
		if ($aMaxPages > 1) {
			echo '<div class="pagination-block">';
				echo '<ul class="pagination">';
					if($aPage > 0) {
						echo '<li><a href="javascript:void(0);" onclick="CODEBOT.page.challenges.load(\''.$aBlock.'\', {type: \''.$aType.'\', page: '.($aPage - 1).'});">Anterior</a></li>';
					}
					for ($i = 0; $i < $aMaxPages; $i++ ) {
						echo '<li class="'.($aPage == $i ? 'active' : '').'"><a href="javascript:void(0);" onclick="CODEBOT.page.challenges.load(\''.$aBlock.'\', {type: \''.$aType.'\', page: '.$i.'});">'.($i + 1).'</a></li>';
					}
					if($aPage < $aMaxPages - 1) {
						echo '<li><a href="javascript:void(0);" onclick="CODEBOT.page.challenges.load(\''.$aBlock.'\', {type: \''.$aType.'\', page: '.($aPage + 1).'});">Próxima</a></li>';
					}
				echo '</ul>';
			echo '</div>';
		}
	}
?>
