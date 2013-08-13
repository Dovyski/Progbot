<?php 
	require_once dirname(__FILE__).'/layout.php';

	layoutHeader('Revisões', View::baseUrl());
	
	$aData				= View::data();
	$aChallengeId 		= $aData['challengeId'];
	$aUserInfo	 		= $aData['user'];
	
	echo '<div class="hero-unit">';
		echo '<h1>Revisão</h1>';
		echo '<p>Avaliação de respostas.</p>';
	echo '</div>';
	
	if ($aChallengeId != 0) {
		// Showing all answers of a challenge
		$aAnswers 	= $aData['answers'];
		$aChallenge = $aData['challenge'];
		
		echo '<div class="row">';
			echo '<div class="span4">';
				echo '<a href="reviews.php"><i class="icon-backward"></i> Voltar</a><br/><br/>';				
			echo '</div>';
		echo '</div>';
		
		echo '<h4><i class="icon-eye-open"></i> Respostas para "'.$aChallenge['name'].'"</h4>';
		
		echo '<div class="bloco-desafios">';
			if (count($aAnswers) == 0) {
				echo '<p>Não há respostas para esse desafio ainda.</p>';
				
			} else {
				echo '<table class="table table-hover">';
					echo '<thead>';
						echo '<th style="width: 5%;"></th>';
						echo '<th>Aluno</th>';
						echo '<th>Última atualização</th>';
						echo '<th>Nota</th>';
						echo '<th>Opções</th>';
					echo '</thead>';
					echo '<tbody>';
						foreach($aAnswers as $aIdProgram => $aRow) {
							echo '<tr>';
								echo '<td><i class="icon-file"></i></td>';
								echo '<td>';
									// TODO: FIX THIS! Use batch select to get user info
									$aUser = userGetById($aRow['fk_user']);
									echo '<a href="user.php?id='.$aRow['fk_user'].'">'.$aUser['name'].'</a>';
								echo '</td>';
								echo '<td>'.date('d/m/Y H:i:s', $aRow['last_update']).'</td>';
								echo '<td>'.($aRow['grade'] < 0 ? 'N/A' : $aRow['grade']).'</td>';
								echo '<td><a href="code.php?challenge='.$aChallengeId.'&user='.$aRow['fk_user'].'"><i class="icon-zoom-in"></i>Revisar</a></td>';
							echo '</tr>';
						}
					echo '</tbody>';
				echo '</table>';
			}
			//echo '<div class="bloco-desafios-legenda">Desafios já resolvidos</div>';
		echo '</div>';
		
	} else {
		// Showing all challenges of user's group
		$aChallenges = $aData['challenges'];
		
		echo '<h4><i class="icon-eye-open"></i> Desafios disponíveis para revisão</h4>';
		
		echo '<div class="bloco-desafios">';
			if (count($aChallenges) == 0) {
				echo '<p>Não há desafios ativos para o seu grupo.</p>';
				
			} else {
				echo '<table class="table table-hover">';
					echo '<thead>';
						echo '<th style="width: 5%;"></th>';
						echo '<th style="width: 80%;">Título</th>';
						echo '<th>Respostas</th>';
					echo '</thead>';
					echo '<tbody>';
						foreach($aChallenges as $aIdChallenge => $aRow) {
							echo '<tr>';
								echo '<td><i class="icon-list-alt"></i></td>';
								echo '<td>';
									echo '<a href="reviews.php?challenge='.$aIdChallenge.'">'.$aRow['name'].'</a> ';
								echo '</td>';
								echo '<td>N/A</td>';
							echo '</tr>';
						}
					echo '</tbody>';
				echo '</table>';
			}
			//echo '<div class="bloco-desafios-legenda">Desafios já resolvidos</div>';
		echo '</div>';
	}
	
	layoutFooter(View::baseUrl());
?>