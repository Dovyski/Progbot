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
		echo '<p>'.($aType == 'actives' ? 'Não existem desafios ativos no momento.' : 'Você não resolveu desafios até agora.').'</p>';
		
	} else {
		echo '<table class="table table-hover">';
			echo '<tbody>';
				foreach($aChallenges as $aIdChallenge => $aRow) {
					echo '<tr>';
						echo '<td style="width: 5%;"><i class="icon-list-'.($aType == 'actives' ? 'alt' : 'circle').'"></i></td>';
						echo '<td>';
							echo '<a href="code.php?challenge='.$aIdChallenge.'">'.$aRow['name'].'</a> ';
							echo '<span class="label label-warning"> '.challengeLevelToString($aRow['level']).' </span> '; // TODO: create some standart way to print challenges.
							if($aIsProfessor) {
								echo '<a href="challenges-manager.php?id='.$aIdChallenge.'" title="Editar desafio"><i class="icon-edit"></i></a>';
							}
							echo '<p>'.MarkdownExtended($aRow['description']).'</p>';
						echo '</td>';
					echo '</tr>';
				}
			echo '</tbody>';
		echo '</table>';
		
		$aBlock = $aType == 'actives' ? 'active-challenges' : 'answered-challenges';
		
		// Pagination
		if($aMaxPages > 1) {
			echo '<div class="pagination">';
				echo '<ul>';
				if($aPage > 0) {
					echo '<li><a href="javascript:void(0);" onclick="CODEBOT.loadChallenges(\''.$aBlock.'\', \''.$aType.'\', '.($aPage - 1).');">Anterior</a></li>';
				}
				for ($i = 0; $i < $aMaxPages; $i++ ) {
					echo '<li class="'.($aPage == $i ? 'active' : '').'"><a href="javascript:void(0);" onclick="CODEBOT.loadChallenges(\''.$aBlock.'\', \''.$aType.'\', '.$i.');">'.($i + 1).'</a></li>';
				}
				if($aPage < $aMaxPages - 1) {
					echo '<li><a href="javascript:void(0);" onclick="CODEBOT.loadChallenges(\''.$aBlock.'\', \''.$aType.'\', '.($aPage + 1).');">Próxima</a></li>';
				}
				echo '</ul>';
			echo '</div>';
		}
	}
?>