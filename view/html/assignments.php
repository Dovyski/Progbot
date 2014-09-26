<?php 
	require_once dirname(__FILE__).'/layout.php';

	layoutHeader('Trabalhos', View::baseUrl());
	
	$aData 			= View::data();
	$aIsProfessor 	= $aData['isProfessor'];
	
	echo '<div class="jumbotron">';
		echo '<div class="container">';
			echo '<h1>Trabalhos</h1>';
			echo '<p>Lista dos trabalhos que precisam ser resolvidos e entregues.</p>';
		echo '</div>';
	echo '</div>';
	
	echo '<div class="container assignment-container">';
	
		for ($i = 0; $i < 2; $i++) {
			$aIsShowingActiveChallenges = $i == 0;
			$aAssignments = $aIsShowingActiveChallenges ? $aData['activeAssignments'] : $aData['finishedAssignments'];
			
			echo '<h4>'.($aIsShowingActiveChallenges ? 'Trabalhos com entrega próxima' : 'Trabalhos finalizados').'</h4>';	
		
			// Active assignments
			echo '<div class="panel panel-default">';
				echo '<div id="active-challenges">';
					if (count($aAssignments) == 0) {
						echo '<p style="padding: 15px;">'.($aIsShowingActiveChallenges ? 'Não há trabalhos para serem entregues.' : 'Nenhum trabalho foi finalizado até agora.').'</p>';
						
					} else {
						echo '<table class="table table-hover">';
							echo '<thead>';
								echo '<th style="width: 5%;"></th>';
								echo '<th style="width: 50%;">Descrição</th>';
								echo '<th style="width: 20%;">Prazo de entrega</th>';
								echo '<th style="width: 15%;">Foi entregue?</th>';
								echo '<th style="width: 10%;">'.($aIsShowingActiveChallenges ? '' : 'Nota').'</th>';
							echo '</thead>';
							echo '<tbody>';
								foreach($aAssignments as $aIdChallenge => $aChallenge) {
									echo '<tr>';
										echo '<td style="text-align: center;">';
											echo '<i class = "fa fa-book"></i>';
										echo '</td>';
										echo '<td>';
											echo '<strong><a href="code.php?challenge='.$aIdChallenge.'">'.$aChallenge['name'].'</a></strong>';
											
											if($aIsProfessor) {
												echo ' <a href="challenges-manager.php?id='.$aIdChallenge.'" title="Editar desafio"><span class="fa fa-edit"></span></a>';
											}
										echo '</td>';
										echo '<td>';
											echo date('d/m/Y (h:i)', $aChallenge['deadline_date']);
										echo '</td>';
										echo '<td>';
											if($aChallenge['program_id'] != null) {
												echo '<span class="label label-success">Sim</span> <a href="code.php?challenge='.$aIdChallenge.'&tab=1"><i class="fa fa-send" title="Clique para ver a resposta enviada."></i></a>';
											} else {
												echo '<span class="label label-danger">Não</span>';
											}
										echo '</td>';
										
										echo '<td>'.($aIsShowingActiveChallenges ? '' : '-').'</td>';
									echo '</tr>';
								}
							echo '</tbody>';
						echo '</table>';
					}
				echo '</div>';
			echo '</div>';
		}
		
	echo '</div>';
	
	layoutFooter(View::baseUrl());
?>